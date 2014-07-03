var app = app || {};

var ColeccionServicios = Backbone.Collection.extend({
	model	: app.ModeloServicio,

	// localStorage	: new Backbone.LocalStorage('servicio-backbone'),
	url 	:'http://qualium.mx/sites/crmqualium/api_servicios',

	obtenerTodos : function () {
		return this.filter( function (servicio){
			return servicio.get('id');
		});
	},

	establecerIdSiguiente	: function () {
		if(!this.length){
			return 1;
		}
		return this.last().get('id') + 1;
	},

	obtenerUltimoId	: function () {
		return this.last().get('id');
	},

	// parse	: function (response) {
	// 	return response.data;
	// },

	obtenerUltimo	: function () {
		return this.last();
	},

	sync	: function (method, model, options) {
				
		if (method === 'read') {
			app.busquedaServicio.servicio.buscarPorNombre(options.data.nombre).done(function (data) {
				// console.log(data); //Debuelbe el objeto [Object]
				options.success(data);
			});
		};
	}
});

app.coleccionServicios = new ColeccionServicios(app.coleccionDeServicios);


















































// app.coleccionServicios = new ColeccionServicios([
// 	[
// 		{id:'1',nombre:'Tarjeta de presentación frente', concepto:'Diseño Gráfico',precio:'600',realizacion:'2 horas',descripcion:'-'},
// 		{id:'2',nombre:'Medallón', concepto:'Diseño Gráfico',precio:'800',realizacion:'-',descripcion:'-'},
// 		{id:'3',nombre:'Tríptico', concepto:'Diseño Gráfico',precio:'1800',realizacion:'-',descripcion:'-'},
// 		{id:'4',nombre:'díptico', concepto:'Diseño Gráfico',precio:'1200',realizacion:'-',descripcion:'-'},
// 		{id:'5',nombre:'Catálogo', concepto:'Diseño Gráfico',precio:'600',realizacion:'-',descripcion:'precio por página'},
// 		{id:'6',nombre:'Tarjeta de presentación frente y vuelta', concepto:'Diseño Gráfico',precio:'700',realizacion:'2 horas',descripcion:'-'},
// 		{id:'7',nombre:'Anuncio sencillo', concepto:'Diseño Gráfico',precio:'600',realizacion:'2 horas y media',descripcion:'(flyer, banner, poster)'},
// 		{id:'8',nombre:'Menú de restaurante', concepto:'Diseño Gráfico',precio:'600',realizacion:'1 semana',descripcion:'-'},
// 		{id:'9',nombre:'Diseño de caja', concepto:'Diseño Gráfico',precio:'3500',realizacion:'3 dias',descripcion:'Diseño, impresión, pruebas de armado'},
// 		{id:'10',nombre:'Branding Completo', concepto:'Diseño Gráfico',precio:'12000',realizacion:'-',descripcion:'Manual, mock ups, logotipo, 3 aplicaciones (A escoger hoja membretada, tarjetas, iconos de redes sociales, wallpapers).'},
// 		{id:'11',nombre:'Logo Animado', concepto:'Diseño Gráfico',precio:'3500',realizacion:'-',descripcion:'-'},
// 		{id:'12',nombre:'Video Branding', concepto:'Diseño Gráfico',precio:'18000',realizacion:'-',descripcion:'manual, logo animado, cortinilla, lower third, créditos, se entregan proyectos en dvd.'},
// 		{id:'13',nombre:'Campaña', concepto:'Diseño Gráfico',precio:'4000',realizacion:'-',descripcion:'Proceso creativo'},
// 		{id:'14',nombre:'Aplicaciones de campaña', concepto:'Diseño Gráfico',precio:'3500',realizacion:'-',descripcion:'2 diseños en horizontal y vertical, se entregan archivos .psd o .ai'}
// 	],
// 	[
// 		{id:'15',nombre:'Página Web sencilla ', concepto:'Programación',precio:'12000',realizacion:'2 semanas',descripcion:'(5 secciones)'},
// 		{id:'16',nombre:'Página Web complicada (Mas de 5 secciones)', concepto:'Programación',precio:'18000',realizacion:'3 a 5 semanas',descripcion:'(Carrito, bienes raíces).'},
// 		{id:'17',nombre:'Página Web con sistema interno', concepto:'Programación',precio:'22000',realizacion:'1 mes',descripcion:'Escuelas, bases de datos.'},
// 		{id:'18',nombre:'App sencilla', concepto:'Programación',precio:'35000',realizacion:'1 mes',descripcion:'Directorio, incluye landing page'},
// 		{id:'19',nombre:'App Complicada', concepto:'Programación',precio:'60000',realizacion:'3 a 4 meses',descripcion:'PIngo, '},
// 		{id:'20',nombre:'Sistema de ventas', concepto:'Programación',precio:'120000',realizacion:'3 meses',descripcion:'Punto de venta sencillo'},
// 		{id:'21',nombre:'Rediseño pagina web', concepto:'Programación',precio:'8000',realizacion:'1 semana',descripcion:'-'}
// 	],
// 	{id:'22',nombre:'Mailing', concepto:'Publicidad',precio:'1200',realizacion:'-',descripcion:'100000 contactos de Merida'},
// 	{id:'23',nombre:'Redes sociales', concepto:'Redes',precio:'4000',realizacion:'-',descripcion:'-'},
// 	{id:'24',nombre:'Comercial video', concepto:'Video',precio:'14000',realizacion:'1 semana',descripcion:'spot sencillo, sin scouting, ni casting'}
// ]);


// app.coleccionServicios.create({id:'01',nombre:'Tarjeta de presentación frente', concepto:'Diseño Gráfico',precio:'600',realizacion:'2 horas',descripcion:'-'});
		// app.coleccionServicios.create({id:'02',nombre:'Medallón', concepto:'Diseño Gráfico',precio:'800',realizacion:'-',descripcion:'-'});
		// app.coleccionServicios.create({id:'03',nombre:'Tríptico', concepto:'Diseño Gráfico',precio:'1800',realizacion:'-',descripcion:'-'});
		// app.coleccionServicios.create({id:'04',nombre:'díptico', concepto:'Diseño Gráfico',precio:'1200',realizacion:'-',descripcion:'-'});
		// app.coleccionServicios.create({id:'05',nombre:'Catálogo', concepto:'Diseño Gráfico',precio:'600',realizacion:'-',descripcion:'precio por página'});
		// app.coleccionServicios.create({id:'06',nombre:'Tarjeta de presentación frente y vuelta', concepto:'Diseño Gráfico',precio:'700',realizacion:'2 horas',descripcion:'-'});
		// app.coleccionServicios.create({id:'07',nombre:'Anuncio sencillo', concepto:'Diseño Gráfico',precio:'600',realizacion:'2 horas y media',descripcion:'(flyer, banner, poster)'});
		// app.coleccionServicios.create({id:'08',nombre:'Menú de restaurante', concepto:'Diseño Gráfico',precio:'600',realizacion:'1 semana',descripcion:'-'});
		// app.coleccionServicios.create({id:'09',nombre:'Diseño de caja', concepto:'Diseño Gráfico',precio:'3500',realizacion:'3 dias',descripcion:'Diseño, impresión, pruebas de armado'});
		// app.coleccionServicios.create({id:'10',nombre:'Branding Completo', concepto:'Diseño Gráfico',precio:'12000',realizacion:'-',descripcion:'Manual, mock ups, logotipo, 3 aplicaciones (A escoger hoja membretada, tarjetas, iconos de redes sociales, wallpapers).'});
		// app.coleccionServicios.create({id:'11',nombre:'Logo Animado', concepto:'Diseño Gráfico',precio:'3500',realizacion:'-',descripcion:'-'});
		// app.coleccionServicios.create({id:'12',nombre:'Video Branding', concepto:'Diseño Gráfico',precio:'18000',realizacion:'-',descripcion:'manual, logo animado, cortinilla, lower third, créditos, se entregan proyectos en dvd.'});
		// app.coleccionServicios.create({id:'13',nombre:'Campaña', concepto:'Diseño Gráfico',precio:'4000',realizacion:'-',descripcion:'Proceso creativo'});
		// app.coleccionServicios.create({id:'14',nombre:'Aplicaciones de campaña', concepto:'Diseño Gráfico',precio:'3500',realizacion:'-',descripcion:'2 diseños en horizontal y vertical, se entregan archivos .psd o .ai'});
		// app.coleccionServicios.create({id:'15',nombre:'Página Web sencilla ', concepto:'Programación',precio:'12000',realizacion:'2 semanas',descripcion:'(5 secciones)'});
		// app.coleccionServicios.create({id:'16',nombre:'Página Web complicada (Mas de 5 secciones)', concepto:'Programación',precio:'18000',realizacion:'3 a 5 semanas',descripcion:'(Carrito, bienes raíces).'});
		// app.coleccionServicios.create({id:'17',nombre:'Página Web con sistema interno', concepto:'Programación',precio:'22000',realizacion:'1 mes',descripcion:'Escuelas, bases de datos.'});
		// app.coleccionServicios.create({id:'18',nombre:'App sencilla', concepto:'Programación',precio:'35000',realizacion:'1 mes',descripcion:'Directorio, incluye landing page'});
		// app.coleccionServicios.create({id:'19',nombre:'App Complicada', concepto:'Programación',precio:'60000',realizacion:'3 a 4 meses',descripcion:'PIngo, '});
		// app.coleccionServicios.create({id:'20',nombre:'Sistema de ventas', concepto:'Programación',precio:'120000',realizacion:'3 meses',descripcion:'Punto de venta sencillo'});
		// app.coleccionServicios.create({id:'21',nombre:'Rediseño pagina web', concepto:'Programación',precio:'8000',realizacion:'1 semana',descripcion:'-'});
		// app.coleccionServicios.create({id:'22',nombre:'Mailing', concepto:'Publicidad',precio:'1200',realizacion:'-',descripcion:'100000 contactos de Merida'});
		// app.coleccionServicios.create({id:'23',nombre:'Redes sociales', concepto:'Redes',precio:'4000',realizacion:'-',descripcion:'-'});
		// app.coleccionServicios.create({id:'24',nombre:'Comercial video', concepto:'Video',precio:'14000',realizacion:'1 semana',descripcion:'spot sencillo, sin scouting, ni casting'});