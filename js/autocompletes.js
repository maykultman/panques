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
	/*... La tarea de este metodo es aplicar css a la fecha de la cotizacion...*/
	function ordenar(fecha)
	{  
		var parametros = ['abajo','arriba'];
		var flecha     = ['downt','upt'];
		
		if($(fecha.currentTarget).attr('class')==='arriba')
		{
			parametros.reverse();
			flecha.reverse();		
		}
		$( '#bfecha' ) .removeClass ( parametros [0] );
		$( '#bfecha' ) .addClass    ( parametros [1] );
		$( '#fecha'  ) .removeClass ( flecha     [0] );		
		$( '#fecha'  ) .addClass    ( flecha     [1] );		
	}
	/*... Este metodo es utilizado por el modulo de usuario Nuevo, consulta y consulta perfiles...*/
	/*... Su tarea es hacer "checked" a los "checkbox" y pintarlos de color verde...*/
	/*... Los dos primeros parametros son arrays, y el tercer es el "$el" de backbone que pinta cada permiso...*/
	function marcarPermiso(permiso, checkbox, el)
	{
		for( e in permiso)
		{
			for(var i = 0 ; i < checkbox.length ; i++)
			{ 
			 	if(permiso[e] == checkbox[i].value)
			 	{
			 		el.find('#permiso_'+permiso[e]).attr('checked', 'true');
			 		el.find('#permiso_'+permiso[e]).parent().css('background','#ddffdd');
					el.find('#permiso_'+permiso[e]).parent().css('border-radius','5px');						 	
			 	}
			}
		}	
	}

	 
