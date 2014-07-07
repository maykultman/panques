var app = app || {};

app.VistaContrato = Backbone.View.extend({
	tagName	: 'tr',
	plantilla : _.template($('#plantilla_tr_contrato').html()),
	plantillaModal	: _.template($('#plantilla_modal').html()),
	events	: {
		'click #eliminar'				: 'eliminar',
		'click #tr_btn_editar'			: 'verInfo',
		'click #tr_btn_verInfo'			: 'verInfo',
	},
	initialize	: function () {
		this.listenTo(this.model, 'destroy', this.remove);
	},
	render		: function () {
		this.$el.html(this.plantilla( this.model.toJSON() ));
		return this;
	},
	verInfo		: function (elem) {
		var thiS = this;
		this.$el.append( this.plantillaModal(this.model.toJSON()) );
	},
	eliminar	: function () {
		this.model.destroy({
			wait	: true,
			success	: function (model, response) {
				console.log(response.responseText);
			},
			error	: function (model, response) {
				console.log(response.responseText);
			}
		});
	},
});

app.VistaConsultaContrato = Backbone.View.extend({
	el	: '.contenedor_principal_modulos',
	events	: {
		'click #buscarCliente'  : 'busqueda',
		'keyup #buscarCliente'  : 'borrayRenderiza',
		'click #buscarEmpleado' : 'busqueda',
		'keyup #buscarEmpleado' : 'borrayRenderiza',
		'click .abajo'    : 'ordenarporfecha',
		'click .arriba'   : 'ordenarporfecha'
	},
	initialize	: function () {
		this.$tbody_contratos = $('#tbody_contratos');
		this.cargarContratos();
	},
	render		: function () {},
	cargarContrato	: function (contrato) {
		contrato.set({
			nombreComercial:app.coleccionClientes.get({
				id:contrato.get('idcliente')
			}).get('nombreComercial'),
			nombreRepresentante:app.coleccionRepresentantes.get({
				id:contrato.get('idrepresentante')
			}).get('nombre'),
			nombreEmpleado:app.coleccionEmpleados.get({
				id : contrato.get('idempleado')
			}).get('nombre')
		});
		var vista = new app.VistaContrato({model:contrato});
		this.$tbody_contratos.append(vista.render().el);
	},
	cargarContratos	: function () {
		app.coleccionContratos.each(this.cargarContrato, this);
	},

	ordenarporfecha : function(fecha)
	{ 
		var modelo = ordenar(fecha, app.coleccionDeContratos);
		this.$tbody_contratos.html('');
		for( i in modelo)
		{
			this.cargarContrato( ( new ( Backbone.Model.extend({ defaults : modelo[i] }) ) ) );
		}
	},
	busqueda : function(elemento)
	{
		// input de busqueda, this, coleccion, tabla donde se renderizara el modelo
		autocompleteGenerico(elemento, this, app.coleccionDeContratos, this.$tbody_contratos);
	},	
	
	borrayRenderiza	: function (e) 
    {
		if(e.keyCode===8)
          {
          	this.$tbody_contratos.html('');
            this.cargarContratos();
          }
	},
});

app.vistaConsultaContrato = new app.VistaConsultaContrato();