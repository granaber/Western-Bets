<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$new = $_REQUEST['new'];
$IDDD = $_REQUEST['IDDD'];
$opcionesOpt = $_REQUEST['opcionesOpt'];
$EVE = $_REQUEST['EVE'];
$logValidar = $_REQUEST['logValidar'];
$RangoLogro = $_REQUEST['DesdeLog'] . '|' . $_REQUEST['HastaLog'];
$RangoCarr = $_REQUEST['DesdeCarr'] . '|' . $_REQUEST['HastaCarr'];


$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbvalidarlogros  where Idval=$new ");
if (mysqli_num_rows($result) == 0) :
  $result = mysqli_query($GLOBALS['link'], "INSERT INTO _tbvalidarlogros  (IDDD,op,rangoLogro,IDDDcmp,rangoCarrera,EVE) VALUES (" . $IDDD . ",$opcionesOpt,'$RangoLogro',$logValidar,'$RangoCarr','$EVE')");
else :
  $result = mysqli_query($GLOBALS['link'], "Update _tbvalidarlogros set IDDD=$IDDD,op=$opcionesOpt,rangoLogro='$RangoLogro',IDDDcmp=$logValidar,rangoCarrera='$RangoCarr',EVE='$EVE' where Idval=$new ");
endif;
if ($result) :
  $respuesta = true;
else :
  $respuesta = error(1);
endif;

echo json_encode($respuesta);
