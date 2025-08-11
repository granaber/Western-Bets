<?php
include "./prc_php.php";
$GLOBALS['link'] = Connection::getInstance();
$valid = "false";
$mesanje = "po";

if (isset($_GET["nombre"])) {
  if (strlen($_GET["nombre"]) < 1) {
    $mesanje = "El Nombre NO debe estar en blanco";
  } else {
    $valid = "true";
    $mesanje = "";
  }
} else if (isset($_GET["direccion"])) {
  if (strlen($_GET["direccion"]) < 1) {
    $mesanje = "La Direccion NO debe estar en blanco";
  } else {
    $valid = "true";
    $mesanje = "";
  }
} else if (isset($_GET["estado"])) {
  if (strlen($_GET["estado"]) < 1) {
    $mesanje = "El Estado NO debe estar en blanco";
  } else {
    $valid = "true";
    $mesanje = "";
  }
} else if (isset($_GET["municipio"])) {
  if (strlen($_GET["municipio"]) < 1) {
    $mesanje = "El Municipio NO debe estar en blanco";
  } else {
    $valid = "true";
    $mesanje = "";
  }
} else if (isset($_GET["telefono"])) {
  if (!is_numeric($_GET["telefono"])) {
    $mesanje = "Este dato debe ser Numerico";
  } else {
    $valid = "true";
    $mesanje = "";
  }
} else if (isset($_GET["c_idc"])) {
  $result = mysqli_query($GLOBALS['link'], "Select * from _tconsecionario where IDC='" . $_GET["c_idc"] . '' . $_GET["nomidcn"] . "'");
  if (mysqli_num_rows($result) != 0) {
    $mesanje = "Ya Existe";
  } else {
    $valid = "true";
    $mesanje = "";
  }
} else if (isset($_GET["grupo"])) {
  $result = mysqli_query($GLOBALS['link'], "Select * from _tconsecionario where IDC='" . $_GET["nomidcn"] . '' . $_GET["grupo"] . "'");
  if (mysqli_num_rows($result) != 0) {
    $mesanje = "Ya Existe";
  } else {
    $valid = "true";
    $mesanje = "";
  }
}

echo $valid . "||" . $mesanje;