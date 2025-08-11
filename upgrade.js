// Archivos de Upgrade


//////////////////////////////////////////////////////

function _grabarvalores6(IDC,valor1,valor2,valor3){
	new Ajax.Request("chaceStus.php",{ parameters: { opk:7,IDC:IDC,MontoDesde:valor1,MontoHasta:valor2,aCobrar:valor3 },
			 method:'post',
				onComplete: function(transport){
				var response = transport.responseText.evalJSON() ;
				  if (!response)
				  	alert('No se pudo actulizar su requerimiento');
			   },
			  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });
}
function _grabarvalores7(IDC,valor1,valor2){
	new Ajax.Request("chaceStus.php",{ parameters: { opk:6,IDC:IDC,MontoDesde:valor1,MontoHasta:valor2 },
			 method:'post',
				onComplete: function(transport){
				var response = transport.responseText.evalJSON() ;
				  if (!response)
				  	alert('No se pudo actulizar su requerimiento');
			   },
			  	onFailure: function(){ alert('No tengo respuesta Comuniquese con el Administrador!'); }
			  });
	
}
//////////////////////////////////////////////////////