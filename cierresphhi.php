 <?php
	date_default_timezone_set('America/Caracas');
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();

	$fecha = date('d/n/Y');


	?>
 <div id="box1" style="background: #333333; ">


 	<table width="449" border="0" cellspacing="0">
 		<tr>
 			<th colspan="4">
 				<div align="center" style="color:#FFFFFF; font-size:14px">Cierre</div>
 			</th>
 			<th>
 				<div id="ver" align="center" style="color: #F90; font-size:10px"></div><img id="pro" src="media/proceso.gif" width="16" height="16" style="display:none" />
 			</th>
 		</tr>
 		<tr>
 			<th width="43">
 				<div align="center" style="color:#FFFFFF; font-size:12px"><strong>Fecha:</strong></div>
 			</th>
 			<td width="72"><input name="fc" type="text" id="fc" onFocus="cargarcampos3();" size="10" value="<? echo  $fecha; ?>" /> </td>

 			<td><input type="submit" name="Submit3" value="Buscar" onClick="  datoscierresphhi();" /></td>

 		</tr>
 	</table>
 	<table border="0">
 		<tr>
 			<div id='lganadores' title="">
 				<?
					$tipo = 4;
					$arrayIDCN = array();
					$arrayNAME = array();
					$resulthip = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where fecha='" . $fecha . "'");
					if (mysqli_num_rows($resulthip) != 0) :
						while ($rowhi = mysqli_fetch_array($resulthip)) {

							$resultNomhip = mysqli_query($GLOBALS['link'], "SELECT * FROM _hipodromoshi where _idhipo=" . $rowhi['IDhipo']);
							$rowhiN = mysqli_fetch_array($resultNomhip);

							$idcn = $rowhi['IDCN'];
							$arrayIDCN[] = $idcn;
							$arrayNAME[] = $rowhiN['Descripcion'];
							echo ' <td><div id="' . $idcn . '" style="background:#036;height:1000px;"><span style="background:#036; color:#FFF; font-size:16px">HIPODROMO:' . $rowhiN['Descripcion'] . '</span>';

							include "cierresph2hi.php";
							//echo "</div>&nbsp;</td>";	 
						}

					endif;

					?>
 			</div>
 		</tr>
 	</table>

 </div>

 </div>
 <div id='ver'> </div>


 <script>
 	var idcn = '<? echo implode(',', $arrayIDCN); ?>';
 	var NameHipo = '<? echo implode(',', $arrayNAME); ?>';
 	aidcn = idcn.split(',');
 	aNameHipo = NameHipo.split(',');

 	function clicktoolBar(id) {
 		switch (id) {
 			case "Cerrar_":
 				dhxWins1.window("w1").close();
 				break;
 			case "ImprimiR_":
 				ImprimirReporte2('reportedeventashipodromo-2.php');
 				break;

 				//"ImprimirReporte2('reportedeventashipodromo-2.php');"
 		}
 	}

 	dhxWins1 = new dhtmlXWindows();
 	dhxWins1.setImagePath("codebase/imgs/");
 	for (i = 0; i <= aidcn.length - 1; i++) {

 		dhxWins1.createWindow("w" + i, 350, 270 + (i * 20), 400, 600);
 		dhxWins1.window("w" + i).setText(aNameHipo[i]);
 		dhxWins1.window("w" + i).attachObject(aidcn[i]);
 		dhxWins1.window("w" + i).button('close').hide();
 		dhxWins1.window("w" + i).button('minmax1').hide();
 		dhxWins1.window("w" + i).button('minmax2').hide();
 		dhxWins1.window("w" + i).button('park').hide();
 		dhxWins1.window("w" + i).denyResize();
 		//dhxWins1.window("w1").denyMove();
 		dhxWins1.setSkin('dhx_black');
 	}
 	totalventas = aidcn.length;
 	// var bar = w1.attachToolbar();
 	//bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
 	//bar.addButton("ImprimiR_", 1, "Imprimir Reporte", "images/print.gif", "images/print.gif"); 
 	//bar.addButton("Imprimit_", 2, "Imprimir Ticket", "images/print_dis.gif", "images/print_dis.gif"); 
 	//bar.attachEvent("onClick", clicktoolBar);

 	/*cal1 = new dhtmlxCalendarObject('fc1');
 	cal1.setOnClickHandler(mSelectDate);
 	
 	cal2 = new dhtmlxCalendarObject('fc2');
 	cal2.setOnClickHandler(mSelectDate2);*/
 </script>

 </script>