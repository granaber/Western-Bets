<?php
date_default_timezone_set('America/Caracas');

$tc = $_REQUEST['config'];
$tnc = $_REQUEST['nc'];
$tfc = $_REQUEST['fc'];
$thp = $_REQUEST['hp'];
$tnj = $_REQUEST['nj'];

$tdp = $_REQUEST['dp'];
$tta = $_REQUEST['ta'];
$tp4 = $_REQUEST['p4'];
$ret = $_REQUEST['ret'];
$cat = $_REQUEST['fab'];
$est = $_REQUEST['est'];
$fav = $_REQUEST['favor'];
$hor = $_REQUEST['hora'];

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$result = mysqli_query($GLOBALS['link'], "Select * from _tconfighi where IDCN=" . $tnj);
if (mysqli_num_rows($result) == 0) :
  $result = mysqli_query($GLOBALS['link'], "INSERT INTO _tconfjornadahi  VALUES (" . $tnj . ",'" . $tfc . "','" . date("H:i:s") . "'," . $thp . "," . $tnc . "," . $tdp . "," . $tta . "," . $tp4 . "," . $est . ")");
  $result = mysqli_query($GLOBALS['link'], "INSERT INTO _tconfighi  (IDCN,_Ret,_fab,_Jug,_fecha,_Favoritos,_hora) VALUES (" . $tnj . ",'" . $ret . "','" . $cat . "','" . $tc . "','" . $tfc . "','" . $fav . "','" . $hor . "')");
else :
  $result = mysqli_query($GLOBALS['link'], "Update _tconfjornadahi  Set fecha='" . $tfc . "',Hora='" . date("H:i:s") . "',IDhipo=" . $thp . ",Cantcarr=" . $tnc . ",NTDp=" . $tdp . ",NTDta=" . $tta . ",NTDP4= " . $tp4 . ",Estatus=" . $est . " where IDCN=" . $tnj);

  $result = mysqli_query($GLOBALS['link'], "Update _tconfighi  Set _fecha='" . $tfc . "',_Ret='" . $ret . "',_fab='" . $cat . "',_Jug='" . $tc . "',_Favoritos='" . $fav . "',_hora='" . $hor . "' where IDCN=" . $tnj);
endif;

// echo $tc;
// echo $tnc;
// echo $tfc;
// echo $thp;
// echo $tnj;
// echo $tdp;
// echo $tta;
// echo $tp4;
//echo "INSERT INTO _tconfig  (IDCN,_Ret,_fab,_Jug,_fecha) VALUES (".$tnj.",'','','".$tc."','".$tfc."')";
echo "Grabado....";
