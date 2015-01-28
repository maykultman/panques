var app = app || {};

app.VistaPerfil = Backbone.View.extend({
	tagName : 'article',
	className : 'col-xs-12 col-sm-6 col-md-4 col-lg-3',
	
	plantilla : _.template($('#divperfil').html()), // plantilla para dibujar la tarjeta de perfil
	mimodal : _.template( $('#miperfil').html() ),  // plantilla para la edición del perfil
	psubmodulos : _.template( $('#tsubmodulos').html() ), // plantilla donde se generán la lista de submodulos

	events : 
	{
		'click button.edit'		: 'edicion',
		'click #save' 			: 'save_edicion',
		'click .tohead'    		: 'resize',
		'click button.delete'	: 'destroy',	
		'click .pchek'			: 'seleccionachek'	
	},
	
	initialize : function()
	{
		this.listenTo(this.model, 'destroy', this.remove); 
		this.$ListaPermisos = this.$('#ListaPermisos');
	},

	seleccionachek : function(e)
	{
		$(e.currentTarget).children().trigger('click'); // Al darle click al texto selecciona el checkbox
	},

	render : function (){
		
		this.$el.html( this.plantilla( this.model.toJSON() ) );       
		return this;
	},

	resize : function(elemento)
	{
		var id = this.$(elemento.currentTarget).parent().children('.conf').attr('id');
		var spancircle = this.$(elemento.currentTarget).children('i').attr('id');
		rezise(id, spancircle);	
	},

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
	
	edicion : function(e)
	{
		perfil_id = $(e.currentTarget).attr('id'); // Obtenemos el id del perfil
		// Buscamos sus permisos
		var mis_permisos = app.coleccionPerfiles.findWhere({ 'id' : perfil_id}).get('idpermisos'); 
		// Nos devolvera una cadena en formato json y lo convertimos a json.
		mis_permisos = jQuery.parseJSON(mis_permisos);		

		var json={};	
		// El atributo json.band permite diferenciar los elementos del modal de editar perfil y nuevo perfil
		// En esta función estamos ejecutando el modal de edición la 'e' se concatena a los id's de los elemtos del modal
		json.band = 'e';
		this.$("#edicion").append( this.mimodal( this.model.toJSON() ) );
		
		// Guardamos el html tipo li con el titulo de los modulos.
		var list = '<% _.each(modulos, function(modulo){ %> <li><a href="#<%- modulo.modulo+"e" %>" role="tab" data-toggle="tab"> <%- modulo.modulo%> </a></li> <% }) %>';
		// Lo agregamos al elemento DOM #moduloss
		this.$('#moduloss').append(_.template(list)({modulos : app.coleccionPermisos.toJSON() }));			
		// Activamos el primer modulo de la lista.
		this.$("#moduloss").children(':first-child').addClass('active');	

		//obtenemos los permisos en formato json
		submodulos = app.coleccionPermisos.toJSON();				
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
		// la función mis permisos devuelve los permisos de un determinado perfil
		this.mis_permisos( mis_permisos );
		// Aquí obtenemos el modal del perfil actual...
		mimodal = this.$("#modaledicion"+this.model.get('id'));
		var here = this;
		// Aquí los removemos del DOM para evitar conflictos con id´s del modal de otros perfiles.
		mimodal.on('hidden.bs.modal', function()
		{
			this.remove();
			here.render();
		});
	},
	
	save_edicion : function(events)
	{
		var permisos = pasarAJson(this.$('#arraypermisos').serializeArray());		
		permisos = jsonpermisos(permisos);
		var modeloPerfil = {
			nombre : this.$('.form-control').val(),
			idpermisos : permisos
		}
		this.model.save
		(
			modeloPerfil,
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
		events.preventDefault();
	},

	destroy : function(e)
	{
		var self = this;
		var perfil = $(e.currentTarget).data('perfil');
		var api = $(e.currentTarget).data('url');
		$.ajax({
			url : api+perfil,
			type: 'POST',
			async:false,			
			success:function(exito){
				if(exito==1)
				{
					alerta('No puede eliminar este perfil');
				}else{
					confirmar('<b>¿Esta seguro que desea borrar el perfil?</b>', 
						function () {	self.model.destroy();}, function () {});	
				}
			},
			error:function(error){ alerta('Hubo un error verifique su conexión'); }
		});	
	}
});
