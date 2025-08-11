<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$fc = $_REQUEST["fc"];
$Abanca = 0;
$idt = $_REQUEST['idt'];
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu where IDusu=$idt");
$rowj = mysqli_fetch_array($resultj);
$Abanca = $rowj['ABanca'];

if ($Abanca == 0) :
	$listabanca = '';
	$result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca Order by IDB ");
	while ($row_g = mysqli_fetch_array($result_g)) {
		if ($row_g['Estatus'] == 1) :
			$listabanca .= $row_g['IDB'] . '-' . $row_g['NombreB'] . ',';
			$IDB = 1;
		endif;
	}
else :
	$IDB = $Abanca;
endif; ?>

<div id="fromJornada" style=" background:#BAC6D8;width: 100%; height: 100%; overflow: auto; display: none; font-family: Tahoma; font-size: 11px;">
	<? include('publicacc-2.php'); ?>
</div>
<div id="vista">
	<div id="obj2">
		<div id="Calen1" />
	</div>
</div>
</div>
<input id="IDB" name="" type="text" value="<? echo $IDB; ?>" style="display:none" />
<script>
	var idRow = 0;
	var abanca = <? echo $IDB; ?>;
	var lista1 = '<? echo $listabanca; ?>';
	var listabancas = lista1.split(',');
	var fecha = '<? echo $fc; ?>';

	function calendario() {
		dhxWins2 = new dhtmlXWindows();
		dhxWins2.setImagePath("codebase/imgs/");
		var w2 = dhxWins2.createWindow("w2", 450, 300, 190, 210);
		w2.clearIcon();
		dhxWins2.window("w2").button('close').hide();
		dhxWins2.window("w2").button('minmax1').hide();
		dhxWins2.window("w2").button('minmax2').hide();
		dhxWins2.window("w2").button('park').hide();
		w2.setText("");
		w2.attachObject('obj2');
		mCal = new dhtmlxCalendarObject('Calen1');
		mCal.attachEvent("onClick", mSelectDate);
		mCal.setSkin("dhx_black");
		mCal.loadUserLanguage('es');
		mCal.draw();
	}

	function mSelectDate(date) {
		$('vista').innerHTML = '<div id="obj2"><div id="Calen1"/></div></div>';
		fecha = mCal.getFormatedDate("%d/%c/%Y", date);
		setCookie('FechaCookie', fecha);
		bar.setItemText('TextoFecha', 'Fecha: ' + fecha);
		dhxWins2.window("w2").close();

		if (bar.getListOptionSelected("_Banca") == null)
			abanca = 1;
		else {
			xbanca = bar.getListOptionSelected("_Banca");
			verbanca = xbanca.split('-');
			abanca = verbanca[1];
		}
		$('IDB').value = abanca;
		w1.attachURL('publicacc-2.php?fc=' + fecha + '&IDB=' + abanca, true);

	}

	function clicktoolBar(id) {

		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "Calendario_":
				calendario();
				break;
			default:
				xbanca = bar.getListOptionSelected("_Banca");
				verbanca = xbanca.split('-');
				abanca = verbanca[1];
				bar.setItemText('SelBanca', ':' + listabancas[(verbanca[1] - 1)]);
				$('IDB').value = abanca;
				w1.attachURL('publicacc-2.php?fc=' + fecha + '&IDB=' + abanca, true);
		}
	}

	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 350, 255, 410, 500);
	w1.setText(' Publicar Logros ');
	w1.attachObject('fromJornada');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window('w1').setModal(true);
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addSeparator('', 3);
	bar.addText('TextoFecha', 4, 'Fecha:<? echo  $fc; ?>');
	bar.addButton("Calendario_", 5, "", "images/dhtmlxcalendar_icon.gif", "images/dhtmlxcalendar_icon.gif");
	bar.addSeparator('', 6);
	var ListaVer = new Array();
	var ListaVerTemp = new Array();
	for (i = 0; i <= listabancas.length - 2; i++) {
		verbanca = listabancas[i].split('-');
		ListaVer[i] = Array('obj-' + verbanca[0], 'obj', listabancas[i], 'images/navbits_start.gif');
	}

	bar.addButtonSelect("_Banca", 7, "Bancas", ListaVer);
	bar.addText('SelBanca', 8, ':' + listabancas[0]);
	bar.addSeparator('', 9);
	bar.attachEvent("onClick", clicktoolBar);
</script>