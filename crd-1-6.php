<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;

error_reporting(E_ALL & ~E_STRICT);
$GLOBALS['link'] = Connection::getInstance();

$IDC = $_REQUEST['IDC'];

//////////////////
$Debito = array();
$SaldoD = array();
$Credito = array();
$SaldoC = array();
$Pagos = array();
$SaldoP = array();
$orden = array();
$resultEqur = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbcrdtranss ");
while ($resultEqu = mysqli_fetch_array($resultEqur)) {
	switch ($resultEqu['tipo']) {

		case 'D':
			$resultEqu1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb where Serial= " . $resultEqu['Ref'] . " and IDC='$IDC'");
			if (mysqli_num_rows($resultEqu1) != 0) :
				$Datos = explode('-', $resultEqu['fechahora']);
				if (!isset($Debito[$Datos[0]])) : $Debito[$Datos[0]] = 0;
				endif;
				$Debito[$Datos[0]] += $resultEqu['monto'];
				$SaldoD[$Datos[0]] = $resultEqu['saldo'];
				$orden[] = $Datos[0];
			endif;
			break;
		case 'C':
			if ($resultEqu['Ref'] == $IDC) :
				$Datos = explode('-', $resultEqu['fechahora']);
				if (!isset($Credito[$Datos[0]])) : $Credito[$Datos[0]] = 0;
				endif;
				$Credito[$Datos[0]] += $resultEqu['monto'];
				$SaldoC[$Datos[0]] = $resultEqu['saldo'];
				$orden[] = $Datos[0];
			endif;
			break;
		case 'P':
			$resultEqu1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbcrdrecibopago where trans= " . $resultEqu['Ref'] . " and IDC='$IDC'");
			if (mysqli_num_rows($resultEqu1) != 0) :
				$rowEqu1 = mysqli_fetch_array($resultEqu1);
				$Datos[0] = $rowEqu1['fecha'];
				$Pagos[$Datos[0]] += $resultEqu['monto'];
				$SaldoP[$Datos[0]] = $resultEqu['saldo'];
				$orden[] = $Datos[0];
			endif;
			break;
	}
}
$ramdomN = '_TmpCrediONE';
/*$result = mysqli_query($GLOBALS['link'],"
			CREATE  TEMPORARY TABLE ".$ramdomN."
			(
			   trans int(10),
			   nivel int(10),
			   fecha varchar(45),
			   Descrip varchar(45),
			   tipo varchar(1),
			   monto float,
			   saldo float
				  ) ;
		");

	$result = mysqli_query($GLOBALS['link'],"GRANT SELECT, INSERT, UPDATE, DELETE   ON zubanca_parlay.$ramdomN TO $user@localhost ;");
	echo ("GRANT SELECT, INSERT, UPDATE, DELETE   ON zubanca_parlay.$ramdomN TO $user@localhost ;");*/
// print_r($orden);
$resultado = array_unique($orden);
// print_r($resultado);
$i = 1;
$j = 1;
$fechaTrans = array();
foreach ($Debito as $KeyN2 => $Valor) {
	$i = array_search($KeyN2, $resultado);
	$resultij = mysqli_query($GLOBALS['link'], "Insert $ramdomN values ($j,$i,'$KeyN2','Ventas','D',-1*$Valor," . $SaldoD[$KeyN2] . ",'$IDC')");
	$fechaTrans[$KeyN2] = $i;
	//$i++;
	$j++;

	//	echo $KeyN2.'  '.$Valor.'<br>';
}

// print_r($fechaTrans);
// echo 'DEBITO<br>';
foreach ($Credito as $KeyN2 => $Valor) {
	if ($Valor != 0) :
		if (isset($fechaTrans[$KeyN2])) : $i = $fechaTrans[$KeyN2];
		else : $i = array_search($KeyN2, $resultado);
			$fechaTrans[$KeyN2] = $i;
		endif;
		$resultij = mysqli_query($GLOBALS['link'], "Insert $ramdomN values ($j,$i,'$KeyN2','Premio','C',$Valor," . $SaldoC[$KeyN2] . ",'$IDC')");
		//	echo $KeyN2.'  '.$Valor.'<br>';
		//$i++;
		$j++;
	endif;
}

// echo 'PAGOS<br>';
foreach ($Pagos as $KeyN2 => $Valor) {
	//$i= $fechaTrans[$KeyN2];
	if (isset($fechaTrans[$KeyN2])) : $i = $fechaTrans[$KeyN2];
	else : $i = array_search($KeyN2, $resultado);
		$fechaTrans[$KeyN2] = $i;
	endif;
	if ($Valor > 0) :
		$resultij = mysqli_query($GLOBALS['link'], "Insert $ramdomN values ($j,$i,'$KeyN2','Deposito','P',$Valor," . $SaldoP[$KeyN2] . ",'$IDC')");
	else :
		$resultij = mysqli_query($GLOBALS['link'], "Insert $ramdomN values ($j,$i,'$KeyN2','Pago','P',$Valor," . $SaldoP[$KeyN2] . ",'$IDC')");
	endif;
	$j++;
}


$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);
//$grid->render_table("_tusu","IDusu","IDusu,Usuario,Estatus");
//$grid->sql->attach("Update","Update _tusu set Estatus={Estatus} where IDusu={IDusu}");
//$grid->event->attach("beforeUpdate","my_update");
//
//$IDRelacionado=explode('-',$_REQUEST['IdRelacionado']);
$grid->event->attach("beforeRender", "validate");
$grid->render_sql("SELECT * FROM  $ramdomN  where IDC='$IDC' order by nivel  ASC", "trans", "nivel,fecha,Descrip,tipo,monto,saldo");



function validate($data)
{
	$monto = $data->get_value("monto");
	$data->set_value('monto', number_format($monto, 2, ',', '.'));
	if ($monto < 0) : $data->set_cell_style('monto', "color:#F90; font:bold");
	else : if ($monto > 0) :	$data->set_cell_style('monto', "color:#036; font:bold");
		endif;
	endif;

	$saldo = $data->get_value("saldo");
	$data->set_value('saldo', number_format($saldo, 2, ',', '.'));

	if ($saldo < 0) : $data->set_cell_style('saldo', "color:#F90; font:bold");
	else : if ($saldo > 0) :	$data->set_cell_style('saldo', "color:#036; font:bold");
		endif;
	endif;
}
