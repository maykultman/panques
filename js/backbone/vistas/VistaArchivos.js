app.VistaArchivos = Backbone.View.extend({
	events 					: {
		'change #inputArchivos'				: 'cargar',
		'click #btn_subirArchivo'			: 'subirArchivo',
		'click #inputArchivos'				: 'eliminarFileList',
		'click #btn_cancelarArchivo'		: 'cancelarArchivos',
	},
	initialize 				: function () {
		this.listenTo(app.coleccionProyectos, 'add', this.guardar);
		// this.listenTo(app.coleccionProyectos, 'destroy', this.eliminarArchivos);

		this.$inputArchivos			= this.$('#inputArchivos');
		this.$tbody					= this.$('#tbody_archivos');
	},
	render 					: function () { },
	cargar					: function (e) {
		this.$tbody.html('');
		var archivos = $(e.currentTarget).prop('files');
		for (var i = 0; i < archivos.length; i++) {
			this.$tbody.append( this.plantillaArchivo( {i:i, tipo:(archivos[i].type).split('/')[1], nombre:archivos[i].name, tamaño:(archivos[i].size/1024).toFixed() +' KB'} ) );
		};
	},
	/*OK*/guardar 			: function (model) {
		// obtenemos todos los archivos,
		// obtenemos el id del proyecto creado recientemente,
		// preparamos una variable para los objetos formData,
		// y respaldamos this para acceder a las func. y var.
		var archivos = this.$inputArchivos.prop('files'),
			idpropietario = model.get('id'),
			formData,
			tabla,
			self = this;

		tabla = this.establecerTabla(model);

		// verificamos si hay archivos listados para el proy.
		if (archivos.length) {
			// (!) tememos que preparar una variable para indicar,
			// el estado de los achivos (en espera, guardado y no,
			// guardado). classTr es la fila del archivo en la tabla
			self.classTr =  archivos.length - 1;
			for (var i = 0; i < archivos.length; i++) {
				// colocamos un spin en la fila del archivo para indicar 
				// que el archivo esta siendo procesado
				this.$tbody.children('.'+i).children('.icon-eliminar').html('<div class="spin"><div>');
				// creamos un objeto FormData por cada uno de los archivos
				// que serán enviados y añadimos las propiedades que
				// acompañara el archivo en turno
				formData = new FormData();
				formData.append('idpropietario',idpropietario);
				formData.append('tabla',tabla);
				formData.append('archivo[]',archivos[i]);
				// enviamos la info a la api de archivos
				$.ajax({
		            url: 'http://crmqualium.com/api_archivos',
		            type: 'POST',
		            async:true,
		            data: formData,
		            //necesario para subir archivos via ajax
		            cache: false,
		            contentType: false,
		            processData: false,
		            success: function (exito) {
		            	app.coleccionArchivos.add(exito);
		            	self.$tbody.children('.'+self.classTr).addClass('success');
		            	self.$tbody.children('.'+self.classTr).children('.icon-eliminar').html('<div class="has-success"><span class="glyphicon glyphicon-ok form-control-feedback"></span></div>');
		   				self.classTr--;
		   				self.guardado();
		            },
		            error  : function (error) {
		            	self.$tbody.children('.'+self.classTr).addClass('danger');
		            	self.$tbody.children('.'+self.classTr).children('.icon-eliminar').html('<div class="has-error"><span class="glyphicon glyphicon-remove form-control-feedback"></span></div>');
		   				self.classTr--;
		   				self.noGuardada();
		            }
		        });
			};
		} else { 
			console.log('No hay archivos para enviar');
		};
	},
	guardado				: function () {	/*-tambien en VProyecto-*/
		if (this.aumentarContador() == app.totalelementos) {
			var self = this;
			$('#block').toggleClass('activo');
			alerta('¡Proyecto guardado!', function () { });
		};
	},
	noGuardada				: function () {	/*-tambien en VProyecto-*/
		if (this.aumentarContador() == app.totalelementos) {
			$('#block').toggleClass('activo');
			alerta('El proyecto ha sido guardado, pero ocurrieron algunos errores<br>Revice el proyecto en la sección de consulta', function () {
				location.href = 'proyectos_consulta';
			});
		};
	},
	aumentarContador 	: function() {		/*-tambien en VProyecto-*/
		return app.contadorAlerta++;
	},
	/*OK*/establecerTabla 	: function (model) {
		var tabla,
			url = model.url();
		url = url.split('/');
		url.pop();
		url = url.join('/');
		switch( url ){
			case 'http://crmqualium.com/api_proyectos':
				tabla = 'proyectos';
				break;
			default:
				tabla = '';
				break;
		}

		return tabla;
	},
	eliminarFileItemList	: function () {/*[!]*/},
	/*OK*/cancelarArchivos	: function () {
		var here = this;
		confirmar('Los archivos a subir seran cancelados',
			function () {
				here.$inputArchivos.val('');
				here.$tbody.html('');
			},
			function () {});
	},
	/*OK*/eliminarArchivos 	: function (model) {
		var idpropietario = model.get('id'),
			tabla 		  = this.establecerTabla(model);

		app.coleccionArchivos.each(function (model) {
			if (model.get('idpropietario') == idpropietario &&
				model.get('tabla') == tabla
			) {
				model.destroy({
					wait 	: true,
					success : function () {},
					error   : function () {}
				});
			};
		});
	}
});