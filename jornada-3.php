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
$hora = $_REQUEST['hora'];

$macuare = $_REQUEST['macuare'];

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$result = mysqli_query($GLOBALS['link'], "Select * from _tconfig where IDCN=" . $tnj);
if (mysqli_num_rows($result) == 0) :
  $result = mysqli_query($GLOBALS['link'], "INSERT INTO _tconfig  VALUES (" . $tnj . ",'" . $ret . "','" . $cat . "','" . $tc . "','" . $tfc . "','" . $hora . "')");
  $result = mysqli_query($GLOBALS['link'], "INSERT INTO _tconfjornada  VALUES (" . $tnj . ",'" . $tfc . "','" . date("H:i:s") . "'," . $thp . "," . $tnc . "," . $tdp . "," . $tta . "," . $tp4 . "," . $est . "," . $macuare . ")");
else :
  $result = mysqli_query($GLOBALS['link'], "Update _tconfig  Set _Ret='" . $ret . "',_fab='" . $cat . "',_Jug='" . $tc . "',_hora='" . $hora . "' where IDCN=" . $tnj);
  $result = mysqli_query($GLOBALS['link'], "Update _tconfjornada  Set fecha='" . $tfc . "',Hora='" . date("H:i:s") . "',IDhipo=" . $thp . ",Cantcarr=" . $tnc . ",NTDp=" . $tdp . ",NTDta=" . $tta . ",NTDP4= " . $tp4 . ",Estatus=" . $est . ",Macuare=" . $macuare . " where IDCN=" . $tnj);
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
