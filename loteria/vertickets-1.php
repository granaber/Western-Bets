<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$op = $_REQUEST['op'];

switch ($op) {

	case 1:
		$result = mysqli_query($GLOBALS['link'], "Select * from _tjugada_data  where Serial=" . $_REQUEST['serial'] . ' Order By IDLot,numero');
		$respuesta = array();
		$i = 0;
		while ($row = mysqli_fetch_array($result)) {

			$resultpremio = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjugadapremio,_tbpremios where _tbjugadapremio.premiado=_tbpremios.IDPremio and _tbpremios.IDLot=" . $row['IDLot'] . " and Serial=" . $_REQUEST['serial'] . ' and numero="' . $row['numero'] . '" and _tbpremios.adicional=' . $row['Adicional']);

			$premio = 0;
			if (mysqli_num_rows($resultpremio) != 0) :
				$rowPREMIO = mysqli_fetch_array($resultpremio);
				$premio = $rowPREMIO['premio'];
			endif;

			$resultLot = mysqli_query($GLOBALS['link'], "Select _tloteria.*,_tloteria_formato.Lista from _tloteria,_tloteria_formato  where  _tloteria.formato=_tloteria_formato.formato and _tloteria.IDLot=" . $row['IDLot']);

			$rowLot = mysqli_fetch_array($resultLot);
			$respuesta[$i] = $rowLot['NombreTicket'] . '|';
			if ($row['Adicional'] != 0) :
				$listado = explode('|', $rowLot['Lista']);
				$respuesta[$i] .= $listado[$row['Adicional'] - 1] . '|';
			else :
				$respuesta[$i] .= '|';
			endif;
			$respuesta[$i] .= $row['Monto'] . '|';
			$respuesta[$i] .= $row['numero'] . '|';
			if ($premio == 0) :
				$respuesta[$i] .= '0';
			else :
				$respuesta[$i] .= number_format($premio, 2, ',', '.');
			endif;
			$i++;
		}
		$respuesta[$i] = '0';
		$result = mysqli_query($GLOBALS['link'], "Select * from _tjugada   where Serial=" . $_REQUEST['serial']);
		$row = mysqli_fetch_array($result);

		$result1 = mysqli_query($GLOBALS['link'], "Select * from _tjornada   where IDJ=" . $row['IDJ']);
		$row1 = mysqli_fetch_array($result1);
		$fecha = explode(' ', $row1['Fecha']);
		$reslval = array();
		$reslval[] = $row['Hora'];
		$reslval[] = $row['Monto'];
		$reslval[] = implode('*', $respuesta);
		$reslval[] = $_REQUEST['serial'];
		$reslval[] = $fecha[0];


		if ($row['activo']) :
			$reslval[] = true;
		else :
			$reslval[] = false;
		endif;

		$reslval[] = $row['se'];
		echo json_encode($reslval);
		break;

	case 2:
		$result = mysqli_query($GLOBALS['link'], "Select * from _tjugada where Serial=" . $_REQUEST['serial']);

		$row = mysqli_fetch_array($result);
		$QBorrar = false;
		if ($row['IDJ'] == $_REQUEST['idjActual']) :
			$result = mysqli_query($GLOBALS['link'], "Select * from _tjugada_data where Serial=" . $_REQUEST['serial']);
			while ($row = mysqli_fetch_array($result)) {
				$valor = CkqCierreLoteria($row['IDLot'], 0);
				if (!$valor[0]) :
					$QBorrar = true;
					break;
				endif;
			}
		else :
			$QBorrar = true;
		endif;
		if (!$QBorrar) :
			$result = mysqli_query($GLOBALS['link'], "Update  _tjugada  set activo=0 where Serial=" . $_REQUEST['serial']);
			echo json_encode($result);
		else :
			echo json_encode(false);
		endif;
		break;


	case 3:
		$sumarPremio = 0;
		$result = mysqli_query($GLOBALS['link'], "Select * from _tbjugadapremio,_tbpremios where _tbjugadapremio.premiado=_tbpremios.IDPremio and _tbjugadapremio.Serial=" . $_REQUEST['serial']);
		$respuesta = array();
		$i = 0;
		while ($row = mysqli_fetch_array($result)) {

			$resultLot = mysqli_query($GLOBALS['link'], "Select _tloteria.*,_tloteria_formato.Lista from _tloteria,_tloteria_formato  where  _tloteria.formato=_tloteria_formato.formato and _tloteria.IDLot=" . $row['IDLot']);


			$resultExtras = mysqli_query($GLOBALS['link'], "Select * from _tjugada_data  where  Serial=" . $row['Serial'] . " and numero='" . $row['numero'] . "' and Adicional=" . $row['Adicional'] . ' and IDLot=' . $row['IDLot']);
			$rowLotExtras = mysqli_fetch_array($resultExtras);

			$rowLot = mysqli_fetch_array($resultLot);
			$respuesta[$i] = $rowLot['NombreTicket'] . '|';
			if ($row['Adicional'] != 0) :
				$listado = explode('|', $rowLot['Lista']);
				$respuesta[$i] .= $listado[$row['Adicional'] - 1] . '|';
			else :
				$respuesta[$i] .= '|';
			endif;
			$respuesta[$i] .= $rowLotExtras['Monto'] . '|';
			$respuesta[$i] .= $row['numero'] . '|';
			$respuesta[$i] .= number_format($row['premio'], 2, ',', '.');
			$sumarPremio += $row['premio'];
			$i++;
		}
		$respuesta[$i] = '0';
		$result = mysqli_query($GLOBALS['link'], "Select * from _tjugada   where Serial=" . $_REQUEST['serial']);
		$row = mysqli_fetch_array($result);
		$IDCtxt = '';
		$resultAgencias = mysqli_query($GLOBALS['link'], "Select * from _tagencias   where IDC=" . $row['IDC']);
		if (mysqli_num_rows($resultAgencias) != 0) :
			$rowAgencias = mysqli_fetch_array($resultAgencias);
			$IDCtxt = $rowAgencias['Descripcion'];
		endif;
		$result1 = mysqli_query($GLOBALS['link'], "Select * from _tjornada   where IDJ=" . $row['IDJ']);
		$row1 = mysqli_fetch_array($result1);
		$fecha = explode(' ', $row1['Fecha']);
		$reslval = array();
		$reslval[] = $row['Hora'];
		$reslval[] = $row['Monto'];
		$reslval[] = implode('*', $respuesta);
		$reslval[] = $_REQUEST['serial'];
		$reslval[] = $fecha[0];


		if ($row['activo']) :
			$reslval[] = true;
		else :
			$reslval[] = false;
		endif;

		$reslval[] = $row['se'];
		$reslval[] = number_format($sumarPremio, 2, ',', '.');
		$reslval[] = $IDCtxt; //<== Agencia
		echo json_encode($reslval);
		break;
	case 4:
		$reslval = array();
		$result = mysqli_query($GLOBALS['link'], "Select * from _tpremiospagados  where Serial=" . $_REQUEST['serial']);
		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "Select * from _tjugada where Serial=" . $_REQUEST['serial']);
			$row = mysqli_fetch_array($result);
			$reslval[] = true;
			$reslval[] = $row['se'];
		else :
			$row = mysqli_fetch_array($result);
			$result = mysqli_query($GLOBALS['link'], "Select * from _tagencias  where IDC=" . $row['IDC']);
			$row = mysqli_fetch_array($result);
			$reslval[] = false;
			$reslval[] = 'El Ticket Ya Fue Cancelado por la Agencia:' . $row['Descripcion'];
		endif;
		echo json_encode($reslval);
		break;
	case 5:
		global $GLOBALS['minutosh']o;
		$horaActual = Horareal($GLOBALS['minutosh']o, "h:i:s A");
		$fechaActual = Fechareal($GLOBALS['minutosh']o, "d/n/y");
		$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tpremiospagados  VALUES (" . $serial . ",'" . $fechaActual . "','" . $horaActual . "'," . $_REQUEST['IDCtrr'] . "," . $_REQUEST['IDusu'] . ")");
		echo json_encode($result);
		break;
	case 6:
		$SeriakTicket = explode('-', $_REQUEST['seTK']);
		$SeriakIntro = explode('-', $_REQUEST['seIntro']);
		$okey = true;
		for ($i = 0; $i <= count($SeriakIntro) - 1; $i++) {
			if (trim($SeriakTicket[$i]) !=	trim($SeriakIntro[$i])) :
				$okey = false;
				break;
			endif;
		}

		echo json_encode($okey);
		break;
}
