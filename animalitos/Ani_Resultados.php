<style type="text/css">
<!--
.Estilo2d1 {color: #000000}
.Estilo3d1 {
	color: #FFFF66;
	font-size:15px;
}
.Estilo5d1 {
	color: #FFFFFF;
	font-size:15px;
}
.Estilo4d1 { color:#FFFFFF; font-size:14px}
-->
</style>





<div id="fromReporte"  style=" height:1000px; background:#069"  >


 <table   width="440" border="0" cellspacing="0" >
        <tr   >
          <th width="1"    ></th>
          <th colspan="4"   ><div align="center" class="Estilo4d1">Reporte de Resultados</div>
            <div align="right"></div></th>
        </tr>
        <tr   >
          <th    ></th>
          <th width="80"   >&nbsp;</th>
          <th colspan="2"   >&nbsp;</th>
          <th width="68"   ><div align="right"></div></th>
        </tr>

        <tr   >
          <th    ></th>
          <th   ><div align="right" class="Estilo3d1" >Desde:</div></th>
          <th width="144"   ><input name="fc" type="text" id="fc1"  size="10"  value="<?php echo date("d/n/Y");?>" /></th>
          <th width="137"   ><div align="right" class="Estilo3d1">Hasta:</div></th>
          <th   ><input name="fc" type="text" id="fc2"    size="10"  value="<?php echo date("d/n/Y");?>"/></th>
        </tr>

        <tr   >
          <th    ></th>

        </tr>


      </table>
</div>


<script>
function mSelectDate(date) {
     $('fc1').value = cal1.getFormatedDate('%d/%c/%Y', date);
	// MakeRespK1('hipodromo-1-5hi.php?desde='+$('fc1').value+'&hasta='+$('fc2').value,'Hipodro');
    return true;
}
function mSelectDate2(date) {
     $('fc2').value = cal2.getFormatedDate('%d/%c/%Y', date);
//	 MakeRespK1('hipodromo-1-5hi.php?desde='+$('fc1').value+'&hasta='+$('fc2').value,'Hipodro');
    return true;
}
 function clicktoolBar(id){
	switch(id){
		case "Cerrar_":
					dhxWins1.window("w1").close();
					break;
		case "ImprimiR_":
					openClas('Ani_Resultados-1.php','d1='+$("fc1").value+"|d2="+$("fc2").value+"|IDC="+$('con').title,'Reporte de Tickets Pagados',1,0,0,0,0,0,1,900,600,100,500,1);
					break;
					}
  }
    dhxWins1 = new dhtmlXWindows();
    dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1",450, 80, 500, 200);
	w1.setText('Reporte Resultados' );
	w1.attachObject('fromReporte');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window("w1").denyResize();
	dhxWins1.window("w1").denyMove();
	dhxWins1.window('w1').setModal(true)
  var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
	bar.addButton("ImprimiR_", 1, "Imprimir Reporte", "animalitos/icons/noun_926248_cc.png", "animalitos/icons/noun_926248_cc.png");
	bar.attachEvent("onClick", clicktoolBar);

	cal1 = new dhtmlxCalendarObject('fc1');
	cal1.setOnClickHandler(mSelectDate);

	cal2 = new dhtmlxCalendarObject('fc2');
	cal2.setOnClickHandler(mSelectDate2);
</script>
