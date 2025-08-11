<table border="0">
	<tr style="background:#B3D0E1; color: #000">
		<td>Ejemplar</td>
		<td>Div.Fijo</td>
		<td>Premio</td>
		<td>Cupo(%)</td>
	</tr>
	<?
	if ($_REQUEST['xnivel']) :
		require('prc_php.php');
		$GLOBALS['link'] = Connection::getInstance();
		$IDCN = $_REQUEST['IDCN'];
		$nc = $_REQUEST['nc'];
		$nivel = $_REQUEST['xnivel'];
		$cod = $_REQUEST['cod'];


		$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM  _tconfighi  where IDCN=$IDCN");
		$row1 = mysqli_fetch_array($result1);
		$CantiEje = explode('|', $row1['_Fab']);
		$Retirado = explode('|', $row1['_Ret']);
		$fc = $row1['_Fecha'];
		$EjeRetirados = explode('-', $Retirado[$nc - 1]);

	endif;
	$tipo = "'num'";
	$primero = '';
	for ($i = 1; $i <= $CantiEje[$nc - 1]; $i++) {
		$retir = array_search($i, $EjeRetirados);
		if ($retir === false) :
			if (($i % 2) == 0) :
				echo ' <tr style="background:#FF9; color: #000">';
			else :
				echo ' <tr>';
			endif;

			if ($i < $CantiEje[$nc - 1]) :
				$t = "'DF" . ($i + 1) . "'";
			else :
				$t = "'DF1'";
			endif;
			$t1 = "'P" . $i . "'";
			$t2 = "'C" . $i . "'";
			if ($primero == '') : $primero = 'DF' . $i;
			endif;
			$resulti = mysqli_query($GLOBALS['link'], "select * from _tbcondiciones where IDCN=$IDCN and Carr=$nc and Ejemplar=$i and nivel=$nivel and cod='$cod'");
			if (mysqli_num_rows($resulti) == 0) :
				$V1 = 0;
				$V2 = 0;
				$V3 = 0;
			else :
				$row1 = mysqli_fetch_array($resulti);
				$V1 = $row1['DF'];
				$V2 = $row1['Premio'];
				$V3 = $row1['Cupo'];
			endif;
			echo ' <td>' . $i . '.-</td>';
			echo ' <td><input id="DF' . $i . '" type="text" size=4  maxlength="4"  value="' . $V1 . '" onKeyUp="pulsoENTER(event,' . $t1 . ');"  onkeypress="return permite(event,' . $tipo . ');"/></td>';
			echo ' <td><input id="P' . $i . '" type="text" size=4  maxlength="4"   value="' . $V2 . '" onKeyUp="pulsoENTER(event,' . $t2 . ');"  onkeypress="return permite(event,' . $tipo . ');"/></td>';
			echo ' <td><input id="C' . $i . '" type="text" size=6  maxlength="6"   value="' . $V3 . '" onKeyUp="pulsoENTER(event,' . $t . ');""  onkeypress="return permite(event,' . $tipo . ');"/></td>';
			echo ' </tr>';
		else :
			echo ' <tr style="background: #C00; color: #FFF">';
			echo ' <td>' . $i . '.-</td>';
			echo ' <td colspan="3">RETIRADO</td>';
			echo ' </tr>';

		endif;
	}
	?>
	<samp id='ntdc' lang="<? echo $CantiEje[$nc - 1]; ?>"></samp>
</table>