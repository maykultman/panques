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
    // validaciones jQuery
    // $(document).on('ready',function () {
    //     $('input[type=number]').on('click', function () {
    //         alert(2);
    //     });
    // });
    function validarInput (inputType, valor, e) {
        var respuesta;
        switch(inputType) {
            case 'number':
                if(!(/^\d{10,20}$/.test(valor)) ) {
                    alerta('Solo números porfavor',function () {});

                    $(e.currentTarget).css('border-color','#a94442');

                    respuesta = false;
                } else{
                    $(e.currentTarget).css('border-color','#CCC');
                    respuesta = true;
                }
            break;
        }
        return respuesta;
    }