<?
if (isset($_REQUEST['tfc'])) :
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();
	$fc = $_REQUEST['tfc'];
	$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM  _tconfighi  where _fecha='$fc'");
	if (mysqli_num_rows($result1) != 0) :
		$row1 = mysqli_fetch_array($result1);
		$Carreras = $row1['Cantcarr'];
		$hora = explode('|', $row1['_hora']);
		$IDCN = $row1['IDCN'];
	else :
		$Carreras = 0;
	endif;
endif;
?>

<table border="0">
	<tr style="background:#666; color: #000">
		<td>Carrera</td>
		<td>Hora de Cierre</td>
		<td>Condicion</td>
	</tr>
	<?
	for ($i = 1; $i <= $Carreras; $i++) {
		if (($i % 2) == 0) :
			echo ' <tr style="background:#B3D0E1; color: #000">';
		else :
			echo ' <tr>';
		endif;
		echo ' <td>' . $i . '.-</td>';
		$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi  where IDCN=$IDCN and ct=$i");
		if (mysqli_num_rows($result1) == 0) :
			echo ' <td>' . $hora[$i - 1] . '</td>';
		else :
			echo ' <td><img src="media/lock.png" width="16" height="16"></td>';
		endif;

		echo ' <td><input name="" type="button" value="..." onclick="VerCondiciones(' . $i . ',' . $IDCN . ');"></td>';
		echo ' </tr>';
	}
	?>
</table>
<samp id="IDCN" lang="<? echo $IDCN; ?>"></samp>