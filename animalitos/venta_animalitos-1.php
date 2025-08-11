<?
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

switch ($_REQUEST['op']) {
  case '1':
    $IDL = $_REQUEST['IDL'];
    if ($IDL == 1) :
      $resultj = mysqli_query($link, "Select * From _Concesionario_Ani where IDC='" . $_REQUEST['IDC'] . "'");
    else :
      $resultj = mysqli_query($link, "Select * From _Concesionario_Ani_2 where IDL=$IDL and IDC='" . $_REQUEST['IDC'] . "'");
    endif;
    if (mysqli_num_rows($resultj) != 0) :
      $row = mysqli_fetch_array($resultj);
      $resp[0] = true;
      $resp[1] = $row['iMontMin'];
      $resp[2] = $row['iMontMax'];
      $resp[3] = $row['iMontSort'];
    else :
      if ($IDL == 1) :
        $resp[0] = false; // Error
        $resp[1] = 1; // Estado 1: Bloqueo o Cierre de modulo, Estado 2: Solo mensaje,
        $resp[2] = 'Usted no esta habilitado para vender Animalitos';
      else :
        $resp[0] = true;
        $resp[1] = 0;
        $resp[2] = 0;
        $resp[3] = 0;
      endif;
    endif;
    $resultj = mysqli_query($link, "SELECT count( num ) as x FROM _NumeroAnimatios WHERE IDL=$IDL AND Activo=1");
    $row = mysqli_fetch_array($resultj);
    $resp[4] = $row['x'];
    echo json_encode($resp);
    break;
  case '2':
    $lSor = array();
    $IDJ = _FechaDUK(NULL, 0);
    $sql = "Select *,_JornadaStandar.Descripcion from _Jornada,_JornadaStandar where _JornadaStandar.Hora=_Jornada.HoraCierre and _JornadaStandar.IDL=_Jornada.IDL and Activa=1 and _Jornada.IDJ=" . $IDJ . " order by _Jornada.ID";
    // echo $sql;
    $resultj = mysqli_query($link, $sql);
    while ($Row = mysqli_fetch_array($resultj))
      $lSor[$Row['ID']] = array('Sorteo de: ' . $Row['Descripcion'], $Row['IDL']);


    $lNum = array();
    $sql = "Select * from _NumeroAnimatios where  Activo=1 order by num ";
    $resultj = mysqli_query($link, $sql);
    while ($Row = mysqli_fetch_array($resultj))
      $lNum[$Row['num']][$Row['IDL']] = $Row['nombre'];

    // print_r($lSor);
    //  print_r($lNum);

    echo json_encode(array($lSor, $lNum));
    break;
}
