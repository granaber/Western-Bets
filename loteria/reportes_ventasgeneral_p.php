<div id="obj">
<table cellpadding="10" cellspacing="0">

  <tr >
    <td width="105" valign="top"><div id="dhtmlxCalendar"></div></td>
    
    <td width="375" valign="top"><strong>Rango de Fecha a Buscar:</strong>
		<p>
		Desde: <br />
			<div style="position:relative; border:1px solid navy; width: 199px"><input
			 type="text" id="calInput1" style="border-width:0px; width: 179px; font-size:12px;"
			 readonly="true"><img style="cursor:pointer;" onClick="showCalendar(1)" src="codebase/imgs/calendar.gif" align="absmiddle"><div id="calendar1" style="position:absolute; left:199px; top:0px; display:none"></div></div>
		<br>
		Hasta: 
		<div style="position:relative; border:1px solid navy; width: 199px"><input
			 type="text" id="calInput2" style="border-width:0px; width: 179px; font-size:12px;"
			 readonly="true"><img style="cursor:pointer;" onClick="showCalendar(2)" src="codebase/imgs/calendar.gif" align="absmiddle"><div id="calendar2" style="position:absolute; left:199px; top:0px; display:none"></div></div>
		</p>
		</td>
        <td width="40" valign="top">&nbsp;</td>
  </tr>
  <tr bgcolor="#003366" style="color:#FFF">
    <td height="63" valign="top">Indique el Grupo:</td>
    <td valign="top">   <form >
      <input type="radio" name="radio" id="banca" value="radio" checked onClick="showTipo(1);$('txtInf').innerHTML='Indique la Banca:';"> Banca
      <input type="radio" name="radio" id="Zona" value="radio" onClick="showTipo(2);$('txtInf').innerHTML='Indique la Zona:';"> Zona
      <input type="radio" name="radio" id="Intermediario" value="radio" onClick="showTipo(3);$('txtInf').innerHTML='Indique la Intermediario:';"> Intermediario
      <input type="radio" name="radio" id="Agencia" value="radio" onClick="showTipo(4);$('txtInf').innerHTML='Indique la Agencia:';"> Agencia
      
    </form></td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr bgcolor="#333333" style="color:#FFF">
    <td height="66" valign="top"><span id="txtInf">Indique la Banca:</span></td>
    <td valign="top"><div id='respuesta'></div></td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
</div>
<div id="gridbox">

</div>
<samp id="idseleccionado" ></samp>
<script>


function clicktoolBar(id){

switch(id){
	case "Cerrar_":
					dhxWins1.window("w1").close();
					break;	
	case "Imprimir_":
					Reporte_Pv1();
					break;	
}
	
}
 function doOnRowSelected(id){ 
	    
		$('idseleccionado').lang=id;
		
	    } 
   function doOnCheck(rowId,cellInd,state){
  
	if (state)
	  estado=1;
	else
	  estado=0;
	makeResultwin("chaceStatus.php?SqlStatus=Update _tbanca set Estatus="+estado+" where IDB="+rowId,"gridbox");
	} 
  	var dhxWins1 = new dhtmlXWindows();
	
    dhxWins1.setImagePath("codebase/imgs/");	
	var w1 = dhxWins1.createWindow("w1",10, 80, 640, 400);
	w1.setText("Impresion (Reporte de Ventas General)");
	w1.attachObject('obj');
	//dhxWins1.setSkin("web");  
	

    var bar = w1.attachToolbar();
	bar.addButton("Imprimir_", 0, "Imprimir", "images/dhtmlxeditor_icon.gif", "images/dhtmlxeditor_icon.gif");
	bar.addSeparator("separator_", 1); 
   	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	bar.attachEvent("onClick", clicktoolBar);
	
    cal1 = new dhtmlxCalendarObject('calendar1');
    cal1.setOnClickHandler(selectDate1);
	cal1.setSkin("dhx_blue");
    cal2 = new dhtmlxCalendarObject('calendar2');
    cal2.setOnClickHandler(selectDate2);
	cal2.setSkin("dhx_blue");
	
    mCal = new dhtmlxCalendarObject('dhtmlxCalendar', false, {
        isYearEditable: true
    });
    mCal.setYearsRange(2000, 2500);
	mCal.setSkin("dhx_black");
    mCal.draw();
	showTipo(1);


</script>