var app = app || {};

var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
var dias = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sábado'];

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
        fechaFormateada = (fecha.getDate());
    if ((fecha.getMonth() +1) < 10 )
        fechaFormateada += '/0'+(fecha.getMonth() +1);
    else
        fechaFormateada +=  '/'+(fecha.getMonth() +1);

    fechaFormateada +=  '/'+fecha.getFullYear();

    return fechaFormateada;
}

function formatearFechaDB (objDate) {
      return objDate.getFullYear() 
       + "-" + (objDate.getMonth() +1) 
       + "-" + (objDate.getDate());
}

function fechaAmigable (fecha) {

    var fechaFormateada = '';
    if ((fecha.getDate()) < 10 )
        fechaFormateada = '0'+(fecha.getDate());
    else
        fechaFormateada = (fecha.getDate()+1);
    // if ((fecha.getMonth() +1) < 10 )
    fechaFormateada += '/'+meses[fecha.getMonth()];
    // else
    // fechaFormateada +=  '/'+mes[fecha.getMonth()];

    fechaFormateada +=  '/'+fecha.getFullYear();
    // console.log(fechaFormateada);
    return fechaFormateada;
}

/*ALertas alertify.js. Código de tercero*/
/*Recordar llamar a las librerias:
 <script type="text/javascript" src="lib/alertify.js'?>"></script>
 <link rel="stylesheet" type="text/css" href="themes/alertify.core.css'?>">
 <link rel="stylesheet" type="text/css" href="themes/alertify.default.css'?>">*/
function alerta(mensaje, callback){
    //un alert
    alertify.alert(mensaje, function (e) {
        if (e) {
            callback()
        };
    });//"<b>Blog Reaccion Estudio</b> probando Alertify"
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

function ok(mensaje){
    alertify.success(mensaje);
    return false;
}

function error(mensaje){
    alertify.error(mensaje); //"Usuario o constraseña incorrecto/a."
    return false;
}
function marcarCheck(e, ambito)
{
    // console.log(ambito);
    // if(!checkboxTabla)
    // {
        // alert(ambito+' input[name="'+$(e.currentTarget).attr('class')+'"]');
        var checkboxs = $(ambito+' input[name="'+$(e.currentTarget).attr('class')+'"]');
        // alert(JSON.stringify(pasarAJson($(checkboxs).serializeArray())));
        // alert(checkboxs.length);
    // }

    if ($(e.currentTarget).is(':checked'))
    {
        for (var i = 0; i < checkboxs.length; i++) {
            checkboxs[i].checked = true;
        }
    }
    else{
        for (var i = 0; i < checkboxs.length; i++) {
            checkboxs[i].checked = false;
        }
    }
}

/*Subir foto*/
function obtenerFoto (e) {
    //queremos que esta variable sea global
    this.fileExtension = "";
        //obtenemos un array con los datos del archivo
        var file = $("#logoCliente")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        this.fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        // showMessage("<span class='info'>Foto a subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");

        addImage(e);
        function addImage(e){
          var file = e.target.files[0],
          imageType = /image.*/;
        
          if (!file.type.match(imageType))
           return;
      
          var reader = new FileReader();
          reader.onload = fileOnload;
          reader.readAsDataURL(file);
         }
      
         function fileOnload(e) {
          var result=e.target.result;
          $('#direccion').attr("src",result);
         }
};
function urlFoto () {
    // console.log($("#formularioFoto")[0]);
    var formData = new FormData($("#formularioFoto")[0]);
    // console.log(formData);
    // alert(JSON.stringify(formData));
    var mensaje = "";
    //hacemos la petición ajax
    var resp = $.ajax({
        url: 'http://qualium.mx/sites/clientum/api_foto',
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
    // console.log(resp);
    if (resp.responseText != 'false'){
        return resp.responseJSON;
    } else {
        return 'img/logoCliente/sinfoto.png';
    };
};

/*Cálculo de fechas*/
function calcularDuracion (fechainicio,fechafinal) {
    var valorFechaInicio = new Date(fechainicio).valueOf();
    var valorFechaEntrega = new Date(fechafinal).valueOf();
    var valorFechaActual = new Date().valueOf();
    var plazo = ((((valorFechaEntrega-valorFechaInicio))/24/60/60/1000) + 1).toFixed() - excluirDias(fechainicio, fechafinal);
    var hoy = new Date();
    var queda = ((((valorFechaEntrega-valorFechaInicio)-((valorFechaEntrega-valorFechaInicio)-(valorFechaEntrega-valorFechaActual)))/24/60/60/1000) +1).toFixed() - excluirDias(hoy.getFullYear()+'-'+hoy.getMonth()+'-'+hoy.getDate(), fechafinal);
    if (queda == -0) queda = 0;
    var porcentaje = ((100 * queda)/plazo).toFixed();

    // console.log('plazo: '+plazo, 'queda: '+queda, 'porcentaje: '+porcentaje+'%');
    return {
        plazo       :plazo,
        queda       :queda,
        porcentaje  :porcentaje
    };
};
function excluirDias (fechainicio, fechafinal) {
    var contador = 0;
    var valorFechaInicio = new Date(fechainicio).valueOf();
    var valorFechaEntrega = new Date(fechafinal).valueOf();
    var duracion = (((valorFechaEntrega-valorFechaInicio)/24/60/60/1000) +1).toFixed();
    var days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
    // console.log('duracion: '+ duracion);
    for(var i = 0; i<duracion; i++){
        var dia = (new Date(new Date(fechainicio).getTime() + i*24*60*60*1000)).getDay();
        if(days[dia] == 'Sunday' || days[dia] == 'Saturday'){
            // console.log(days[dia]);
            contador++;
        };
    };
    // console.log('Sin trabajar: '+contador);
    return contador;
};

// Esta función carga al select de perfiles para los modulos de:
// #Perfiles #Nuevo Usuario #Consulta Usuario
function select_Perfil(id)
{
    id = (id) ? id:'';

    var list = '<option selected disabled>--Seleccione su Perfil--</option><% _.each(perfiles, function(perfil) { %> <option id="<%- perfil.id %>" value="<%- perfil.id %>"><%- perfil.nombre %></option> <% }); %>';
    this.$('#idperfil'+id).html(_.template(list, { perfiles : app.coleccionPerfiles.toJSON() }));
}


/*Subir foto*/
function obtenerFoto2 (e, seletor) {

    // console.log( $("#"+seletor));
    //queremos que esta variable sea global
    this.fileExtension = "";
    //obtenemos un array con los datos del archivo
    var file = $("#"+seletor)[0].files[0];
    //obtenemos el nombre del archivo
    var fileName = file.name;
    //obtenemos la extensión del archivo
    this.fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
    //obtenemos el tamaño del archivo
    var fileSize = file.size;
    //obtenemos el tipo de archivo image/png ejemplo
    var fileType = file.type;
    //mensaje con la información del archivo
    // showMessage("<span class='info'>Foto a subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");

    addImage(e);
    function addImage(e){
        var file = e.target.files[0],
            imageType = /image.*/;

        if (!file.type.match(imageType))
            return;

        var reader = new FileReader();
        reader.onload = fileOnload;
        reader.readAsDataURL(file);
    }

    function fileOnload(e) {
        var result=e.target.result;
        $('#direccion').attr("src",result);
    }
};

/*--Números--*/
function conComas(valor) {
    var nums = new Array();
    var simb = ","; //Éste es el separador
    valor = valor.split('.');
    valor[0] = valor[0].toString();
    valor[0] = valor[0].replace(/\D/g, "");   //Ésta expresión regular solo permitira ingresar números
    nums = valor[0].split(""); //Se vacia el valor en un arreglo
    var long = nums.length - 1; // Se saca la longitud del arreglo
    var patron = 3; //Indica cada cuanto se ponen las comas
    var prox = 2; // Indica en que lugar se debe insertar la siguiente coma
    var res = "";

    while (long > prox) {
        nums.splice((long - prox),0,simb); //Se agrega la coma
        prox += patron; //Se incrementa la posición próxima para colocar la coma
    }

    for (var i = 0; i <= nums.length-1; i++) {
        res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
    }

    res += '.' + valor[1];
    return res;
}

function loadSelectize_Client (selector,args,options) {
    // Aplicamos el plugin al select con sus propiedades
    var $select = $(selector).selectize(args);
    // Respaldamos las poripiedades del plugin
    var control = $select[0].selectize;
    // Borramos todas las opciones que tenga el select
    // Aplica cuando se hace una cotizacion después de
    // haber creado una sin salir de la sección.
    control.clearOptions();
    // Añadimos los options
    control.addOption(function () {
        var array = [], // El plugin requiere un array de objetos
            // Respaldamos el array de clientes
            clientes = options;
        for (var i = 0; i < clientes.length; i++) {
            // Por cada iteración cargamos el array con
            // un objeto json
            array.push({
                id      : clientes[i].id,
                title   : clientes[i].nombreComercial
            });
        };
        // Devolvemos el array de objetos que son
        // los options
        return array;
    }(/*Los parentesis para ejecutar la función*/));
}

function loadDatepicker (selector) {
    $(selector).datepicker({ 
        dateFormat:'d MM, yy',  
        dayNamesMin:[
            'Do',
            'Lu',
            'Ma',
            'Mi',
            'Ju',
            'Vi',
            'Sá'
        ],
        monthNames:[
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        ]
    });
}