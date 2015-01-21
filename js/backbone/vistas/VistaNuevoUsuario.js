var app = app || {};

app.VistaNuevoUsuario = Backbone.View.extend({
	el : '#datosUsuario',
	plantilla : _.template($('#tsubmodulos').html()),

	events : 
	{
		'click #guardar'   		: 'guardar',			
		'keypress .has-options input'	: 'soloLetras',
		'click .tohead'    		: 'resize',
		'change #idperfil' 		: 'mispermisos',
		'click .todos' 			: 'mark',
		'change #idpermisos' 	: 'marcarTodos',
		'click .pchek' 			: 'seleccionachek',
		'change #fotou' : 'obtenerFoto1',
		'change #idempleado' : 'foto'
	},
	foto : function(e)
	{
		var id = $(e.currentTarget).val();		
		var base = $("#idempleado").data('url');
		var foto = app.coleccionEmpleados.findWhere({'id': id});
		var img='';
		if(foto)
		{
			img = foto.get('foto');
		}		
		this.$("#direccion").attr('src', base+img);
	},
	mark : function(e)
	{
		$(e.currentTarget).children().trigger('click');
	},

	marcarTodos : function(chek)
	{
		markTodos(chek);
	},

	seleccionachek : function(e)
	{
		$(e.currentTarget).children().trigger('click');
	},

	obtenerFoto1 : function(e)
	{
		this.$("#direccion").removeAttr('src');
		obtenerFoto2(e, 'fotou', 'direccion');
	},
	initialize : function ()
	{	
		this.cargarModulo();	
		this.selectEmpleados();
		this.cargarSubmodulo();
		this.selectPerfil();
	},

	selectPerfil : function()
	{
		var list = '<% _.each(perfiles, function(perfil) { %> <option id="<%- perfil.id %>" value="<%- perfil.id %>"><%- perfil.nombre %></option> <% }); %>';
        this.$('#idperfil').append(_.template(list)
        ({ perfiles : app.coleccionPerfiles.toJSON() }));
	},

	resize : function(elemento)
	{
		var id = this.$(elemento.currentTarget).parent().children('.conf').attr('id');
		var spancircle = this.$(elemento.currentTarget).children('i').attr('id');
		rezise(id, spancircle);	
	},

	selectEmpleados : function()
    {
    	var list = '<option disabled>Seleccione un empleado</option><% _.each(empleados, function(empleado) { %> <option disabled id="<%- empleado.id %>" value="<%- empleado.id %>"><%- empleado.nombre %></option> <% }); %>';
		this.$('#idempleado').append(_.template(list)
		({ empleados : app.coleccionEmpleados.toJSON() }));
		
		this.$('#idempleado').selectize({
			create: true,
			maxItems: 1
		});
    },

	cargarModulo : function()
	{
		var list = '<% _.each(modulos, function(modulo){ %> <li><a href="#<%- modulo.modulo %>n" role="tab" data-toggle="tab"> <%- modulo.modulo%> </a></li> <% }) %>';
		this.$('#modulos').append(_.template(list)
		({ modulos : app.coleccionPermisos.toJSON() }));
		$("#modulos").children(':first-child').addClass('active');
	},

	cargarSubmodulo : function()
	{
		submodulos = app.coleccionPermisos.toJSON();			
		
		var json={};
		json.band = 'n';			
		for(var x=0; x < submodulos.length;x++)
		{	
			json.active = (x==0) ? "tab-pane active":"tab-pane";
			json.modulo = submodulos[x].modulo;
			
			json.submodulos = submodulos[x].permisos.split(",");			
			this.$("#submodulos").append(this.plantilla(json));				
		}				
	},
	
	mispermisos : function(idperfil)
	{
		$('#submodulos').html('<div class="text-center"><img id="ajax" src="../../../img/ajax.gif" width:"100";/></div>');
		var selft=this;
		idperfil = $(idperfil.currentTarget).val();
		var permisos = app.coleccionPerfiles.findWhere({id : idperfil }).get('idpermisos');
		var mispermisos = jQuery.parseJSON(permisos);
		var inputchek='';		
		
		setTimeout(function(){		   
			
			$('#submodulos').html('');
			selft.cargarSubmodulo();
			for(i in mispermisos)
			{
				if(
					  mispermisos[i].nombre=='Clientes' ||mispermisos[i].nombre=='Proyectos'
					||mispermisos[i].nombre=='Contratos'||mispermisos[i].nombre=='Cotizaciones'
					||mispermisos[i].nombre=='Proyectos'||mispermisos[i].nombre=='Actividades'
					||mispermisos[i].nombre=='Catálogos'||mispermisos[i].nombre=='Usuarios'
				  )
				{
					for(x in mispermisos[i].submodulos)
					{
						for(y in mispermisos[i].submodulos[x].permisos)
						{
							inputchek = $('#'+mispermisos[i].nombre+mispermisos[i].submodulos[x].nombre+'n .pchek  #'+mispermisos[i].submodulos[x].permisos[y]);						
						    $(inputchek).attr('checked',true);												
						}					
					}
				}		
			}
		}, 500);//setTimeOut
		
	},

	guardar	 : function ()
	{	
		/*--- si el campo foto del formulario tiene una url de carpeta que contenga un archivo img entonces 
			  invocamos a la función urlFoto, y le enviamos de parametro formData---*/		
		if( this.$('#fotou').val() )
		{
			form = new FormData( this.$("#registro")[0]);
			empleado.foto = urlFotoCatalgos(form, this.$('#fotou').data('url') );
		} 
		else{
			empleado.foto = 'img/sinfoto.png';
		}
		/*-- Si el usuario es un empleado se le asigna su idempleado en caso de que sea un usuario que no es empleado su id=0--*/
		var ide = ($("#idempleado").val()) ? $("#idempleado").val() : 0;
		
		var modeloUsuario 		= pasarAJson($('#registroUsuario').serializeArray());
		modeloUsuario 			= limpiarJSON(modeloUsuario); 

		var permisos = pasarAJson(this.$('#arraypermisos').serializeArray());		
		/*--- asignamos atributos ---*/
		modeloUsuario.idempleado = ide;
		modeloUsuario.foto 		 = foto;
		/*--- la funcion jsonpermisos(); devuelve una cadena de todos los permisos asignados ---*/
		modeloUsuario.idpermisos 	= jsonpermisos(permisos);
		
		$('#registroUsuario')[0].reset();

		globaltrue();//vease en el archivo funcionescrm.js|		
		app.coleccionUsuarios.create
		(
			modeloUsuario,
			{
				wait	: true,
				success : function (exito) { location.href='usuarios_consulta'; },
				error 	: function (error) {
					alerta('<p style="color:FireBrick"><b>Error al registrar al usuario</b></p>', function(){});
				}
			}
		);
		globalfalse();//vease en el archivo funcionescrm.js			|		
		
	}, /*... Fin de la función guardar ...*/

	soloLetras : function(e)
    {
        return validarNombre(e);
    }

});

app.vistaNuevoUsuario = new app.VistaNuevoUsuario();