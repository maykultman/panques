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

	function ordenar(fecha, coleccion, coleccionDe)
	{  
		var parametros = ['abajo','arriba'];
		var flecha     = ['downt','upt'];
		
		if($(fecha.currentTarget).attr('class')==='arriba')
		{
			parametros.reverse(); console.log('3')
			flecha.reverse();		
		}
		$( '#bfecha' ) .removeClass ( parametros [0] );
		$( '#bfecha' ) .addClass    ( parametros [1] );
		$( '#fecha'  ) .removeClass ( flecha     [0] );		
		$( '#fecha'  ) .addClass    ( flecha     [1] );	
		
		var col = coleccion.reset(coleccionDe.reverse());		
	}
