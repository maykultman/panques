var app = app || {};
app.VistaUsuario = Backbone.View.extend({
	tagName : 'article',
	className : 'col-xs-12 col-sm-6 col-md-4 col-lg-3',
	plantilla : Handlebars.compile($('#usuario').html()),
	plantedic  : _.template($('#user').html()),
	psubmodulos : _.template( $('#tsubmodulos').html() ),
	
	events : {
		'click button.edit'	    : 'modaledit', // Abre el modal para la edición del usuario
		'click button.guardar'  : 'editar',	
		'click .tohead'    		: 'resize',
		'click .pchek'			: 'seleccionachek',	// Seleccionar todos
		'click .delete'			: 'delete',		
	},

	initialize : function()
	{
		this.listenTo(this.model, 'destroy', this.remove); 
	},
	render : function ()
	{
		this.$el.html(this.plantilla(this.model.toJSON()));	
		return this;
	},

	seleccionachek : function(e)
	{
		 // Al darle click al texto selecciona el checkbox y activa todos los permisos
		$(e.currentTarget).children().trigger('click');
	},

	// Le da animación al icono de cada submodulo
	resize : function(elemento)
	{
		var id = this.$(elemento.currentTarget).parent().children('.conf').attr('id');
		var spancircle = this.$(elemento.currentTarget).children('i').attr('id');
		rezise(id, spancircle);	
	},

	// Muestra el select de perfiles.
	perfil : function()
	{
		var list = '<%_.each(perfiles, function(perfil) { %> <option id="<%- perfil.id %>" value="<%- perfil.id %>"><%- perfil.nombre %></option> <% }); %>';
        this.$('#idperfil'+this.model.get('id')).
        html(_.template(list)({ perfiles : app.coleccionPerfiles.toJSON() }));
	},

	// obtiene los permisos del usuario y activa los checkbox con sus permisos
	mis_permisos : function(permisos)
	{		
		var mod;
		var sub;
		var cont=0;
		var subcont=0;
		var cont3=0;
		for(c in permisos) // recorremos el array de modulos
		{
			mod = permisos[cont].nombre; //obtenemos el nombre del modulo actual en el ciclo
			
			for(d in permisos[cont].submodulos) // recorremos los submodulos estos a su vez contienen arrays de permisos
			{
				sub = permisos[cont].submodulos[subcont].nombre;				
				array = permisos[cont].submodulos[subcont].permisos; 
				
				if( $.isArray(array) )
				{
					for( e in array )
					{
						if(array[cont3]!=undefined)
						{
							this.$('#'+mod+sub+'e #'+array[cont3]).attr('checked', 'true');							
							cont3++;
						}
					}
					cont3=0;						
				}
				else{
					if(array!=undefined)
					{
						this.$('#'+mod+sub+'e #'+array).attr('checked', 'true');	
					}					
				}								
				subcont++;
			}
			subcont=0;
			cont++;
		}
	},

	modaledit :function()
	{
		// Pasamos el modelo a formato json para poder representarlo en la plantilla
		var	user = this.$('#myModal'+this.model.get('id')).attr('id');
		this.$("#edicion").append(this.plantedic(this.model.toJSON()));
		this.perfil();							
		
		$('#'+this.model.get('idperfil')).attr('disabled',true).attr('selected', 'selected');
		// Guardamos el html tipo li con el titulo de los modulos.
		var list = '<% _.each(modulos, function(modulo){ %> <li><a href="#<%- modulo.modulo+"e" %>" role="tab" data-toggle="tab"> <%- modulo.modulo%> </a></li> <% }) %>';
		// Lo agregamos al elemento DOM #moduloss
		this.$('#moduloss').append(_.template(list)({modulos : app.coleccionPermisos.toJSON() }));			
		// Activamos el primer modulo de la lista.
		this.$("#moduloss").children(':first-child').addClass('active');	

		submodulos = app.coleccionPermisos.toJSON();			
		// Obtenemos el modal 
		plantedic = this.$("#myModal"+this.model.get('id'));
		
		var json={};
		json.band = 'e';
		// Creamos un json para la plantilla que mostrará los submodulos
		for(var x=0; x < submodulos.length;x++)
		{	
			// Activamos el primer tab para mostrar sus submodulos						
			json.active = (x==0) ? "tab-pane active":"tab-pane";
			// Obtenemos el modulo...
			json.modulo = submodulos[x].modulo;				
			// Obtenemos la cadena de submodulos y lo pasamos a un array
			json.submodulos = submodulos[x].permisos.split(",");
			// Ahora pasamos el json a la plantilla donde se mostrarán los submodulos
			this.$("#submoduloss").append(this.psubmodulos(json));
		}
		var idpermisos = jQuery.parseJSON(this.model.get('idpermisos'));	
		// la función mis permisos devuelve los permisos de un determinado perfil

		this.mis_permisos( idpermisos );
		plantedic.on('hidden.bs.modal', function(){
		 	this.remove();		 	
		});

		plantedic.modal({
			keybooard :false,
			backdrop  :false
		});
		
	},

	editar : function(e){
		var usuario={};
		var form = pasarAJson(this.$('form').serializeArray());	
		usuario.usuario = form.usuario;
		if(form.idperfil!=undefined){
			usuario.idperfil = form.idperfil
			delete form.idperfil;
		}
		delete form.usuario;
		usuario.idpermisos = jsonpermisos(form);	
		
		this.model.save
		(
			usuario,
			{
				wait:true,
				patch:true,
				success: function (exito){
					alerta('<span class="exito">Edición Guardada con Éxito</span>', function(){});
				}, 
				error: function (error){
					alerta('<span class="error">Ocurrior un error al guardar</span>', function(){});
				}
			}
		);
		e.preventDefault();
	},

	delete : function(e){
		var self = this;
		confirmar(	'<b>¿Esta seguro que desea eliminar a este usuario?</b>', 
					function () {	self.model.destroy();	
					}, 
					function () {}
					);	
	}

});