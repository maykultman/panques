var app = app || {};
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