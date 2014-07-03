var app = app || {};

app.VistaLocalCotizacion = Backbone.View.extend({
	el : '.contenedor_formato',

        events : {},

        initialize : function () {

            var fecha = new Date();   var dia=0;       var mes=0;
            /* Le damos formato a la fecha para que lo muestre en el campo fecha*/
            (fecha.getDate()<10) ? dia = '0'+fecha.getDate()      : dia = fecha.getDate();
            (fecha.getMonth()<10)? mes = '0'+(fecha.getMonth()+1) : mes = (fecha.getMonth()+1);

            $('#fecha').text(dia+'/'+mes+'/'+fecha.getFullYear());
            // app.coleccionLocalCotizaciones().toJSON();
            
        },

        render : function () { return this; }

}); //Fin de la vista Local Cotización

app.vistaLocalCotizacion = new app.VistaLocalCotizacion();
