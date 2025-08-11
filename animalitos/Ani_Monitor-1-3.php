<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$IDL = $_REQUEST['IDL'];
$IDJ = $_REQUEST['IDJ'];
$aSorteo = array();
$isorteo = array();
//echo ("Select * From  _Jornada  Where IDJ=".$IDJ." and IDL=".$IDL);("Select * From  _Jornada  Where IDJ=".$IDJ." and IDL=".$IDL);
$result = mysqli_query($link, "Select * From  _Jornada  Where IDJ=" . $IDJ . " and IDL=" . $IDL . "   order by HoraCierre ASC");
while ($Row = mysqli_fetch_array($result)) {
    $aSorteo[] = '(' . $Row['ID'] . ')-' . convertirNormal($Row['HoraCierre']);
    $isorteo[] = $Row['ID'];
}

$a = '';
foreach ($isorteo as $i => $delta) {
    $a .= "<div id='tpg_" . $i . "'  style='height:730px; '>";
    $a .= "</div>";
}

echo json_encode(array($aSorteo, $isorteo, $a));
