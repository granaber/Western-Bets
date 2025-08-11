 <table width="200" border="1">
 	<tr>
 		<td>Fecha</td>
 		<td>Partido</td>
 		<td>Equipo1</td>
 		<td>Equipo2</td>
 		<td>Hora Conf.</td>
 		<td>Hora Cerrado</td>
 		<td>Usuario que Cerro</td>
 	</tr>
 	<?

		require('prc_php.php');
		$GLOBALS['link'] = Connection::getInstance();
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb  where IDJ>=198 and IDJ<=204 order by IDJ,IDP");

		while ($Row = mysqli_fetch_array($resultj)) {
			$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where IDE=" . $Row['IDE1']);
			$Row1 = mysqli_fetch_array($result1);
			$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where IDE=" . $Row['IDE2']);
			$Row2 = mysqli_fetch_array($result2);

			$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrebb where IDP=" . $Row['IDP']);
			$Row3 = mysqli_fetch_array($result3);

			$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu where IDusu=" . $Row3['usuario']);
			$Row4 = mysqli_fetch_array($result4);

			$result5 = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $Row['IDJ']);
			$Row5 = mysqli_fetch_array($result5);

			echo '<tr>';
			echo '<td>' . $Row5['Fecha'] . '</td>';
			echo '<td>' . $Row['IDP'] . '</td>';
			echo '<td>' . $Row1['Descripcion'] . '</td>';
			echo '<td>' . $Row2['Descripcion'] . '</td>';
			echo '<td>' . convertirhora($Row['Hora']) . '</td>';
			echo '<td>' . $Row3['Hora'] . '</td>';
			echo '<td>' . $Row4['Nombre'] . '</td>';
			echo '</tr>';
		}
		?>




 </table>