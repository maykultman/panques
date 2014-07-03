var app = app || {};

app.VistaNuevoCliente = Backbone.View.extend({
	el		: '.contenedor_modulo',

	events	: 
		{
					//Eventos de consulta
					'keyup #inputBusquedaI'	: 'buscarServicioI',
			        'keyup #inputBusquedaC'	: 'buscarServicioC',
			         'change .tipo_cliente'	: 'obtenerTipoCliente',

					//Eventos de eliminación
					'click	#btn_eliminar'	: 'eliminarTodos_Prueba',
			     'click  .eliminarCopia'	: 'eliminarCopia', //Para eliminar los telefonos que se van listando
					'click  .icon-uniF477'	: 'eliminarContacto', // Evento para el icono (boton) eliminar contacto.
					'click .icon-uniF470'	: 'quitarDeLista',

					//eventos para mostrar informacion
				'keypress #inputBusquedaI'	: 'agregarNuevoServ',
					 'click	#btn_agregarI'	: 'agregarNuevoServBoton',
				'keypress #inputBusquedaC'	: 'agregarNuevoServ',
					 'click	#btn_agregarC'	: 'agregarNuevoServBoton',
			'click	#btn_agregarContacto'	: 'agregarContactoLista',
					
					// Eventos para registro de clientes y contactos
				'click	#btn_crear'	        : 'nuevoCliente',
				'click	#btn_nuevoContacto' : 'nuevoContacto',
				'click	.otroTelefono'	    : 'otroTelefono',
				'click 	#btn_otroContacto'  : 'otroContacto',
				'change #fotoCliente'		: 'obtenerFoto',

					/*Las funciones para validar se ejecutan cuando 
					se hace blur a los elementos html con el id o class 
					especificados*/
					  'blur #email'			: 'validarCorreo',
					'blur .telefonoCliente'	: 'validarTelefono',
					 'blur #paginaCliente' 	: 'validarPaginaWeb',
				'blur #contactoEmail'		: 'validarCorreo',
				'blur .telefonoContacto'	: 'validarTelefono',
				'blur #emailRepresentante' 	: 'validarCorreo',
			'blur .telefonoRepresentante'	: 'validarTelefono',
			'blur #otroContactoEmail'		: 'validarCorreo',

			'keyup #rfc'	: 'validarRFC',


					//Eventos para las advertencias
							'click #cerrar'	: 'cerrarAlerta'
		},

// -----initialize-------------------------------- 
	initialize		: function () {
	// Datos básicos
		this.tipoCliente          = '';
		this.$nombreFiscal        = $('#nombreComercial');
		this.$nombreComercial     = $('#nombreFiscal');
		this.$email               = $('#email');
		this.$rfc                 = $('#rfc');
		this.$paginaWeb           = $('#paginaCliente');
		this.$giro                = $('#giro');
		this.$direccion           = $('#txtareaDireccion');
		this.$logoCliente         = $('#logoCliente');
		this.$comentarioCliente   = $('#comentarioCliente');
		this.$foto	              = $("#direccion");

	// Datos especificos
		this.$nombreRepresentante = $('#nombreRepresentante');
		this.$correoRepresentante = $('#emailRepresentante');
		this.$cargoRepresentante  = $('#cargoRepresentante');
	// Datos de contacto
		this.$nombreContacto      = $('#contactoNombre');
		this.$correoContacto      = $('#contactoEmail');
		this.$cargoContacto       = $('#contactoCargo');
	// Dinámica de formulario
		this.arregloDeContactos   = new Array();
		this.pasarFiltro = 0;

		// {{{{{{{{{{{{{selectores de servicios de interes y actuales}}}}}}}}}}}}}
		this.$menuServiciosInteres	  = $('#menuServiciosInteres');
		this.$menuServiciosCuenta	  = $('#menuServiciosCuenta');
		// {{{{{{{{{{{{{selectores de servicios de interes y actuales}}}}}}}}}}}}}

		this.cargarServiciosC();
		this.cargarServiciosI();
	},
// -----render------------------------------------ 
	render			: function () {
		return this;
	},	
// -----agregarContactoLista---------------------- 
	agregarContactoLista	: function () {
		this.$nombreContacto = $('#otroContactoNombre');
		this.$correoContacto = $('#otroContactoEmail');
		this.$cargoContacto = $('#otroContactoCargo');
		$('#contactosLista').html('');
		this.otroContacto();
		$('#myModal').modal('hide');
	},
// -----buscarServicioI--&--buscarServicioC------- 

	buscarServicioI	: function (elemento) {
		
		var buscando = $(elemento.currentTarget).val();
		app.coleccionServicios.fetch({reset:true, data:{nombre: buscando}});

		this.sinCoincidencias();

		this.$menuServiciosInteres.html('');
		this.cargarServiciosI();
	}, 

	buscarServicioC	: function (elemento) {
		
		var buscando = $(elemento.currentTarget).val();
		app.coleccionServicios.fetch({reset:true, data:{nombre: buscando}});

		this.sinCoincidencias();

		this.$menuServiciosCuenta.html('');
		this.cargarServiciosC();
	},

	sinCoincidencias	: function () {
		if (app.coleccionServicios.length == 0) {
			app.coleccionServicios.fetch({reset:true, data:{nombre: ''}});
		};
	},

	agregarNuevoServ	: function (elemento) {
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
        if ((this.pasarFiltro == 1 || elemento.keyCode === 13) && $(elemento.currentTarget).attr('id') == 'inputBusquedaI') {

        	this.pasarFiltro = 0;

        	if ($(elemento.currentTarget).val() != '') {
        		app.coleccionServicios.create(
        			{ nombre : $(elemento.currentTarget).val() },
        			{
        				wait:true,
        				success : function (exito) {
		        			$('#listaInteres').append('<li class="list-group-item">'+ exito.get('nombre') +'<label class="icon-uniF470" style="float: right;"><span></span></label><input type="checkbox" class="check_posicion" name="serviciosInteres" value="'+exito.get('id')+'" checked></li>');
		        			$(elemento.currentTarget).val('');
        				}
        			}
        		);
			}
            elemento.preventDefault();
        }

        if ((this.pasarFiltro == 1 || elemento.keyCode === 13) && $(elemento.currentTarget).attr('id') == 'inputBusquedaC') {

        	this.pasarFiltro = 0;

        	if ($(elemento.currentTarget).val() != '') {
        		app.coleccionServicios.create(
        			{ nombre : $(elemento.currentTarget).val() },
        			{
        				wait:true,
        				success : function (exito) {
		        			$('#listaCuenta').append('<li class="list-group-item">'+ exito.get('nombre') +'<label class="icon-uniF470" style="float: right;"><span></span></label><input type="checkbox" class="check_posicion" name="serviciosCuenta" value="'+exito.get('id')+'" checked></li>');
		        			$(elemento.currentTarget).val('');
        				}
        			}
        		);
			}
            elemento.preventDefault();
        }

		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
    },

    agregarNuevoServBoton	: function (elemento) {
    	if ($(elemento.currentTarget).attr('id') == 'btn_agregarI') {
    		this.pasarFiltro = 1;
    		$('#inputBusquedaI').trigger('keypress');
    	};
    	if ($(elemento.currentTarget).attr('id') == 'btn_agregarC') {
    		this.pasarFiltro = 1;
    		$('#inputBusquedaC').trigger('keypress');
    	};
    },
// -----cargarServicios--------------------------- 
	/*Las funciones cargarServicioI y cargarServicioC agregar los servicios 
	dentro de menus desplegables especificados por los selectores
	menuServiciosInteres y menuServiciosCuenta. Se realizan una sola vez;
	para que se agreguenTodos los servicios se necesitan las las dos 
	funciones que seguien a estas. para cada funcion se instancia un nuevo
	objeto de la clase VistaServicioIteres y VistaServicioCuenta ejecutando
	tras ello las funciones render() pasando la devolucion de render() al
	elemento contenido en la propiedad el de dicha clase instanciada*/
	cargarServicioI	: function (servicio) {
		var vistaServicioI = new app.VistaServicioInteres({model:servicio});
		this.$menuServiciosInteres.append(vistaServicioI.render().el);
	},
	cargarServicioC	: function (servicio) {
		var vistaServicioC = new app.VistaServicioCuenta({model:servicio});
		this.$menuServiciosCuenta.append(vistaServicioC.render().el);
	},
	/*Las funciones carcarServiciosI y cargarServiciosC recorren la colección
	de servicios ejecutando las funciones especificadas como parametros un 
	número de veces definido por la misma longitud de modelos que contiene 
	establecida por el parametro this. El resultado puede verse en el menú
	desplegable en el archivo modulo_cliente_nuevo.php.*/
	cargarServiciosI	: function () {
		app.coleccionServicios.each(this.cargarServicioI, this);
	},
	cargarServiciosC	: function () {
		app.coleccionServicios.each(this.cargarServicioC, this);
	},
	quitarDeLista	: function (elemento) {
		/*Esta funcion recibe un parametro al y se ejecuta al momento de ejecutarse
		el evento para quitar de la lista uno de los servicios. El parametro
		es un objeto del DOM.

		En la variable arrayServicios se almacenan los objetos que coincidan
		con el mismo atributo name.*/
		var arrayServicios = document.getElementsByName($(elemento.currentTarget).attr('name'));

		/*En la variable servicio almacenamos el id del elemento que se quiere
		quitar de la lista.*/
		var servicio = $(elemento.currentTarget).parent().attr('id');

		/*Mediante el ciclo for se itera sobre los elementos del arreglo
		arrayServicios hasta encontrar una coincidencia de id espeficicada
		en la condición if. se establece como falso y se rompe el ciclo.
		Esto se hace para no desactivar todos los alementos de la lista
		que se han agregado para el cliente. Hay un checkbox oculto con 
		cada elemento de la lista*/
		for (var i = 0; i < arrayServicios.length; i++) {
			if ($(arrayServicios[i]).attr('id') == servicio) {
				$(arrayServicios[i]).prop('checked', false);
				break;
			};
		};

		// Finalmente se remueve del DOM el servicio que ya no se quiera ver en ella
		$(elemento.currentTarget).parent().remove();
	},
// -----eliminarCopia----------------------------- 
	eliminarCopia	: function (elemento) {
		/*Función para eliminar telefonos. Recibe como parametro un objeto del DOM
		pasado como parametro por el evento que descencadena la ejecución de
		esta función. este objeto se utiliza como referencia para encontrar al elemento
		más cercano con el atributo class "copia" para luego removerlo del DOM.*/
		$(elemento.currentTarget).parents('.copia').remove();
	},
// -----eliminarContacto-------------------------- 
	eliminarContacto	: function (contacto) {
		/*Recibe como parametro un objeto del DOM que apunta a uno de los contactos
		listados en el proceso de registro de contactos. 

		Se itera sobre el arreglo que contiene a todos los objetos contacto hasta
		encontrar una coincidencia y para sustituir al objeto por null en su posición*/
		for (var i = 0; i < this.arregloDeContactos.length; i++) {
			if (i == $(contacto.currentTarget).parent().parent().parent().attr('id')) {
				this.arregloDeContactos[i] = null;
			}
		};

		/*En un nuevo arreglo se iran introduciendo objetos del arregloDeContactos excepto
		los que sean null.*/
		var newArray = new Array();
		for( var i = 0; i < this.arregloDeContactos.length; i++ ){
			if ( this.arregloDeContactos[i] ){
				newArray.push( this.arregloDeContactos[i] );
			}
		}

		/*Pasamos el arregli nuevo añ arregloDeContactos para tener todas sus posiciones 
		ocupadas.*/
		this.arregloDeContactos = newArray;

		// Finalmente se remueve definitivamente del DOM el con contacto.
		$(contacto.currentTarget).parent().parent().parent().remove();

	},
// -----nuevoContacto----------------------------- 
	nuevoContacto	: function () {
		// Esta fucncion almacena los contactos en la base de datos

		/*Se ejecuta la función otroContacto() para pasar al arreglo
		de contactos los datos del ultimo o unico contacto en forna
		de objeto. Si unicamente hay un contacto se creará un
		arreglo de objetos de una sola posición.*/
		this.otroContacto();

		var esto = this;

		/*Se activan las dos variables globales de Backbone para
		mandar de manera correcta el POST de contactos. Antes de finalizar
		esta función se desactivarán estas dos variables globales
		para que no afecte otras funciónes.*/
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		
		/*La condicion if siempre se va a cumplir, sin embargo,
		no especificarla causaria el error de quiera guardar
		un objeto contacto cuando el usuario no especifico
		ningún dato en el formulario de contacto permaneciendo
		un arreglo vacio.*/
		if (this.arregloDeContactos.length > 0) {
			/*Segun sea la longitud del arreglo de contactos se
			ejecutara la funcion create de la colección de
			contactos pasando como parametro cada objeto contacto
			y esperando a que se almacenen debido al parametro wait:true.*/
			for (var i = 0; i < this.arregloDeContactos.length; i++) {
				/*copiar los teléfonos del array de contactos*/
				var telefonos = this.arregloDeContactos[i].telefonos;
				/*Hacer nulo la propiedad telefonos para luego limpiar el json*/
				this.arregloDeContactos[i].telefonos = null;
				/*copiar en la misma posición el contacto*/
				this.arregloDeContactos[i] = this.limpiarJSON(this.arregloDeContactos[i]);
				/*crear el contacto*/
				app.coleccionContactos.create(this.arregloDeContactos[i],{ wait:true, success: function (exito) {
					/*si el registro del contacto es exitoso, registrar sus
					teléfonos*/
					esto.guardarTelefono(exito.get('id'),'contactos',telefonos);
				} });
			}
		}

		/*Para registrar a un representante debe cumplirse quelo
		elementosdel html que apuntan los selectores no esten vacios*/
		if (this.$nombreRepresentante.val().trim()
			&& this.$correoRepresentante.val().trim()
			&& this.$cargoRepresentante.val().trim()
		){
			/*Se genera un arreglo o una variable que almacene el valor
			de telefonos y el tipo de telefono segun sea el caso. Antes de
			almacenar al representante los valores de las variables telefono
			y tipo se pasan como parametro a la funcion recursividadTelefonos
			para recuperarlos como objeto u objetos json.
			Guardamos en una variable al representante*/
			var representante = this.nuevosAtributosContacto(
				this.$nombreRepresentante.val().trim(),
				this.$correoRepresentante.val().trim(),
				this.$cargoRepresentante.val().trim(),
				this.recursividadTelefonos(
					document.getElementsByName('telefonoRepresentante'),
					document.getElementsByName('tipoTelefonoRepresentante')
				)
			);
			// console.log(representante);

			/*copiar los teléfonos del array de representante*/
			var telefonos = representante.telefonos;
			// console.log(telefonos);
			/*Hacer nulo la propiedad telefonos para luego limpiar el json*/
			representante.telefonos = null;
			/*copiar en la misma posición el contacto*/
			representante = this.limpiarJSON(representante);
			// console.log(representante);
			/*crear el contacto*/

			/*Se ejecuta la función create de la coleccion de representantes
			pasando como parametro los datos y los telefonos en formato json
			para enviarlos al servido y ser almacenados.*/
			app.coleccionRepresentantes.create(representante, { wait:true, success:function (exito) {
				esto.guardarTelefono(exito.get('id'),'representantes',telefonos);
			} });
		}

		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;

		// window.location.href = "modulo_consulta_clientes";

	},
// -----nuevoCliente------------------------------ 
	nuevoCliente	: function (evento) {
		/*Se ejecuta la funcion nuevosAtributosCliente que
		tras terminar devuelve un json el cual es
		almacenado en la variable objetoCliente*/
		var objetoCliente = this.limpiarJSON(this.nuevosAtributosCliente());

		/*Nos aseguramos de que las propiedades nombreComercial y tipoCliente
		del objeto esten definidas. De lo contrario se alerta al usuario y
		la creación del cliente no procede*/
		if (!objetoCliente.nombreComercial || !objetoCliente.tipoCliente){
			alert('Registre el tipo de cliente y un nombre de cliente');
			return;
		}

		/*Guardamos la referencia a this para poder usarla en las
		funciones dentro de esta función*/
		var esto = this;
		/**/
		var telefonos = this.recursividadTelefonos(
			document.getElementsByName('telefonoCliente'),
			document.getElementsByName('tipoTelefonoCliente')
		);

		/*Se activan las dos variables globales de Backbone para
		mandar de manera correcta el POST de contactos. Antes de finalizar
		esta función se desactivarán estas dos variables globales
		para que no afecte otras funciónes.*/
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		/*Se pasa la variable objetoCliente como primer parametro en la función
		create de la colección de clientes. La propiedad success del segundo
		parametro espera la respuesta del servidos tras almacenar los datos
		del cliente de manera exitos, de lo contrario la funcion de de la
		propiedad success no procedera para mostrar el formulario para el
		registro de contactos y representante.*/
		app.coleccionClientes.create(objetoCliente,
			{
				wait:true,
				success	: function(exito){
					// Muestra el nombre comercial del cliente el el siguente formulario
					$('#div_nombreCliente').html('<h2>'+exito.get('nombreComercial')+'</h2><h3>Registro para representante y contactos</h3>');
			
					esto.guardarTelefono(exito.get('id'),'clientes',telefonos);
					esto.guardarServiciosI(exito.get('id'),esto.obtenerServicios(document.getElementsByName('serviciosInteres')));
					esto.guardarServiciosC(exito.get('id'),esto.obtenerServicios(document.getElementsByName('serviciosCuenta')));
					esto.$('.visibleR').toggleClass('ocultoR');
				},
				error	: function () {
					$('#error #comentario').html('Ocurrio un error al intentar registrar al cliente');
	      			$('#error').removeClass('oculto');
				}
			}
		);
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;


		// setTimeout(
		// 	function (){
		// 	},
		// 	500
		// );

		evento.preventDefault();
	},
// -----guardarServiciosI------------------------- 
	guardarServiciosI	: function (idcliente,idservicio) {
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		if (idservicio) {
			if (idservicio.length > 0) {
				for (var i = 0; i < idservicio.length; i++) {
					app.coleccionServiciosClientesI.create({
						idcliente:idcliente,
						idservicio:idservicio[i]
					},{wait:true});
				};
			}
		}
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
	},
// -----guardarServiciosC------------------------- 
	guardarServiciosC	: function (idcliente,idservicio) {
		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;
		if (idservicio) {
			if (idservicio.length > 0) {
				for (var i = 0; i < idservicio.length; i++) {
					app.coleccionServiciosClientesC.create({
						idcliente:idcliente,
						idservicio:idservicio[i]
					},{wait:true});
				};
			}
		}
		Backbone.emulateHTTP = false;
		Backbone.emulateJSON = false;
	},
// -----guardarTelefono--------------------------- 
	guardarTelefono	: function (idpropietario,tabla,telefono) {
		if (telefono) {
			if (telefono.length) {
				for (var i = 0; i < telefono.length; i++) {
					this.guardarTelefono(idpropietario,tabla,telefono[i]);
				};
			} else{
				telefono.idpropietario = idpropietario;
				telefono.tabla = tabla;
				Backbone.emulateHTTP = true;
				Backbone.emulateJSON = true;

				app.coleccionTelefonos.create(telefono,{wait:true});

				Backbone.emulateHTTP = false;
				Backbone.emulateJSON = false;
			};
		}
	},
// -----nuevosAtributosContacto------------------- 
	nuevosAtributosContacto	: function (nombre,correo,cargo,telefonos) {
		/*Los valores de los parametros se especifican en el lugar en 
		donde es ejecutada esta función*/
		return {
			idCliente : app.coleccionClientes.obtenerUltimo().get('id'),
				 // tipo : tipo,
			   nombre : nombre,
			   correo : correo,
			    cargo : cargo,
			telefonos : telefonos
		}
	},
// -----nuevosAtributosCliente-------------------- 
	nuevosAtributosCliente	: function () {
		/*Los valores de cada propiedad se obtienen directamente
		de los campos del html donde los selectores apuntan.*/
		return {
             nombreComercial : this.$nombreFiscal.val().trim(),
                nombreFiscal : this.$nombreComercial.val().trim(),
                      correo : this.$email.val().trim(),
                         rfc : this.$rfc.val().trim(),
                   paginaWeb : this.$paginaWeb.val().trim(),
                        giro : this.$giro.val(),
           comentarioCliente : this.$comentarioCliente.val().trim(),
                   direccion : this.$direccion.val().trim(),
                 tipoCliente : this.tipoCliente,
            	   // telefonos : this.recursividadTelefonos(document.getElementsByName('telefonoCliente'),document.getElementsByName('tipoTelefonoCliente')),
            // serviciosInteres : this.obtenerServicios(document.getElementsByName('serviciosInteres')),
             // serviciosCuenta : this.obtenerServicios(document.getElementsByName('serviciosCuenta')),
                        foto : this.urlFoto()
		}
	},
// -----obtenerTipoCliente------------------------ 
	obtenerTipoCliente	: function (elemento) {
		/*currentTarget obtiene el elemento html,
		  este se utiliza como selector para obtener
		  el valor del elemento seleccionado; en este
		  caso el TIPO de cliente a registrar*/
		this.tipoCliente = $(elemento.currentTarget).val();
	},
// -----obtenerFoto------------------------------- 
	obtenerFoto	: function () {
	    $("#mensajeFoto").hide();
	    //queremos que esta variable sea global
	    this.fileExtension = "";
	        //obtenemos un array con los datos del archivo
	        var file = $("#fotoCliente")[0].files[0];
	        //obtenemos el nombre del archivo
	        var fileName = file.name;
	        //obtenemos la extensión del archivo
	        this.fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
	        //obtenemos el tamaño del archivo
	        var fileSize = file.size;
	        //obtenemos el tipo de archivo image/png ejemplo
	        var fileType = file.type;
	        //mensaje con la información del archivo
	        showMessage("<span class='info'>Foto a subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
	},
	urlFoto	: function () {
		// console.log($("#formularioFoto")[0]);
        var formData = new FormData($("#formularioFoto")[0]);
        // console.log(formData);
        // alert(JSON.stringify(formData));
        var mensaje = "";    
        //hacemos la petición ajax  
        var resp = $.ajax({
            url: 'http://qualium.mx/sites/crmqualium/api_foto',
            type: 'POST',
            async:false,
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false
        });
        var nombreFoto = jQuery.parseJSON(resp.responseText);
        console.log(nombreFoto);
        if (nombreFoto != false){
        	return 'img/fotosClientes/'+nombreFoto+'';	
        } else{
        	// nombreFoto.data; //false
        	return 'img/fotosClientes/sinfoto.png';
        };
	},
// -----otroTelefono------------------------------ 
	otroTelefono	: function (elemento) {
		/*Esta función se ejecuta su evento asociado
		pasandole como parametro un objeto del DOM.
		Este elemento DOM sirve como referencia para
		obtener html y encajarla en nuevo html. Al final
		el nuevo html se imprime el una lista de teléfonos.*/
		this.$(elemento.currentTarget).parents('.telefonos').prepend('<div class="copia">'+this.$(elemento.currentTarget).parent().parent().parent().html()+'</div>');
		/*Se añade en el atributo class un nuevo nombre donde 
		apunta el selector*/
		$('.copia .icon-uniF476').addClass('icon-uniF477 eliminarCopia'); 
		/*Primero se elimina y luego se añade un nuevo nombere 
		en el atributo class del elemento donde apunta el selector*/
		$('.copia .otroTelefono').removeClass().addClass('eliminarCopia'); 
	},
//------otroContacto------------------------------ 
	otroContacto 	: function (contacto) {
		console.log(JSON.stringify(this.arregloDeContactos));
		/*Se obtienen los objetos DOM en donde los atributos name coincidan
		y se almacenan en las variables correspondientes*/
		var numero;
		var tipo;
		
		/*Se evalua que los campos hacia donde apuntan los selectores no esten vacios
		de lo contrario el arregloDeContactos no guardara objetos de contactos*/
		if (this.$nombreContacto.val().trim() 
			&& this.$correoContacto.val().trim() 
			&& this.$cargoContacto.val().trim()
		) {
			numero = document.getElementsByName('telefonoContacto');
			tipo   = document.getElementsByName('tipoTelefonoContacto');
			/*Se evalua si el arregloDeContactos tiene datos para almacenar
			en la posición diguiente el nuevo json de contacto*/
			if (this.arregloDeContactos.length > 0) {
				// Si la longitud no pasa de 1 se ejecuta lo que la condición contenga
				if (this.arregloDeContactos.length > 1) {
					this.arregloDeContactos[this.arregloDeContactos.length + 1] = this.nuevosAtributosContacto(	this.$nombreContacto.val().trim(),
																												this.$correoContacto.val().trim(),
																												this.$cargoContacto.val().trim(),
																												this.recursividadTelefonos(numero,tipo));
				} else {
					// De lo contrario los datos se almacenan en la posicion especificada por la longitud del arreglo
					this.arregloDeContactos[this.arregloDeContactos.length] = this.nuevosAtributosContacto(	this.$nombreContacto.val().trim(),
																											this.$correoContacto.val().trim(),
																											this.$cargoContacto.val().trim(),
																											this.recursividadTelefonos(numero,tipo));
				};
			} else {
				// de lo contrario se almacena en la primera posición del arreglo
				this.arregloDeContactos[0] = this.nuevosAtributosContacto(	this.$nombreContacto.val().trim(),
																			this.$correoContacto.val().trim(),
																			this.$cargoContacto.val().trim(),
																			this.recursividadTelefonos(numero,tipo));
			};

			// Si en el lugar donde se ejecuta esta función se a pasado un paranetro procede la condición
			if (contacto) {
				// Se crea nuevo html en el div del formulario de contacto reemplazando los anteriores
				$(contacto.currentTarget).parent().parent().html('<div id="listaContactosCliente"><h3>Datos de contacto</h3><br><button id="btn_formularioContacto" class="btn btn-default" data-toggle="modal" data-target="#myModal"><span class="icon-uniF476"></span></button></div><div class="desborde"></div><hr><table id="contactosLista" class="table"></table>');
				// Del nuevo html creado se crean nuevos selectores debido a que los a se eliminaron
				this.$nombreContacto      = $('#contactosLista #contactoNombre');
				this.$correoContacto      = $('#contactosLista #contactoEmail');
				this.$cargoContacto       = $('#contactosLista #contactoCargo');
			};

			// Se imprime en pantalla lo que el arreglo de contactos contenga formateado con nuevo html
			if (this.arregloDeContactos.length > 1) {
				for (var i = 0; i < this.arregloDeContactos.length; i++) {
					$('#contactosLista').append('<tr id="'+i+'"><td><h4 style="width:300px;">'+this.arregloDeContactos[i].nombre+'</h4></td></td><td><div class="iconos-operaciones-contacto"><span class="icon-uniF477"></span></div></td></table>');/*</span><span class="icon-edit2">*/
				};
			} else{
				$('#contactosLista').append('<tr id="'+0+'"><td><h4 style="width:300px;">'+this.arregloDeContactos[0].nombre+'</h4></td></td><td><div class="iconos-operaciones-contacto"><span class="icon-uniF477"></span></div></td></table>');/*</span><span class="icon-edit2">*/
			};

			// En todo caso se limpian los campos tras respaldar lo datos
			// this.$nombreContacto.val('');
			// this.$correoContacto.val('');
			// this.$cargoContacto.val('');
			// this.$('.telefonoContacto').val('');
			$('#myModal form')[0].reset();

			$('#myModal').modal('show');
		}
	},
// -----recursividadTelefonos--------------------- 
	recursividadTelefonos	: function (telefono,tipo) {
		if (telefono.length > 1 && tipo.length > 1) {
			var arreglo = new Array();
			for (var i = 0; i < telefono.length; i++) {
				if ($(telefono[i]).val() != "" && $(tipo[i]).val() != "") {
					arreglo[i] = this.recursividadTelefonos(telefono[i],tipo[i]);
				};
			};
			return arreglo;
		} else if($(telefono).val() != "" && $(tipo).val() != "") {
			var objetoTelefono = {};
			objetoTelefono.numero = $(telefono).val().trim();
			objetoTelefono.tipo = $(tipo).val();

			return jQuery.parseJSON(JSON.stringify(objetoTelefono));
		};
	},
// -----obtenerServicios-------------------------- 
	obtenerServicios	: function (servicio) {
			var arreglo = new Array();
			var cont = 0;

			for (var i = 0; i < servicio.length; i++) {
				if ($(servicio[i]).is(':checked')) {
					arreglo[cont] = $(servicio[i]).val();
					cont++;
				}
			};

			/*if (arreglo.length == 1) {
				return arreglo[0];
			} else */if (arreglo.length == 0) {
				return '';
			} else {
				return arreglo;
			};
	},
// -----recursividadArchivos---------------------- 
	recursividadArchivos	: function (archivo,tipo,comentario) {
		if (comentario.length > 1) {
			var arreglo = new Array();
				for (var i = 0; i < comentario.length; i++) {
				arreglo[i] = this.recursividadArchivos(archivo[i],tipo[i],comentario[i]);
			};

			return arreglo;

		} else{
			var objetoArchivo = {};
			objetoArchivo.nombre = $(archivo).val().trim();
			objetoArchivo.tipo = $(tipo).val();
			objetoArchivo.comentario = $(comentario).val().trim();
			return jQuery.parseJSON(JSON.stringify(objetoArchivo));
		};
	},

// -----validarCorreo----------------------------- 
	validarCorreo	: function (elemento) {
		if( !(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(elemento.currentTarget).val().trim())) && $(elemento.currentTarget).val().trim() != '' ) {
	      $('#error #comentario').html('No es un correo valido');
	      $('#error').removeClass('oculto');
	      $(elemento.currentTarget).focus();
	      return false;
	    };
	},
//------validarTelefono--------------------------- 
	validarTelefono	: function (elemento) {
		// if(isNaN($(elemento.currentTarget).val().trim()) && $(elemento.currentTarget).val().trim() != '' ) {
		if(!(/^\d{10}$/.test($(elemento.currentTarget).val().trim())) && $(elemento.currentTarget).val().trim() != '' ) {
	        $('#error #comentario').html('No ingrese letras u otros símbolos<br>Escriba 10 números<br>Establezca un tipo de teléfono');
	        $('#error').removeClass('oculto');
	        $(elemento.currentTarget).focus();
	        return false;
	    };
	},
//------validarPaginaWeb-------------------------- 
	validarPaginaWeb	: function () {
		if (!(this.$paginaWeb.val().trim().match(/^[a-z0-9\.-]+\.[a-z]{2,4}/gi)) && this.$paginaWeb.val().trim() != '' ) {
			this.$paginaWeb.focus();
		//   /\.[a-z0-9\.-]+\.[a-z]{2,4}/gi
		//   /^(http|https)\:\/\/[a-z0-9\.-]+\.[a-z]{2,4}/gi
			$('#error #comentario').html('La dirección de la página web no es correcta');
	        $('#error').removeClass('oculto');
			return false;
		}; 
	},
	cerrarAlerta	: function () {
		$('#error').toggleClass('oculto');
	},
validarRFC	: function (elem) {
	$(elem.currentTarget).val($(elem.currentTarget).val().toUpperCase());
},
// -----limpiarJSON------------------------------- 
	limpiarJSON	: function (objeto) {
		/*La variable valorJson y el ciclo for eliminan los
		valores nulos o vacios de la variable objetoCliente*/
		var valorJson;
		for (var x in objeto) {
		    if ( Object.prototype.hasOwnProperty.call(objeto,x)) {
		        valorJson = objeto[x];
		        if (valorJson==="null" || valorJson===null || valorJson==="" || typeof valorJson === "undefined") {
		            delete objeto[x];
		        }

		    }
		}
		return objeto;
	},
});

app.vistaNuevoCliente = new app.VistaNuevoCliente();

function showMessage (message) {
    $("#mensajeFoto").html("").show();
    $("#mensajeFoto").html(message);
}
//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
// function isImage (extension) {
//     switch(extension.toLowerCase()) 
//     {
//         case 'jpg': case 'gif': case 'png': case 'jpeg':
//             return true;
//         break;
//         default:
//             return false;
//         break;
//     }
// }