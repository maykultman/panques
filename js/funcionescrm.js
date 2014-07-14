var app = app || {};

var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
var dias = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sábado'];

app.busquedaServicio.servicio = (function () {
    buscarPorNombre = function (searchKey) {
        var deferred = $.Deferred();
        var results = servicios.filter(function (element) {
            var nombre = element.nombre;
            // console.log(nombre);
            // console.log(searchKey);
            return nombre.toLowerCase().indexOf(searchKey.toLowerCase()) > -1;
        });
        deferred.resolve(results);
        return deferred.promise();
    },
    servicios = app.coleccionDeServicios;

    // The public API
    return {
        buscarPorNombre: buscarPorNombre
    };
}());  

app.busquedaCliente.cliente = (function () {
    buscarPorNombre = function (searchKey) {
        var deferred = $.Deferred();
        var results = clientes.filter(function (element) {
            var nombre = element.nombreComercial;
            // console.log(nombre);
            // console.log(searchKey);
            return nombre.toLowerCase().indexOf(searchKey.toLowerCase()) > -1;
        });
        deferred.resolve(results);
        return deferred.promise();
    },
    clientes = app.coleccionDeClientes;

    // The public API
    return {
        buscarPorNombre: buscarPorNombre
    };
}());

function pasarAJson (objSerializado) {
    var json = {};
    $.each(objSerializado, function () {
        if (json[this.name]) {
            if (!json[this.name].push) {
                json[this.name] = [json[this.name]];
            };
            json[this.name].push(this.value || '');
        } else{
            json[this.name] = this.value || '';
        };
    });
    return json;
}

//Para la Busqueda de Roles en el modulo catalogo Roles
app.busquedaRol.rol = (function () {
    buscarPorNombre = function (searchKey) {
        var deferred = $.Deferred();
        var results = roles.filter(function (element) {
            var nombre = element.nombre;
            return nombre.toLowerCase().indexOf(searchKey.toLowerCase()) > -1;
        });
        deferred.resolve(results);
        return deferred.promise();
    },

    roles = app.coleccionDeRoles;

    // The public API
    return {
        buscarPorNombre: buscarPorNombre
    };
}()); 

//Para la Busqueda de Roles en el modulo catalogo Roles
app.busquedaPermiso.permiso = (function () {
    buscarPorNombre = function (searchKey) {
        var deferred = $.Deferred();
        var results = permisos.filter(function (element) {
            var nombre = element.nombre;
           return nombre.toLowerCase().indexOf(searchKey.toLowerCase()) > -1;
        });
        deferred.resolve(results);
        return deferred.promise();
    },
    permisos = app.coleccionDePermisos;

    // The public API
    return {
        buscarPorNombre: buscarPorNombre
    };
}()); 


//Puestos
app.busquedaPuesto.puesto = (function () {
    buscarPorNombre = function (searchKey) {
        var deferred = $.Deferred();
        var results = puestos.filter(function (element) {
            var nombre = element.nombre;
           return nombre.toLowerCase().indexOf(searchKey.toLowerCase()) > -1;
        });
        deferred.resolve(results);
        return deferred.promise();
    },
    puestos = app.coleccionDePuestos;

    // The public API
    return {
        buscarPorNombre: buscarPorNombre
    };
}()); 


//Cotizaciones...
app.busquedaCotizacion.cotizacion = (function () {
    buscarPorNombre = function (searchKey) {
        var deferred = $.Deferred();
        var results = cotizaciones.filter(function (element) {
            var nombre = element.idcliente;
           return nombre.toLowerCase().indexOf(searchKey.toLowerCase()) > -1;
        });
        deferred.resolve(results);
        return deferred.promise();
    },
    cotizaciones = app.coleccionDeCotizaciones;

    // The public API
    return {
        buscarPorNombre: buscarPorNombre
    };
}()); 

app.busquedaCotizacion2.cotizacion2 = (function () {
    buscarPorNombre = function (searchKey) {
        var deferred = $.Deferred();
        var results = cotizaciones2.filter(function (element) {
            var nombre = element.idempleado;
           return nombre.toLowerCase().indexOf(searchKey.toLowerCase()) > -1;
        });
        deferred.resolve(results);
        return deferred.promise();
    },
    cotizaciones2 = app.coleccionDeCotizaciones;

    // The public API
    return {
        buscarPorNombre: buscarPorNombre
    };
}()); 


// -----limpiarJSON------------------------------- 
   function  limpiarJSON (objeto) {
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
    }

/*Debe recibir un objeto Date*/
function formatearFechaUsuario (fecha) {
    
    var fechaFormateada = '';
    if ((fecha.getDate()) < 10 )
        fechaFormateada = '0'+(fecha.getDate()); 
    else
        fechaFormateada = (fecha.getDate()+1);
    if ((fecha.getMonth() +1) < 10 )
        fechaFormateada += '/0'+(fecha.getMonth() +1);
    else
        fechaFormateada +=  '/'+(fecha.getMonth() +1);

    fechaFormateada +=  '/'+fecha.getFullYear();

    return fechaFormateada;
}

/*ALertas alertify.js. Código de tercero*/
    /*Recordar llamar a las librerias:
    <script type="text/javascript" src="lib/alertify.js'?>"></script>
    <link rel="stylesheet" type="text/css" href="themes/alertify.core.css'?>">
    <link rel="stylesheet" type="text/css" href="themes/alertify.default.css'?>">*/
    function alerta(mensaje, callback){
        //un alert
        alertify.alert(mensaje, callback());//"<b>Blog Reaccion Estudio</b> probando Alertify"
    }

    function confirmar(mensaje, callbackAceptar, callbackCancelar){
        //un confirm
        alertify.confirm(mensaje, function (e) { //"<p>Aquí confirmamos algo.<br><br><b>ENTER</b> y <b>ESC</b> corresponden a <b>Aceptar</b> o <b>Cancelar</b></p>"
            if (e) {
                callbackAceptar(); //alertify.success("Has pulsado '" + alertify.labels.ok + "'");
            } else { 
                callbackCancelar(); //alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
            }
        }); 
        return false
    }

    function datos(){
        //un prompt
        alertify.prompt("Esto es un <b>prompt</b>, introduce un valor:", function (e, str) { 
            if (e){
                alertify.success("Has pulsado '" + alertify.labels.ok + "'' e introducido: " + str);
            }else{
                alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
            }
        });
        return false;
    }

    function notificacion(){
        alertify.log("Esto es una notificación cualquiera."); 
        return false;
    }

    function ok(){
        alertify.success("Visita nuestro <a href=\"http://blog.reaccionestudio.com/\" style=\"color:white;\" target=\"_blank\"><b>BLOG.</b></a>"); 
        return false;
    }

    function error(mensaje){
        alertify.error(mensaje); //"Usuario o constraseña incorrecto/a."
        return false; 
    }
    function marcarCheck(elemento, checkboxTabla)
    {
        if(!checkboxTabla)
        {
            var checkboxTabla = document.getElementsByName($(elemento.currentTarget).attr('id'));
        }
        
        if ($(elemento.currentTarget).is(':checked')) 
        {
            for (var i = 0; i < checkboxTabla.length; i++) {
                    checkboxTabla[i].checked = true;
                }
            }
            else{
                for (var i = 0; i < checkboxTabla.length; i++) {
                    checkboxTabla[i].checked = false;
            }
        }
    }