<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="prc.js"></script>
<script src="codebase/dhtmlxcommon.js"></script>
<script src="codebase/dhtmlxmenu.js"></script>
<script src="codebase/dhtmlxwindows.js"></script>
<script src="codebase/dhtmlxgrid.js"></script>
<script src="codebase/dhtmlxgridcell.js"></script>
<script src="codebase/dhtmlxtoolbar.js"></script>
<script src="codebase/ext/dhtmlxwindows_wtb.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<script src="codebase/dhtmlxlayout.js"></script>
<script src="codebase/dhtmlxtree.js"></script>
<script src="codebase/dhtmlxcontainer.js"></script>

<script src="dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script>

<link rel="stylesheet" type="text/css" href="codebase/dhtmlxtree.css">
<link rel="stylesheet" type="text/css" href="codebase/dhtmlxlayout.css">
<link rel="stylesheet" type="text/css" href="codebase/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="codebase/dhtmlxgrid.css">

<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxlayout_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxtoolbar_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxmenu_modern_blue.css">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxgrid_dhx_skyblue.css">




<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />




<style type="text/css">
	@media print {

		.header {
			display: none
		}

		div,
		a {
			display: none
		}

		span {
			display: none
		}

	}
</style>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>.:: WM Lottery ::.</title>
</head>
<?
date_default_timezone_set('America/Caracas');
require_once('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$IDJ = Jornada();
$Fecha = Fechareal(0, 'd/m/Y');
?>

<body onLoad="initMenu();">
	<div style="background:#036;">
		<span style="color: #FC0; font-size:14px">Jornada No.:</span><span id="IDJ" lang="<? echo $IDJ; ?>" style="color:#FFF; font-size:14px"><? echo $IDJ; ?></span>&nbsp;&nbsp;
		<span style="color: #FC0; font-size:14px">Fecha:</span><span id="Fecha" lang="<? echo $Fecha; ?>" style="color:#FFF; font-size:14px"><? echo $Fecha; ?></span>&nbsp;&nbsp;
	</div>
	<div>
		<div id="contextArea"></div>
	</div>
	<div>
		<div style="height: 180px;">
			<div id="toolbarObj" style=" position: relative;"></div>
		</div>
	</div>
	<div id="resp"></div>

	<samp id="printer" style=" color:#FFF"></samp>
</body>

</html>

<script>
	var menu;

	function _onclikMenu(id) {
		switch (id) {
			case "m11":
				makeResultwin("banca.php", "resp");
				break;
			case "m12":
				makeResultwin("zona.php", "resp");
				break;
			case "m17":
				makeResultwin("intermediario.php", "resp");
				break;
			case "m18":
				makeResultwin("relacion.php", "resp");
				break;
			case "m14":
				makeResultwin("loteria.php", "resp");
				break;
			case "m15":
				makeResultwin("cupos.php", "resp");
				break;
			case "m19":
				makeResultwin("listaloteria.php", "resp");
				break;
			case "m2":
				makeResultwin("ventas.php", "resp");
				break;
			case "m16":
				makeResultwin("usuarios.php", "resp");
				break;


		}
	}

	function initMenu() {




		menu = new dhtmlXMenuObject("contextArea", "modern_blue");
		menu.setImagePath("codebase/imgs/");
		menu.setIconsPath("images/");
		menu.setOpenMode("win");
		menu.loadXML("menu.xml?e=" + new Date().getTime());
		menu.attachEvent("onClick", "_onclikMenu");

		var webBar = new dhtmlXToolbarObject("toolbarObj");
		webBar.setIconsPath("images/");
		webBar.loadXML("toolsbar.xml?etc=" + new Date().getTime());
	}
</script>