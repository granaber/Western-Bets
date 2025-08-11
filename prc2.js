// JavaScript Document

function uploadFileExcel(obj) {
	
	
	
	$('fromiut').submit();
	
	var a=$(obj).value; 
	
	a1=a.split(String.fromCharCode(92));
	
	extension=a1[a1.length-1].split('.');
	
	
	
	if (extension[1]=='xls' || extension[1]=='XLS') {
	
		$(obj).lang=a1[a1.length-1];
	
		/*$('imgver').src= 'images/logo/'+a1[a1.length-1];*/
	
	} else {
	
		$(obj).value=''; 
	
		alert('SOLAMENTE SE ACEPTAN LOGOS CON EXTENSION XLS!');
	
	}
	
	
	
	}