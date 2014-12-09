var app = app || {};

app.ModeloPerfil = Backbone.Model.extend({
	urlRoot	:'http://crmqualium.com/api_perfil'
});

	function rezise(elemento)
	{
		var efect = $(elemento.currentTarget).parent().children('.conf').attr('id');	
		$('#'+efect).slideToggle( 400 );
		if( $(elemento.currentTarget).children('#fl').children().attr('class') == 'icon-circledown' )
		{
			$(elemento.currentTarget).children('#fl').children().removeClass();
			$(elemento.currentTarget).children('#fl').children().addClass('icon-circleup');
		}
		else
		{
			$(elemento.currentTarget).children('#fl').children().removeClass();
			$(elemento.currentTarget).children('#fl').children().addClass('icon-circledown');	
		}
	}
		