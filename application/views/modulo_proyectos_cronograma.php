<link rel="stylesheet" href="<?=base_url().'css/estilos_modulo_proyectos.css'?>" type="text/css">
<!-- CSS jQuery.Gantt -->
	<link rel="stylesheet" type="text/css" href="js/plugin/Gantt/css/style.css">
	<style type="text/css">
      /* Bootstrap 3.x re-reset */
      .fn-gantt *,
      .fn-gantt *:after,
      .fn-gantt *:before {
        -webkit-box-sizing: content-box;
           -moz-box-sizing: content-box;
                box-sizing: content-box;
      }
	.fn-gantt .leftPanel .fn-label:hover{
		color:blue;
	}
	</style>
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="page-header">
				<h1>Cronograma de proyectos</h1>
			</div>
			
			<div class="gantt"></div>
		</div>
	</div>


	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Información del proyecto</h4>
				</div>
				<div class="modal-body">
					<!-- PLANTILLA TABLA INFORMACION DEL PROYECTO -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	var app = app || {};
	app.colecionDeClientes = <?=json_encode($clientes)?>;
	app.colecionDeProyectos = <?=json_encode($proyectos)?>;
</script>
<!-- Utilerias -->
	<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
	<!-- js plugin jQuery Gantt -->
	<script src="js/plugin/Gantt/js/jquery.fn.gantt.js"></script>
<!-- plantillas -->
	<script type="text/template" id="tabla_info">
		<h3><%- nombre %></h3>
		<table class="table">
			<tr>
				<td> <b>Descripcion: </b> </td>
				<td><%- descripcion %></td>
			</tr>
				<td> <b>Avance: </b> </td>
				<td><%- 100 - duracion.porcentaje %>%</td>
			</tr>
			<tr>
				<td> <b>Duración: </b> </td>
				<td>Queda <%= duracion.queda == 1 ? duracion.queda+' día' : duracion.queda+' días' %> de <%- duracion.plazo %></td>
			<tr>
			<tr>
				<td> <b>Fecha de inicio: </b> </td>
				<td><%- formatearFechaUsuario( new Date(fechainicio) ) %></td>
			<tr>
				<td> <b>Fecha final: </b> </td>
				<td><%- formatearFechaUsuario( new Date(fechafinal) ) %></td>
			</tr>
		</table>
	</script>
<!-- MV* -->
	<script type="text/javascript" src="<?=base_url().'js/backbone/lib/underscore.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/lib/backbone.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloCliente.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/modelos/ModeloProyecto.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionClientes.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/backbone/colecciones/ColeccionProyectos.js'?>"></script>

	<script type="text/javascript">
		app.coleccionProyectos = new ColeccionProyectos(app.colecionDeProyectos);
	</script>
<script type="text/javascript">
	app.VistaProyecto = Backbone.View.extend({
		plantilla : _.template( $('#tabla_info').html() ),
		events:{
			'click .fn-label':'verInfo'
		},
		verInfo : function (){
			$('.modal-body').html(this.plantilla(this.model.toJSON()));
		}
	});
	app.VistaCronograma = Backbone.View.extend({
		el	: '.contenedor_principal_modulos',
		events	: {},
		initialize	: function () {
			var here = this;
			this.carganDiagramaGantt();

				
		},
		render	: function () {},
		crearVistaProyecto	: function (){
			var i = 0;
			var vista;
			app.coleccionProyectos.each(function (model) {
				vista = new app.VistaProyecto({model:model});
				vista.setElement(this.$('.fn-wide')[i]);
				i++;
			}, this);
		},

		/*Lias siguientes funciones son para el modulo de gantt*/
		carganDiagramaGantt	: function () {
			var here = this;
			/*Instanciamos una coleccion con el fin de obtener una arreglo
			  de objetos json estructurado para el plugin Gantt de jQuery*/
			var coleccion = new Backbone.Collection();
			/*Extendemos la clase Model para crear cada objeto json que
			  requiere el plugin*/
			var Modelo = Backbone.Model.extend();

			/*Recorremos la coleccion de proyectos*/
			app.coleccionProyectos.each(function (model){
				/*Establecemos la duracion del proyecto en el modelo*/
				model.set({duracion : here.calcularDuracion(model)});
				/*Validamos si el proyecto esta con tiempo suficiente, 
				mitad de tiempo o por terminar el plazo. Asignamos un
				color para dicha situación*/
				var color = '';
				var porcentaje = parseInt(model.get('duracion').porcentaje);
				if (porcentaje >= 51 && porcentaje < 100)
					{color = 'ganttGreen';}
				if (porcentaje >= 15 && porcentaje < 51)
					{color = 'ganttOrange';}
				if (porcentaje >= 0 && porcentaje < 15)
					{color = 'ganttRed';}
				/*if (porcentaje < 0)
					{color = 'ganttGray';}*/
				/*Cada iteración crea un modelo del proyecto y lo añade a
				  la coleccion*/
			    coleccion.add( new Modelo({
			    	/*Creamos el json necesario para el plugin*/
			    	name	:model.get('nombre'),
					// desc	:'',
					idd		: model.get('id'),
					values	:[{
						from		: new Date(model.get('fechainicio')).valueOf() + 1*24* 60* 60*1000,
						to			: new Date(model.get('fechafinal')).valueOf() + 1*24* 60* 60*1000,
						label		: model.get('duracion').queda +'/'+ model.get('duracion').plazo,
						customClass	: color
					}],
				}) );
			},this);
			/*Cargamos el arreglo de objetos json que nececita el plugin*/
			this.$('.gantt').gantt({
				source			: coleccion.toJSON(),/*Convertimos la coleccion en un arreglo de objetos json*/
				navigate		: "scroll",
				maxScale		: "hours",
				itemsPerPage	: 10,
				months			: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],//Meses
				dow				: ['D','L','M','M','J','V','S'],//Días
				waitText		: 'Espera por favor...',
				onRender: function() {
					if (window.console && typeof console.log === "function") {
						console.log("chart rendered");
						/*Al momento de cargar el diagrama de gantt
						  creamos una vista por cada proyecto para ver
						  la información de cada uno de ellos*/
						here.crearVistaProyecto();
					}
				}
			});


		},
		calcularDuracion		: function (model,callback) {
			var valorFechaInicio = new Date(model.get('fechainicio')).valueOf(),
				valorFechaEntrega = new Date(model.get('fechafinal')).valueOf(),
				valorFechaActual = new Date().valueOf(),
				plazo = ((((valorFechaEntrega-valorFechaInicio))/24/60/60/1000) + 1).toFixed() - this.excluirDias(model.get('fechainicio'), model.get('fechafinal')),
				queda = ((((valorFechaEntrega-valorFechaInicio)-((valorFechaEntrega-valorFechaInicio)-(valorFechaEntrega-valorFechaActual)))/24/60/60/1000) +1).toFixed() - this.excluirDias(new Date(), model.get('fechafinal'));
			if (queda == -0) queda = 0;
			var porcentaje = ((100 * queda)/plazo).toFixed();

			// console.log('plazo: '+plazo, 'queda: '+queda, 'porcentaje: '+porcentaje+'%');
			return {
				plazo		:plazo,
				queda		:queda,
				porcentaje	:porcentaje
			};
			callback();
		},
		excluirDias	: function (fechaInicio, fechaFinal) {
			var contador = 0;
			var valorFechaInicio = new Date(fechaInicio).valueOf();
			var valorFechaEntrega = new Date(fechaFinal).valueOf();
			var duracion = (((valorFechaEntrega-valorFechaInicio)/24/60/60/1000) +1).toFixed();
			var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
			for(var i = 0; i<duracion; i++){
				var dia = (new Date(new Date(fechaInicio).getTime() + i*24*60*60*1000)).getDay();
			   	if(days[dia] == 'Saturday' || days[dia] == 'Sunday'){ 
			   		contador++;
			   	};
			};
			return contador;
		},
	});

	app.vistaCronograma = new app.VistaCronograma();

</script>