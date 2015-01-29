<?=
// <!-- CSS jQuery.Gantt -->
	link_tag('js/plugin/Gantt/css/style.css');?>
	<style type="text/css">
      /* Bootstrap 3.x re-reset */
      .fn-gantt *,
      .fn-gantt *:after,
      .fn-gantt *:before {/*No borrar*/
        -webkit-box-sizing: content-box;
           -moz-box-sizing: content-box;
                box-sizing: content-box;
      }
      .fn-gantt .leftPanel .fn-label{
      	font-weight: normal;
      }
	.fn-gantt .leftPanel .fn-label:hover{
		color:#006ad5;
		text-decoration: underline;
	}
	</style>
	<section id="contenedor_principal_modulos" class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-md-4 col-md-4 col-lg-4">
								<h3>Cronograma de proyectos</h3>
							</div>
							<div class="col-xs-12 col-md-8 col-md-8 col-lg-8">
								<br>
								<span class="label label-default">Con tiempo para iniciar</span>
								<span class="label label-success">Entre el 50% de avance</span>
								<span class="label label-warning">Entre el 85% de avance</span>
								<span class="label label-danger">Entregar / tiempo rebasado</span>	
							</div>
						</div>
						<div class="gantt"></div>
					</div>
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
		</div><!-- /.row -->
	</section><!-- /#contenedor_principal_modulos -->
</div><!-- /.contenedor_modulo -->


<script type="text/javascript">
	var app = app || {};
	app.colecionDeClientes = <?=json_encode($clientes)?>;
	app.colecionDeProyectos = <?=json_encode($proyectos)?>;
</script>
<!-- Utilerias -->
	<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
	<!-- js plugin jQuery Gantt -->
		<script src="<?=base_url().'js/plugin/Gantt/js/jquery.fn.gantt.js'?>"></script>
<!-- plantillas -->
	<script type="text/template" id="tabla_info">
		<h3><%- nombre %></h3>
		<table class="table">
			<tr>
				<td> <b>Avance: </b> </td>
				<td>
					<%if ( duracion.queda >= duracion.plazo ) {%>
						0%
					<%} else{%>
						<%- 100 - duracion.porcentaje %>%
					<%};%>
				</td>
			</tr>
			<tr>
				<td> <b>Duración: </b> </td>
				<td>
					<%if ( duracion.queda >= duracion.plazo ) {%>
						<% var comenzarEn = duracion.queda - duracion.plazo; %>
						Comienza en <%= comenzarEn == 1 ? comenzarEn+' día' : comenzarEn+' días' %>
					<%} else{%>
						Queda <%= duracion.queda == 1 ? duracion.queda+' día' : duracion.queda+' días' %> de <%- duracion.plazo %>
					<%};%>
				</td>
			</tr>
			<tr>
				<td> <b>Fecha de inicio: </b> </td>
				<td><%- formatearFechaUsuario( new Date(fechainicio) ) %></td>
			</tr>
			<tr>
				<td> <b>Fecha final: </b> </td>
				<td><%- formatearFechaUsuario( new Date(fechafinal) ) %></td>
			</tr>
			<tr>
				<td colspan="2">
					<b>Descripcion: </b>
					<p>
						<%- descripcion %>
					</p>
				</td>
			</tr>
		</table>
	</script>
<!-- MV* -->
	<?=
		script_tag('js/backbone/lib/underscore.js').
		script_tag('js/backbone/lib/backbone.js').
		script_tag('js/backbone/modelos/ModeloCliente.js').
		script_tag('js/backbone/modelos/ModeloProyecto.js').
		script_tag('js/backbone/colecciones/ColeccionClientes.js').
		script_tag('js/backbone/colecciones/ColeccionProyectos.js');?>

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
		el	: '#contenedor_principal_modulos',
		events	: {},
		initialize	: function () {
			var here = this;
			var modelos = app.coleccionProyectos.where({entregado:'0'});
			app.coleccionProyectos.reset();
			app.coleccionProyectos.add(modelos);
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
				model.set({duracion : calcularDuracion( 
					new Date( fechaEstandar( model.get('fechainicio') ) ),
					new Date( fechaEstandar( model.get('fechafinal') ) )
				)});
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
						label		: function (json){
							if (json.queda < json.plazo) {
								return 'queda '+json.queda+' día(s) de '+json.plazo
							} else{
								return 'comienza en '+(json.queda - json.plazo)+ ' día(s)'
							};
						}(model.toJSON().duracion),
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
				waitText		: 'Espere por favor...',
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


		}
	});

	app.vistaCronograma = new app.VistaCronograma();

</script>