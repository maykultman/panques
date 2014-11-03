<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        
    <script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>

    <!-- Alertas alertify.js -->
    <script type="text/javascript" src="<?=base_url()?>js/plugin/alertify/alertify.js"></script>
    <?=
        link_tag('js/plugin/alertify/themes/alertify.core.css').
        link_tag('js/plugin/alertify/themes/alertify.bootstrap.css');
    ?>

    <!-- plugin selectize css -->
    <?= script_tag('js/tablas/jquery-latest.min.js').
        script_tag('js/tablas/jquery.tablesorter.js').
        script_tag('js/tablas/jquery.tablesorter.widgets.js').
        // script_tag('js/tablas/widget-scroller.js').
        script_tag('js/tablas/widget-cssStickyHeaders.js').
        script_tag('js/tablas/estilo_tabla.js');
    ?>
    <?php /*Si no se llama aquí, la edicion de la ficha de un cliente no se activa,
            además debe estar despues de las librerias selectize*/ ?>
    <?= link_tag('css/theme.default.css').
        link_tag('js/plugin/selectize/selectize.default.css').
        script_tag('js/plugin/selectize/selectize.min.js');
    ?>


    <!--Bootstrap-->
    <?=
        link_tag('css/bootstrap-3.1.1-dist/css/bootstrap.min.css').
        link_tag('css/bootstrap-3.1.1-dist/css/bootstrap-theme.css').
        script_tag('css/bootstrap-3.1.1-dist/js/tooltip.js').
        //script_tag('css/bootstrap-3.1.1-dist/js/dropdown.js'). Si  se incluye, los accesos directos no funcionarán
        script_tag('css/bootstrap-3.1.1-dist/js/button.js').
        script_tag('css/bootstrap-3.1.1-dist/js/alert.js').
        script_tag('css/bootstrap-3.1.1-dist/js/tab.js').
        script_tag('css/bootstrap-3.1.1-dist/js/modal.js').
        script_tag('css/bootstrap-3.1.1-dist/js/bootstrap.min.js');
    ?>

 
    <!--Iconos-->
        <?=link_tag('css/style.css');?>
    <!-- Css -->
    <link rel="stylesheet/css" type="text/css" href="<?=base_url()?>css/jquery-ui-1.10.4.custom.css">

    <!--Less-->

    <link rel="stylesheet/less" type="text/css" href="<?=base_url()?>css/estilos_menu_cabecera.less">
    <link rel="stylesheet/less" type="text/css" href="<?=base_url()?>css/estilos_modulo_cotizaciones.less">
    <link rel="stylesheet/less" type="text/css" href="<?=base_url()?>css/estilos_modulo_clientes.less">
    <link rel="stylesheet/less" type="text/css" href="<?=base_url()?>css/estilo_general.less">
    <script>
        less = {
            env: "development",
            logLevel: 2,
            async: false,
            fileAsync: false,
            poll: 1000,
            functions: {},
            dumpLineNumbers: "comments",
            relativeUrls: false,
            globalVars: {
                var1: '"string value"',
                var2: 'regular value'
            }
            // rootpath: "crmqualium.com/css"
        };
    </script>
    <script type="text/javascript" src="<?=base_url()?>js/less.min.js"></script>
    <!--Less-->
     
    
    <script type="text/javascript" src="<?=base_url()?>js/funcionescrm.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/validaciones.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/autocompletes.js"></script>

    <script type="text/javascript" src="<?=base_url()?>js/backbone/lib/handlebars.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/backbone/lib/underscore.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/backbone/lib/backbone.js"></script>


    <script type="text/javascript">
        $(document).on('ready',function(){
            $('#tab_pagos a').click(function (e) {
              e.preventDefault()
              $(this).tab('show');
            });
        });
    </script>
    
    <!-- Hace que la cinta seleccione el linck donde
         nos encontramos actualmente -->
    <script type="text/javascript">
        $(document).ready(function(){
            var cambio = false;
            $('.nav li a').each(function(index) {
                if(this.href.trim() == window.location){
                    $(this).parent().addClass("active");
                    cambio = true;
                }
            });
            if(!cambio){
                $('.nav li:first').addClass("active");
            }
        });
    </script>
    <title></title>

</head>
<body id="cuerpo">

