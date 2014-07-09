var app = app || {};
app.VistaEdicionContrato = app.VistaNuevoContrato.extend({
	el 	: '#section_actualizar',
	// plantilla 	: _.template($('#form_contrato').html()),
	// render	: function () {
	// 	this.$el.html(this.plantilla( this.model.toJSON() ));
	// },
	establecerContrato	: function () {
		/*Respandamos this para utilizar las funciones de la clase en
		  caso de que las funciones contengas funciones*/
			var here = this;
		/*Obtenemos y establecemos el nombre del cliente en el campo busqueda*/
			this.$('#busqueda')
				.val(				this.
									model.
									get('nombreComercial') );
		/*Obtenemos y establecemos el nombre del representante en el campo input_Representante*/
			this.$('#input_Representante')
				.val(				this.
									model.
									get('nombreRepresentante') );
		/*Obtenemos y establecemos la fecha final en el campo fechaFinal*/
			this.$('#fechaFirma')
				.val( formatearFechaUsuario(
						new Date(	this.
									model.
									get('fechafirma') ) ) );
		/*Obtenemos y establecemos el titulo del contrato en el campo text_titulocontrato*/
			this.$('#text_titulocontrato')
				.val(				this.
									model.
									get('titulocontrato') );
		/*Obtenemos y establecemos la fecha de firma del contrato en el campo hidden_fechafirma*/
			this.$('#hidden_fechafirma')
				.val(				this.
									model.
									get('fechafirma') );
		this.$('#'+this.model.get('plan')).click();
		/*---------------------------------------------------------------------------------*/
		/*Cargamos los servicios cada vez que se cliquee en el boton
		  editar del contrato, para distinguir los servicios que ha 
		  seleccionado*/
		  	//La funcion tambien limpia la lista de servicios
			this.cargarServicios();
		/*Limpiamos la tabla de servicios que seleccione el cliente y
		  con los que cuenta el contrato*/
			this.$('#tbody_servicios_seleccionados').html('');
		/*Filtramos la coleccion de servicios contratados para mostrar
		  en pantalla todos aquellos que estes relacionados con el
		  contrato de esta vista*/
			_.filter(app.coleccionServiciosContrato.models, function (model) {
				if (model.get('idcontrato') == here.model.get('id')){
					here.apilarServicioContratado(model);
				}
			});
		/*---------------------------------------------------------------------------------*/

		if (this.model.get('plan') == 'evento') {
			this.$('.input_fechaInicioPago')
				.first().val( formatearFechaUsuario(new Date(this.model.get('fechainicio'))) ).trigger('change');
			this.$('.n_pagos').first().val(this.model.get('nplazos')).trigger('change');
		};
		if (this.model.get('plan') == 'iguala') {
			this.$('.input_fechaInicioPago')
				.last().val( formatearFechaUsuario(new Date(this.model.get('fechainicio'))) ).trigger('change');
			this.$('.n_pagos').last().val(this.model.get('nplazos')).trigger('change');
		};
	},
	/*[polimorfismo] Reescribimos la funcion.
	  Mismo procedimientos pero adaptado al historial de contratos*/
	apilarServicioContratado		: function (model) {
		var servicio = app.coleccionServicios.get({id:model.get('idservicio')});
		model.set({
			nombre	: servicio.get('nombre'),
			total	: 	( 	/* ( precio - ( (precio x descuento)/100 ) ) * cantidad */ 
							(
								( model.get('precio') ) - (
									( model.get('precio') * model.get('descuento') ) / 100
								)
							) * model.get('cantidad')
						).toFixed(2)
		});
		var vista = new app.VistaServicioSeleccionado({ model:model });
		this.$('#tbody_servicios_seleccionados').append(vista.render().el);
																			/*ELIMINAR LA FUNCION parents() Y css()*/
		this.$( '#servicio_'+model.get('idservicio') ).attr('disabled',true).parents('td').css({'background':'gray'});
		vista.calcularImporteIVATotalNeto();
	},
});
app.VistaContrato = Backbone.View.extend({
	tagName	: 'tr',
	plantilla : _.template($('#plantilla_tr_contrato').html()),
	plantillaModal	: _.template($('#plantilla_modal').html()),
	events	: {
		'click #eliminar'		: 'eliminar',
		'click #tr_btn_verInfo'	: 'verInfo',
		'click #tr_btn_editar'	: 'editar',
		
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
	editar 		: function () {
		vista = new app.VistaEdicionContrato({model:this.model});
		vista.establecerContrato();
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
		'click #todos'	        : 'marcarTodosCheck',
		'click .abajo'    		: 'ordenarporfecha',
		'click .arriba'   		: 'ordenarporfecha'
	},
	initialize	: function () {
		this.$tbody_contratos = $('#tbody_contratos');
		this.cargarContratos();
		this.listenTo( app.coleccionContratos, 'reset', this.cargarContratos);
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
		this.$tbody_contratos.html('');
		app.coleccionContratos.each(this.cargarContrato, this);
	},

	ordenarporfecha : function(fecha)
	{ 
		ordenar(fecha, app.coleccionContratos, app.coleccionDeContratos);
	},
	
	busqueda : function(elemento)
	{
		// input de busqueda, this, coleccion, tabla donde se renderizara el modelo
		autocompleteGenerico(elemento, this, app.coleccionContratos, this.$tbody_contratos);
	},	
	
	borrayRenderiza	: function (e) 
    {
		if(e.keyCode===8)
          {
          	this.$tbody_contratos.html('');
            this.cargarContratos();
          }
	},
	marcarTodosCheck : function(elemento)
    {        
        marcarCheck(elemento);
    },
});

app.vistaConsultaContrato = new app.VistaConsultaContrato();