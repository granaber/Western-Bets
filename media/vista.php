



<div id="vista" >

<table  border="1" cellspacing="0" cellpadding="0" >
  <tr>
    <td><img src="formato1.png" width="190" height="209" onClick="LogroVista('impresionlogros.php')"></td>
    <td>&nbsp;</td>
    <td><img src="formato2.png" width="190" height="209" onClick="LogroVista('impresionlogros1.php')"></td>
  </tr>
</table>


</div>

<script>
    dhxWins1 = new dhtmlXWindows();
    dhxWins1.setImagePath("codebase/imgs/");	
	w1 = dhxWins1.createWindow("w1",150, 255, 400, 350);
	w1.setText('Seleccione la Hoja de Logros');
	w1.attachObject('vista');
	//dhxWins1.window("w1").button('close').hide();

	/*dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();*/
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window('w1').setModal(true);
    dhxWins1.window('w1').centerOnScreen();
	//dhxWins1.window('w1').maximize();
</script>