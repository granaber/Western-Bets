<?php
date_default_timezone_set('America/Caracas');

require('prc_php.php');





$GLOBALS['link'] = Connection::getInstance();


$idj = $_REQUEST['idj'];
$idg = explode(',', $_REQUEST['idg']);
$usu = $_REQUEST['usu'];
if ($usu == -2) : $acceso = true;
else : $acceso = false;
endif;

echo '  <input name="" type="button" value="Imprimir" onclick="print();"/><input name="" type="button" value="Cerrar" onclick="window.close();"/><br><br>';


for ($tg = 0; $tg <= count($idg) - 1; $tg++) {

	$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where grupo=" . $idg[$tg]);
	$row = mysqli_fetch_array($result2);
	$descripcion = $row['Descripcion'];

	$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $idj . " and grupo=" . $idg[$tg]);
	$row = mysqli_fetch_array($resultp);
	$fecha_d = $row['Fecha'];

	$i = 2;
	echo '..::Parlay En Linea::. ' . $descripcion . '  Fecha:' . $fecha_d . '<br>';
	echo 'RESULTADOS<br>';
	echo 'Impreso:' . Fechareal($GLOBALS['minutosh'], "d-m-y") . " " . Horareal($GLOBALS['minutosh'], "h:i:s A") . '<br>';
	echo '<table border="1" cellpadding="0" cellspacing="0">';
	echo '<tr>';
	echo '<td>Hora</td>';
	echo '<td>Equipo</td>';

	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute order by posicion");
	while ($Row = mysqli_fetch_array($resultj)) {


		$IDDD = explode('|', $Row['IDDD_AESC']);

		for ($l = 0; $l <= count($IDDD) - 1; $l++) {
			$resultj2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where grupo=" . $idg[$tg] . " and IDDD=" . $IDDD[$l]);

			if (mysqli_num_rows($resultj2) != 0) :

				$newstr = str_replace(" ", ".", $Row['Descripcion']);
				echo '<td>' . trim($newstr, '.') . '</td>';
				$i++;
				break;
			endif;
		}
	}
	echo '</tr>';


	$np = $row['Partidos'];
	$inicio = true;

	if ($inicioenca) :
		$inicioenca = false;
	endif;
	$result_lo = mysqli_query($GLOBALS['link'], "SELECT _partidosbb.* FROM _partidosbb,_equiposbb  where _partidosbb.IDE1=_equiposbb.IDE and  _partidosbb.IDJ=" . $idj . " and _partidosbb.grupo=" . $idg[$tg] . " and  ( _equiposbb.Grupo=" . $idg[$tg] . " or _equiposbb.Grupo1=" . $idg[$tg] . " or _equiposbb.Grupo2=" . $idg[$tg] . ")");

	$t = 1;
	$le = 1;


	while ($row3 = mysqli_fetch_array($result_lo)) {


		$eq1 = $row3["IDE1"];
		$eq2 = $row3["IDE2"];
		$result2 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq1);
		$row2 = mysqli_fetch_array($result2);
		$sg1 = $row2["Descripcion"];
		$result3 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq2);
		$row = mysqli_fetch_array($result3);
		$sg2 = $row["Descripcion"];
		$sg = array();
		$pch = array();
		$gp = array();
		$efec = array();
		$pch[0] = $row3['PIDE1'];
		$pch[1] = $row3['PIDE2'];
		$gp[0] = $row3['JGP1'];
		$gp[1] = $row3['JGP2'];
		$efec[0] = $row3['EFEC1'];
		$efec[1] = $row3['EFEC2'];
		$sg[0] = $sg1;
		$sg[1] = $sg2;



		for ($j = 0; $j <= 1; $j++) {
			$aa = array();
			if ($j == 0) :
				$fho = explode(':', $row3['Hora']);
				if ($fho[0] < 12) :
					$ann = 'a';
				endif;
				if ($fho[0] == 12) :
					$ann = 'm';
				endif;
				if ($fho[0] > 12) :
					$ann = 'p';
					$horr = $fho[0] - 12;
				else :
					$horr = $fho[0];
				endif;
				$aa[0] = $horr . ':' . $fho[1] . $ann;
			else :
				$aa[0] = '';

			endif;
			$aa[1] = $sg[$j];

			$y = 2;

			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbescrute where IDJ=" . $idj . " and Grupo=" . $idg[$tg] . " and IDP=" . $row3['IDP']);

			if (mysqli_num_rows($resultj) != 0) :
				$row = mysqli_fetch_array($resultj);
				$escrute = $row['Escrute'];
				$valores = explode('|', $escrute);
				/* 1|!-!-|2|!-!-|3|!-!-|*/
				if ($le == 1) :
					$le = 0;
				else :
					$le = 1;
				endif;

				for ($l = 1; $l <= count($valores) - 1; $l += 2) {
					$val1 = explode('-', $valores[$l]);
					if ($val1[$le] != '!') :
						$resultj3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute where  IDCNGE=" . $valores[$l - 1]);
						$rowj3 = mysqli_fetch_array($resultj3);

						if ($rowj3['Formato'] == 2) :
							if ($le == 0 and $val1[$le] == 1) :
								$aa[$y] = 'SI';
							else :
								if ($le == 1 and $val1[$le] == 1) :
									$aa[$y] = 'NO';
								else :
									$aa[$y] = '-';
								endif;
							endif;
						else :
							$aa[$y] = $val1[$le];
						endif;
					else :
						$aa[$y] = 'SUSPENDIDO!';
					endif;
					$y++;
				}

				registro($aa);
				$aa2 = array();
				$aa2 = array_fill(0, $y, ' ');
			endif;
		}
	}
	echo '</table><br /><br>';
}




echo '*Nota: Estos logros pueden ser modificados sin previo aviso..! ';
echo Fechareal($GLOBALS['minutosh'], "d-m-y") . " " . Horareal($GLOBALS['minutosh'], "h:i:s A");


function registro($varlo)
{
	// 
	echo '<tr>';
	for ($i = 0; $i < count($varlo); $i++)
		echo '<td>' . $varlo[$i] . '</td>';
	//
	echo '</tr>';
}
