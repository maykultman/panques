// console.log(toUTCString ()); 		
	function validarTel(e)
 	{
		key = e.keyCode || e.which;
        tecla = String.fromCharCode(key);
        letras = "1234567890";
        especiales = "8-37-39-46";
        tecla_especial = false;
        for(var i in especiales)
        {
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial)
        {
            return false;
        }
    }

    function letras(especiales, key, letras, tecla_especial)
    {
        // key = e.keyCode || e.which;
        // tecla = String.fromCharCode(key).toLowerCase();
        // letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        // especiales = "8-37-39-46";
        // tecla_especial = false
        for(var i in especiales)
        {
             if(key == especiales[i])
             {
                 tecla_especial = true;
                 break;
             }
         }
         if(letras.indexOf(tecla)==-1 && !tecla_especial)
         {
             return false;
         }
    }
    // -----validarRFC-------------------------------- 
    function validarRFC (elem) {
        $(elem.currentTarget).val($(elem.currentTarget).val().toUpperCase());
    }

    function textoObligatorio (elem) {
        if ($(elem).val() != '') {
            $(elem).parents('.form-group').removeClass('has-error');
           return false;
        } else {
            $(elem).parents('.form-group').addClass('has-error');
             return true;
        };
    }

    function validarEmail (elem) {
        if( (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(elem).val())) || $(elem).val() == '') {
            $(elem).parents('.form-group').removeClass('has-error');
            return false;
        } else{
            $(elem).parents('.form-group').addClass('has-error');
            return true;
        };
    }

    function validarTelefono(elem) {
        if( (/^\d{10,20}$/.test($(elem).val().trim())) || $(elem).val().trim() == '' ) {
            $(elem).parents('.form-group').removeClass('has-error');
            return false;
        } else{
            $(elem).parents('.form-group').addClass('has-error');
            return true;
        };
    }
    // validaciones jQuery
    // $(document).on('ready',function () {
    //     $('input[type=number]').on('click', function () {
    //         alert(2);
    //     });
    // });
    // function validarNumero (inputType, valor, e) {
    //     var respuesta;
    //     console.log(isNaN(valor));return;
    //     switch(inputType) {
    //         case 'number':
    //             if( isNaN(valor) ) {
    //                 alerta('Solo números porfavor',function () {});

    //                 $(e.currentTarget).css('border-color','#a94442');

    //                 respuesta = false;
    //             } else{
    //                 $(e.currentTarget).css('border-color','#CCC');
    //                 respuesta = true;
    //             }
    //         break;
    //     }
    //     return respuesta;
    // }