<?
//////////////////////////////////////////////////////////
		$IDJ=$_REQUEST['IDJ'];
		$Grupo=$_REQUEST['Grupo'];
		$IDB=$_REQUEST['IDB'];
		$IDP=$_REQUEST['IDP'];
		$TCol=$_REQUEST['TCol'];
		$IDDD=$_REQUEST['IDDD'];
//////////////////////////////////////////////////////////		
?>

<div id="frmLogros">
<div  id="GridLogros"  height="390px"    style=" width:900px;background-color:#FC0 "></div>
</div>
<script>
	function clicktoolBarK(id){
		switch(id){	
			case "Cerrar_":
						 dhxWinsMM.window("w2").close();
						 break;		
		
		}	
	}	
	dhxWinsMM =new dhtmlXWindows();
    dhxWinsMM.setImagePath("codebase/imgs/");	
	w2 = dhxWinsMM.createWindow("w2",100, 270, 300, 300);
	w2.setText("Modificaciones de <? echo $TCol; ?> ");
	w2.attachObject('frmLogros');
	dhxWinsMM.window("w2").button('close').hide();
	dhxWinsMM.window("w2").button('minmax1').hide();
	dhxWinsMM.window("w2").button('minmax2').hide();
	dhxWinsMM.window("w2").button('park').hide();
	dhxWinsMM.window("w2").denyResize();
	dhxWinsMM.window("w2").centerOnScreen();
	dhxWinsMM.window('w2').setModal(true);
    var bar1 = w2.attachToolbar();
	bar1.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar1.attachEvent("onClick", clicktoolBarK);
	mygridG = new dhtmlXGridObject('GridLogros');
	mygridG.setImagePath("codebase/imgs/"); 
	mygridG.setHeader("Hora,Logros Modif.,Usuario"); 
	mygridG.setInitWidths("80,100,100");
	mygridG.setColAlign("right,left,left");
	mygridG.setSkin("light");
	mygridG.init();	
	mygridG.clearAll();
	mygridG.loadXML("Auditoriadeventas-2.php?Grupo=<? echo $Grupo;?>&IDB=<? echo $IDB;?>&IDJ=<? echo $IDJ;?>&IDP=<? echo $IDP;?>&IDDD=<? echo $IDDD;?>");
	
</script>