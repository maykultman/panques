var app = app || {};

app.VistaEmpleado = Backbone.View.extend({
	tagName	: 'tr',
	events	: {
		'click .checkbox_empleado'	: 'apilarEmpleado'
	},

	plantillaEmpelado : _.template($('#tds_empleado').html()),

	initialize	: function () {
		this.$tbody_empleados_seleccionados = $('#tbody_empleados_seleccionados');
	},
	render	: function () {
		this.$el.html(this.plantillaEmpelado( this.model.toJSON() ));
		return this;
	},
	apilarEmpleado	: function (elemento) {
		var vistaParticipante = new app.VistaParticipante({model:this.model});
		this.$tbody_empleados_seleccionados.append( vistaParticipante.render().el );
		$(elemento.currentTarget).attr('disabled',true);
		
		this.$el.css('color','#CCC');
	},
});

app.VistaParticipante = Backbone.View.extend({
	tagName	: 'tr',
	className : 'info tr-participante',
	plantillaSeleccionado	: _.template($('#tds_empleado_seleccionado').html()),
	plantillaRol : _.template($('#input_rol').html()),
	events	: {
		'change .select_rol' : 'agregarRol',
		'click .btn_eliminarRol'	: 'eliminarRol',
		// 'click .eliminarParticipacion' : 'eliminar'
	},
	initialize	: function () {
		this.listenTo(app.coleccionRoles, 'add', this.cargarRoles);
	},
	render	: function () {
		var self = this;
		this.$el.html( this.plantillaSeleccionado(this.model.toJSON() ));
		this.$select_rol = this.$('.select_rol');

		// Cargamos el plugin selectize al select de roles
		// para empleado
		this.$select_rol.selectize({
			valueField  : 'id',
			labelField  : 'title',
			searchField : 'title',
			create      :  function (value) {
				// enviamos al servidor el nuevo rol
				Backbone.emulateHTTP = true;
				Backbone.emulateJSON = true;
				app.coleccionRoles.create({nombre:value},{
					wait:true,
					success:function (model) {
						// en el momento que el rol es creado
						// actualizamos en select del empleado,
						// realizamos esta operacion despues de
						// 10ms.
						setTimeout(function() {
							self.actualizarItem();
						}, 10);
					},
					error 	: function (model) {
						error('Error al listar nuevo rol');
					}
				});
				Backbone.emulateHTTP = false;
				Backbone.emulateJSON = false;

				// necesariamente tenemos que retornar un id y un
				// title. en la funcion success de la creacion del 
				// rol se ejecuta la funcion actualizarItem para
				// usar datos correctos y no el que se retorna aquí.
				return {
					id:'nuevo',
					title:value
				}
			}
		});

		this.$form_participante	= this.$('.form_participante');

		this.cargarRoles();
		return this;
	},
	cargarRoles	: function () {
		// clearOptions(), addOption(), setValue(); son 
		// funciones del plugin selectize
		var control = this.$select_rol[0].selectize,
			values  = this.$select_rol.val();
		control.clearOptions();
		control.addOption(function () {
	        var array = [],
	            roles = app.coleccionRoles.toJSON();
	        
	        for (var i = 0; i < roles.length; i++) {
	            array.push({
	                id      : roles[i].id,
	                title   : roles[i].nombre
	            });
	        };

	        return array;
	    }());
	    // [IMPORTANTE] si no ocurre la autoselección
	    // despues de actualizar los items utilize una
	    // función setTimeout con 10 ms como minimo.
	    control.setValue( values );
	},
	actualizarItem 	: function (value) {
		// model contrandrá el rol más recientemente creado
		// tenga o no tenga valor, respaldamos los valores del select y
		// obtenemos el objeto control de selectize.
		var model 	= app.coleccionRoles.last(),
			values 	= this.$select_rol.val(),
			control = this.$select_rol[0].selectize;
		
		// _.isNull retorna true si values no tiene valor.
		// invertimo el valor booleano para agregar el id del
		// nuevo rol en caso de que la funcion _.isNull retorne
		// false para autoseleccionar todos los valores antes 
		// seleccionados y el nuevo tambipen. De lo contrario
		// solo autoseleccionamos el nuevo rol.
		if ( !_.isNull(values) ) {
			values.push(model.get('id'));
			control.setValue(values);
		} else {
			control.setValue(model.get('id'));
		};	
	},
	eliminarRol 	: function (elemento) {
		this.$select_rol.children('#'+$(elemento.currentTarget).attr('value')).attr('disabled',false);
		$(elemento.currentTarget).parents('.tag_rol').remove();
	},
});
