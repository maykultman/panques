var app = app || {};

app.VistaNuevoPerfil = Backbone.View.extend({
	el : '#nuevop',
	plantilla : _.template($('#tsubmodulos').html()),

	events : {
		'click #guardar' 		: 'guardar',
		'keypress #nombre' 	 	: 'validarNombre',
		'click #perfil_nuevo' 	: 'cargarSubmodulo',
		'click .tohead'    		: 'resize', 
		'click .pchek'			: 'seleccionachek', // Selecciona los chekbox(permisos)
		'change #idpermisos'   	: 'marcarTodos',
		'click .todos' : 'mark',
		
	},

	initialize : function ()
	{
	    this.cargarModulo();
	    $('#submodulos').html();
        this.cargarSubmodulo();
	},
	render : function (){ return this; },

	seleccionachek : function(e)
	{
		$(e.currentTarget).children().trigger('click');
	},

	mark : function(e)
	{
		$('#idpermisos').trigger('click');
	},

	marcarTodos : function(chek)
	{
		markTodos(chek);
	},

	resize : function(elemento)
	{
		var id = this.$(elemento.currentTarget).parent().children('.conf').attr('id');
		var spancircle = this.$(elemento.currentTarget).children('i').attr('id');
		rezise(id, spancircle);	
	},

	cargarModulo : function()
	{
		var list = '<% _.each(modulos, function(modulo){ %> <li><a href="#<%- modulo.modulo+"n" %>" role="tab" data-toggle="tab"> <%- modulo.modulo%> </a></li> <% }) %>';
		
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

	guardar : function(evento)
	{
		evento.preventDefault();
		var permisos = pasarAJson(this.$('#arraypermisos').serializeArray());		
		permisos = jsonpermisos(permisos);

		$('#arraypermisos')[0].reset();
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;

		app.coleccionPerfiles.create
		(
			{
				nombre : $("#nombre1").val(),
				idpermisos : permisos
			},
			{
				wait : true,
				success: function (exito)
				{
					alerta('<span class="exito">Perfil Guardado con Éxito</span>', function(){});
				},
				error: function (error) {
					alerta('<span class="error">Error al registrar el Perfil</span>', function(){});
				}
			}
			
		);
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
	}

});

app.vistaNuevoPerfil = new app.VistaNuevoPerfil();