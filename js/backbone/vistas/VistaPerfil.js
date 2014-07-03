var app = app || {};
/*...Esta vista es para crear o eliminar permisos de un determinado perfiel...*/
app.VistaPermisoDePerfil = Backbone.View.extend({
	tagName : 'label',
	className : 'chek',

	plantilla : _.template($('#Permisos').html()),
	events : {
		'change #chekPermiso' : 'GuadarPermiso'
	},

	initialize : function(){},

	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	},

	GuadarPermiso : function(elemento)
	{
		if(!elemento.currentTarget.checked)
		{
			 this.model.destroy();	/*...Si el checkbox se des selecciona entonces lo eliminamos del perfil...*/
		}
		else
		{		
			Backbone.emulateHTTP = true;
			Backbone.emulateJSON = true;

			app.coleccionPermisosPerfil.create
			(
				{ 
					idperfil  : $(elemento.currentTarget).parent().parent().parent().attr('id'),
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

app.VistaPerfil = Backbone.View.extend({
	tagName : 'div',

	plantilla : _.template($('#Perfil').html()),

	events : {},

	initialize : function (){},

	render : function (){
		this.$el.html(this.plantilla(this.model.toJSON()));
		this.$ListaPermisos = this.$('#ListaPermisos');
        this.cargarPermisos();
		return this;
	},

	cargarPermiso : function(permiso)
	{
		var si = app.coleccionPermisosPerfil.where({idperfil:this.model.get('id'), idpermiso:permiso.get('id')});
		
		if (si[0] != undefined) {
			permiso.set({palomita:'checked'});
			var vistaPermiso = new app.VistaPermisoDePerfil({ model : permiso });
			this.$ListaPermisos.append(vistaPermiso.render().el);
		} 
		else
		{
			permiso.set({palomita:''});
 			var vistaPermiso = new app.VistaPermisoDePerfil({ model : permiso });
			this.$ListaPermisos.append(vistaPermiso.render().el);
		};
	},

	cargarPermisos : function()
	{
		app.coleccionPermisos.each(this.cargarPermiso, this);	
	},

	eliminar : function() { this.model.destroy(); }

});