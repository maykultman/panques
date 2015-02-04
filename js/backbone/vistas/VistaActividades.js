var app = app || {};
app.VistaActividades = Backbone.View.extend({
	el:'#contenedor_principal_modulos',
	events  	: {
		'click #crear' : 'crear',
		'change #allDay' : 'conmutarAllDay'
	},
	initialize 	: function () {
		var self = this;

		

		var ajax = app.coleccionClientes.fetch();
		ajax.then(function () {
			var ajax = app.coleccionEmpleados.fetch();
			ajax.then(function () {
				self.cargarPlugins();
				var ajax = app.coleccionActividades.fetch();
				ajax.then(function () {
					// self.cargarCalendario();
				}, function () {});
			}, function () {});
		}, function () {});

		this.listenTo(app.coleccionActividades, 'add', this.cargarCalendario);

		this.$formNuevaActividad = this.$('#form-nueva-actividad');
		this.$datepickerDe = this.$('#datepickerDe');
		this.$datepickerA = this.$('#datepickerA');
		this.$timepicker = this.$('.timepicker');
		this.$invitados = this.$('#invitados');
		this.$calendar = this.$('#calendar');
		this.$allDay = this.$('#allDay');
	},
	crear 		: function (e) {
		var json = pasarAJson( this.$formNuevaActividad.serializeArray() );
		
		json.start = formatearFechaDB( this.$datepickerDe.datepicker('getDate') );
		json.end = formatearFechaDB( this.$datepickerA.datepicker('getDate') );
		
		if ( !this.$allDay.is(':checked') ) {
			json.start += 'T'+this.$timepicker.eq(0).val()+':00';
			json.end += 'T'+this.$timepicker.eq(1).val()+':00';
		};

		console.log(json);

		$('#block').toggleClass('activo');

		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		app.coleccionActividades.create(json,{
			wait 	: true,
			success : function (model) {
				console.log('se creo: ', model);
				$('#block').toggleClass('activo');
			},
			error 	: function (model) {
				console.log('no creo: ', model);
				$('#block').toggleClass('activo');
			}
		});
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
		e.preventDefault();
	},
	consultar 	: function () {},
	actualizar 	: function () {},
	eliminar 	: function () {},
	conmutarAllDay	: function () {
		switch( this.$allDay.is(':checked') ){
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
	cargarPlugins : function () {
		loadDatepickerRange('#datepickerDe','#datepickerA');
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
			    labelField: 'email',
			    searchField: ['name'],
			    render : {
			    	optgroup_header: function(data, escape) {
		            	return '<div class="optgroup-header">' + escape(data.label) + ' <span class="text-muted">(' + escape(data.label_description) + ')</span></div>';
		        	}
			    }
			});

		this.$calendar.fullCalendar({
			lang : 'es',
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: '2014-11-12',
			selectable: true,
			selectHelper: true,
			editable: true,
			eventLimit: true, // allow "more" link when too many events
		});
	},
	cargarCalendario : function (model) {
		var jsonModel = model.toJSON();
		console.log(jsonModel.summary,jsonModel.start.date,jsonModel.end.date);
		var json = {
			title 	: jsonModel.summary,
			start 	: jsonModel.start.date,
			end 	: jsonModel.end.date
		};
		console.log(json);
		this.$calendar.fullCalendar('renderEvent', json, true);
	}
});