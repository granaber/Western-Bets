<?php

$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
mysql_select_db("sphonlin_sphonline", $GLOBALS['link']);

$cant = $_REQUEST["cant"];
?>
<style type="text/css">
	<!--
	.Estilo3 {
		color: #999999
	}
	-->
</style>


<table border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td width="38" bgcolor="#FFFFFF">
			<div align="center"><strong>N.P</strong></div>
		</td>
		<td width="54" bgcolor="#FFFFFF">
			<div align="center"><strong>Hora</strong></div>
		</td>
		<td width="58" bgcolor="#FFFFFF">
			<div align="center"><strong>Equipo(M)</strong></div>
		</td>
		<td width="13" bgcolor="#FFFFFF">&nbsp;</td>
		<td width="61" valign="bottom" bgcolor="#FFFFFF">
			<div align="center"><strong>Equipo(H)</strong></div>
		</td>
		<?php

		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb  Order by Formato",  $GLOBALS['link']);
		if (mysqli_num_rows($result) != 0) :
			$i = 1;
			while ($row3 = mysqli_fetch_array($result)) {
				$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where Formato=" . $row3['Formato'],  $GLOBALS['link']);
				while ($row2 = mysqli_fetch_array($result2)) {
					echo '<td bgcolor="#FFFFFF"><div align="center"><input id="c' . $row2['IDDD'] . '" type="checkbox" value="" checked="checked" /><br />' . $row3['Descripcion'] . '<br /><strong>' . $row2['Descripcion'] . '</strong></div></td>';
				}
			}
		endif;
		echo '</tr>';

		for ($j = 1; $j <= $cant; $j++) {
			$eq1[$j] = 1;
			$eq2[$j] = 1;
			$hrx[$j] = "";
		}
		for ($i = 1; $i <= $cant; $i++) {
			if (($i % 2) == 0) :
				$bkcolor = "#999999";
			else :
				$bkcolor = "#E2E7EF";
			endif;
			echo '<tr bgcolor="' . $bkcolor . '"><td ><div align="center">' . $i . '</div></td>
          <td ><div align="center">
            <input id="hora' . $i . '" name="textfield" type="text" size="8" maxlength="8" value=' . $hrx[$i] . '>
          </div></td>
          <td ><div align="center">
            <select name="select2" size="1" id="equipo' . $i . '" >';
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb order by IDE",  $GLOBALS['link']);
			while ($row = mysqli_fetch_array($result)) {
				echo "<option " . ($eq1[$i] == $row["IDE"] ? " selected='selected'" : " ") . " value=" . $row["IDE"] . ">" . $row["Descripcion"] . "</option>";
			}
			$n = $i + $cant;
			echo  '</select>
          </div></td>
          <td><div align="center"><strong>vs</strong></div></td>
          <td ><div align="center">
             <select name="select2" size="1" id="equipo' . $n . '" >';
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb order by IDE",  $GLOBALS['link']);
			while ($row = mysqli_fetch_array($result)) {
				echo "<option " . ($eq2[$i] == $row["IDE"] ? " selected='selected'" : " ") . " value=" . $row["IDE"] . ">" . $row["Descripcion"] . "</option>";
			}
			echo '</select></div></td>';


			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb  Order by Formato",  $GLOBALS['link']);
			if (mysqli_num_rows($result) != 0) :
				while ($row3 = mysqli_fetch_array($result)) {
					$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where Formato=" . $row3['Formato'],  $GLOBALS['link']);
					while ($row2 = mysqli_fetch_array($result2)) {
						echo '<td  ><div align="center"><strong><input  type="text" size="3" maxlength="3" /></strong></div></td>';
					}
				}
			endif;
			echo '</tr>';
		}
		?>
</table>