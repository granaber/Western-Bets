<style type="text/css">
	.Estilo2 {
		color: #FFFFFF
	}
</style>
<?php

/// Call Api colletion ///

$curl = curl_init();
$MODULO = "ikronos";
$THISURL = "https://verfacil.com:2124/status/parlayenlinea";
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
endif;
//http://www.sportsmemo.com/live_odds/books.php?host=SPORTSMEMO
//http://www.therx.com/lines/books.php?host=TheRX
$xml = simplexml_load_file('http://www.therx.com/lines/books.php?host=TheRX');
$s = simplexml_import_dom($xml);
$si = $s->BOOK;
$listacasino = '0-Todos,';
for ($i = 0;; $i++) {
	if (isset($si[$i])) :
		$listacasino .= $si[$i]['id'] . '-' . $si[$i]['name'] . ',';
	else :
		break;
	endif;
}
?>
<div id="vista">
	<div id="obj2">
		<div id="Calen1" />
	</div>
</div>
</div>
<div id="fromJornada"></div>
<div id="coc"></div>
<div id="selcas" style="display:none">0</div>
<div id="tlmenu"></div>
<script>
	var idRow = 0;
	var liga = 0;
	var abanca = <? echo $Abanca; ?>;
	var lista1 = '<? echo $listabanca; ?>';
	var listabancas = lista1.split(',');
	var lista2 = '<? echo $listacasino; ?>';
	var listacasino = lista2.split(',');
	var casino = 0;

	function clicktoolBar(id) {

		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "Agregar_":
				/*if (liga!=0){
							dhxWins1.window("w1").close();
							makeResultwin('skynet-3.php?fc='+fecha+'&liga='+liga,'tablemenu');
				}else
							nalert('ERROR','DEBE SELECCIONAR PRIMERO LA LIGA A AGREGAR!!');	*/


				if (abanca == 0) abanca = 1;

				//alert('skynet-3xt.php?liga='+arre+'&casino=0&idb='+abanca)
				makeResultwin('skynet-3xt.php?liga=' + arre + '&casino=' + $('selcas').innerHTML + '&idb=' + abanca, 'coc');
				break;
			case "Modificar_":
				if (idRow != 0) {

					cargarpartidos(idRow);
					dhxWins1.window("w1").close();
				} else
					nalert('ERROR', 'DEBE SELECCIONAR PRIMERO LA JORNADA A MODIFICAR!!');
				break;
			case "SelCasino2":
				makeResultwin('skynet-1-1xt.php?selec=' + $('selcas').innerHTML, 'tlmenu');

				break;
			default:

				xbanca = bar.getListOptionSelected("_Banca");
				if (xbanca != null) {
					verbanca = xbanca.split('-');
					abanca = verbanca[1];
					bar.setItemText('SelBanca', ':' + listabancas[(verbanca[1] - 1)]);
				}

				xcasino = bar.getListOptionSelected("_Casino");
				if (xcasino != null) {
					vercasino = xcasino.split('-');
					casino = vercasino[1];
					bar.setItemText('SelCasino', ':' + ListaCasTemp[(vercasino[1])]);
				}



				//"ImprimirReporte2('reportedeventashipodromo-2.php');"
		}
	}
	var arre = new Array;
	var n = 0;

	function doOnCheck(rowId, cellInd, state) {
		estado = false;
		if (state) {
			liga = rowId;
			var s = rowId.search("-");
			if (s != -1) {
				estado = true;
				saltar = false;
				for (i = 0; i <= n - 1; i++)
					if (arre[i] == -1) {
						arre[i] = rowId;
						saltar = true;
						break;
					}
				if (!saltar) {
					arre[n] = rowId;
					n++;
				}
			}
		} else {
			estado = true;
			liga = 0;

			for (i = 0; i <= n - 1; i++)
				if (arre[i] == rowId) {
					arre[i] = -1;
					break;
				}
		}
		return estado;
	}

	function doOnRowSelected(id) {
		idRow = id;
	}


	new Ajax.Request("skynet-2xlmXT.php", {
		method: 'get',
		asynchronous: false,
		onComplete: function(transport) {
			var response = transport.responseText;
		},
		onFailure: function() {
			alert('No tengo respuesta Comuniquese con el Administrador!');
		}
	});

	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 350, 255, 500, 550);
	w1.setText('Captura de Datos Kronos');
	w1.attachObject('fromJornada');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window('w1').setModal(true);
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("Agregar_", 1, "Agregar ", "images/copy.gif", "images/copy.gif");
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
	var ListaCas = new Array();
	var ListaCasTemp = new Array();
	for (i = 0; i <= listacasino.length - 2; i++) {
		vercasino = listacasino[i].split('-');
		ListaCasTemp[vercasino[0]] = listacasino[i]
		ListaCas[i] = Array('obj-' + vercasino[0], 'obj', listacasino[i], 'images/navbits_start.gif');
	}

	/*bar.addButtonSelect("_Casino", 10, "Casino", ListaCas);
	bar.addText('SelCasino', 11, ':'+listacasino[0]);*/
	bar.addButton("SelCasino2", 12, "Casinos ", "images/copy.gif", "images/copy.gif");

	bar.attachEvent("onClick", clicktoolBar);

	mygrid = w1.attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader(",Descripcion Deportes,");
	mygrid.setInitWidths("25,400,0")
	mygrid.setColAlign("right,left,left")
	mygrid.setColTypes("ch,ro,ro");
	mygrid.enableCollSpan(true);
	mygrid.setSkin("dhx_skyblue");
	mygrid.attachEvent("onRowSelect", doOnRowSelected);
	mygrid.attachEvent("onCheckbox", doOnCheck);

	mygrid.loadXML("doc.xml?e=" + new Date().getTime());
	mygrid.init();
</script>