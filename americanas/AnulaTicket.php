<?
require_once('../prc_php.php');
require_once('../prc_credit.php');
$linkAme = mysqli_connect($serverAME, $userAME, $clvAME);
mysqli_select_db($linkAme, $dbAME);

$serial = $_REQUEST['serial'];

$result = mysqli_query($linkAme, "SELECT * FROM _tjugadahi where serial=" . $serial . " and  Anulado=0 ");
if (mysqli_num_rows($result) != 0) :
  $row = mysqli_fetch_array($result);
  $IDC = $row['IDC'];
  $IDCN = $row['IDCN'];
  $MYAP = $row['Valor_J'];
  // if (in_array($row['IDJug'], $idJugadaAvalible)) {
  //   $idCarreras = listCarrerasMacuare($row['IDCN'], $row["tanda"]);
  //   $carr = $idCarreras[0];
  // } else {
  $carr = $row['carr'];
  // }
  $result = mysqli_query($linkAme, "SELECT * FROM _cierrehi where  IDCN=" . $IDCN . " and IDJug=1 and ct=" . $carr);
  if (mysqli_num_rows($result) == 0) :
    $result = mysqli_query($linkAme, "SELECT * FROM _tporcentajes where IDC='" . $IDC . "'");
    $row = mysqli_fetch_array($result);
    $Cantidad = $row['EliminarTK'];
    $result = mysqli_query($linkAme, "SELECT count(serial) as x FROM _tjugadahi where IDC='" . $IDC . "' and  Anulado=1 and IDCN=" . $IDCN);
    $row = mysqli_fetch_array($result);
    if ($row['x'] < $Cantidad) :
      $fecha = date("d/m/y");
      $hora = Horareal($horasretro, "h:i:s A");
      $ip = getip();
      if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
      endif;
      if (isset($_REQUEST['idc'])) : $qidc = $_REQUEST['idc'];
      else : $qidc = 'No';
      endif;
      $result = mysqli_query($linkAme, "Insert  _tjugadahiANUL values (" . $serial . ",'" . $fecha . '-' . $hora . "','" . $ip . "','" . $qidc . "')");
      $result = mysqli_query($linkAme, "Update  _tjugadahi set  Anulado=1 where serial=" . $serial);
      $ResponseCredito = BackendCredito($IDC, $serial, $MYAP, $TYPE_REVERSO,  2);
      $respol = array(true);
    else :
      $respol = array(false, 0, "TOPE-Ya cubrio la cantidad de tickets a eliminar en la Jornada");
    endif;
  else :
    $respol = array(false, 0, "CERRADA-No puedo anular el ticket porque la Carrera esta Cerrada!");
  endif;
else :
  $respol = array(false, 0, "NO EXISTE-Este ya esta ANULADO");
endif;

echo json_encode($respol);
