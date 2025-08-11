<table width="1083" cellspacing="2" cellpadding="2">

	<?php


	function ntandas($idcn, $idj, $ctc, $ct)
	{
		// $idcn=La Jornada
		// $idj=la Jugada
		// $ctc=Cantidad de Carreras
		// $ct= Si es con Tandas =1
		$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
		mysql_select_db("sphonlin_sphonline", $GLOBALS['link']);
		$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig where IDCN=" . $idcn,  $GLOBALS['link']);
		$row3 = mysqli_fetch_array($result4);
		$config = explode("|", $row3["_Jug"]);

		for ($k = 0; $k <= count($config) - 1; $k++) {
			$_tem = explode("*", $config[$k]);
			if ($_tem[0] == $idj) :
				break;
			endif;
		}
		$_xc = explode("-", $_tem[1]);
		if ($ct == 2) :
			$tct = (count($_xc) - 1) / $ctc;
		else :
			$tct = (count($_xc) - 1);
		endif;
		return $tct . '||' . $_tem[1];
	}

	$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
	mysql_select_db("sphonlin_sphonline", $GLOBALS['link']);


	$IDCN = $_REQUEST['idcn'];


	$tc = 1;
	$c = 0;
	$ty = '"num"';
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where Estatus=1 and relpos<>0 order by relpos ",  $GLOBALS['link']);
	while ($row = mysqli_fetch_array($result)) {

		if ($row['Formato'] == 1) :
			if ($c == 0) :
				echo '<tr>';
			endif;

			echo "<td height='73' align='center' bgcolor='#D4DAE6'><div id='c" . $tc . "' lang='" . $row['CantidadCarr'] . "||" . $row['Formato'] . "||" . $row['IDJug'] . "' class='shadowcontainer'><div class='innerdiv'><table border='0' cellspacing='0'> ";
			echo "<tr bgcolor='#0066FF'><th colspan='3' bgcolor='" . $row['Color'] . "'><div align='center'>" . $row['Descrip'] . "</div></th></tr>";
			for ($i = 1; $i <= $row['CantidadCarr']; $i++) {
				$result_r = mysqli_query($GLOBALS['link'], "select * from  _relacion where IDCN=" . $IDCN . " and IDJug=" . $row['IDJug'] . " and Posi=" . $i,  $GLOBALS['link']);


				if (mysqli_num_rows($result_r) != 0) :
					$row3 = mysqli_fetch_array($result_r);
					$en = $row3['NomEjem'];
					$e = $row3['Ejem'];
				else :
					$en = '';
					$e = '';
				endif;

				$ev1 = '"e' . $row['IDJug'] . "-" . $i . '"';
				if (($i + 1) <= $row['CantidadCarr']) :
					$ev2 = '"ne' . $row['IDJug'] . "-" . ($i + 1) . '"';
				else :
					$ev2 = '"es' . $row['IDJug'] . '"';
				endif;
				echo '<tr>';
				echo "<th width='25'>" . $i . "</th>";
				echo "<td width='111'><span class='Estilo17'><input id='ne" . $row['IDJug'] . '-' . $i . "' onkeypress='this.value = this.value.toUpperCase();' type='text' size='20' maxlength='20'        onkeyup='pulsart(event," . $ev1 . ");' value='" . $en . "'/></span></td>";
				echo "<td width='78' align='right'><div align='center'><input id='e" . $row['IDJug'] . '-' . $i . "' onkeyup='pulsart(event," . $ev2 . ");'  type='text' size='10' maxlength='10' value='" . $e . "' /></div></td>";
				echo "</tr>";
			}
			$ev1 = '"ac' . $row['IDJug'] . '"';
			$ev2 = '"fac' . $row['IDJug'] . '"';
			$ev3 = '"dv' . $row['IDJug'] . '"';
			$ev4 = '"ne' . $row['IDJug'] . '-1"';

			$result_r = mysqli_query($GLOBALS['link'], "select * from  _relacion12 where IDCN=" . $IDCN . " and IDJug=" . $row['IDJug'],  $GLOBALS['link']);
			if (mysqli_num_rows($result_r) != 0) :
				$row3 = mysqli_fetch_array($result_r);
				$e1 = $row3['es'];
				$e2 = $row3['ac'];
				$e3 = $row3['fac'];
				$e4 = $row3['diven'];
			else :
				$e1 = '';
				$e2 = '';
				$e3 = '';
				$e4 = '';
			endif;



			echo "<tr bgcolor='" . $row['Color'] . "'>  <th colspan='4'>ESCRUT.:<input id='es" . $row['IDJug'] . "' onkeyup='pulsart(event," . $ev1 . ");'   type='text' size='10' maxlength='15' value='" . $e1 . "'/>&nbsp;AC:<input id='ac" . $row['IDJug'] . "' onkeyup='pulsart(event," . $ev2 . ");'  type='text' size='10' maxlength='15' value='" . $e2 . "'/></th><tr>";
			echo "<tr  bgcolor='" . $row['Color'] . "'>  <th colspan='4'>FACTOR:<input id='fac" . $row['IDJug'] . "' onkeyup='pulsart(event," . $ev3 . ");' type='text' size='10' maxlength='15' value='" . $e3 . "'/>&nbsp;DIVID.:<input id='dv" . $row['IDJug'] . "' onkeyup='pulsart(event," . $ev4 . ");' type='text' size='7' maxlength='10' value='" . $e4 . "'/></th><tr>";
			echo "</table></div></div></td>";
			if ($c == 2) :
				echo '</tr>';
			endif;

			if ($c < 3) :
				$c++;
			else :
				$c = 1;
			endif;
			$tc++;
		endif;

		if ($row['Formato'] == 2) :
			$nt = ntandas($IDCN, $row['IDJug'], $row['CantidadCarr'], $row['Tandas']);
			$ntan = explode('||', $nt);
			$ccc = explode('-', $ntan[1]);
			for ($j = 1; $j <= $ntan[0]; $j++) {

				if ($c == 0) :
					echo '<tr>';
				endif;
				if ($row['Tandas'] == 2) :
					$r = $j;
				else :
					$r = $ccc[$j - 1];
				endif;

				echo "<td height='73' align='center' bgcolor='#D4DAE6'><div id='c" . $tc . "' lang='" . $row['CantidadCarr'] . "||" . $row['Formato'] . "||" . $row['IDJug'] . "||" . $r . "' class='shadowcontainer'><div class='innerdiv'><table border='0' cellspacing='0'> ";

				echo "<tr bgcolor='#0066FF'><th colspan='3' bgcolor='" . $row['Color'] . "'><div align='center'>" . $row['Descrip'] . "(Tanda/Carrera): No." . $r . "</div></th></tr>";

				for ($i = 1; $i <= $row['CantidadCarr']; $i++) {
					$result_r = mysqli_query($GLOBALS['link'], "select * from  _relacion where IDCN=" . $IDCN . " and IDJug=" . $row['IDJug'] . " and Posi=" . $i . " and carr=" . $r,  $GLOBALS['link']);
					if (mysqli_num_rows($result_r) != 0) :
						$row3 = mysqli_fetch_array($result_r);
						$en = $row3['NomEjem'];
						$e = $row3['Ejem'];
					else :
						$en = '';
						$e = '';
					endif;

					$ev1 = '"e' . $row['IDJug'] . "-" . $i . '-' . $j . '"';
					if (($i + 1) <= $row['CantidadCarr']) :
						$ev2 = '"ne' . $row['IDJug'] . "-" . ($i + 1) . '-' . $j . '"';
					else :
						$ev2 = '"dv' . $row['IDJug'] . '-' . $j . '"';
					endif;

					echo '<tr>';
					echo "<th width='25'>" . $i . "</th>";
					echo "<td width='111'><span class='Estilo17'><input id='ne" . $row['IDJug'] . '-' . $i . '-' . $j . "'  onkeyup='pulsart(event," . $ev1 . ");' onkeypress='this.value = this.value.toUpperCase();' type='text' size='20' maxlength='20' value='" . $en . "'/></span></td>";
					echo "<td width='78' align='right'><div align='center'><input id='e" . $row['IDJug'] . '-' . $i . '-' . $j . "'  onkeyup='pulsart(event," . $ev2 . ");'   type='text' size='10' maxlength='10' value='" . $e . "' /></div></td>";
					echo "</tr>";
				}

				$result_r = mysqli_query($GLOBALS['link'], "select * from  _relacion12 where IDCN=" . $IDCN . " and IDJug=" . $row['IDJug'] . " and carr=" . $r,  $GLOBALS['link']);
				if (mysqli_num_rows($result_r) != 0) :
					$row3 = mysqli_fetch_array($result_r);
					$e1 = $row3['diven'];
				else :
					$e1 = '';
				endif;

				$ev1 = '"ne' . $row['IDJug'] . '-1-' . $j . '"';
				echo "<tr bgcolor='" . $row['Color'] . "'>  <th colspan='4'>DIVIDENDO:<input id='dv" . $row['IDJug'] . '-' . $j . "' onkeyup='pulsart(event," . $ev1 . ");' type='text' size='10' maxlength='10' value='" . $e1 . "'/></th><tr>";
				echo "</table></div></div></td>";
				if ($c == 2) :
					echo '</tr>';
				endif;
				if ($c < 3) :
					$c++;
				else :
					$c = 1;
				endif;
				$tc++;
			}
		endif;

		//***********************************************************************************************************//


		if ($row['Formato'] == 3) :
			$nt = ntandas($IDCN, $row['IDJug'], $row['CantidadCarr'], $row['Tandas']);
			$ntan = explode('||', $nt);
			$ccc = explode('-', $ntan[1]);
			$o = 0;
			for ($j = 1; $j <= $ntan[0] * 2; $j++) {
				if ($c == 0) :
					echo '<tr>';
				endif;

				$r = $ccc[$o] . '-' . $ccc[$o + 1];
				$r1 = $ccc[$o];

				echo "<td height='73' align='center' bgcolor='#D4DAE6'><div id='c" . $tc . "' lang='" . $row['CantidadCarr'] . "||" . $row['Formato'] . "||" . $row['IDJug'] . "||" . $r . "' class='shadowcontainer'><div class='innerdiv'><table border='0' cellspacing='0'> ";

				echo "<tr bgcolor='#0066FF'><th colspan='3' bgcolor='" . $row['Color'] . "'><div align='center'>" . $row['Descrip'] . "(Tanda/Carrera): No." . $r . "</div></th></tr>";
				$u = 1;
				for ($i = 1; $i <= $row['CantidadCarr']; $i++) {

					if ($i == 3) :
						$r1 = $ccc[$o + 1];
					endif;

					$result_r = mysqli_query($GLOBALS['link'], "select * from  _relacion where IDCN=" . $IDCN . " and IDJug=" . $row['IDJug'] . " and Posi=" . $i . " and carr=" . $r1,  $GLOBALS['link']);

					if (mysqli_num_rows($result_r) != 0) :
						$row3 = mysqli_fetch_array($result_r);
						$e = $row3['Ejem'];
						$en = $row3['NomEjem'];
					else :
						$e = '';
						$en = '';
					endif;


					if (($i + 1) <= $row['CantidadCarr']) :
						$ev2 = '"e' . $row['IDJug'] . "-" . ($i + 1) . '-' . $r . '"';
					else :
						$ev2 = '"e' . $row['IDJug'] . '-1-' . $r . '"';
					endif;

					echo '<tr>';
					echo "<th width='25'>" . $u . "</th>";
					echo "<td width='111'><input id='e" . $row['IDJug'] . '-' . $i . '-' . $r . "'  onkeyup='pulsart(event," . $ev2 . ");' onkeypress='return permite(event, " . $ty . ");'  type='text' size='4' maxlength='4' value='" . $e . "' /></td>";
					echo "<td width='78' align='right'><div align='center'></div></td>";
					echo "</tr>";
					if ($u == 2) :
						$u = 1;
					else :
						$u++;
					endif;
				}
				$o = $o + 2;

				echo "</table></div></div></td>";
				if ($c == 2) :
					echo '</tr>';
				endif;
				if ($c < 3) :
					$c++;
				else :
					$c = 1;
				endif;
				$tc++;
			}
		endif;
	}

	$result_r = mysqli_query($GLOBALS['link'], "select * from  _relacion13 where IDCN=" . $IDCN,  $GLOBALS['link']);
	if (mysqli_num_rows($result_r) != 0) :
		$row3 = mysqli_fetch_array($result_r);
		$e1 = $row3['Observa'];
	else :
		$result_r = mysqli_query($GLOBALS['link'], "select * from  _relacion13 order by IDCN desc",  $GLOBALS['link']);
		$row3 = mysqli_fetch_array($result_r);
		$e1 = $row3['Observa'];
	endif;
	?>
	<tr>
		<td colspan="4">
			<div class="shadowcontainer2">
				<div class="shadowcontainer11">
					<div id='infc' lang="<?php echo $tc; ?>" class="innerdiv" style=" top: auto">
						<p>OBSERVACIONES
							<textarea cols="120" rows="5" id="observa" onKeyDown="valida_longitud(700)" onKeyUp="valida_longitud(700)"> <?php echo $e1; ?></textarea>
							Caracteres:<input type="text" disabled="disabled" id="ccuenta" size="3" maxlength="3" value="<?php echo strlen(trim($e1)); ?>" />
							de 700
					</div>
				</div>
			</div>
		</td>
	</tr>
</table>