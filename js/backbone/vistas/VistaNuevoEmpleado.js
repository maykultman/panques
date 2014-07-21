var app = app || {};

//*****************************************************//
app.VistaPuestoEmpleado = Backbone.View.extend({
	tagName : 'li',
	className : 'opciones',

	plantilla  : _.template($('#ppuestos').html()),

	events : {},

	initialize : function () {
		this.$listaPuesto = this.$('#listaPuesto');		
	},

	render : function ()
	{	//Renderiza en la plantilla el modelo....
		this.$el.html(this.plantilla(this.model.toJSON()));
		this.$el.attr('id', 'puesto_'+this.model.get('id'));		
		return this;
	}	
});
//*****************************************************//

//*****************************************************//
app.VistaSelectPuesto = Backbone.View.extend({//app.VistaPuestoEmpleado.extend({
	tagName : 'option',
	
	plantilla  : _.template($('#selectpuesto').html()),

	events : {},

	initialize : function () 
	{
		this.$puesto = this.$('#puesto');	
		this.$el.attr('value', this.model.get('id'));
		this.$el.attr('id', this.model.get('id'));			
	},

	render : function()
	{
		this.$el.html(this.plantilla(this.model.toJSON()));
		this.$el.attr('id', 'puesto_'+this.model.get('id'));		
		return this;	
	}

});
//*****************************************************//

app.VistaNuevoEmpleado = Backbone.View.extend({
	el : '#modal_nuevo_empleado',

	events : {
		'click #guardar'  : 'guardar',
		'keypress #cel'   : 'validarTelefono',
		'keypress #casa'  : 'validarTelefono',
		'blur #correo'    : 'validarCorreo',
		'keypress #nombre': 'validarNombre'
	},

	initialize : function ()
	{
		this.contadorAlerta = 1;
		this.$selectpuesto = this.$('#puesto');
		this.cargarSelectPuestos();		
	},

	render : function()	{	return this; },

	validarTelefono	: function (e) 
	{
		return validarTel(e);
	},

	validarNombre : function(e)
	{
		key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = "8-37-39-46";
        tecla_especial = false;
        for(var i in especiales)
        {
            if(key == especiales[i])
            {
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial)
        {
            return false;
        }                 
	},

	guardar : function (evento)
	{
		var modeloTelefono = new Array();
		var modeloEmpleado = pasarAJson($('#registro').serializeArray());
		modeloEmpleado = limpiarJSON(modeloEmpleado);
		console.log(modeloEmpleado.puesto);
		$('#registro')[0].reset();
 		/* nombre tiene algún valor?*/
	 	if(modeloEmpleado.nombre&&modeloEmpleado.puesto)
	 	{
			if(modeloEmpleado.movil!=undefined) /*... Tiene telefono movil?...*/
			{
				var movil = modeloEmpleado.movil;
				delete modeloEmpleado.movil;    /*... eliminamos movil de modelo que contiene los datos el empleado ...*/
			}else{ var movil = '0000'}
			if(modeloEmpleado.casa!=undefined) /*... Tiene telefono de casa?...*/
			{
				var casa  = modeloEmpleado.casa;					
				delete modeloEmpleado.casa;    /*... eliminamos movil de modelo que contiene los datos el empleado ...*/
			}else{ var casa = '00000'}
			var self = this;
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;
			app.coleccionEmpleados.create
			(
				modeloEmpleado,
				{
					wait: true,
					success: function (exito)
					{
						if(movil) /* Esperamos un exito del post del empleado para guardar su telefono*/
						{
							modeloTelefono[0] = { id 			: '',
												  idpropietario : exito.get('id'),
												  tabla         : 'empleados', 
												  numero        : movil, 
									  			  tipo          : 'movil'
												};
		        		}
		        		if(casa)
						{
		        			modeloTelefono[1] = { id 			: '',
		        								  idpropietario : exito.get('id'),
									  			  tabla         : 'empleados', 
									  			  numero        : casa, 
									  			  tipo          : 'casa'
												};
						}
						
						if(modeloTelefono.length>0)
						{
							Backbone.emulateHTTP = true;
							Backbone.emulateJSON = true;
							for (i in modeloTelefono) 
							{	
								app.coleccionTelefonos.create
								(
									modeloTelefono[i],
									{
										wait: true,
										success: function (exito){
											if(self.aumentarContador() === 2)
					                        { 
					                            alerta('<p style="color:#1A641A"><b>El empleado '+modeloEmpleado.nombre+' se guardo con éxito<b></p>', function(){} );  
					                        }
											
										},
										error  : function(error){
											alerta('<p style="color:FireBrick"><b>Error al registrar el Empleado</b></p>', function(){});
										}
									}
								);						
							}
							Backbone.emulateHTTP = false;
							Backbone.emulateJSON = false;
						}
						$('#modal_nuevo_empleado').modal('hide'); /* Oculta el modal*/
						
					}, // Fin de success...
					error: function (error) {}
				}
			);
			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;			
		}
		else{
			var campo;
			if(modeloEmpleado.puesto==undefined)
			{
				campo = 'Cargo al empleado';
			}
			if(modeloEmpleado.nombre==undefined)
			{
				campo = 'nombre al Empleado';
			}
			alerta('<p style="color:FireBrick"><b>Ingrese un '+campo+'</b></p>', function(){});
		}		
		evento.preventDefault();
	}, /*... Fin de la función guardar ...*/
	
	cargarSelectPuesto : function (puesto)
	{
		var vistaPuesto = new app.VistaSelectPuesto({ model : puesto});		
	    this.$selectpuesto.append(vistaPuesto.render().el);
	},

	cargarSelectPuestos : function ()
	{	
		app.coleccionPuestos.each(this.cargarSelectPuesto, this);
	},

	aumentarContador : function()
    {
      return this.contadorAlerta++;
    },

	validarCorreo	: function (elemento) 
	{
		if( !(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(elemento.currentTarget).val().trim())) && $(elemento.currentTarget).val().trim() != '' ) {
			alerta('No es un correo valido',function () {});
			$(document.getElementsByTagName('body')).find('#alertify-ok').on('click',function(){
				$(elemento.currentTarget).focus();
			});
			$(elemento.currentTarget).css('border-color','#a94442');
	      	return false;
	    } else{
	    	$(elemento.currentTarget).css('border-color','#CCC');
	    	return true;
	    };
	},
});

app.vistaNuevoEmpleado = new app.VistaNuevoEmpleado();

app.VistaConsultaEmpleado = Backbone.View.extend({
	el : '#consultaEmpleado',

	events : {
		'click .opciones'	  : 'opciones'
	},

	initialize : function ()
	{		
		this.$divEmpleado = this.$('#accordion'); // Div donde se visualiza los datos del empleado			
		this.$listaPuesto = this.$('#listaPuesto'); // Lista de opciones de puestos
		this.cargarPuestos();
		this.opciones('puesto_1'); //Carga empleados		
	},

	opciones : function(evento)
	{	
		var id;
		if(evento==='puesto_1')
		{
			 id = evento.split('_');			 
		}
		else
		{
			id = ($(evento.currentTarget).attr('id')).split('_');			
		}

		this.$divEmpleado.html('');		
		var evens = _.filter(app.coleccionEmpleados.toJSON(), 
			function(empleado)
			{ 
				var validate = false; 
				if(empleado.puesto == id[1])
				{
					validate = true;
				}
				return validate;

			});

		for(x in evens)
		{
			var employ = app.coleccionEmpleados.where({ id : evens[x].id });
			var viewEmpleado = new app.VistaCatalogoEmpleado({ model : employ });

			this.$divEmpleado.append(viewEmpleado.render({ empleado : evens[x]}).el);						
		}

	},	

	cargarPuesto : function (puesto)
	{
		var vistaPuesto = new app.VistaPuestoEmpleado({ model : puesto});		
		this.$listaPuesto.append(vistaPuesto.render().el);
	},

	cargarPuestos : function ()
	{	
		app.coleccionPuestos.each(this.cargarPuesto, this);
		$('#listaPuesto').children(':first-child').addClass('active');
	}	

});

app.vistaConsultaEmpleado = new app.VistaConsultaEmpleado();
