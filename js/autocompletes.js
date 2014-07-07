	/* 'elemento' es el campo donde se realiza la busqueda
	 *  es el this de la clase que llamo a este metodo
	 * 'coleccion' es la coleccion del modulo que llama a este metodo
	 * 'tbody' es donde se renderizara el modelo
	*/
	function autocompleteGenerico(elemento, self, coleccion, tbody )
	{
		var lista = new Array();  var cont  = 0;
		var coleccionPersona; 
				
		if($(elemento.currentTarget).attr('id')==='buscarCliente') 
		{
			coleccionPersona = app.coleccionClientes;
			for(i in app.coleccionDeClientes)
	        {
	             lista[cont] = app.coleccionDeClientes[i].nombreComercial; cont++;          
	        };
		}
		else
		{	coleccionPersona = app.coleccionEmpleados;
			for(i in app.coleccionDeEmpleados)
	        {
	            lista[cont] = app.coleccionDeEmpleados[i].nombre; cont++;          
	        };
		}
		$(elemento.currentTarget).autocomplete({ source : lista });
        
        $(elemento.currentTarget).on( "autocompleteselect", function( event, ui ) {
        	var modelo;
            /*...Buscamos al cliente que nos proporciono el autocomplete en la coleccion.....*/
            if($(elemento.currentTarget).attr('id')==='buscarCliente') 
			{
	            modelo = coleccion.where
	            			({ idcliente 		 : ( ( coleccionPersona.findWhere
	            			({ 'nombreComercial' :     ui.item.value } ) ).toJSON() ).id });
	        }
	        else
	        {
	        	modelo = coleccion.where
	            			({ idempleado : ( ( coleccionPersona.findWhere
	            			({ 'nombre'   :     ui.item.value } ) ).toJSON() ).id });	
	        }	        
	        
     		tbody.html('');
     		if($(tbody).attr('id')==='lista_cotizaciones')
     		{
     			for(i in modelo)
	     			self.cargarCotizacion(modelo[i]);	 
     		}
     		else
     		{
     			for(i in modelo)
	     			self.cargarContrato(modelo[i]);
	     	}            
        });
	}

	function ordenar(fecha, coleccion)
	{  console.log(coleccion);
		if($(fecha.currentTarget).attr('class')==='abajo')
		{
			$('#bfecha').removeClass('abajo');
			$('#bfecha').addClass('arriba');
			$('#fecha').removeClass('downt');		
			$('#fecha').addClass('upt');			
		}
		else
		{
			$('#bfecha').removeClass('arriba');
			$('#bfecha').addClass('abajo');
			$('#fecha').removeClass('upt');		
			$('#fecha').addClass('downt');			
		}
		var ordenar = coleccion.sort
		(
			function(a,b)
			{
				if($(fecha.currentTarget).attr('class')==='abajo')
				{
					alert('e.e');
					return ( b.fecha - a.fecha );	
				}
				else
				{
						return (a.fecha - b.fecha);
				}			
			}
		);		
		return ordenar;		
	}