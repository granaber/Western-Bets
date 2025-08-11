<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$usu = $_REQUEST['usu'];


$cierre = _check_cierre_sorteo($usu);

if (in_array($_REQUEST['iSord'], $cierre)):
  echo json_encode($cierre);
else:
  echo json_encode(array());
endif;
