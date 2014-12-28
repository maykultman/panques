<script type="text/plantilla" id="tsubmodulos">
<div class="<%-active%>" id="<%-modulo%><%-band%>">	
	<% for(i in submodulos){ %>
		<div id="toggle<%-band%>">
			<div class="tohead">
				<span><%- submodulos[i]%></span>				
				<i id="i<%-(submodulos[i]+modulo)%><%-band%>" class="icon-circledown"></i>																
			</div>
			<div id="<%-modulo%><%- submodulos[i] %><%-band%>" class="ui-widget-content ui-corner-all conf">
				
				<% if(submodulos[i]=='Nuevo'||submodulos[i]=='Cronograma'||submodulos[i]=='Usuarios'){%>
					<span class="pchek"><input id="1" name="<%-modulo%><%-submodulos[i]%>" value="1" class="chek" type="checkbox" >Acceso</span>
				<%}else{%>
					<% if(submodulos[i]=='Papelera'){%>
						<span class="pchek"><input id="6" name="<%-modulo%><%-submodulos[i]%>" value="6" class="chek" type="checkbox" >Restaurar</span>
						<span class="pchek"><input id="4" name="<%-modulo%><%-submodulos[i]%>" value="4" class="chek" type="checkbox" >Eliminar</span>
					<%}%>
					<% if(submodulos[i]=='Prospectos'){%>								
						<span class="pchek"><input id="5" name="<%-modulo%><%-submodulos[i]%>" value="5" class="chek" type="checkbox" >Pasar a Cliente</span>															
					<%} %>
														
				<%}%>
				<% if(	submodulos[i]=='Prospectos'	||	submodulos[i] == 'Clientes'		||
						submodulos[i]=='Proyectos'	||	submodulos[i] == 'Cotizaciones'	||
						submodulos[i]=='Contratos'	||	submodulos[i] == 'Empleados'	||
						submodulos[i]=='Perfiles'	||	submodulos[i] == 'Puestos'		||
						submodulos[i]=='Roles'		||	submodulos[i] == 'Servicios'	
				){ %>
					<%if(submodulos[i] == 'Empleados'||submodulos[i]=='Perfiles'	||submodulos[i] == 'Puestos'		
						||submodulos[i]=='Roles'||submodulos[i] == 'Servicios'|| submodulos[i]=='Contratos')
						{%>  
					<span class="pchek"><input id="1" name="<%-modulo%><%-submodulos[i]%>" value="1" class="chek" type="checkbox" >Nuevo</span> <%}%>
					<span class="pchek"><input id="2" name="<%-modulo%><%-submodulos[i]%>" value="2" class="chek" type="checkbox" >Consultar</span>
					<span class="pchek"><input id="3" name="<%-modulo%><%-submodulos[i]%>" value="3" class="chek" type="checkbox" >Editar</span>
					<span class="pchek"><input id="4" name="<%-modulo%><%-submodulos[i]%>" value="4" class="chek" type="checkbox" >Eliminar</span>
				<% }%>
				</div>
			</div>
		<%}%>	
	</div>
</script> 