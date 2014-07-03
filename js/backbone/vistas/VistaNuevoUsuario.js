var app = app || {};

//*****************************************************//
app.VistaSelectPerfil = Backbone.View.extend({
	tagName : 'option',
	
	plantilla  : _.template($('#selectperfil').html()),

	events : {},

	initialize : function () 
	{
		this.$el.attr('value', this.model.get('id'));
		this.$el.attr('id', this.model.get('id'));			
	}, 

	render : function()
	{
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	}
});

app.VistaPermisoPerfil = Backbone.View.extend({
	tagName : 'label',
	className : 'chek',

	plantilla : _.template($('#Permisos').html()),
	events : {},

	initialize : function(){},

	render : function ()
	{
		var permi = app.coleccionPermisosPerfil.where({ idpermiso : this.model.get('id'), idperfil : this.model.get('idperfil') });
		if (typeof permi[0] != 'undefined') {
			this.$el.css('background','#ddffdd');
			this.$el.css('border-radius','5px');
			this.model.set({palomita:'checked'});
		}
		else{
			this.model.set({palomita:''})
		};
		this.$el.html(this.plantilla(this.model.toJSON()));
		return this;
	},
});

app.VistaNuevoUsuario = Backbone.View.extend({
	el : '#datosUsuario',

	events : {
		'click #guardar'    : 'urlFoto',
		'click #empleado'   : 'buscarEmpleado',
		'blur  #empleado'   : 'Aidempleado',
		'keypress #empleado': 'soloLetras',
		'change #idperfil'  : 'mostrarPermisos',
		'change #idpermiso' : 'marcarTodos'
	},

	initialize : function ()
	{
		this.$Perfiles = this.$('#idperfil');
        this.cargarSelectPerfiles();

		this.$ListaPermisos = this.$('#ListaPermisos');
        this.cargarPermisos();	
	},

	render : function()	{	return this; },

	soloLetras : function(e)
    {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = "8-37-39-46";

        tecla_especial = false
        for(var i in especiales)
        {
            if(key == especiales[i])
            {
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
             return false;
        }
    },

	cargarPermiso : function (permiso)
	{
		var vistaPermiso = new app.VistaPermisoPerfil({model : permiso});		
		this.$ListaPermisos.append(vistaPermiso.render().el);
	},
	cargarPermisos : function (elemento)
	{	$('#ListaPermisos').html('');
		app.coleccionPermisos.each(this.cargarPermiso, this);
	},
	
	cargarSelectPerfil : function (perfil)
	{
		var vistaPerfil = new app.VistaSelectPerfil({ model : perfil});		
	    this.$Perfiles.append(vistaPerfil.render().el);
	},

	cargarSelectPerfiles : function ()
	{	
		app.coleccionPerfiles.each(this.cargarSelectPerfil, this);
	},

	mostrarPermisos : function(idperfil)
	{
		var self = this;
		$('#ListaPermisos').html('');
		app.coleccionPermisos.each(function(model){
			model.set({idperfil:$(idperfil.currentTarget).val()});
			self.cargarPermiso(model);
		}, this);
	},

	Aidempleado : function()
	{
		var busca=0;
		
		for(e in this.empleado)
	    {
	      	if($('#empleado').val()==this.empleado[e])
	      	{
	       		$('#hempleado').val(this.empleado[busca+1]);
	       	}
	       	busca++;
	    }
	},

	buscarEmpleado : function (elemento)
	{
        this.empleado = new Array();  var cont  = 0; 
        for(i in app.coleccionDeEmpleados)
        {
            this.empleado[cont] = app.coleccionDeEmpleados[i].nombre; cont++;
            this.empleado[cont] = app.coleccionDeEmpleados[i].id; 	  cont++;
        };
        $('#empleado').autocomplete({ source: this.empleado});
	},

	marcarTodos : function(elemento)
	{
		var checkboxTabla = document.getElementsByName($(elemento.currentTarget).attr('id'));
		
		if ($(elemento.currentTarget).is(':checked')) 
		{
 	 		for (var i = 0; i < checkboxTabla.length; i++) 
 	 		{
				checkboxTabla[i].checked = true;
			}
 	 	}
        else
        {
        	for (var i = 0; i < checkboxTabla.length; i++) 
        	{
				checkboxTabla[i].checked = false;
			}
        }        
	},

	guardar : function (fotoUsuario)
	{
		var modeloUsuario = pasarAJson($('#registroUsuario').serializeArray());
		modeloUsuario = limpiarJSON(modeloUsuario);	
		
		var permisos = modeloUsuario.idpermiso;
		var self = this;
		$('#registroUsuario')[0].reset();
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		app.coleccionUsuarios.create
		(
			{
				idempleado  : modeloUsuario.idempleado,
				idperfil    : modeloUsuario.idperfil,
				usuario     : modeloUsuario.usuario,
				contrasenia : modeloUsuario.contrasenia,
				foto        : fotoUsuario
			},
			{
				wait	: true,
				success : function (exito) {
					
					Backbone.emulateHTTP = true;
					Backbone.emulateJSON = true;
					for(i in modeloUsuario.idpermiso)
					{
						app.coleccionPermisosUsuario.create
						(
							{
								idusuario :  exito.get('id'),
								idpermiso  : modeloUsuario.idpermiso[i],							
							},
							{
								wait	: true,
								success : function (exito) {
									console.log('exito');
									
									// self.cargarPermisos();
								},
								error 	: function (error) {}
							}
						);

					} /*...for...*/
					
					Backbone.emulateHTTP = false;
					Backbone.emulateJSON = false;
				},
				error 	: function (error) {}
			}
		);
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
		
	}, /*... Fin de la función guardar ...*/

	// -----obtenerFoto------------------------------- 
	urlFoto	: function (evento) {
		
        var formData = new FormData($("#registroUsuario")[0]);
        //hacemos la petición ajax  
        var resp = $.ajax({
            url: 'http://qualium.mx/sites/crmqualium/api_foto',
            type: 'POST',
            async:false,
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false
        });
        var nombreFoto = jQuery.parseJSON(resp.responseText);
        if (nombreFoto != false)
        {
        	var foto = 'img/fotosUsuario/'+nombreFoto+'';	
        	this.guardar(foto);        	
        	return;
        }
        else
        {        	
        	return 'img/fotoUsuario/sinfoto.png';
        };

        evento.preventDefault();
	},
});

app.vistaNuevoUsuario = new app.VistaNuevoUsuario();
