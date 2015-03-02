var app = app || {};
app.Evento = Backbone.View.extend({
	events  	: {
		'click #enviar' : 'enviar',
		'change .allDay' : 'conmutarAllDay',
		'click #cancelar' : 'cancelar',
		'click #eliminar' : 'eliminar'
	},
	template : _.template( $('#form-event-update-template').html() ),
	initialize 	: function () {
	},
	render 	: function () {
		this.$el.html( this.template() );
		this.$el.attr({
			'class':"modal fade",
			'id':"myModal",
			'tabindex':"-1",
			'role':"dialog",
			'aria-labelledby':"myModalLabel",
			'aria-hidden':"true"
		});
		this.prepararObjetos();
		return this;
	},
	prepararObjetos : function () {
		this.$datepickerDe = this.$('.datepickerDe');
		this.$description = this.$('.description');
		this.$datepickerA = this.$('.datepickerA');
		this.$timepicker = this.$('.timepicker');
		this.$formEvento = this.$('.form-event');
		this.$invitados = this.$('.invitados');
		this.$location = this.$('.location');
		this.$info = this.$('.google-info');
		this.$titulo = this.$('.titulo');
		this.$allDay = this.$('.allDay');
		this.cargarPlugins();
	},
	enviar 		: function (e) {
		var json = this.obtenerDatos(), self = this;

		if ( _.isBoolean(json) && json == false ) {
			e.preventDefault();
			return false;
		};
		
		$('#block').toggleClass('activo');

		if ( !_.isUndefined( this.model ) ) {
			var ajax = this.model.update(json);
			ajax.then(function (model) {
				$('#block').toggleClass('activo');
				self.cancelar();
				ok('El evento ha sido actualozado.');
			}, function () {
				$('#block').toggleClass('activo');
				self.cancelar();
				error('Error al intentar acutalizar el evento.');
			});
		} else{
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionActividades.create(json,{
				wait 	: true,
				success : function (model) {
					// console.log('se creo: ', model);
					$('#block').toggleClass('activo');
					self.control.clear();
					self.$formEvento[0].reset();
				},
				error 	: function (model) {
					// console.log('no creo: ', model);
					$('#block').toggleClass('activo');
				}
			});
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		};			
		e.preventDefault();
	},
	cancelar 	: function () {
		// el elemento que genera el evento es un
		// input reset. Si no hay modal solo resetemos
		// el formulario, de lo contrario cerramos el
		// modal.
		if ( !_.isUndefined( this.model ) ) {
			this.$el.modal('hide');
		};
	},
	eliminar 	: function () {
		var self = this;
		confirmar('¿Estás seguro de eliminar el evento?', function(){
			$('#block').toggleClass('activo');
			var ajax = self.model.delete();
			ajax.then(function () {
				ok('Evento eliminado.');
				$('#block').toggleClass('activo');
				self.cancelar();
			}, function () {
				error('Error al intentar eliminar el evento.');
				$('#block').toggleClass('activo');
				self.cancelar();
			});
		},function(){});
			
	},
	obtenerDatos : function () {
		var json = pasarAJson( this.$formEvento.serializeArray() ),
			self = this,
			mensaje = '',
			hora1, hora2;
		
		try{
			json.start = formatearFechaDB( this.$datepickerDe.datepicker('getDate') );
		}catch(e){
			mensaje = 'Introdusca una fecha valida de comienzo (De) para el evento.';
			alerta(mensaje, function () {
				self.$datepickerDe.datepicker('setDate', new Date());
			});
			return false;
		}
		
		if ( this.$datepickerA.val() == '' ) {
			json.end = json.start;
		} else {
			try{
				json.end = formatearFechaDB( this.$datepickerA.datepicker('getDate') );
			}catch(e){
				mensaje = 'Introdusca una fecha valida para el final del evento (a).';
				alerta(mensaje, function () {
					self.$datepickerA.datepicker('setDate', new Date(json.start));
				});
				return false;
			}
		};

		if ( !this.$allDay.is(':checked') ) {
			hora1 = this.$timepicker.eq(0).val();
			hora2 = this.$timepicker.eq(1).val();
			if (hora1 == '' || hora2 == '') {
				mensaje = 'Seleccione las horas de inicio y fin del evento.';
				alerta(mensaje, function () {});
				return false;
			} else {
				json.start += 'T'+ hora1 +':00';
				json.end += 'T'+ hora2 +':00';
			};
				
		};

		return json;
	},
	conmutarAllDay	: function (e) {
		switch( this.$(e.currentTarget).is(':checked') ){
			case true:
				this.$timepicker.attr('disabled',true);
				break;
			case false:
				this.$timepicker.attr('disabled',false);
				break;
			default:
				/**/
				break;
		}
	},
	establecerDatos : function () {
		var json = this.model.toJSON(), de, a, hora1, hora2,
			fn = function (hour,minute) {
				if (hour 	< 10) { hour 	= '0'+hour };
				if (minute 	< 10) { minute 	= '0'+minute };
				return hour+':'+minute;
			};

		this.$titulo.val(json.summary);
		
		if ( !_.isNull(json.start.date) ) {
			de 	= new Date( fechaEstandar( json.start.date ) );
			a 	= new Date( fechaEstandar( json.end.date ) );
			this.$datepickerDe.datepicker('setDate', de);
			this.$datepickerA.datepicker('setDate', a);
			this.$timepicker.eq(0).attr('disabled',true);
			this.$timepicker.eq(1).attr('disabled',true);
			this.$allDay.attr('checked',true);
		} else {
			de 	= new Date( json.start.dateTime );
			a 	= new Date( json.end.dateTime );
			hora1 = fn( de.getHours(), de.getMinutes() );
			hora2 = fn( a.getHours(), a.getMinutes() );
			this.$datepickerDe.datepicker('setDate', de);
			this.$datepickerA.datepicker('setDate', a);
			this.$timepicker.eq(0).attr('disabled',false).val(hora1);
			this.$timepicker.eq(1).attr('disabled',false).val(hora2);
			this.$allDay.attr('checked',false);
		};

		this.$location.val(json.location);

		this.control.setValue( _.pluck(json.attendees,'email') );

		this.$description.val(json.description);
		this.$info.text('creado por:'+json.creator.displayName+', email:'+json.creator.email);
	},
	cargarPlugins : function () {
		var self = this,
			optionsDatepicker = {
				dateFormat:'d MM, yy',  
		        dayNamesMin:[
		            'Do',
		            'Lu',
		            'Ma',
		            'Mi',
		            'Ju',
		            'Vi',
		            'Sá'
		        ],
		        monthNames:[
		            'Enero',
		            'Febrero',
		            'Marzo',
		            'Abril',
		            'Mayo',
		            'Junio',
		            'Julio',
		            'Agosto',
		            'Septiembre',
		            'Octubre',
		            'Noviembre',
		            'Diciembre'
		        ],
		        defaultDate: "+1w",
		        changeMonth: true,
		        numberOfMonths: 1,
			};
		// plugins bootstrap
			this.$('[data-toggle="tooltip"]').tooltip();
	    // plugins de fecha y hora
			this.$datepickerDe.datepicker(_.extend(optionsDatepicker,{
		        onClose: function( selectedDate ) {
		            self.$datepickerA.datepicker( "option", "minDate", selectedDate );
		        }
		    }));
			this.$datepickerA.datepicker(_.extend(optionsDatepicker,{
		        onClose: function( selectedDate ) {
		            self.$datepickerDe.datepicker( "option", "maxDate", selectedDate );
		        }
		    }));
			this.$timepicker.timepicker({
				defaultTime: '00:00',
				hourText: 'Hora',
	   			minuteText: 'Minuto',
			});
		// establecer la fecha actual como día predeterminado
		// del evento.
			this.$datepickerDe.datepicker( 'setDate', new Date() );
			this.$datepickerA.datepicker( 'setDate', new Date() );
		// Obtener todos los emails de los empleados, tanto
		// usuario como no usuarios
			var empleados = app.coleccionEmpleados.toJSON(),
				clientes = app.coleccionClientes.toJSON(),
				getOptions = function (collection, aislar, agrupador) {
					var array = [],
						json,
						excluir = function ( json, quien ) {
							switch( quien ){
								case 'nombre':
									json.name = json.nombre;
									json.email = json.correo;
									delete json.nombre;
									delete json.correo;
									return json;
									break;
								case 'nombreComercial':
									json.name = json.nombreComercial;
									delete json.nombreComercial;
									return json;
									break;
								default:
									statements_def
									break;
							}
						};
					if ( _.isArray( collection ) ) {
						for (var i = 0; i < collection.length; i++) {
							json = _.extend( _.pick(collection[i], aislar), agrupador );
							array.push( excluir( json, aislar[0] ) );
						};
					} else if ( _.isObject( collection ) ) {
						json = _.extend( _.pick(collection, aislar), agrupador );
						array.push( excluir( json, aislar[0] ) );
					};
					return array;
				},
				emails = _.union(
					getOptions(clientes, ['nombreComercial','email'], {class:'clientes'}),
					getOptions(empleados, ['nombre','correo'], {class:'empleados'})
				);
			this.$invitados.selectize({
				options : emails,
				optgroups : [
					{
						value:'clientes',
						label:'Clientes',
						label_description:'Prospectos & Clientes'
					},
					{
						value:'empleados',
						label:'Empleados',
						label_description:'Con o sin usuario'
					}
				],
				optgroupField: 'class',
				valueField: 'email',
			    labelField: 'name',
			    searchField: ['name'],
			    render : {
			    	optgroup_header: function(data, escape) {
		            	return '<div class="optgroup-header">' + escape(data.label) + ' <span class="text-muted">(' + escape(data.label_description) + ')</span></div>';
		        	}
			    }
			});
			this.control = this.$invitados[0].selectize;
	},
});
app.VistaActividades = Backbone.View.extend({
	el:'#contenedor_principal_modulos',
	initialize 	: function () {
		var self = this;
		$('#block').toggleClass('activo');

		this.$calendar = this.$('#calendar');
		var request1 = app.coleccionClientes.fetch();
		request1.then(function () {
			var request2 = app.coleccionEmpleados.fetch();
			request2.then(function () {
				var view = new app.Evento();
				view.setElement( self.$('#div-new-event') );
				view.prepararObjetos();
				self.cargarPlugins();
			}, function () {});
		}, function () {});

		var request3 = app.coleccionActividades.fetch();
		
		request3.then(function () {
			$('#block').toggleClass('activo');
		}, function () {
			$('#block').toggleClass('activo');
			alerta('No se pudo realizar la conexión con Google, intente más tarde.');
		});

		this.listenTo(app.coleccionActividades, 'add', this.cargarEvento);
		this.listenTo(app.coleccionActividades, 'destroy', this.retirarEvento);
		this.listenTo(app.coleccionActividades, 'change', this.renderizarEvento);
	},
	cargarEvento : function (model) {
		var jsonModel = model.toJSON();
		var fn = function (date) {
			if ( !_.isNull( date.dateTime ) ) {
				return date.dateTime;
			} else if ( !_.isNull( date.date ) ) {
				return date.date;
			};
		};

		var json = {
			title 	: jsonModel.summary,
			start 	: fn( jsonModel.start ),
			end 	: fn( jsonModel.end ),
			_id 	: jsonModel.id
		};
		this.$calendar.fullCalendar('renderEvent', json, true);
	},
	retirarEvento : function (model) {
		this.$calendar.fullCalendar('removeEvents', model.get('id'));
	},
	renderizarEvento : function (model) {
		this.retirarEvento(model);
		this.cargarEvento(model);
	},
	cargarPlugins : function () {
		var self = this;
		this.$calendar.fullCalendar({
			lang : 'es',
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			selectHelper: true,
			eventLimit: true, // allow "more" link when too many events
			eventClick: function(event, element) {
				view = new app.Evento({
					model : app.coleccionActividades.get( event._id )
				});
				self.$el.append( view.render().el );
				view.$el.modal({
					backdrop : false
				}).on('shown.bs.modal', function (e) {
					view.establecerDatos();
				}).on('hidden.bs.modal', function (e) {
					view.$el.remove();
				});
			},
		});
	},
});