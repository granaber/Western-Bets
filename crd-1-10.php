<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

/////////////////////////////
$resultado = array();
$fecha = $_REQUEST['fc'];
$IDC = $_REQUEST['IDC'];
if (isset($_REQUEST['checkboxC'])) : $iCheque = $_REQUEST['iCheque'];
	$strCheque = $_REQUEST['strCheque'];
else : $iCheque = 0;
	$strCheque = '*';
endif;
if (isset($_REQUEST['checkboxE'])) : $iEfectivo = $_REQUEST['iEfectivo'];
else : $iEfectivo = 0;
endif;
if (isset($_REQUEST['checkboxT'])) : $strRecibo = $_REQUEST['strRecibo'];
	$strBanco = $_REQUEST['strBanco'];
	$iTransfer = $_REQUEST['iTransfer'];
else : $strRecibo = '*';
	$strBanco = '*';
	$iTransfer = 0;
endif;
$pago = $_REQUEST['pago'];
switch ($_REQUEST['radio']) {

	case 'radio1':
		$tipodepago = 1;
		$deuda = $_REQUEST['deudaT'];
		break;

	case 'radio2':
		$tipodepago = 2;
		$Monto_TOtal = $_REQUEST['Monto_TOtal'];
		break;
}

//// /////////////////

$registro = $iEfectivo . '-' . $strCheque . '-' . $iCheque . '-' . $strRecibo . '-' . $strBanco . '-' . $iTransfer;

$hora = Horareal($minutosa, "h:i:s A");
$result = mysqli_query($GLOBALS['link'], "Insert _tbcrdrecibopago (fecha,monto,tipo,registro,IDC,hora)  values ('$fecha',$pago,$tipodepago,'$registro','$IDC','$hora')");
if ($result) :
	$Tipo = 'P';
	$result = mysqli_query($GLOBALS['link'], "Select * from _tbcrdrecibopago ORDER BY  trans DESC");
	$row = mysqli_fetch_array($result);
	$Ref = $row['trans'];
	$Repuesta = cRdSaldo($IDC, $pago, 0, $Tipo, $Ref);
	$resultado[0] = $Repuesta;
else :
	$resultado[0] = false;
endif;

if ($resultado[0]) :

	$resultado[1] = '<table width="327" border="0">
	  <tr>
		<td width="177">Recibo No.</td>
		<td width="134">' . $Ref . '</td>
	  </tr>
	  <tr>
		<td>Fecha/Hora:</td>
		<td>' . $fecha . ' ' . $hora . '</td>
	  </tr>
	  <tr>
		<td>Letra:</td>
		<td>' . $IDC . '</td>
	  </tr>
	  <tr>
		<td>Monto Depositado Bsf:</td>
		<td>' . $pago . '</td>
	  </tr>
	  <tr>
		<td>Forma de Deposito:</td>
		<td></td>
	  </tr>
	  <tr>
		<td>Datos del  Pago:</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2">Debe Bsf.:</td>
	  </tr>
	</table>
	';
endif;

echo json_encode($resultado);
