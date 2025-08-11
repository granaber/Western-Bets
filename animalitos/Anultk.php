<?
require_once('prc_phpDUK.php');
require_once("typedef.php");

$link = ConnectionAnimalitos::getInstance();

$sql = "Select * from _Jugada_ani where serial=" . $_REQUEST['serial'];
//Serial,Hora,Fecha,Monto,Cantidad de Numeros
$resultj = mysqli_query($link, $sql);
$rowj = mysqli_fetch_array($resultj);
if ($rowj['Activo'] != 0) :
  if (_Vericacion_Anulacion(unserialize(decoBaseK($rowj['Jugada'])), $rowj['IDJ'])) :
    $reslval[0] = false;
    $reslval[1] = '7';
    $reslval[2] = 'SORTEO CERRADO - El ticket tiene jugada donde el Sorteo ya fue cerrado!';
  else :
    if ($rowj['down'] == 0) :

      if (cuantostickets($rowj['IDC'], $rowj['IDJ'])) :
        $hora = HorarealAnimalitos($minutosho, "H:i:s");
        $Fecha = FecharealAnimalitos($minutosho, 'Y-m-d');
        $ip = getipAnimalitos();
        if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
        endif;
        $MYIDC = $rowj['IDC'];
        $serial = $_REQUEST['serial'];
        $MYAP = $rowj['monto'];
        $resultj = mysqli_query($link, "Update  _Jugada_ani set HE='" . $hora . "-" . $Fecha . "', IPE='" . $ip . "',IDUE=" . $_REQUEST['usu'] . ",Activo=0 where serial=" . $_REQUEST['serial']);
        $ResponseCredito = BackendCredito($MYIDC, $serial, $MYAP, $TYPE_REVERSO, "");

        $reslval[0] = true;
      else :
        $reslval[0] = false;
        $reslval[1] = '7';
        $reslval[2] = 'LIMITES - Usted no puede eliminar tickets ya cubrio su limite';
      endif;
    else :
      $reslval[0] = false;
      $reslval[1] = '7';
      $reslval[2] = 'PERDEDOR - Usted no puede eliminar tickets perdedores';
    endif;
  endif;
else :
  $reslval[0] = false;
  $reslval[1] = '7';
  $reslval[2] = 'ELIMINADO - Este ticket ya esta anulado!';
endif;
echo json_encode($reslval);


function cuantostickets($IDC, $IDJ)
{
  global $link;

  $resultj = mysqli_query($link, "Select * from  _Concesionario_Ani where IDC='$IDC'");
  $row = mysqli_fetch_array($resultj);
  $iTkElim = $row['iTkElim'];

  $resultj = mysqli_query($link, "Select count(serial) as cuantos from _Jugada_ani  where IDC='$IDC' and Activo=0 and IDJ=$IDJ");
  if (mysqli_num_rows($resultj) != 0) :
    $row = mysqli_fetch_array($resultj);
    if ($row['cuantos'] + 1 <= $iTkElim) :
      return true;
    else :
      return false;
    endif;
  endif;

  return true;
}
