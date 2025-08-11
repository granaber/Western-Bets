<?php
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$sql = "Select * from _Jugada_ani_prem where serial=" . $_REQUEST['serial'];
//Serial,Hora,Fecha,Monto,Cantidad de Numeros
$resultj = mysqli_query($link, $sql);
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);

  $sql = "Select * from _Jugada_ani where serial=" . $_REQUEST['serial'];
  $resultj1 = mysqli_query($link, $sql);
  $rowj1 = mysqli_fetch_array($resultj1);
  if ($rowj1['Activo'] == 1) :

    if ($rowj1['se'] == $_REQUEST['se']) :

      $sql = "Select * from _Jugada_ani_pagado where serial=" . $_REQUEST['serial'];
      $resultj3 = mysqli_query($link, $sql);
      $rowj3 = mysqli_fetch_array($resultj3);
      if (mysqli_num_rows($resultj3) == 0) :

        $ip = getipAnimalitos();
        if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
        endif;

        $resultj4 = mysqli_query($link, "Insert  _Jugada_ani_pagado  values (" . $_REQUEST['serial'] . "," . $rowj['premio'] . ",'" . $ip . "','" . $_REQUEST['usu'] . '-' . FecharealAnimalitos($minutosh, "d/n/Y") . '-' . HorarealAnimalitos($minutosh, "h:i:s A") . "')");
        //echo ("Insert  * from _Jugada_ani_pagado  values (".$_REQUEST['serial'].",".$rowj['premio'].",'".$ip."','".$_REQUEST['usu'].'-'.FecharealAnimalitos($minutosh,"d/n/Y").'-'.HorarealAnimalitos($minutosh,"h:i:s A")."')");
        if ($resultj4) :
          $resultj2 = mysqli_query($link, "Select * from _Jornarda_fecha  where IDJ=" . $rowj1['IDJ']);
          $rowj2 = mysqli_fetch_array($resultj2);

          echo json_encode(array(true, ticketDUK($rowj['serial'], _ConverFecha($rowj2['Fecha']), convertirNormal($rowj1['hora']), $rowj1['IDC'], $rowj1['se'], unserialize(decoBaseK($rowj1['Jugada'])), $rowj1['monto'], $rowj1['IDJ'], 3, 1)));
        else :
          echo json_encode(array(false, 'No puedo paga el ticket!'));
        endif;

      else :
        echo json_encode(array(false, 'Este ticket ya fue pagado!'));
      endif;

    else :
      echo json_encode(array(false, 'No cumple con los requerimiento para ser Pagado, Serial Electronico Errado!'));
    endif;

  else :
    echo json_encode(array(false, 'No cumple con los requerimiento para ser Pagado, ticket esta Anulado!'));
  endif;

else :
  echo json_encode(array(false, 'No cumple con los requerimiento para ser Pagado!'));
endif;
