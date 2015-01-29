var app = app || {};

app.VistaRolPrincipal = Backbone.View.extend({

	events	: {
	},

	initialize		: function () {
		this.listenTo(this.model, 'destroy', this.remove);
	},

	render			: function () {
		this.$el.html( this.plantillaDefault( this.model.toJSON() ) );
		this.$el.attr('id',this.model.get('id'));
		this.$el.attr('value', this.model.get('id')+'_'+this.model.get('nombre'));
		return this;
	},
	guardarRol		: function (modelo, callBack) {/**/
		var esto = this;
		globlatrue();
		app.coleccionRoles.create(
			modelo,
			{
				wait	: true,
				success : function (exito) {
					// esto.globalizarId(exito.get('id'));
					if (!(!variable)) {
						callBack(exito.get('id'));
					};
				},
				error 	: function (error) {}
			}
		);
		globlafalse();
	}
});

// app.VistaRol = app.VistaRolPrincipal.extend({
// 	tagName	: 'option',
// 	className	: 'optionRol',
// 	plantillaDefault : _.template($('#option_rol').html()),
// });