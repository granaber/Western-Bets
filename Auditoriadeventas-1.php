<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$fc = Fechareal($GLOBALS['minutosh'], "d/n/Y");
$IDB = 1;
?>
<div id="box4" style="background: #036">
	<div align="left" style="color:#FC0">Indique la Fecha:
		<input name="fc" type="text" id="fc" size="10" value="<?php echo $fc; ?>" />&nbsp;&nbsp;
		Banca:<select name="select2" id="IDB">
			<?
			$result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca Order by IDB ");
			while ($row_g = mysqli_fetch_array($result_g)) {
				if ($row_g['Estatus'] == 1) :
					echo '<option value="' . $row_g['IDB'] . '">' . $row_g['IDB'] . '-' . $row_g['NombreB'] . '</option>';
				endif;
			}
			?>
		</select><input name="" type="button" onClick="makeResultwin('Auditoriadeventas-1-4.php?xfc='+$('fc').value+'&IDB='+$('IDB').value,'box5');$('printer3').innerHTML ='';" value="Buscar">
		<input name="" type="button" onClick="makeResultwin('Auditoriadeventas-6.php?xfc='+$('fc').value,'fromChangeOdds');" value="Ver Jugada">
	</div>
</div>

<br>
<br>
<table width="200" border="0">
	<tr>
		<td>
			<div id="box5" style="background:#033; float:left">
				<? include "Auditoriadeventas-1-4.php"; ?>
			</div>
		</td>
		<td>
			<? include "ticketbbN-2.php"; ?>
		</td>
	</tr>
</table>



<br />
<br />

</div>
<div id="fromChangeOdds"></div>
<script>
	function mSelectDate(date) {
		$('fc').value = cal1.getFormatedDate('%d/%c/%Y', date);
		return true;
	}
	cal1 = new dhtmlxCalendarObject('fc');
	cal1.setOnClickHandler(mSelectDate);
</script>