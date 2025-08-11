<?
$valores=explode(',',$_REQUEST['ldv']);
$namearc=explode(',',$_REQUEST['arch']);
$fecha=str_replace("/", "_", $_REQUEST['fch']);
echo $fecha;
for ($i=0;$i<=count($namearc)-2;$i++){
	echo $namearc[$i].'<br>';
	if (file_exists('arch/'.$namearc[$i])):
			 rename('arch/'.$namearc[$i],'arch/'.$valores[$i].'_'.$fecha.'.pdf');		
			/*else:
			 if (file_exists( 'images/logo/'.$nomarchi) && strcmp ($nomarchi,'eq'.$valores[0].'.png')!=0 ):	      
			   unlink ('images/logo/eq'.$valores[0].'.png');
			   rename('images/logo/'.$nomarchi,'images/logo/eq'.$valores[0].'.png');
			  endif;*/
	endif; 
}
?>