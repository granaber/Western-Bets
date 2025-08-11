<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$fc = date("d/n/Y");
$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM  _tconfighi  where _fecha='$fc'");
if (mysqli_num_rows($result1) != 0) :
	$row1 = mysqli_fetch_array($result1);
	$Carreras = $row1['Cantcarr'];
	$hora = explode('|', $row1['_hora']);
	$IDCN = $row1['IDCN'];
else :
	$Carreras = 0;
endif;


?>
<div id='fromCarr'>
	<div style="background:#036; color:#FFF">Fecha:<input id='fc' type="text" value="<? echo $fc; ?>"></div>
	<br>
	<div id='TablaCarr'>
		<?
		include "condiciones-1.php";
		?>

	</div>
</div>
<div id="gridbox"></div>
<script>
	function doOnCellEdit(stage, rowId, cellInd, newvalue) {
		if (stage == 2)
			makeResultwin("chaceStatus.php?SqlStatus=Update _creditos set Saldo=" + newvalue + " where IDC='" + rowId + "'", "gridbox");
		return true;
	}

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins3.window("w1").close();
				break;
			case "Reporte_":
				mygrid4.toPDF('codebase/server/generate.php');
				break;

		}
	}

	function mSelectDate(date) {
		$('fc').value = cal1.getFormatedDate('%d/%c/%Y', date);
		makeResultwin("condiciones-1.php?tfc=" + $('fc').value, "TablaCarr");
		return true;
	}
	dhxWins3 = new dhtmlXWindows();
	dhxWins3.setImagePath("codebase/imgs/");
	w1 = dhxWins3.createWindow("w1", 200, 100, 250, 600);
	w1.setText('Condiciones de Carreras ');
	w1.attachObject('fromCarr');
	dhxWins3.window("w1").button('close').hide();
	dhxWins3.window("w1").button('minmax1').hide();
	dhxWins3.window("w1").button('minmax2').hide();
	dhxWins3.window("w1").button('park').hide();
	dhxWins3.window("w1").denyResize();

	dhxWins3.window('w1').setModal(true);
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "media/icon_bar/close.gif", "media/icon_bar/close.gif");
	bar.attachEvent("onClick", clicktoolBar);

	cal1 = new dhtmlxCalendarObject('fc');
	cal1.setOnClickHandler(mSelectDate);
</script>