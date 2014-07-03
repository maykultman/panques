var app = app || {};

//***********************************Save***********//
app.VistaTelefonoEmpleado = Backbone.View.extend({
	tagName : 'div',
	className : 'padre',
	plantilla  : _.template($('#telefono').html()),

	events : {
		'keypress #tel' : 'editarTelefono',
		'keypress .tel' : 'validarTelefono'
	},

	initialize : function () {},

	render : function ()
	{	//Renderiza en la plantilla el modelo....
		this.$el.html(this.plantilla(this.model.toJSON()));	
		return this;
	},

	validarTelefono	: function (e) {
		key = e.keyCode || e.which;
        tecla = String.fromCharCode(key);
        letras = "1234567890";
        especiales = "8-37-39-46";
        tecla_especial = false
        for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
                return false;
        }
  		
	},

	editarTelefono : function(events)
	{
		if(events.keyCode === 13)
		{
			if($(events.currentTarget).val()) // La variable rol tiene valor
			{
				this.model.save
				(
					pasarAJson($(events.currentTarget).serializeArray()), 
					{
						wait:true,
						patch:true,
						success: function (exito){
							$(events.currentTarget)
							.blur()
							.parents('.padre')
							.children('.resp')
							.html('&nbsp;<label class="icon-uniF479 exito"></label>');
						}, 
						error: function (error){
							$(events.currentTarget)//Selector
							.blur()
							.parents('.padre')
							.children('.resp')
							.html('&nbsp;<label class="icon-uniF478 error"></label>');
						}
					}
				);
			}//If de validación de la variable rol
			events.preventDefault();
		};//..if elemento.keyCode
	}	
});
//*****************************************************//

app.VistaCatalogoEmpleado = Backbone.View.extend({

	tagName : 'div',

	plantilla : _.template($('#datosEmpleado').html()),

	events : {
		'click .icon-trash'   	     : 'destroyModel',
		'keypress #nombrei'   	     : 'editar',
		'change   #puesto'   	     : 'editar',
		'keypress #direccion'        : 'editar',
		'keypress #correo'   	     : 'editar',
		'change   #fecha_nacimiento' : 'editar'		
	},

	initialize : function()	{ 
		// this.listenTo(this.model[0], 'change', this.prerender);  
		this.listenTo(this.model[0], 'destroy', this.remove);

	},

	prerender : function()
	{
		this.render(this.model[0].toJSON());
		// this.$('#nombreEmpleado').trigger('click'); /*...eventos del teclado...*/        
	},

	render : function(info) 
	{	var empleado;

		if   (info.empleado) { empleado = info.empleado;	}
		else    		     { empleado = info;     		}


		this.$el.html(this.plantilla(empleado));
		var select_puestos = this.$el.find('#puesto');
		this.cargarSelectPuestos(
			function()
			{
				$(select_puestos).children('#puesto_'+empleado.puesto).attr('disabled', true);				
				$(select_puestos).children('#puesto_'+empleado.puesto).attr('selected', 'selected');				
			}
		);

		this.$tmovil = this.$('#tel');
		this.cargarTel();
		return this;		
	},

	editar : function(events)
	{
		if(events.keyCode===13||events.type == 'change')
		{
			this.model[0].save(
				pasarAJson($(events.currentTarget).serializeArray()), 
				{
					wait:true,
					patch:true,
					success: function (exito){
						if($(events.currentTarget).attr('id')==='nombrei')
						{
							var datos = exito.toJSON();
							$('#nombreEmpleado'+datos.id).text(datos.nombre);
						}
						$(events.currentTarget)//Selector
						.blur()//Salimos del elem						
						.parents('.padre')//Nos hubicamos en el padre del selector						
						.children('.resp')//Buscamos al hijo con la clase especificada						
						.html('&nbsp;<label class="icon-uniF479 exito">');//Removemos su atributo class						
					}, 
					error: function (error){
						$(events.currentTarget)//Selector
						.blur()
						.parents('.padre')
						.children('.resp')
						.html('&nbsp;<label class="icon-uniF478 error">');
					}
				}
			);
			events.preventDefault();
		}
	},

	cargarTel : function()
	{
		var telefono  = app.coleccionTelefonos.where({ idpropietario : this.model[0].get('id'), tabla : 'empleados' });
		for(i in telefono)
		{
			var vistaTelefono = new app.VistaTelefonoEmpleado({ model : telefono[i]});						
			this.$tmovil.append(vistaTelefono.render().el);			
		}	
	},	

	cargarSelectPuesto : function (puesto)
	{
		var vistaPuesto = new app.VistaSelectPuesto({ model : puesto});
		this.$('#puesto').append(vistaPuesto.render().el);	
	},

	cargarSelectPuestos : function (callback) {	app.coleccionPuestos.each(this.cargarSelectPuesto, this);	callback(); },

	destroyModel        : function () {	this.model[0].destroy();	                                }

});