var app = app || {};

app.VistaGetEmpleado = Backbone.View.extend({

	tagName : 'article',
	className : 'col-xs-12 col-sm-6 col-md-4 col-lg-4',
	plantilla : _.template($('#empleado').html()),

	events : {
		'click .icon-circleup' : 'block',
		'click .glyphicon-remove' : 'block',
		'click .remov'				: 'eliminar',
		'click .edita'				: 'editar',
		'change .botonf' : 'changefoto',
		'click .update' : 'updatephoto'
	},
	
	initialize: function(){
		this.listenTo(this.model, 'destroy', this.remove);
		var self = this;
	},

	render:function()
	{
		if(this.model.get('telefonos'))
		{
			var n = jQuery.parseJSON(this.model.get('telefonos'));
			this.model.set({'movil': n.movil});
			this.model.set({'telefono': n.casa});
		}	
		else{
			this.model.set({'movil': ''});
			this.model.set({'telefono': ''});
		}		
		this.$el.html( this.plantilla( this.model.toJSON() ) );  		
		this.jobs();    
		return this;
	},

	updatephoto : function(e)
	{
		var id = this.model.get('id');
		var foto = this.$('#foto'+id);		
		var emp;
		if( foto.val() )
		{
			emp = new FormData( this.$("#dateEmp")[0]);
			emp.foto = urlFotoCatalgos(emp, foto.data('url') );	
			
			if(emp.foto)
			{
				this.model.save
				(
					emp, 
					{
						wait:true,
						patch:true,
						success: function (exito){
							self.$('#true'+id).toggleClass('yes');
							setTimeout(function(){
							   	$('#true'+id).toggleClass('yes'); 
							}, 3000);
						}, 
						error: function (error){}
					}
				);
			}else{
				this.$('#not'+id).toggleClass('yes');
            	setTimeout(function(){
                	$('#not'+id).toggleClass('yes'); 
            	}, 3000);
			}
		} 
	},
	// Cambia la foto del empleado
	changefoto:function(e){	

		var id = $(e.currentTarget).attr('id');
		var contenedor = 'direccion'+this.model.get('id');	
		obtenerFoto2(e, id,contenedor);	
	},
	// Devuelve un select de puestos
	jobs:function(){
		var options = '<% _.each(puestos, function(puesto){ %> <option id="<%-puesto.id%>" value="<%-puesto.id%>"><%-puesto.nombre%></option><%})%>';
		this.$('#job').append(_.template(options)({puestos:app.coleccionPuestos.toJSON()}));
		this.$('#job #'+this.model.get('puesto')).attr('disabled',true).attr('selected', 'selected');
	},
	// Muestra el formulario de edición del empleado
	block : function(){
		this.$('.edit').toggleClass('fulls');
		this.$('.ed').toggleClass('edb');
	},

	editar : function()
	{	
		var self = this;
		var modelo = pasarAJson(this.$('#dateEmp').serializeArray());
		modelo.telefonos = jsonphone(modelo);		
		delete modelo.telefono;
		delete modelo.movil;		
		this.model.save(
			modelo,
			{
				wait:true,
				patch:true,
				success:function(exito){										
					self.$('.inf small').html(self.model.get('nompuesto'));										
					if(modelo.puesto!=undefined)
					{
						var puestos = app.coleccionPuestos;	
						self.model.set({ 'nompuesto' : puestos.findWhere({ 'id':self.model.get('puesto') }).get('nombre') });
						self.$(".inf b").html(self.model.get('nombre'));
						var vista = new app.VistaGetEmpleado({ model : self.model});									
						$('#empleados #p'+modelo.puesto).append(vista.render().el);
						self.remove();	
						alerta('Cambios guardados exitosamente se ha removido a la sección del puesto '+self.model.get('nompuesto'), function() {});					
					}
					else{
						alerta('Exito', function() {});	
					}
					
				},
				error:function(){
					alerta('error', function() {});
				}
			}
		);
	},

	eliminar : function(e)
	{
		var isuser = $(e.currentTarget).data('count');		
		// var self = this;
		if(isuser==1)
		{
			confirmar('<b>Este empleado es un usuario del sistema si lo elimina, eliminara sus privilegios</b>', 
						function () {}, function () {});
		}else{
			confirmar('¿Desea eliminar a este empleado?', function(){
				self.model.destroy();
			},function(){});
		}
	}
});