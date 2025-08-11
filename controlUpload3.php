<?php

$tipo = substr($_FILES['fileUpload']['type'], 0, 5);
$ext=substr($_FILES['fileUpload']['type'], 6);
$dir = 'images/logo/'; 
  if ($tipo == 'image' && $ext == 'png'):
        if (!copy($_FILES['fileUpload']['tmp_name'],$dir.$_FILES['fileUpload']['name'])):
		   echo "<script> alert('No pude copiar el archivo al Servidor!'); </script>";
		endif;  
	

   endif;
 
   
   
  

?>
