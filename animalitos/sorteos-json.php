<?
require_once('prc_phpDUK.php');
header("Content-type:application/json");
$link = ConnectionAnimalitos::getInstance();
$cierre = _check_cierre_sorteo($_REQUEST['usu']);
$Loteria = array();
$resultj = mysqli_query($link, 'Select * from _Loterias Where Activa=1');
while ($Row = mysqli_fetch_array($resultj)) $Loteria[$Row['IDL']] = $Row['Nombre'];
$IDJ = _FechaDUK();
$IDL = $_REQUEST['IDL'];

$json = [];
if (count($cierre) == 0) :
  $add = '';
else :
  if ($cierre[0] == false) :
    echo  json_encode($json);
    exit;
  else :
    $add = '  and not _Jornada.ID  in (' . implode(",", $cierre) . ')';
  endif;
endif;


$sql = "Select *,_JornadaStandar.Descripcion from _Jornada,_JornadaStandar where _JornadaStandar.Hora=_Jornada.`HoraCierre` and _JornadaStandar.IDL=_Jornada.IDL and Activa=1 and IDJ=" . $IDJ . $add . "  and _Jornada.IDL=$IDL order by HoraCierre ASC";
$resultj = mysqli_query($link, $sql);
while ($Row = mysqli_fetch_array($resultj)) {
  $json[] = array("id" => $Row['ID'], "idl" => $Loteria[$Row['IDL']], "nom" => 'Sorteo de: ' . $Row['Descripcion'],);
}

echo  json_encode($json);
