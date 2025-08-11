<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();
$IDJ = _FechaDUK($_REQUEST['fecc'], 0);


$aSorteo = array();
$isorteo = array();
$result = mysqli_query($link, "Select * From  _Jornada  Where IDJ=" . $IDJ);
while ($Row = mysqli_fetch_array($result)) {
    $aSorteo[] = '(' . $Row['ID'] . ')-' . convertirNormal($Row['HoraCierre']);
    $isorteo[] = $Row['ID'];
}

echo json_encode(array($aSorteo, $isorteo, $IDJ));
