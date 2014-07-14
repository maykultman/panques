var app = app || {};

app.VistaNuevoUsuario = Backbone.View.extend({
	el : '#datosUsuario',

	events : {
		'click #guardar'    : 'urlFoto',
		'click #empleado'   : 'buscarEmpleado',
		'blur  #empleado'   : 'Aidempleado',
		'keypress #empleado': 'soloLetras',
		'change #idperfil'  : 'mostrarPermisos',
		'change #idpermisos' : 'marcarTodos'
	},

	initialize : function ()
	{	
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
		var vistaPermiso = new app.VistaRenderizaPermiso({model : permiso});		
		this.$ListaPermisos.append(vistaPermiso.render().el);
	},
	cargarPermisos : function (elemento)
	{	$('#ListaPermisos').html('');
		app.coleccionPermisos.each(this.cargarPermiso, this);
	},
	
	cargarSelectPerfil : function (perfil)
	{
		var vistaPerfil = new app.VistaSelectPerfil({ model : perfil});		
	    this.$('#idperfil').append(vistaPerfil.render().el);
	},

	cargarSelectPerfiles : function ()
	{	
		app.coleccionPerfiles.each(this.cargarSelectPerfil, this);
	},

	mostrarPermisos : function(idperfil)
	{
		var nombre = app.coleccionPerfiles.findWhere({id : $(idperfil.currentTarget).val() }).get('idpermisos');
		this.cargarPermisos();
		if(nombre)
		{
			marcarPermiso(JSON.parse(nombre).idpermisos, this.$el.find('.chek').children(), this.$el);	
		}		
	},

	Aidempleado : function()
	{
		var idempleado = app.coleccionEmpleados.findWhere({ nombre : $('#empleado').val()});
		$('#hempleado').val(idempleado.get('id'));
	},

	buscarEmpleado : function (elemento)
	{
        empleado = new Array();  var cont  = 0; 
        for(i in app.coleccionDeEmpleados)
        {
            empleado[cont] = app.coleccionDeEmpleados[i].nombre; cont++;
        };
        $('#empleado').autocomplete({ source: this.empleado});
	},

	marcarTodos : function(elemento)
	{
		marcarCheck(elemento);      
	},

	guardar	 : function ()
	{
		var modeloUsuario = pasarAJson($('#registroUsuario').serializeArray());
		modeloUsuario = limpiarJSON(modeloUsuario);	
		
		modeloUsuario.idpermisos = JSON.stringify({idpermisos:modeloUsuario.idpermisos});
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
				foto        : fotoUsuario,
				idpermisos  : modeloUsuario.idpermisos
			},
			{
				wait	: true,
				success : function (exito) {},
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
            url: 'http://crmqualium.com/api_foto',
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
