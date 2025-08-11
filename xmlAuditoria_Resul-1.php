<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$fc = Fechareal($GLOBALS['minutosh'], "d/n/Y");
$IDB = 1;
?>
<div id="box4" style="background: #333">
	<div align="left" style="color:#FC0">Indique la Fecha:
		<input name="fc" type="text" id="fc" size="10" value="<?php echo $fc; ?>" />
		</select><input name="" type="button" onClick="makeResultwin('xmlAuditoria_Resul-4.php?xfc='+$('fc').value+'&IDB=1','box5');" value="Buscar">
	</div>
</div>

<br>
<br>
<div id="box5" style="background: #036; float:left">
	<? include "xmlAuditoria_Resul-4.php"; ?>
</div>
<input name="" type="submit" value="Imprimir Reporte" onclick="pdf_s();" />
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