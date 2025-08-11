<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$pr = $_REQUEST['pr'];

if ($pr == 1) :
  $jn = $_REQUEST['jn'];
  $fc = $_REQUEST['fc'];
  $am = $_REQUEST['am'];
  $jt = $_REQUEST['jt'];
  $je = $_REQUEST['je'];
  $nj = $_REQUEST['nj'];
  $colort = $_REQUEST['co'];
  $cc = $_REQUEST['cc'];
  $ce = $_REQUEST['ce'];
  $cfn = $_REQUEST['cfn'];
  $fdc = $_REQUEST['fdc'];
  $frm = $_REQUEST['frm'];
  $rps = $_REQUEST['rps'];

  $proc = $_REQUEST['proc'];
  $op1 = $_REQUEST['op1'];
  $op2 = $_REQUEST['op2'];
  $op3 = $_REQUEST['op3'];

  $result = mysqli_query($GLOBALS['link'], "Select * from _tdjuegos where IDJug=" . $nj);

  if (mysqli_num_rows($result) == 0) :
    $result = mysqli_query($GLOBALS['link'], "INSERT INTO _tdjuegos (IDJug,Descrip,Multip,ApuestaMinima,Tandas,Estatus,Color,CantidadCarr,EjemxCarr,Config,Formato,calculo,relpos,op1,op2,op3,porc) VALUES (" . $nj . ",'" . $jn . "'," . $fc . "," . $am . "," . $jt . "," . $je . ",'#" . $colort . "'," . $cc . "," . $ce . ",'" . $cfn . "'," . $frm . "," . $fdc . "," . $rps . "," . $op1 . "," . $op2 . "," . $op3 . "," . $proc . ")");
  else :
    $result = mysqli_query($GLOBALS['link'], "Update _tdjuegos  Set Descrip='" . $jn . "',Multip=" . $fc . ",ApuestaMinima=" . $am . ",Tandas=" . $jt . ",Estatus=" . $je . ", Color='#" . $colort . "',CantidadCarr=" . $cc . ",EjemxCarr=" . $ce . ",Config='" . $cfn . "',Formato=" . $frm . ",calculo=" . $fdc . ",relpos=" . $rps . ",op1=" . $op1 . ",op2=" . $op2 . ",op3=" . $op3 . ",porc=" . $proc . " where IDJug=" . $nj);
  endif;

else :
  $nj = $_REQUEST['nj'];
  $result = mysqli_query($GLOBALS['link'], "Delete from _tdjuegos  where IDJug=" . $nj);
endif;

//echo "Grabado....";
//echo "INSERT INTO _tdjuegos (IDJug,Descrip,Multip,Config,ApuestaMinima,Tandas,Estatus,Color,CantidadCarr,EjemxCarr,Config) VALUES (".$nj.",'".$jn."',".$fc.",'',".$am.",".$jt.",".$je.",'#".$colort."',".$cc.",".$ce.",'".$cfn."')";
