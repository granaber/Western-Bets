<?php
$valid ="false";
$mesanje="po";
     
require('prc_php.php');   
				$GLOBALS['link'] = Connection::getInstance(); 

if (isset($_GET["nombre"])) {
 if ( strlen($_GET["nombre"])<1 ) {
   $mesanje="El Nombre NO debe estar en blanco";
 } else {
   $valid ="true";
   $mesanje="";
 }
}else if (isset($_GET["responsable"])) {
 if ( strlen($_GET["responsable"])<1 ) {
   $mesanje="La Clave NO debe estar en blanco";
 } else {
   $valid ="true";
   $mesanje="";
 }
}else if (isset($_GET["telefono"])) {
 if (!is_numeric($_GET["telefono"])) {
   $mesanje="Este dato debe ser Numerico";
 } else {
   $valid ="true";
   $mesanje="";
 }
}else if (isset($_GET["direccion"])) {
 if ( strlen($_GET["direccion"])<1 ) {
   $mesanje="La Direccion NO debe estar en blanco";
 } else {
   $valid ="true";
   $mesanje="";
 }
}else if (isset($_GET["sig"])) {
 if ( strlen($_GET["sig"])<1 ) {
   $mesanje="La Siglas NO debe estar en blanco";
 } else {
   $valid ="true";
   $mesanje="";
 }
}

echo $valid."||".$mesanje;
