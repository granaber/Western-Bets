<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$idj = $_REQUEST["idj"];
$fc = $_REQUEST["fc"];

$result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig where _Fecha='" . $fc . "'");
if (mysqli_num_rows($result_g) != 0) :
	$row_g = mysqli_fetch_array($result_g);
	$idcn = $row_g['IDCN'];
	$result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $idj);
	$row_g = mysqli_fetch_array($result_g);
	$arepartir = $row_g['porc'];
	$repatiracum = $row_g['op1'];
	$cfactor = $row_g['op2'];
	$cDivi = $row_g['op3'];
	$formato = $row_g['Formato'];
	$calculo = $row_g['calculo'];
	$conesc = explode('-', $row_g['op4']);
	$CantidadCarr = $row_g['CantidadCarr'];

	for ($p_e = 0; $p_e <= count($conesc) - 1; $p_e++) {

		if ($cDivi == 0) :
			$comando1 = "reportederesultados('reporteresultadoxconcesionario.php'," . $idcn . "," . $idj . ",$('factor" . $p_e . "').value,$('factor" . $p_e . "').value," . $p_e . ");";
		else :
			$comando1 = "reportederesultados('reporteresultadoxconcesionario.php'," . $idcn . "," . $idj . ",$('factor" . $p_e . "').lang,$('dividendo" . $p_e . "').lang," . $p_e . ");";
		endif;
		if (count($conesc) >= 2) :
?>
			<div id="box5" style="background: #999999">
				<?
				echo '<div   align="center" style="color:#FFFFFF; font-size:16px"> Escrute con :' . $conesc[$p_e] . '</div>';
				?>
			</div><br />
		<? endif; ?>
		<div id="box1" style="background: #006600">
			<table width="200" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<th scope="col" align="center">
						<div align="center" style="color:#FFFFFF"><img align="" src="media/users.png" onclick="<? echo $comando1; ?>" /> <br />Resultados x Consecionario</div>
					</th>
					<th scope="col">
						<div align="center" style="color:#FFFFFF"><img align="" src="media/grupo.png" /> <br />Resultado x Grupo</div>
					</th>
					<th scope="col">&nbsp;</th>
				</tr>
			</table>
		</div><br />
		<? if ($cDivi == 0) : ?>
			<div id="box4" style="background: #3399CC; display:none">
				<table width="200" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th width="117" align="center" scope="col">
							<div align="center" style="color:#FFFFFF">Dividendo/Logro:</div>
						</th>
						<th width="72" scope="col"><span id="sprytextfield1">
								<input name="input" type="text" id="factor<? echo $p_e; ?>" size="10" />
								<span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></th>
						<th width="11" scope="col"><input name="" type="button" value="Grabar" /></th>
					</tr>
				</table>
			</div><br />
		<? endif; ?>
		<div id="box3" style="background:#5F92C1; color:#FFFFFF">
			<p align="left" style="color:#FFFFFF; font-size:16px">
				<? if ($calculo == 2) :
					echo '<input name="" type="button" value="Imprimir Nulos" />';
				endif;
				?></p>
			<p align=" " style="color:#FFFFFF; font-size:16px"><? echo  $row_g['Descrip']; ?></p>

			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<th scope="col"><input name="" type="checkbox" value="" onclick="marcat(<? echo $p_e; ?>);" />
						<p align=" " style="color:#FFFFFF; font-size:10px">Todos</p>
					</th>
					<th scope="col"></th>
					<th scope="col">
						<p style="color:#FFFFFF; font-size:14px">Grupo</p>
					</th>
					<th scope="col">
						<p style="color:#FFFFFF; font-size:14px">Ventas</p>
					</th>
					<th scope="col">
						<p style="color:#FFFFFF; font-size:14px">Premios</p>
					</th>
					<? if ($formato == 1) : ?>
						<th scope="col">
							<p style="color:#FFFFFF; font-size:14px">Buenos</p>
						</th>
						<th scope="col">
							<p style="color:#FFFFFF; font-size:14px">Malos</p>
						</th>
					<? endif; ?>
					<th width="96" scope="col"></th>
				</tr>

				<?php

				$tgv = 0;
				$tdp = 0;
				$tpb = 0;
				$tpm = 0;
				$un = 0;
				$totalgrupos = 0;
				$premiost = array();
				$result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo ");
				while ($row_g = mysqli_fetch_array($result_g)) {
					$grupo = explode(',', $row_g['grupopertence']);
					$ventas = 0;
					$key = array_search(1, $grupo);
					if (!($key === false)) :
						$result = mysqli_query($GLOBALS['link'], "SELECT _tjugada.* FROM _tjugada,_tconsecionario where _tjugada.IDC=_tconsecionario.IDC and _tconsecionario.IDG=" . $row_g['IDG'] . " and IDJug=" . $idj . " and idcn=" . $idcn . " and Anulado=0");
						$array_total = array();
						$co = 0;
						while ($row = mysqli_fetch_array($result)) {
							$arrayes = poolescrute($row['Serial']);
							//print_r( $arrayes);
							$atp = contarenblanco($arrayes, 5);	//0 es ganador!

							$totaldeb = $CantidadCarr - $conesc[$p_e];

							if ($atp == $totaldeb) :
								$array_total[$co] = $arrayes;
								$premiost[] = $arrayes;
								$co++;
							endif;
							$ventas += $row['Valor_J'];
						}
						if ($un == 1) :
							echo "<tr >";
							$un = 0;
						else :
							echo "<tr bgcolor='#666666'>";
							$un = 1;
						endif;
						if ($cDivi == 0) :
							$comando1 = "abrir('reportedepremiosdetallado.php?idcn=" . $idcn . "&idj=" . $idj . "&idg=" . $row_g['IDG'] . "&concg=" . $p_e . "&fac='+$('factor" . $p_e . "').value+'&div='+$('factor" . $p_e . "').value,'Reporte de Premios ',1,0,0,0,0,0,1,400,400,100,100,1);";
						else :
							$comando1 = "abrir('reportedepremiosdetallado.php?idcn=" . $idcn . "&idj=" . $idj . "&idg=" . $row_g['IDG'] . "&concg=" . $p_e . "&fac='+$('factor" . $p_e . "').lang+'&div='+$('dividendo" . $p_e . "').lang,'Reporte de Premios ',1,0,0,0,0,0,1,400,400,100,100,1);";
						endif;
						echo '<th scope="col"><input name="" type="checkbox"  id="chk' . $p_e . "" . $row_g['IDG'] . '" value="" /></th>';
						$tp = count($array_total);
						$tb = participaciones($array_total, 0);
						$tm = participaciones($array_total, 1);
						if ($tp != 0) :
							echo '<th scope="col"><img src="media/estrella.png" onclick="' . $comando1 . '" Title="Imprimir Detalle de Boletos Premiados"></th>';
						else :
							echo '<th  scope="col"><img src="media/estrellaout.gif" ></th>';
						endif;
						echo '  
				
    			<th  scope="col"><p style="color:#FFFFFF">' . $row_g['IDG'] . '</p></th>
    			<th  scope="col"><p align="right" style="color:#FFFFFF">' . number_format($ventas, 2, ',', '.') . '</p></th>
				<th scope="col"><p  align="center" style="color:#FFFFFF">' . $tp . '</p></th>';
						if ($formato == 1) :
							echo '	
    			<th scope="col"><p align="center" style="color:#FFFFFF">' . $tb . '</p></th>
   			    <th  scope="col"><p  align="center" style="color:#FFFFFF">' . $tm . '</p></th>';
						endif;
						echo '  <th  scope="col"></th>		</tr>';

						$tgv += $ventas;
						$tdp += $tp;
						$tpb += $tb;
						$tpm += $tm;

					endif;
					$totalgrupos++;
				}


				echo '  <tr bgcolor="#006699">
	            <th  scope="col"></th>
				<th  scope="col"></th>
    			<th  align="left" scope="col"><p style="color:#FFFFFF">TOTAL/VENTAS</p></th>
    			<th  scope="col"><p align="right" style="color:#FFFFFF">' . number_format($tgv, 2, ',', '.') . '</p></th>
				<th scope="col"><p  align="center" style="color:#FFFFFF">' . $tdp . '</p></th>';
				if ($formato == 1) :
					echo '	
    			<th scope="col"><p align="center" style="color:#FFFFFF">' . $tpb . '</p></th>
   			    <th  scope="col"><p  align="center" style="color:#FFFFFF">' . $tpm . '</p></th>';
				endif;
				echo '	  <th width="96" scope="col"></th>	</tr>';

				if ($arepartir != 0) :
					$tar = $tgv * ($arepartir / 100);
				else :
					$tar = $tgv;
				endif;


				$acum = 0;
				if ($tdp == 0) :
					$acum = $tar;
					$factor = 0;
				else :
					$factor = $tar / $tdp;
				endif;
				$totaldemalos = 0;

				for ($i = 0; $i <= count($premiost) - 1; $i++) {
					$posi1 = 4;
					$posi2 = 3;
					if ($premiost[$i][1] != 0) :
						$totaldemalos += (($factor * $premiost[$i][$posi1]) / $premiost[$i][$posi2]);
					endif;
				}

				if ($totaldemalos == 0) : $div = $tar;
				else : $div = $tar - $totaldemalos;
				endif;

				?>

			</table>
		</div>
		<br><br>
		<div id="box15" style="width:150px">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<th width="77" scope="col">
						<p style="color:#FFFFFF">A Repartir:</p>
					</th>
					<th width="10" scope="col" align="left">
						<p style="color:#FFFFFF; font-size:14px"><? echo number_format($tar, 2, ',', '.'); ?></p>
					</th>
					<th width="30" scope="col">&nbsp;</th>
				</tr>
				<? if ($arepartir != 0) : ?>
					<tr>
						<td scope="col">
							<p style="color:#FFFFFF">Acumulado:</p>
						</td>
						<td align="left">
							<p style="color:#FFFFFF; font-size:14px"><? echo number_format($acum, 2, ',', '.'); ?></p>
						</td>
						<td>&nbsp;</td>
					</tr>
				<? endif;

				if ($cfactor == 1) : ?>
					<tr>
						<td>
							<p style="color:#FFFFFF">Factor:</p>
						</td>
						<td align="left">
							<p id="factor<? echo $p_e; ?>" lang="<? echo $factor; ?>" style="color:#FFFFFF; font-size:14px"><? echo number_format($factor, 2, ',', '.'); ?></p>
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>
							<p style="color:#FFFFFF">Total Malos:</p>
						</td>
						<td align="left">
							<p id="factor" lang="<? echo $totaldemalos; ?>" style="color:#FFFFFF; font-size:14px"><? echo number_format($totaldemalos, 2, ',', '.'); ?></p>
						</td>
						<td>&nbsp;</td>
					</tr>
				<? endif;

				if ($cDivi == 1) :  ?>
					<tr>
						<td>
							<p style="color:#FFFFFF">Dividendo:</p>
						</td>
						<td align="left">
							<p id="dividendo<? echo $p_e; ?>" lang="<? echo $div; ?>" style="color:#FFFFFF; font-size:14px"><? echo number_format($div, 2, ',', '.'); ?></p>
						</td>
						<td>&nbsp;</td>
					</tr>
				<? endif; ?>
			</table>
		</div>
	<? echo '<br><br>';
	} ?>

<? else : ?>
	<p align="left" style="color:#FFFFFF; font-size:16px">NO HAY INFORMACION!!</p>

<? endif;
/*<div id="gridbox" width="100%" height="350px" style="background-color:white;overflow:hidden"></div>
<script> 
	mygrid = new dhtmlXGridObject('gridbox');
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("Estatus,Grupo,Ventas,Premios,Buenos,Malos");
	mygrid.setInitWidths("50,150,160,80,80,80")
	mygrid.setColAlign("right,left,left,right,center,left")
	mygrid.setColSorting("int,str,str,int,str,str");	
	mygrid.setSkin("light");
	mygrid.loadXML("grid2.xml");mygrid.init();
    Nifty('div#box');   Nifty('div#box15'); 

</script>*/
?>
<p id="totalg" lang="<? echo $totalgrupos; ?>"></p>
<script>
	Nifty('div#box3');
	Nifty('div#box15');
	Nifty('div#box1');
	var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {
		useCharacterMasking: true
	});
	Nifty('div#box4');
</script>