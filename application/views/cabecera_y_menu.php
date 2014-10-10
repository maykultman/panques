<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
		
		<?=script_tag('js/jquery.js');?>

	<!-- Alertas alertify.js -->
		<?=script_tag('js/plugin/alertify/lib/alertify.js').
		   script_tag('js/plugin/alertify/lib/alertify.js').
		   link_tag('js/plugin/alertify/themes/alertify.core.css').
		   link_tag('js/plugin/alertify/themes/alertify.default.css').
		   script_tag('js/prefixfree.min.js').
		   script_tag('js/menu_jquery.js');?>	

	<!--Bootstrap-->
	<?= link_tag('css/bootstrap-3.1.1-dist/css/bootstrap.min.css').
			   link_tag('css/bootstrap-3.1.1-dist/css/bootstrap-theme.css').
			   link_tag('css/bootstrap-3.1.1-dist/js/bootstrap.min.js').
			   script_tag('css/bootstrap-3.1.1-dist/js/dropdown.js').
			   script_tag('css/bootstrap-3.1.1-dist/js/tab.js').
			   script_tag('css/bootstrap-3.1.1-dist/js/button.js').
			   script_tag('css/bootstrap-3.1.1-dist/js/tooltip.js').
			   script_tag('css/bootstrap-3.1.1-dist/js/alert.js');
	?>	
    <!--Bootstrap-->
 
	<!--Iconos-->
		<?=link_tag('css/style.css');?>
	<!--Iconos-->
	<!-- Css -->
		<?=link_tag('css/jquery-ui-1.10.4.custom.css');?>


	<!--Less-->
	<?
		// link_tag('css/estilos_menu_cabecera.less','stylesheet','text/less').
		// link_tag('css/estilos_modulo_cotizaciones.less','stylesheet','text/less').
		// link_tag('css/estilos_modulo_clientes.less','stylesheet','text/less').
		// link_tag('css/estilo_general.less','stylesheet','text/less').
		// script_tag('js/less.js');
	?>		
	
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
	    },
	    // rootpath: "crmqualium.com/css"
	  };
	</script>
	<script type="text/javascript" src="<?=base_url()?>js/less.min.js"></script>
	<!--Less-->
	 
	
	<script type="text/javascript" src="<?=base_url().'js/funcionescrm.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/validaciones.js'?>"></script>
	<script type="text/javascript" src="<?=base_url().'js/autocompletes.js'?>"></script>
<?=
script_tag('js/backbone/lib/handlebars.js').
script_tag('js/backbone/lib/underscore.js').
    script_tag('js/backbone/lib/backbone.js');?>

	<script type="text/javascript">
		$(document).on('ready',function(){
			$('#tab_pagos a').click(function (e) {
			  e.preventDefault()
			  $(this).tab('show');
			});
		});
	</script>
	
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
	<script type="text/javascript" src="<?=base_url().'css/bootstrap-3.1.1-dist/js/modal.js'?>"></script>
</head>
<body id="cuerpo">

