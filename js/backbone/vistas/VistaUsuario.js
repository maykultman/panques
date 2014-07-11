var app = app || {};

app.VistaSelectPerfil = Backbone.View.extend({
	tagName : 'option',	
	plantilla  : Handlebars.compile($('#selectpefil').html()),

	initialize : function () 
	{
		this.$perfil = this.$('#perfil');	
		this.$el.attr('value', this.model.get('id'));
		this.$el.attr('id', 'per'+this.model.get('id'));			
	},

	render : function()
	{
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;	
	}
});

app.VistaPermiso = Backbone.View.extend({
	tagName : 'label',
	className : 'chek',

	plantilla : Handlebars.compile($('#Permisos').html()),
	events : {
		'change #chekPermiso' : 'editarPermiso'
	},

	render : function (){

		this.$el.html(this.plantilla(this.model.toJSON()));
		if(this.model.get('palomita'))
		{
			this.$el.css('background','#ddffdd');
			this.$el.css('border-radius','5px');	
		}		
		return this;
	},

	editarPermiso : function(elemento)
	{
		this.$el.css('background','#ddffdd');
		this.$el.css('border-radius','5px');
		var idusuario = $(elemento.currentTarget).parent().parent().attr('class').split(' ');
		if(!elemento.currentTarget.checked)
		{
			this.model.destroy();
			this.$el.css('background','');
			this.$el.css('border-radius','5px');	
		}
		else
		{		
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;

			app.coleccionPermisosUsuario.create
			(
				{ 
					idusuario : idusuario[1],
					idpermiso : $(elemento.currentTarget).val()
				},
				{
					wait: true,
					success: function (data){},
					error: function (error) {}
				}
			);

			Backbone.emulateHTTP = false;
			Backbone.emulateJSON = false;
		} /*Creación*/
	}
});

app.VistaUsuario = Backbone.View.extend({
	tagName : 'div',
	className : 'panel panel-default',

	plantilla : Handlebars.compile($('#usuario').html()),
	events : {
		'change   #perfil' 		: 'editar',
		'keypress #usuarioi'    : 'editar',
		'keypress #empleado'    : 'editar',
		'keypress #contrasenia' : 'editar',
	},

	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));	
		
		var select_Perfil = this.$el.find('#perfil');
		var usuario = this.model;
		this.cargarSelectPerfiles(function() 
		{	/*... Se le hace selected al puesto que le pertenece al modelo y desactiva el click...*/
			$(select_Perfil).children('#per'+usuario.get('idperfil')).attr('disabled', true).attr('selected', 'selected');				
		});
		this.cargarPermisos();
		return this;
	},

	cargarSelectPerfil : function (perfil)
	{
		var vistaPerfil = new app.VistaSelectPerfil({ model : perfil });
		this.$('#perfil').append(vistaPerfil.render().el);	
	},

	cargarSelectPerfiles : function (callback) 
	{ 
		app.coleccionPerfiles.each(this.cargarSelectPerfil, this); callback(); 
	},

	cargarPermiso : function(permiso)
	{   /*... Buscamos el permiso que le pertenece al usuario...*/
		var permi = app.coleccionPermisosUsuario.where({ idpermiso : permiso.get('id'), idusuario : this.model.id });
			
		if (typeof permi[0] != 'undefined') {
			permiso.set({palomita:'checked'}); /*... Establecemos la propiedad checked al permiso ...*/
		}
		else{
			permiso.set({palomita:''})
		};
		var vistaPermiso = new app.VistaPermiso({ model : permiso });
		this.$('#ListaPermisos').append(vistaPermiso.render().el);	
	},

	cargarPermisos : function()
	{
		app.coleccionPermisos.each(this.cargarPermiso, this);
	},

	editar : function(events)
	{		
		if(events.keyCode===13||events.type == 'change')
		{
			this.model.save(
				pasarAJson($(events.currentTarget).serializeArray()), 
				{
					wait:true,
					patch:true,
					success: function (exito){
						if($(events.currentTarget).attr('id')==='usuarioi')
						{							
							$('#t_usuario'+exito.get('id')).text(exito.get('usuario'));
							console.log(exito.get('usuario'));
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
	}
});