<?

date_default_timezone_set('America/Caracas');
require('prc_php.php');
require('escruteshi.php');
$GLOBALS['link'] = Connection::getInstance();
global $minutosa;


$op = $_REQUEST['op'];
switch ($op) {

	case 1:
		$hora2 = $_REQUEST['horacierre'];

		// HORA SERVIDOR	
		$fechada = array();

		$hora1 = Horareal($minutosa, "H:i");
		$fechaactual = Fechareal($minutosa, "d/m/Y");
		// echo $hora1.'<br>';

		$horaM = explode(":", $hora1);
		$fechaMK = explode("/", $fechaactual);
		if ($horaM[2] == '') : $horaM[2] = 0;
		endif;
		$fechaMK1 = mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);


		$horaM = explode(":", $hora2);
		$fechaMK = explode("/", $fechaactual);
		if ($horaM[2] == '') : $horaM[2] = 0;
		endif;
		$fechaMK2 =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

		$respuesta = $fechaMK2 - $fechaMK1;
		if ($respuesta > 0) :
			$respuesta = abs(($respuesta) / 60);
		else :
			$respuesta = 0;
		endif;
		echo json_encode($respuesta);
		break;

	case 2:

		$valor = restantiempo($_REQUEST['IDCN'], $_REQUEST['carr']);
		echo json_encode($valor);
		break;
	case 3:
		$ticket = array();
		$serial = $_REQUEST['serial'];


		$result = mysqli_query($GLOBALS['link'], "SELECT _tjugadahi.*,_tconsecionario.Direccion FROM _tjugadahi,_tconsecionario where _tjugadahi.IDC=_tconsecionario.IDC  and serial=" . $serial);

		$row = mysqli_fetch_array($result);

		$resultc = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where ct=" . $row['carr'] . " and IDCN=" . $row['IDCN']);
		if (mysqli_num_rows($resultc) == 0) :
			$ticket[] = true;
			$ticket[] = $row['Fecha'];
			$ticket[] = $row['Hora'];
			$ticket[] = $row['Jugada'];
			$ticket[] = $row['se'];
			$ticket[] = $row['Direccion'];

			$resulthiop = mysqli_query($GLOBALS['link'], "SELECT _hipodromoshi.Descripcion FROM _hipodromoshi,_tconfjornadahi where _hipodromoshi._idhipo=_tconfjornadahi.IDhipo  and  IDCN=" . $row['IDCN']);
			$rowhip = mysqli_fetch_array($resulthiop);

			$ticket[] = $rowhip['Descripcion'];
			$ticket[] = $row['carr'];
		else :
			$ticket[] = false;
		endif;



		echo json_encode($ticket);
		break;

	case 4:
		$prem = array(false, 0, 0);
		$serial = $_REQUEST['serial'];

		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadahi where serial=" . $serial);

		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			if ($row['IDJug'] == 0) :
				$premacion = EscrutarHI($row['Serial'], 1);
				$prem[2] = 0;
				$prem[0] = true;
				$prem[1] = $premacion[1];
				$prem[3] = $premacion[2];
			else :
				$premacion = EscrutarHI($row['Serial'], 1);
				$prem[2] = 1;
				$prem[0] = true;
				$prem[1] = $premacion[1];
				$prem[3] = $premacion[2];
			endif;
		else :
			$prem[0] = true;
			$prem[1] = -1;
		endif;

		echo json_encode($prem);
		break;
	case 5:
		$Grupo = $_REQUEST['Grupo'];
		$lista = array();
		$i = 0;
		$result2 = mysqli_query($GLOBALS['link'], "SELECT _tbjuegodd.* , _formatosbb.Descripcion as posicion FROM _tbjuegodd , _formatosbb WHERE _tbjuegodd.grupo =$Grupo AND _tbjuegodd.Formato = _formatosbb.Formato ORDER BY _tbjuegodd.Formato, IDDD");
		while ($row = mysqli_fetch_array($result2)) {
			$lista[0][] = $row['Descripcion'] . '-' . $row['posicion'];
			$lista[1][] = 100;
			$lista[2][] = 'center';
			$lista[3][] = 'ch';
			$lista[4][] = $row['IDDD'];
			$lista[5][$row['IDDD']] = $i;
			$i++;
		}
		echo json_encode($lista);
		break;
	case 6:
		$Grupo = $_REQUEST['Grupo'];
		$lista = array();
		$i = 0;
		$result2 = mysqli_query($GLOBALS['link'], "SELECT _tbjuegodd.* , _formatosbb.Descripcion as posicion FROM _tbjuegodd , _formatosbb WHERE _tbjuegodd.grupo =$Grupo AND _tbjuegodd.Formato = _formatosbb.Formato ORDER BY _tbjuegodd.Formato, IDDD");
		while ($row = mysqli_fetch_array($result2)) {
			$lista[0][] = $row['Descripcion'] . '-' . $row['posicion'];
			$lista[1][] = 100;
			$lista[2][] = 'center';
			$lista[3][] = 'ch';
			$lista[4][] = $row['IDDD'];
			$lista[5][$row['IDDD']] = $i;
			$i++;
		}
		echo json_encode($lista);
		break;
	case 7:
		$Grupo = $_REQUEST['Grupo'];
		$lista = array();
		$i = 1;
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute order by posicion");
		while ($Row = mysqli_fetch_array($resultj)) {
			$IDDD = explode('|', $Row['IDDD_AESC']);
			for ($l = 0; $l <= count($IDDD) - 1; $l++) {
				$resultj2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where IDDD=" . $IDDD[$l] . " and Grupo=$Grupo");
				if (mysqli_num_rows($resultj2) != 0) :
					$Row2 = mysqli_fetch_array($resultj2);
					$lista[0][] = $Row['Descripcion'];
					$lista[1][] = 100;
					$lista[2][] = 'center';
					$lista[3][] = 'ch';
					$lista[4][] = $Row['IDCNGE'];
					$lista[5][$row['IDCNGE']] = $i;
					$i++;
					break;
				endif;
			}
		}
		echo json_encode($lista);
		break;
}
