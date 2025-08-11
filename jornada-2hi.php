<?php
function configuracion($vl, $ntc, $ntpc, $ntdp)
{
	$pos = strrpos($vl, "U");
	if ($pos === false) :
		$pos = strrpos($vl, "P");
		if ($pos === false) :
			$pos = strrpos($vl, "T");
			if ($pos === false) :
				$pos = strrpos($vl, "Y");
				if ($pos === false) :
					$pos = strrpos($vl, "Z");
					if ($pos === false) :
						return 1000;
					else :
						return $ntc - ($ntdp * substr($vl, 0, strrpos($vl, "Z")));
					endif;
				else :
					return $ntc - ($ntpc * substr($vl, 0, strrpos($vl, "Y")));
				endif;
			else :
				return 0;
			endif;
		else :
			return -1;
		endif;
	else :
		return $ntc - substr($vl, 0, strrpos($vl, "U"));
	endif;
}


$tc = $_REQUEST['nc'];
$tp4 = $_REQUEST['tp4'];
$tp3 = $_REQUEST['tp3'];
$dd = $_REQUEST['dd'];
$tnj = $_REQUEST['nj'];
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$carga = 0;
$result = mysqli_query($GLOBALS['link'], "Select * from _tconfighi where IDCN=" . $tnj);

if (mysqli_num_rows($result) != 0) :
	$carga = 1;
	$row = mysqli_fetch_array($result);
	$config = explode("|", $row["_Jug"]);
	$cantcb = explode("|", $row["_Fab"]);
	$retira = explode("|", $row["_Ret"]);
	$favor = explode("|", $row["_Favoritos"]);
	$hora = explode("|", $row["_hora"]);
	$fecha = $row["_Fecha"];

	$result = mysqli_query($GLOBALS['link'], "Select * from _tconfjornadahi where IDCN=" . $tnj);
	$row = mysqli_fetch_array($result);
	$idhipo = $row["IDhipo"];
	$CantCarr = $row["Cantcarr"];

	/* if ($CantCarr!=$tc or $tp4!=$row["NTDp"] or $tp3!=$row["NTDta"] or $dd!=$row["NTDP4"]):
   $carga=0;*/
	$tp4 = $row["NTDp"];
	$tp3 = $row["NTDta"];
	$dd = $row["NTDP4"];
/* endif;*/

endif;
$arreglodeCantTandas = array($tp4, $tp3, $dd);
$result = mysqli_query($GLOBALS['link'], "Select * from _tdjuegoshi");
/*
 echo $carga;  */
?><br />
<div id="box4" style="background:#257EB7">
	<table id='tblcgn' border="0" cellpadding="3" cellspacing="-1" width="129">
		<tr>
			<th width="45" scope="col" align="center">
				<div align="center" style="color: #FFFFFF">Carr</div>
			</th>
			<th width="38" scope="col" align="center">
				<div align="center" style="color:#FFFFFF">Ejem.</div>
			</th>
			<?php
			$ti = 0;
			$t = 0;
			$ti1 = 0;
			$ti2 = 0;
			$arreglodejuegos = array();
			$marcardetandas = array();
			$juegosconTanda = array();
			$Acompartir = array();
			while ($row = mysqli_fetch_array($result)) {
				$ti++;
				$identi = "'t" . $ti . "'";
				if ($row['Compartir'] == 0) :
					echo '<th width="100" scope="col" align="center" ><span id=' . $identi . ' title="' . $row["IDJug"] . '" style="color:#FFFF00" >' . $row["Descrip"] . '</span></th>';
					$ti1++;
				else :
					for ($y = 0; $y <= $row['Compartir']; $y++) {
						$identi = "t" . $ti;
						echo '<th width="100" scope="col" align="center" ><span id="' . $identi . '_' . ($y + 1) . '" title="' . $row["IDJug"] . '$' . ($y + 1) . '" lang="' . $row["CantidadCarr"] . '" style="color:#FFFF00" >' . $row["Descrip"] . '(' . ($y + 1) . ')</span></th>';
					}
					$marcardetandas[$row["IDJug"]] = '';
					$juegosconTanda[$row["IDJug"]] = $row["CantidadCarr"];
					$Acompartir[$t] = $row['Compartir'];
					$t++;
					$ti2++;
				endif;
				$arreglodejuegos[$ti - 1] = $row["IDJug"];
			}
			echo '<th width="200" scope="col" align="center"><span id="reti" style="color:#FFFFFF">Retirados</span></th>';
			echo '<th width="200" scope="col" align="center"><span id="favor" style="color:#FFFFFF">Favoritos</span></th>';
			echo '<th width="200" scope="col" align="center"><span id="hora" style="color:#FFFFFF">Hora</span></th>';
			?>
		</tr>
		<?php

		$tipo = "'num'";


		for ($i = 1; $i <= $tc; $i++) {
			if (fmod($i, 2) == 0) :
				echo '<tr style="background:#5F92C1">';
			else :
				echo '<tr>';
			endif;
			$cuento = -1;
			$contador = 0;
			$seguida = -1;
			for ($j = 0; $j <= $ti + 1; $j++) {

				switch ($j) {
					case 0:
						echo '<th width="28" scope="col" align="center"  style="color:#FFFFFF" >' . $i . '</th>';
						break;
					case 1:

						if ($i == $tc) {
							$g = "'ejem1'";
						} else {
							$g = "'ejem" . ($i + 1) . "'";
						}
						if ($carga == 0) :
							echo '<th width="28" scope="col" align="center"> <input type="text" size="4" name="ejem' . $i . '" id="ejem' . $i . '" value=0 onkeyup = "pulsart(event,' . $g . ')" onkeypress="return permite(event,' . $tipo . ');" > </th>';
						else :
							//$valoresdec=explode("*",$config[$i]);
							echo '<th width="28" scope="col" align="center"> <input type="text" size="4" name="ejem' . $i . '" id="ejem' . $i . '" value="' . $cantcb[$i - 1] . '" onkeyup = "pulsart(event,' . $g . ')"  onkeypress="return permite(event,' . $tipo . ');"> </th>';
						endif;
						break;

					default:


						$result = mysqli_query($GLOBALS['link'], "Select * from _tdjuegoshi where IDjug=" . $arreglodejuegos[$contador]);
						// echo "Select * from _tdjuegoshi where IDjug=".$arreglodejuegos[$contador];
						$row = mysqli_fetch_array($result);
						if ($row['Compartir'] != 0) :




							if ($cuento == -1) :
								$cuento = 1;
								$idchel = "chek" . ($j - 1) . "-" . $i . '-1';
							else :

								if ($cuento < $row['Compartir']) :
									$cuento++;
									$idchel = "chek" . ($j - 1) . "-" . $i . '-' . $cuento;
								else :
									$cuento++;
									$idchel = "chek" . ($j - 1) . "-" . $i . '-' . $cuento;
									$cuento = -1;
									$contador++;
								endif;
							endif;

							$marcardetandas[$row["IDJug"]] .= $idchel . '|';
						else :
							$cuento = -1;
							$contador++;
							$idchel = "chek" . ($j - 1) . "-" . $i;
						endif;



						if ($carga == 0) :  //realiza este proceso en casos de que no se tenga que cargar la configuracion

							if ($row['Tandas'] != 2) :
								$marcar = configuracion($row['Config'], $tc, $ntp4, $ntdp);
							else :
								$marcar = configuracion($row['CantidadCarr'] . 'Y', $tc, $ntp4, $ntdp);
							endif;

							if ($marcar == -1) :
								$tope = substr($row['Config'], 0, strrpos($row['Config'], "P"));
								if ($i <= $tope) :
									echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' type="checkbox" value="" title="' . $idchel . '" checked></th>';
								else :
									echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' name="" type="checkbox" value="" title="' . $idchel . '" ></th>';
								endif;
							else :
								if ($i > $marcar) :
									echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' name="" type="checkbox" value=""  title="' . $idchel . '"checked></th>';
								else :
									echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' name="" type="checkbox" title="' . $idchel . '" value="" ></th>';
								endif;
							endif;

						else :
							//****************************************
							if ($row['Compartir'] == 0) :
								$valoresdec = explode("*", $config[($j - 1)]);
								$valorverr = explode("-", $valoresdec[1]);
							else :
								$valordecoluma = explode("-", $idchel);

								if ($seguida == -1) :
									$seguida = ($j - 1) + ($valordecoluma[2] - 1);
								else :
									$seguida++;
								endif;
								// |1*1-2-3-4-5-6-7-8-9-10-0|3*1-2-3-4-5-6-7-8-9-10-0|4*1-2-3-4-5-6-7-8-9-10-0|6$1*1-2-3-4-2-3-4-5-3-4-5-6-0|6$2*0|7$1*0|7$2*0|8$1*0|8$2*0
								/*|1*1-2-3-4-5-6-7-8-9-10-0|3*1-2-3-4-5-6-7-8-9-10-0|4*1-2-3-4-5-6-7-8-9-10-0|6$1*1-2-3-4-0|6$2*2-3-4-5-0|7$1*1-2-3-0|7$2*2-3-4-0|8$1*0|8$2*0*/
								//echo '**'.($seguida); 
								$valoresdec = explode("*", $config[$seguida]);
								// 
								$valorverr2 = explode("-", $valoresdec[1]);
								//  print_r($valorverr2);
								$valorverr = array();
								for ($ex = 0; $ex <= count($valorverr2); $ex += $juegosconTanda[$row["IDJug"]]) {
									//  echo '**'.$ex.'->'.$valorverr2[$ex];	
									$valorverr[] = $valorverr2[$ex];
								}
							//		print_r($valorverr);
							endif;
							//
							//$v=array_search($i,$valorverr);
							//
							if (is_int(array_search($i, $valorverr))) :
								echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' type="checkbox" value="" title="' . $idchel . '" checked></th>';
							else :
								echo '<th width="28" scope="col" align="center"> <input id=' . $idchel . ' name="" type="checkbox" value="" title="' . $idchel . '" ></th>';
							endif;
						//***************************************
						endif;
						if ($cuento != -1) : $j--;
						endif;
				}
			}
			if ($i == $tc) {
				$g = "'reti1'";
			} else {
				$g = "'reti" . ($i + 1) . "'";
			}

			if ($carga == 0) :
				echo '<th width="28" scope="col" align="center"> <input id="reti' . $i . '"  type="text"   onkeyup = "pulsart(event,' . $g . ')""/> </th>';
			else :
				echo '<th width="28" scope="col" align="center"> <input id="reti' . $i . '" value="' . $retira[$i - 1] . '" type="text" onkeyup = "pulsart(event,' . $g . ')"/> </th>';
			endif;
			if ($i == $tc) {
				$g = "'favor1'";
			} else {
				$g = "'favor" . ($i + 1) . "'";
			}
			if ($carga == 0) :
				echo '<th width="28" scope="col" align="center"> <input id="favor' . $i . '"  type="text"   onkeyup = "pulsart(event,' . $g . ')""/> </th>';
			else :
				echo '<th width="28" scope="col" align="center"> <input id="favor' . $i . '" value="' . $favor[$i - 1] . '" type="text" onkeyup = "pulsart(event,' . $g . ')"/> </th>';
			endif;

			if ($i == $tc) {
				$g = "'hora1'";
			} else {
				$g = "'hora" . ($i + 1) . "'";
			}
			if ($carga == 0) :
				echo '<th width="28" scope="col" align="center"> <input id="hora' . $i . '"  type="text"   onkeyup = "pulsart(event,' . $g . ')"" size="5"/> </th>';
			else :
				echo '<th width="28" scope="col" align="center"> <input id="hora' . $i . '" value="' . $hora[$i - 1] . '" type="text" onkeyup = "pulsart(event,' . $g . ')" size="5"/> </th>';
			endif;
			echo '</tr>';
		}
		// print_r($marcardetandas);
		?>
	</table>
	<span><strong style="color:#FF0; font-size:14px">*ATENCION:</strong> <span style="color: #FC0; font-size:14px"> (1) = TANDAS IMPARES (ES DECIR TANDA 1,3,5)</span><span style="color: #6F0; font-size:14px"> (2) =TANDAS PARES (ES DECIR TANDA 2,4,5)</span> <br />
		SOLAMENTE MARCAR LA PRIMERA CARRERA (INICIO DE LA TANDA)</span>
</div>
<input id="btngrb" type="button" value="Grabar" onClick="_grabconthi('jornada-3hi.php','<? echo implode(',', $Acompartir); ?>');" alt="<?php echo $ti1; ?>" lang="<?php echo $ti2; ?>">
<div id="divresul"></div>

<script>
	var juegosConTandas = "<? echo implode(',', $juegosconTanda); ?>";
	var CamposConfigurar = "<? echo implode(',', $marcardetandas); ?> ";
	var CantidadCarr = "<? echo $tc; ?> ";
	var Totaldetandas = "<? echo implode(',', $arreglodeCantTandas); ?> ";

	Nifty('div#box4');

	var AjuegosConTandas = juegosConTandas.split(',');
	var ACamposConfigurar = CamposConfigurar.split(',');


	/*for (t=0;t<=ACamposConfigurar.length-1;t++){
		listado=ACamposConfigurar[t].split('|');

		    contadordecarrera=0;
			for (i=0;i<=listado.length-1;i++){
				for (j=0;j<=AjuegosConTandas[t];j++){
					alert(listado[contadordecarrera])
					$(listado[contadordecarrera]).checked=true;
					contadordecarrera++;
				}
			}
	}*/
</script>