var app = app || {};

app.VistaConsultaCP = Backbone.View.extend({
	el	: '#clientes',
	events		: {
		/*Boton que debe aparecer solo si el usuario tiene
		  permiso pa ver clientes eliminados*/
		'click #obtenerEliminados'	: 'obtenerEliminados',
		/*Esté evento ocurre cuando se introduce una letra dentro
		del elemento input con id inputBuscarCliente y se a levantado
		la tecla precionada. tras dicho evento se ejecuta la funcion
		buscarCliente.*/
		'keyup #inputBuscarCliente'	: 'buscarCliente',
	},

	render		: function () {
		return this;
	},
	/* {{{{{{{{{{{{{{{{{{{}}}}}}}}}}}}}}}}}}} */
	agregarCliente	: function (cliente) {
		/*El parametro cliente contiene las propiedades del cliente
		que seran pasadas como modelo a la clase VistaCliente e
		instanciar un nuevo objeto de la misma clase dentro de
		la variable vistaCliente.*/
		var vistaCliente = new app.VistaCliente({model:cliente});
		/*Ya intanciado un objeto de la clase VistaCliente se ejecuta
		la funcion render() contenida en la instancia a la vez de
		encerrar lo que devuelve la funcion render() en el elemento
		html contenida en la propiedad el del mismo de la misma 
		instancia.
		Finalemente se apila dentro del elemento html especificada
		dentro del selector asicosiado a $filasCliente de dentro de
		esta vista (VistaConsultaCliente)*/
		this.$filasClientes.append(vistaCliente.render().el);
	},
	buscarCliente	: function (elemento) {

		// if (elemento.keyCode === 13)
			elemento.preventDefault();
		/*Obtenemos al cliente mediante la finción fetch especificando
		el nombreComercial capturado por el evento keyup. No es
		necesario almacenar a el o los clientes que coincidieron con 
		la búsqueda	porque especificamos que cada vez que se se 
		realice también se actualice la colección con las 
		coincidencias.*/
		app.coleccionClientes.fetch({
			reset:true,
			data:{
				nombreComercial: this.$inputBuscarCliente.val()
			}
		});
		/*Borramos lo que contenga las etiquetas tbody antes de
		imprimir lo que contenga la coleccion de clientes.*/
		this.$filasClientes.html('');
		/*Ejecutamos la funcion obtenerClientes() para pintar los
		datos de la coleccion en pantalla.*/
		this.obtenerClientes(this.tipoCliente);		
	},
	// marcar	: function () {
	// 	var arregloInputs = document.getElementsByName('checkboxCliente');
	// 	console.log(arregloInputs);
	// },
	obtenerClientes	: function (tipo) {
		/*Obtenemos los clientes que contengan los
		atributos especificados en la fincion where
		de la coleccion de clientes. Se almacena
		dentro de la variable clientes que puede ser
		un array de clientes.*/
		var clientes = app.coleccionClientes.where({
			tipoCliente:tipo,
			visibilidad:true
		});
		/*Pasamos la variable clientes a la función recursividadCP 
		que a su vez pasará como parametro a cada uno de los 
		objetos cliente para imprimirlos en pantalla.*/
		this.recursividadCP(clientes);
	},
	obtenerEliminados	: function (tipo) {
		/*Esta función solo puede ser ejecutada si el usuario
		tiene el permiso*/

		/*Limpiar el contenedor actuamente contiene clientes activos
		para desplegar los clientes eliminados*/
		this.$filasClientes.html('');
		/*La funcion where busca dentro de la colección 
		a los clientes de tipo cliente que tengan 
		visibilidad igual a falso. Esto quiere decir 
		que son clientes eliminados de manera ficticia.
		A continuación se alacena en una variable*/
		var clientes = app.coleccionClientes.where({
			tipoCliente:tipo,
			visibilidad:false
		});
		/*La variable "clientes" contiene a todos los
		encontrados. Se pasa como parametro a la 
		funcion recursividadCP*/
		this.recursividadCP(clientes);
	},
	recursividadCP	: function (cp) {
		/*el parametro cp es un arreglo de objetos que contiene a
		clientes activos, aliminados así como prospectos.*/
		if (cp!="null" 
			&& cp!=null 
			&& cp!="" 
			&& typeof cp != "undefined") 
		{
			if (cp.length) {
				/*Si el parametro "cp" es un arreglo entra dentro de
				un ciclo que ejecuta nuevamente pero con un solo
				objeto dentro del parametro.*/
				for (var i = 0; i < cp.length; i++) {
					this.recursividadCP(cp[i]);
				};
			} else {
				/*En caso de que el parametro sea solo un objeto se
				ejecuta	la siguiente función.*/
				this.agregarCliente(cp);
			};
		};
	}
});

app.VistaConsultaClientes = app.VistaConsultaCP.extend({
	initialize	: function () {
		this.$inputBuscarCliente = $('#inputBuscarCliente');
		/*El selector #filasClientes es el id de la la etiqueta
		tbody del archivo modulo_consulta_clientes.php.*/
		this.$filasClientes = $('#filasClientes');

		this.tipoCliente = 'cliente';
		/*Cuando se intancie la clase VistaConsultaCliente lo primero
		que se ejecutará será la funcion initialize. el cual ejecutara
		la función obtenerClientes(). Está fución se encargará de
		imprimir a todos los clientes.*/
		this.obtenerClientes(this.tipoCliente);
	},
});

app.VistaConsultaProspectos = app.VistaConsultaCP.extend({
	initialize	: function () {
		this.$inputBuscarCliente = $('#inputBuscarCliente');
		/*El selector #filasClientes es el id de la la etiqueta
		tbody del archivo modulo_consulta_clientes.php.*/
		this.$filasClientes = $('#filasClientes');

		this.tipoCliente = 'prospecto';
		/*Cuando se intancie la clase VistaConsultaCliente lo primero
		que se ejecutará será la funcion initialize. el cual ejecutara
		la función obtenerClientes(). Está fución se encargará de
		imprimir a todos los clientes.*/
		this.obtenerClientes(this.tipoCliente);
	},
});



