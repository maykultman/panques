var app = app || {};

app.VistaNuevoEmpleado = Backbone.View.extend({
	el : '.modal-content',

	initialize : function(){
		this.cargarPuestos();
	},
	events:{
		'click #guardar':'guardar',
		'change #fotou' : 'obtenerFoto1',
		'keypress #nemp' : 'valnombre'		
	},
	valnombre : function(e)
	{ 
		return validarNombre(e);
	},

	obtenerFoto1 : function(e)
	{
		obtenerFoto2(e, 'fotou', 'direccionn');
	},

	existsjob:function(job)
	{
		var stin ={};		
		var cadena;
		var cero='';
		var resp;

		if(job.indexOf(' ')!=-1)//Tiene espacio el string
		{
				var array = Array();
				cadena = job.split(' '); // si tiene espacio lo separamos			
				for(e in cadena)
				{					
					cero += cadena[e][0].toUpperCase();//Volvemos mayusculas las primeras letras
					for(k in cadena[e])	
					{
						if(k>0)
						{
							cero+=cadena[e][k];//concatenamos los demas caracteres					
						}								
					}	
					cero+=' ';//le damos un espacio a cada palabara
				}			
				cero = cero.split(' ');//los separamos por espacios
				cero.pop();//eliminamos el espacio en el ultimo caracter
				cero = cero.join(" ");//Lo volvemos cadena

		}
		else{				
				cero = job[0].toUpperCase();//Si sólo fue una palabra
				for(i in job)
				{
					if(i>0)
					{
						cero+=job[i];
					}
				}
		}
		//buscamos en la colección el puesto						
		stin = app.coleccionPuestos.findWhere({'nombre':cero});
		if(stin){
		 return stin.get('id');
		}
		else{
			this.globaltrue();
			app.coleccionPuestos.create(
				{'nombre':job},
				{
					wait:true,
					success:function(exito){ 
						return exito.id;
					},
					error :function(){}
				}
			);
			this.globalfalse();
		}
		// return resp;
	},

	guardar : function(){
		var self = this;

		var empleado = pasarAJson(this.$('#registro').serializeArray());
		modelo.telefonos = jsonphone();
		
		delete modelo.telefono;
		delete modelo.movil;
		
		if(isNaN(empleado.puesto))
		{
			empleado.puesto = this.existsjob(empleado.puesto);
		}
		

		if( this.$('#fotou').val() )
		{
			form = new FormData( this.$("#registro")[0]);
			empleado.foto = urlFotoCatalgos(form, this.$('#fotou').data('url') );
		} 
		else{
			empleado.foto = 'img/sinfoto.png';
		}

		globaltrue();//vease en el archivo funcionescrm.js
		app.coleccionEmpleados.create(
			empleado,
			{
				wait : true,
				success : function(exito){				
					self.$('#registro')[0].reset();					
					alerta('El Empleado se añadio exitosamente');					
				},
				error : function(error){}
			}
			
		);
		globalfalse();//vease en el archivo funcionescrm.js			
		
	},
	
	saveTel : function(telefonos){
		var band;
		this.globaltrue();
		app.coleccionTelefonos.create(
			telefonos,
			{
				wait : true,
				success:function(good){
					band = 1;
				},
				error:function(bad){
					band = 0;
				}
			}
		);
		this.globalfalse();
		return band;
	},
	cargarPuestos : function(){

		var ne = '<%_.each(jobs, function(job){ %> <option disabled id="<%-job.id%>" value="<%-job.id%>"><%-job.nombre%></option><%});%>';
		this.$('.jobs').html(_.template(ne)({jobs : app.coleccionDePuestos }));

		 this.$('.jobs').selectize({
			create: true,
			maxItems: 1
		});
	}

});
app.vistaNuevoEmpleado = new app.VistaNuevoEmpleado();

app.VistaConsultaEmpleado = Backbone.View.extend({
	el : '#consultaEmpleado',

	events : {
		'click .opciones'	  : 'opciones',
	},

	initialize : function ()
	{		
		//this.$divEmpleado = this.$('#empleados'); // Div donde se visualiza los datos del empleado			
		this.cargarPuestos();
		this.cargarEmpleados();
	},

	cargarEmpleados : function()
	{
		var vista;
		var self=this;
		var tab;
		var content;
		var puestos = app.coleccionPuestos;
		
		app.coleccionEmpleados.each(function(empleado){
			tab = 'p'+empleado.get('puesto');
			empleado.set({ 'nompuesto' : puestos.findWhere({ 'id':empleado.get('puesto') }).get('nombre') });
			vista = new app.VistaGetEmpleado({ model : empleado});			
			self.$('#empleados #'+tab).append(vista.render().el);			
		},this);
	},

	cargarPuestos : function(){

		var coleccion = app.coleccionPuestos.toJSON();
		var list = '<% _.each(puestos, function(puesto){ %> <li><a href="#p<%-puesto.id%>" role="tab" data-toggle="tab"><%-puesto.nombre%></a></li><%})%>';
		// Lo agregamos al elemento DOM #moduloss
		$('#listaPuesto').append(_.template(list)({puestos : coleccion }));			
		// Activamos el primer modulo de la lista.
		$("#listaPuesto").children(':first-child').addClass('active');

		var div=''; var active='tab-pane';
		for(i in coleccion)
		{
			active = (i==0) ? 'active' : '';
			div += '<div id="p'+coleccion[i].id+'" class="tab-pane '+active+'"></div>';
		}		
		this.$('#empleados').append(div);
	}


});

app.vistaConsultaEmpleado = new app.VistaConsultaEmpleado();
