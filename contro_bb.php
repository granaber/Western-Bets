<?php

$tp = $_REQUEST['tp'];

if ($tp == 1) :

  echo json_encode(1);
endif;

if ($tp == 2) :
  require_once('prc_php.php');
  date_default_timezone_set('America/Caracas');

  echo Fechareal($GLOBALS['minutosh'], "d/m/y") . '||' . Horareal($GLOBALS['minutosh'], "h:i:s A");
endif;

if ($tp == 3) :
  require_once('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();
  $con = $_REQUEST["con"];
  $result = mysqli_query($GLOBALS['link'], "SELECT * From _tconsecionario where IDC='" . $con . "'");
  $row = mysqli_fetch_array($result);

  echo json_encode($row['Direccion']);

endif;
