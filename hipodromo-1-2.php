<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$pr = $_REQUEST['pr'];

if ($pr == 1) :
  $idh = $_REQUEST['idh'];
  $nm = $_REQUEST['nm'];
  $sg = $_REQUEST['sg'];
  $es = $_REQUEST['es'];

  $result = mysqli_query($GLOBALS['link'], "Select * from _hipodromos where _idhipo=" . $idh);

  if (mysqli_num_rows($result) == 0) :
    $result = mysqli_query($GLOBALS['link'], "INSERT INTO _hipodromos (_idhipo,Descripcion,Estatus,siglas) VALUES (" . $idh . ",'" . $nm . "'," . $es . ",'" . $sg . "')");
  else :
    $result = mysqli_query($GLOBALS['link'], "Update _hipodromos  Set Descripcion='" . $nm . "',Estatus=" . $es . ",siglas='" . $sg . "' where _idhipo=" . $idh);
  endif;

else :
  $idh = $_REQUEST['idh'];
  $result = mysqli_query($GLOBALS['link'], "Delete from _hipodromos  where _idhipo=" . $idh);
endif;
echo "Grabado..";
