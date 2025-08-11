<?php
$valid = "false";
$mesanje = "po";
$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
mysql_select_db("sphonlin_sphonline", $GLOBALS['link']);

if (isset($_GET["usuario"])) {
  if (strlen($_GET["usuario"]) < 1) {
    $mesanje = "El Usuario NO debe estar en blanco";
  } else {
    $result = mysqli_query($GLOBALS['link'], "Select * from _tusu where Usuario='" . $_GET["usuario"] . "'");
    if (mysqli_num_rows($result) != 0) {
      $mesanje = "Ya Existe";
    } else {
      $valid = "true";
      $mesanje = "";
    }
  }
} else if (isset($_GET["nombre"])) {
  if (strlen($_GET["nombre"]) < 1) {
    $mesanje = "El Nombre NO debe estar en blanco";
  } else {
    $valid = "true";
    $mesanje = "";
  }
} else if (isset($_GET["clave"])) {
  if (strlen($_GET["clave"]) < 1) {
    $mesanje = "La Clave NO debe estar en blanco";
  } else {
    $valid = "true";
    $mesanje = "";
  }
} else if (isset($_GET["rep"])) {
  if (strlen($_GET["rep"]) < 1) {
    $mesanje = "La Clave NO debe estar en blanco";
  } else {
    $valid = "true";
    $mesanje = "";
  }
} else if (isset($_GET["estacion"])) {
  if (strlen($_GET["estacion"]) < 1) {
    $mesanje = "La Estacion NO debe estar en blanco";
  } else {
    $valid = "true";
    $mesanje = "";
  }
}

echo $valid . "||" . $mesanje;
