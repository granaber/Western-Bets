<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$apli = $_REQUEST['op'];
$idcn = $_REQUEST['jn'];
$ganar = $_REQUEST['gn'];
$cirr = $_REQUEST['cr'];


$lc = explode("|", $cirr); /// lc[0]='1' lc[1]='0'  n=Numero de Carreras  

//print_r($cirr);
if ($apli == 1) :
  $lista = explode("*", $ganar); /// Lista[0]='1|5||' Lista[1]='1|2||'  n=Numero de Carreras
  for ($i = 0; $i <= count($lista) - 1; $i++) {
    $result = mysqli_query($GLOBALS['link'], "Select * from _ganadorestablas where idcn=" . $idcn . " and carr=" . ($i + 1));
    if (mysqli_num_rows($result) == 0) :
      $result = mysqli_query($GLOBALS['link'], "INSERT INTO _ganadorestablas (idcn,ganadores,carr,cirr) VALUES (" . $idcn . ",'" . $lista[$i] . "'," . ($i + 1) . ",'1')");
    // echo "INSERT INTO _ganadores (idcn,ganadores,carr,cirr) VALUES (".$idcn.",'".$lista[$i]."',".($i+1).",".$lc[$i].")"; //(carr... values ($idcn,$i+1,$lista[$i],$lc[0])
    else :
      $result = mysqli_query($GLOBALS['link'], "Update _ganadorestablas Set ganadores='" . $lista[$i] . "',cirr='1' Where idcn=" . $idcn . " and carr=" . ($i + 1));
    //echo "Update _ganadores Set ganadores='".$lista[$i]."',cirr='".$lc[0]."' Where idcn='".$idcn." and carr=".($i+1);
    endif;
  }
else :
  // Rutina para cerrar Jugadas De acuerdo con el cierre de Carreras
  cierresph($idcn, $lc, 1);

endif;
echo "Grabado..!";
