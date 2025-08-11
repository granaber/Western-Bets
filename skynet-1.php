<style type="text/css">
	.Estilo2 {
		color: #FFFFFF
	}
</style>
<?php

/// Call Api colletion ///

$curl = curl_init();
$MODULO = "ikronos";
$THISURL = "https://saamqx.net:2124/status/parlayenlinea";
curl_setopt_array($curl, array(
	CURLOPT_URL => $THISURL,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"cache-control: no-cache"
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$data = json_decode($response, true);

if ($data["status"]) :
	if ($data["suspend"]) :
		$versuspend = explode(",", $data["tosuspend"]);
		for ($i = 0; $i < count($versuspend); $i++) {
			if ($versuspend[$i] == $MODULO) :
				// include("./suspend/index.html");exit();
				echo "<script>";
				echo "window.location.replace('https://parlayenlinea.tk/suspend/index.html');";
				echo "</script>";
				exit();
			endif;
		}
	endif;
endif;

/////////////////////////
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$fc = $_REQUEST["fc"];

$Abanca = 0;
$idt = $_REQUEST['idt'];
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu where IDusu=$idt");
$rowj = mysqli_fetch_array($resultj);
$Abanca = $rowj['ABanca'];
?>
<div id="vista">
	<div id="obj2">
		<div id="Calen1" />
	</div>
</div>
</div>
<div id="fromJornada"></div>
<div id="coc"></div>
<script>
	var idRow = 0;
	var liga = 0;
	var abanca = <? echo $Abanca; ?>;

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
		mygrid.clearAll();
		mygrid.loadXML('skynet-2.php?fc=' + fecha);

	}

	function makeResulForCreator(src) {
		new Ajax.Request(src, {
			method: "get",
			onComplete: function(transport) {
				var response = transport.responseText.evalJSON(true);
				if (response[0])
					makeResultwin('skynet-3.php?fc=' + fecha + '&liga=' + liga, 'tablemenu');
				else {
					$('tablemenu').innerHTML = ''
					alert("Ups! Hay problemas al Crear la Liga!");
				}
			},
			onCreate: function() {
				$('tablemenu').innerHTML = '<img src="media/ajax-loader.gif" />';
			},

			onFailure: function() {
				alert("No tengo respuesta Comuniquese con el Administrador!");
			},
		});
	}

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "Agregar_":
				if (liga != 0) {
					dhxWins1.window("w1").close();
					new Ajax.Request('skynet-creator-1.php', {
						parameters: {
							fc: fecha,
							liga: liga
						},
						method: 'post',
						asynchronous: false,
						onComplete: function(transport) {
							var response = transport.responseText.evalJSON(true);
							if (response[0])
								makeResulForCreator('skynet-creator.php?IdSport=' + response[2] + '&Nom=' + response[1] + '&liga=' + liga);
							else
								makeResultwin('skynet-3.php?fc=' + fecha + '&liga=' + liga, 'tablemenu');
						},
						onFailure: function() {
							alert('No tengo respuesta Comuniquese con el Administrador!');
						}
					});
				} else
					nalert('ERROR', 'DEBE SELECCIONAR PRIMERO LA LIGA A AGREGAR!!');
				break;
			case "Modificar_":
				if (idRow != 0) {

					cargarpartidos(idRow);
					dhxWins1.window("w1").close();
				} else
					nalert('ERROR', 'DEBE SELECCIONAR PRIMERO LA JORNADA A MODIFICAR!!');
				break;
			case "Calendario_":
				calendario();
				break;


				//"ImprimirReporte2('reportedeventashipodromo-2.php');"
		}
	}


	function doOnCheck(rowId, cellInd, state) {
		if (state) {
			estado = 1;
			liga = rowId;
		} else {
			estado = 0;
			liga = 0;
		}

	}

	function doOnRowSelected(id) {
		idRow = id;
	}

	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 350, 255, 400, 550);
	w1.setText('Captura de Datos ');
	w1.attachObject('fromJornada');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window('w1').setModal(true);
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("Agregar_", 1, "Agregar ", "images/copy.gif", "images/copy.gif");
	bar.addSeparator('', 3);
	bar.addText('TextoFecha', 4, 'Fecha:<? echo  $fc; ?>');
	bar.addButton("Calendario_", 5, "", "images/dhtmlxcalendar_icon.gif", "images/dhtmlxcalendar_icon.gif");
	bar.addSeparator('', 6);
	bar.attachEvent("onClick", clicktoolBar);

	mygrid = w1.attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader(",ID,Descripcion Deportes");
	mygrid.setInitWidths("25,55,300")
	mygrid.setColAlign("right,left,left")
	mygrid.setColTypes("ch,ro,ro");

	mygrid.setSkin("dhx_skyblue");
	mygrid.attachEvent("onRowSelect", doOnRowSelected);
	mygrid.attachEvent("onCheckbox", doOnCheck);

	mygrid.loadXML("skynet-2.php?fc=<? echo $_REQUEST["fc"]; ?>");
	mygrid.init();
</script>