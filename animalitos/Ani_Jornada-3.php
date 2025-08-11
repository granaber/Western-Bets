<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

switch ($_REQUEST['op']) {
  case '1':
    $ID = $_REQUEST['ID'];
    $HoraCierre = convertirMilitarAnimalitos($_REQUEST['HoraCierre']);
    $CantidadNumero = $_REQUEST['CantidadNumero'];
    $Activo = $_REQUEST['Activo'];

    if ($ID == 0) :

      $IDJ = _FechaDUK();
      $resultj = mysqli_query($link, "SELECT * FROM _Jornada  Where IDJ=" . $IDJ . " and HoraCierre='" . $HoraCierre . "'");
      if (mysqli_num_rows($resultj) == 0) :
        $resultj2N = true; // mysqli_query($link,"Insert _Jornada (	IDJ,IDJS,HoraCierre,Activa,CantidadNum ) values($IDJ,0,'".$HoraCierre."',".$Activo.",".$CantidadNumero.")");
        if ($resultj2N) :
          $reslval[0] = TRUE;
        else :
          $reslval[0] = false;
          $reslval[1] = '7';
          $reslval[2] = 'ERROR - Disculpe hubo un error a tratar de ingresar la Jornada!';
        endif;
      else :
        $reslval[0] = false;
        $reslval[1] = '7';
        $reslval[2] = 'EXISTE - Ya existe una Jornada para la hora seleccionada!';
      endif;

    else :

      $resultj2N = mysqli_query($link, "Update _Jornada  set HoraCierre='" . $HoraCierre . "',Activa=" . $Activo . ",CantidadNum=" . $CantidadNumero . "  where ID=" . $ID);
      if ($resultj2N) :
        $reslval[0] = TRUE;
      else :
        $reslval[0] = false;
        $reslval[1] = '7';
        $reslval[2] = 'ERROR - Disculpe hubo un error a tratar de Actualizar la Jornada!';
      endif;

    endif;
    echo json_encode($reslval);
    break;

  case '3':
    $resultj2N = mysqli_query($link, "Update _Jornada  set  Activa=" . $_REQUEST['Activo'] . "  where ID=" . $_REQUEST['ID']);
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar la Jornada!"); </script>';
    endif;
    break;
  case '4':
    $IDJ = _FechaDUK($_REQUEST['fc']);
    $IDL = $_REQUEST['IDL'];
    $resultj = mysqli_query($link, "SELECT * FROM _Jornada  Where IDL=$IDL and IDJ=" . $IDJ);
    while ($row1N = mysqli_fetch_array($resultj)) {
      if ($row1N['Activa'] == 1) : $Activo = 0;
      else : $Activo = 1;
      endif;
      $resultj2N = mysqli_query($link, "Update _Jornada  set  Activa=" . $Activo . "  where IDL=$IDL and  ID=" . $row1N['ID']);
    }
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar la Jornada!"); </script>';
    endif;
    break;
  case '5':
    $l = $_REQUEST['l'];
    $resultj2N = mysqli_query($link, "Update _Conf_premio  set  modo=" . $_REQUEST['modo'] . ",numero=" . $_REQUEST['numero'] . ",logro=" . $_REQUEST['logro'] . "  where l=" . $l);
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar !"); </script>';
    endif;
    break;
  case '6':
    $modo = $_REQUEST['modo'];
    $premio = $_REQUEST['logro'];
    $numero = $_REQUEST['numero'];
    $ID = $_REQUEST['ID'];
    $resultj2N = mysqli_query($link, "Select * from   _Conf_premio  where  modo=" . $modo . " and numero=" . $numero);
    if (mysqli_num_rows($resultj2N) == 0) :
      $resultj2N = mysqli_query($link, "Insert  _Conf_premio  (ID,modo,numero,logro) values (" . $ID . "," . $modo . "," . $numero . "," . $premio . ")");
    else :
      $rowj2n = mysqli_fetch_array($resultj2N);
      $l = $rowj2n['l'];
      $resultj2N = mysqli_query($link, "Update _Conf_premio  set  modo=" . $_REQUEST['modo'] . ",numero=" . $_REQUEST['numero'] . ",logro=" . $_REQUEST['logro'] . "  where l=" . $l);
    endif;
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar !"); </script>';
    endif;
    break;
  case '7':
    $l = $_REQUEST['l'];
    $resultj2N = mysqli_query($link, "Delete From  _Conf_premio    where l=" . $l);
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar !"); </script>';
    endif;
    break;
}
