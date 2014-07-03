var app = app || {};
app.ModeloServicioProyecto = Backbone.Model.extend({
	urlRoot	:'http://crmqualium.com/api_serviciosProyecto',
	defaults	: {
		status	: true
	},
	conmutarStatus	: function (callbackExito,callbackError) {
		var st;
		if (this.get('status') == true)
			st = '0';
		else
			st = '1';
		this.save(
			{ status: st },
			{
				wait:true, 
				patch:true,
				success:function () {
					callbackExito();
				},
				error:function () {
					callbackError();
				}
			}
		);
	}
});