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
		'click #cliente'  : 'autocompleteCliente',
		'keyup #cliente'  : 'borrayRenderiza',
		'click #empleado' : 'autocompleteEmpleado',
		'keyup #empleado' : 'borrayRenderiza',
		'click .abajo'    : 'abajo',
		'click .arriba'   : 'arriba'
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

	abajo : function()
	{
		var contratos = app.coleccionDeContratos;
		var ordenar = contratos.sort(function(a,b){
			return ( b.id - a.id );
		})
		var model = new Array();

		this.$tbody_contratos.html('');
		for( i in ordenar)
		{
			model = Backbone.Model.extend({defaults : ordenar[i] });
			this.cargarContrato(new model);
		}
		$('#bfecha').toggleClass('arriba');
		$('#fecha').removeClass('downt');		
		$('#fecha').addClass('upt');		
	},
	arriba : function()
	{
		var contratos = app.coleccionDeContratos;
		var ordenar = contratos.sort(function(a,b){
			return ( a.id - b.id );
		})
		var model = new Array();

		this.$tbody_contratos.html('');
		for( i in ordenar)
		{
			model = Backbone.Model.extend({defaults : ordenar[i] });
			this.cargarContrato(new model);
		}
		$('#fecha').removeClass('upt');		
		$('#fecha').addClass('downt');
	},

	autocompleteCliente : function (elemento)
	{		
        clientes = new Array();  var cont  = 0; 
        for(i in app.coleccionDeClientes)
        {
             clientes[cont] = app.coleccionDeClientes[i].nombreComercial; cont++;          
        };
        
        $('#cliente').autocomplete({ source : clientes }); // Autocompletamos
 		
 		var esto = this; // Respaldamos el this para llamar a una funcion dentro del evento siguiente...

        $( "#cliente" ).on( "autocompleteselect", function( event, ui ) {
            /*...Buscamos al cliente que nos proporciono el autocomplete en la coleccion.....*/
            var modeloCont = app.coleccionContratos.where
            				({ idcliente 		 : ( ( app.coleccionClientes.findWhere
            				({ 'nombreComercial' :     ui.item.value } ) ).toJSON() ).id });

     		esto.$tbody_contratos.html('');
     		for(i in modeloCont)
     		{
     			esto.cargarContrato(modeloCont[i]);
     		}
            
        });
	},

	autocompleteEmpleado : function (elemento)
	{
        var empleados = new Array();  var cont  = 0; 
        for(i in app.coleccionDeEmpleados)
        {
             empleados[cont] = app.coleccionDeEmpleados[i].nombre; cont++;          
        };
        
        $('#empleado').autocomplete({ source : empleados }); // Autocompletamos
 		
 		var esto = this; // Respaldamos el this para llamar a una funcion dentro del evento siguiente...

        $( "#empleado" ).on( "autocompleteselect", function( event, ui ) {
            /*...Buscamos al Empleado que nos proporciono el autocomplete en la coleccion.....*/              
            var modeloCont = app.coleccionContratos.where
            				({ 
	            				idempleado : ( ( app.coleccionEmpleados.findWhere( { 
	            				'nombre'   :     ui.item.value } ) ).toJSON() ).id 
            				});
	     	
	     	esto.$tbody_contratos.html('');
	     	for(i in modeloCont)
	     	{
	     		esto.cargarContrato(modeloCont[i]);	
	     	}
            
        });
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