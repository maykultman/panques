var app = app || {
    //Array de objetos de servicio que se 
    //resetea cada vez que se hace una búsqueda
    busquedaServicio:{},
    busquedaCliente:{},
    busquedaRol:{},
    busquedaPermiso:{},
    busquedaPuesto:{},
    busquedaCotizacion:{},
    busquedaCotizacion2:{},
    // funciones:{}
};

//Funcion auto ejecutable. para renderizar la colección
//de servicios cada vez que se haga una búsqueda en el
//en este modulo de clientes.
