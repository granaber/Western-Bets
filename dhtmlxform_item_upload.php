<?php

/*

HTML5/FLASH MODE

(MODE will detected on client side automaticaly. Working mode will passed to server as GET param "mode")

response format

if upload was good, you need to specify state=true and name - will passed in form.send() as serverName param
{state: 'true', name: 'filename'}



if (@$_REQUEST["mode"] == "html5" || @$_REQUEST["mode"] == "flash") {
	$filename = $_FILES["file"]["name"];
	// move_uploaded_file($_FILES["file"]["tmp_name"],"uploaded/".$filename);
	print_r("{state: true, name:'".str_replace("'","\\'",$filename)."'}");
}

/*

$tipo = substr($_FILES['fileUpload']['type'], 0, 5);
$ext=substr($_FILES['fileUpload']['type'], 6);
$dir = 'images/logo/'; 
  if ($tipo == 'image' && $ext == 'png'):
        if (!copy($_FILES['fileUpload']['tmp_name'],$dir.$_FILES['fileUpload']['name'])):
		   echo "<script> alert('No pude copiar el archivo al Servidor!'); </script>";
		endif;  
	

   endif;


HTML4 MODE

response format:

to cancel uploading
{state: 'cancelled'}

if upload was good, you need to specify state=true, name - will passed in form.send() as serverName param, size - filesize to update in list
{state: 'true', name: 'filename', size: 1234}

*/
$tipo = substr($_FILES['file']['type'], 0, 5);
$ext=substr($_FILES['file']['type'], 6);
$dir = 'media/'; 
  if ($tipo == 'image' && ($ext == 'png' || $ext == 'PNG') ):     
       $nameFile=trim($_COOKIE['idlogoN']).'.'.$ext;
	   if (file_exists($dir.$nameFile)):
	        $old = getcwd();
	        chdir('media/');
			unlink($nameFile);
			chdir($old);
	   endif;
       if (  move_uploaded_file($_FILES["file"]["tmp_name"],$dir.$nameFile) ):	            
		  	print_r("{state: true, name:'".str_replace("'","\\'",$nameFile)."'}");
		endif;  
   endif;

?>
