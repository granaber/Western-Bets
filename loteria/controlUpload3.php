<?php

$tipo = substr($_FILES['fileUpload']['type'], 0, 5);
$ext=substr($_FILES['fileUpload']['type'], 6);
$dir = 'images/logo/'; 
  if ($tipo == 'image' && ( $ext == 'png' || $ext == 'gif' )):
        if (!copy($_FILES['fileUpload']['tmp_name'],$dir.$_FILES['fileUpload']['name'])):
		   echo "<script> alert('No pude copiar el archivo al Servidor!'); </script>";
		else:
		   echo "<script> $('imgver').src= 'images/logo/".$_FILES['fileUpload']['name']."'; </script>";
		endif;  
	else:
	  echo "<script> alert('No pude copiar el archivo al Servidor!'); </script>";
   endif;
 
   
   
  

?>
