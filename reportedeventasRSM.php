<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$conse = $_REQUEST['cs'];
$d1 = $_REQUEST['d1'];
$d2 = $_REQUEST['d2'];

$result = mysqli_query($GLOBALS['link'], "SELECT _tjugada.IDjug,_tdjuegos.Descrip,sum(valor_r) as vr,sum(valor_j) as vj,_tjugada.IDCN FROM _tjugada, _tdjuegos where _tjugada.IDJug=_tdjuegos.IDJug  and anulado=0 and _tjugada.nom='" . $conse . "'  and IDCN in  (Select IDCN From _tconfig Where STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $d1 . "','%d/%m/%Y') and STR_TO_DATE('" . $d2 . "','%d/%m/%Y')) group by _tjugada.IDCN");

if (mysqli_num_rows($result) != 0) :
?>
	<? include "statusprint.php"; ?>
	<table width="300" border="0" class="bortb">
		<tr>
			<th colspan="4" scope="col" class="alinc">Resumen de Ventas Diarias </th>
		</tr>
		<tr>
			<th colspan="4" scope="col" class="alinc">Concesionario:<?php echo $conse; ?> </th>
		</tr>
		<tr>
			<th colspan="4" scope="col" class="alinc">Desde:<?php echo $d1; ?> &nbsp;Hasta:<?php echo $d2; ?>
			</th>
		</tr>
		<tr>
			<th width="70" bgcolor="#CCCCCC" scope="col" class="alinc"> Jugada </th>
			<th width="153" valign="top" bgcolor="#CCCCCC" scope="col" class="alinc">Ventas</th>
			<th width="153" valign="top" bgcolor="#CCCCCC" scope="col" class="alinc">Premio</th>
		</tr>

		<?
		$premiosTotales = 0;
		$ventasTotales = 0;
		while ($row = mysqli_fetch_array($result)) {
			$formattedJ = $row['vj'];
			$premios = 0;
			$resultdivi = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where  idcn=" . $row['IDCN']);
			$rowdivi = mysqli_fetch_array($resultdivi);
			$divi = $rowdivi['Macuare'];

			$resultjuego = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDjug=" . $row['IDjug']);
			$rowjuego = mysqli_fetch_array($resultjuego);
			$conesc = explode('-', $rowjuego['op4']);
			$totaldeb = $conesc[$concg];

			$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugada where IDJug=" . $row['IDjug'] . " and idcn=" . $row['IDCN'] . " and idc='" . $conse . "' and anulado=0");

			while ($row3 = mysqli_fetch_array($result3)) {

				$arrayes = poolescrute($row3['Serial']);
				$atp = contarenblanco($arrayes, 5);

				if ($atp == $totaldeb) :
					$premios += ($row3['Valor_J'] * $divi);
				endif;
			}
			$premiosTotales += $premios;
			$ventasTotales += $formattedJ;
			$resultFecha = mysqli_query($GLOBALS['link'], "Select * From _tconfig Where idcn=" . $row['IDCN']);
			$rowFecha = mysqli_fetch_array($resultFecha);
			echo '<tr>';
			echo '<th  bgcolor="#FFFFFF" scope="col"  class="alinl">' . $rowjuego['Descrip'] . '-' . $rowFecha['_Fecha'] . ' </th>';
			echo '<th  width="153" valign="top"  bgcolor="#FFFFFF"  class="alinr">' . number_format($formattedJ) . '</th>';
			echo '<th   width="153" valign="top" bgcolor="#FFFFFF" scope="col" class="alinr">' . number_format($premios) . '</th>';

			echo '</tr>';
		}

		echo '<tr ></tr>';
		echo '<tr ></tr>';
		echo '<tr ></tr>';
		echo '<tr ></tr>';
		echo '<tr ></tr>';
		echo '<tr ></tr>';
		echo '<tr >';
		echo '<th  bgcolor="#CCCCCC" scope="col" >Total Jugado--></th>';
		echo '<th valign="top"  bgcolor="#CCCCCC" scope="col" class="alinr">' . number_format($ventasTotales) . '</th>';
		echo '<th valign="top" bgcolor="#CCCCCC" scope="col" class="alinr">' . number_format($premiosTotales) . '</th>';
		echo '</tr>';
		echo '<tr > <th colspan="4">-</th></tr>';
		echo '<tr > <th colspan="4">-</th></tr>';
		echo '<tr > <th colspan="4">-</th></tr>';
		echo '<tr > <th colspan="4">-</th></tr>';
		echo '<tr > <th colspan="4">-</th></tr>';
		echo '<tr > <th colspan="4">-</th></tr>';



		?>
		Hora:<?php echo date("H:i:s"); ?>
	</table>
<?php
endif;
?>