<?php
$valid ="false";
$mesanje="po";

if (isset($_GET["juego_nombre"])) {
 if ( strlen($_GET["juego_nombre"])<1 ) {
   $mesanje="El Nombre del Juego NO debe estar en blanco";
 } else {
   $valid ="true";
   $mesanje="";
 }
}else if (isset($_GET["factor"])) {
 if (!is_numeric($_GET["factor"])) {
   $mesanje="Este dato debe ser Numerico";
 } else {
   $valid ="true";
   $mesanje="";
 }
} else if (isset($_GET["juego_apuesta_minima"])) {
 if (!is_numeric($_GET["juego_apuesta_minima"])) {
   $mesanje="Este dato debe ser Numerico";
 } else {
   $valid ="true";
   $mesanje="";
 }
}else if (isset($_GET["cantidadcarrera"])) {
 if (!is_numeric($_GET["cantidadcarrera"])) {
   $mesanje="Este dato debe ser Numerico";
 } else {
   $valid ="true";
   $mesanje="";
 }
}else if (isset($_GET["cantidadejemp"])) {
 if (!is_numeric($_GET["cantidadejemp"])) {
   $mesanje="Este dato debe ser Numerico";
 } else {
   $valid ="true";
   $mesanje="";
 }
}
echo $valid."||".$mesanje;
?>
