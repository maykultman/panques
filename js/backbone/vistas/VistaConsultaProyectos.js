var app = app || {};

app.VistaConsultaProyectos = Backbone.View.extend({
	el	: '.contenedor_principal_modulos',
	events	: {},
	initialize	: function () {
		this.$tbody_proyectos = this.$('#tbody_proyectos');
		this.listenTo( app.coleccionProyectos, 'add', this.cargarProyecto );
		this.cargarProyectos();
		this.carganDiagramaGantt();
	},
	render	: function () {},
	cargarProyecto	: function (modeloProyecto) {
		var propietario = app.coleccionClientes.get({id:modeloProyecto.get('idcliente')});
		if (typeof propietario != 'undefined') {
			modeloProyecto.set({propietario:propietario.get('nombreComercial')});
			var vistaProyecto = new app.VistaProyecto( {model:modeloProyecto} );
			this.$tbody_proyectos.append( vistaProyecto.render().el );
		};
	},
	cargarProyectos	: function () {
		app.coleccionProyectos.each( this.cargarProyecto, this );
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
			/*Validamos si el proyecto esta con tiempo suficiente, 
			mitad de tiempo o por terminar el plazo. Asignamos un
			color para dicha situación*/
			var color = '';
			var pocentaje = parseInt(model.get('duracion').porcentaje);
			if (pocentaje >= 51 && pocentaje < 100)
				{color = 'ganttGreen';}
			if (pocentaje >= 15 && pocentaje < 51)
				{color = 'ganttOrange';}
			if (pocentaje >= 0 && pocentaje < 15)
				{color = 'ganttRed';}
			/*if (pocentaje < 0)
				{color = 'ganttGray';}*/
			/*Cada iteración crea un modelo del proyecto y lo añade a
			  la coleccion*/
		    coleccion.add( new Modelo({
		    	/*Creamos el json necesario para el plugin*/
		    	name	:model.get('propietario'),
				desc	:model.get('nombre'),
				values	:[{
					from		: new Date(model.get('fechainicio')).valueOf() + 1*24* 60* 60*1000,
					to			: new Date(model.get('fechafinal')).valueOf() + 1*24* 60* 60*1000,
					label		: model.get('duracion').queda +'/'+ model.get('duracion').plazo,
					customClass	: color
				}],
			}) );
		},this);
		/*Cargamos el arreglo de objetos json que nececita el plugin*/
		$('.gantt').gantt({
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
				}
			}
		});
	}
});

app.vistaConsultaProyectos = new app.VistaConsultaProyectos();