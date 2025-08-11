	<table width="180" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><span style="color:#FFFFFF; font-size:12px"> Ejem.</span></td>
			<td><span style="color:#FFFFFF; font-size:12px"> Nombre</span></td>
			<td><span style="color:#FFFFFF; font-size:12px"> Ganador</span></td>
			<td><span style="color:#FFFFFF; font-size:12px"> Place</span></td>
			<td><span style="color:#FFFFFF; font-size:12px"> Shot</span></td>
		</tr>
		<?
		if (isset($_REQUEST['IDCNt'])) :
			require('prc_php.php');
			$GLOBALS['link'] = Connection::getInstance();

			$IDCN = $_REQUEST['IDCNt'];
			$primercarr = $_REQUEST['primercarr'];
			$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfighi where IDCN=" . $IDCN);
			if (mysqli_num_rows($result3) != 0) :
				$row = mysqli_fetch_array($result3);
				$caticabb = explode('|', $row['_Fab']);
				$retirado = explode('|', $row['_Ret']);
			endif;

		endif;
		$tipo = "'num'";
		$j = 1;
		for ($i = 1; $i <= $caticabb[($primercarr - 1)]; $i++) {
			$result_qw = mysqli_query($GLOBALS['link'], "SELECT * FROM _tablaejempleareshi where  IDCN=" . $IDCN . " and Carr=" . $j . " and Noeje=" . $i);

			if (mysqli_num_rows($result_qw) == 0) :
				$nombreEje = '';
			else :
				$row = mysqli_fetch_array($result_qw);
				$nombreEje = $row['Nombre'];
			endif;
			$retir = explode('-', $retirado[($primercarr - 1)]);



			if (!buscar($retir, $i)) :
				if ($l == 1) : echo '<tr>';
					$l = 2;
				else :  echo '<tr bgcolor="#999999">';
					$l = 1;
				endif;
				echo '<td><span style="color:#FFFFFF"> ' . $i . '</span></td>';
				echo '<td ><span id="ejemplar' . $i . '" lang="' . $nombreEje . '" style="color:#FFFFFF">' . $nombreEje . '</span></td>';
				$t = "'p" . $i . "'";
				echo '<td><span id="gt' . $i . '" style="color:#FFFFFF; font-size:16px" lang="0"> &nbsp;</span><input id="g' . $i . '" type="text" size="6" style="display:none" onKeyUp="pulsart(event,' . $t . '); " onkeypress="return permite(event,' . $tipo . ');" ></td>';
				$t = "'s" . $i . "'";
				echo '<td><span id="pt' . $i . '" style="color:#FFFFFF; font-size:16px" lang="0"> &nbsp;</span><input id="p' . $i . '" type="text" size="6" style="display:none" onKeyUp="pulsart(event,' . $t . ');" onkeypress="return permite(event,' . $tipo . ');"></td>';
				$t = "'eje'";
				echo '<td><span id="st' . $i . '" style="color:#FFFFFF; font-size:16px" lang="0"> &nbsp;</span><input id="s' . $i . '" type="text" size="6" style="display:none" onKeyUp="pulsart(event,' . $t . ');accesogps(false);" onkeypress="return permite(event,' . $tipo . ');"> </td>';
			else :
				echo '<tr bgcolor="#660000">';
				echo '<td><span style="color:#FFFFFF"> ' . $i . '</span></td>';
				echo '<td><span style="color:#FFFFFF">RETIRADO</span></td>';
				echo '<td><span  style="color:#FFFFFF; font-size:16px" lang="0"> &nbsp;</span></td>';
				echo '<td><span  style="color:#FFFFFF; font-size:16px" lang="0"> &nbsp;</span></td>';
				echo '<td><span  style="color:#FFFFFF; font-size:16px" lang="0"> &nbsp;</span></td>';
			endif;

			echo '</tr>';
		}



		function buscar($arr, $elem)
		{
			$search = false;
			for ($ttt = 0; $ttt <= count($arr) - 1; $ttt++) {
				if ($arr[$ttt] == $elem) :  $search = true;
					break;
				endif;
			}
			return $search;
		}
		?>
	</table>
	<samp id="totaleje" lang="<? echo $caticabb[($primercarr - 1)]; ?>" style="display:none; color: #660000"></samp>
	<script type="text/javascript">
		Nifty('div#box2');
	</script>