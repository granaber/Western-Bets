<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
	<script type="text/javascript" src="prototype.js" ></script>
    <script  type="text/javascript" src="prc.js"></script>
	<script  src="codebase/dhtmlxcommon.js"></script>
	<script  src="codebase/dhtmlxmenu.js"></script>
    <script  src="codebase/dhtmlxwindows.js"></script>
    <script  src="codebase/dhtmlxtabbar.js"></script>
    <script  src="codebase/dhtmlxgrid.js"></script>		
<!--    <script  src="codebase/dhtmlxdataprocessor.js"></script>		Extension de Grid-->
    <script  src="codebase/php/connector.js"></script><!--	Extension de Grid-->
    <script  src="codebase/ext/dhtmlxgrid_filter.js"></script>	<!--	Extension de Grid-->
    <script  src="codebase/ext/dhtmlxgrid_srnd.js"></script><!--	Extension de Grid-->

    <script  src="codebase/dhtmlxgridcell.js"></script>	
    <script  src="codebase/dhtmlxtoolbar.js"></script>
    <script  src="codebase/dhtmlxcombo.js"></script>
    <script  src="codebase/dhtmlxcalendar.js"></script>
    <script  src="codebase/ext/dhtmlxwindows_wtb.js"></script>
    <script  src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <script  src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
	<script  src="codebase/dhtmlxlayout.js"></script>
    <script  src="codebase/dhtmlxtree.js"></script> 
    <script  src="codebase/dhtmlxcontainer.js"></script>


    
    <link rel="stylesheet" type="text/css" href="codebase/dhtmlxtree.css">
    <link rel="stylesheet" type="text/css" href="codebase/dhtmlxlayout.css">
	<link rel="stylesheet" type="text/css" href="codebase/dhtmlxwindows.css">
    <link rel="stylesheet" type="text/css" href="codebase/dhtmlxgrid.css"> 	
    <link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxcombo.css"> 
    <link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxtabbar.css">
    
    <link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_blue.css">
    <link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_black.css">
    
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxlayout_dhx_skyblue.css">
    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxlayout_dhx_black.css">
    
    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_skyblue.css">
    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_black.css">
    
    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxtoolbar_dhx_skyblue.css">
    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxtoolbar_dhx_black.css">
    
    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxmenu_modern_blue.css">  
    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxgrid_dhx_skyblue.css">
    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxgrid_dhx_black.css">
    
</head>

<body>
</body>
</html>
<script>
var dhxWins = new dhtmlXWindows();
				dhxWins.setImagePath("codebase/imgs/");
	
	var w1 = dhxWins.createWindow("w1", 10, 10, 450, 240);alert(1);
	w1.setText("MENSAJE INFORMATIVO");
	//w1.attachObject('obj');
	dhxWins.window("w1").denyResize();
	dhxWins.window("w1").denyMove();
    dhxWins.window("w1").button("park").disable();
</script>