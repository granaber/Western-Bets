<?php

$tipo = substr($_FILES['fileUpload']['type'], 0, 5);
$dir = 'media/'; 
  if ($tipo == 'image'):
        if (!copy($_FILES['fileUpload']['tmp_name'],$dir.$_FILES['fileUpload']['name'])):
		   echo "<script> alert('No pude copiar el archivo al Servidor!'); </script>";
		endif;  
   endif;
 
   
   
  

?>
