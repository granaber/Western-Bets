 <?php

	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();
	?>
 <style type="text/css">
 	<!--
 	.Estilo8 {
 		color: #999999
 	}
 	-->
 </style>


 <div id="box10" style="width:520px">
 	<table border="0">
 		<tr>
 			<th scope="col">

 				<div id="TabbedPanels1" class="TabbedPanels" style="background-color:#CCCCCC">
 					<ul class="TabbedPanelsTabGroup">

 						<?
							$bgclo = array('', '#3366FF', '#3399FF', '#33CCFF', '#339900', '#33CC00', '#33FF00', '#999999', '#3366FF', '#3399FF', '#33CCFF', '#339900', '#33CC00', '#33FF00', '#999999');
							$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd Order by Grupo");

							while ($Row = mysqli_fetch_array($resultj)) {
								echo '<li class="TabbedPanelsTab" style="background-color:' . $bgclo[$Row['Grupo']] . '" stabindex="0">' . $Row['Descripcion'] . '&nbsp;&nbsp; <img  src="media/' . $Row['imagen'] . '"  height="32" width="32" /></li>';
							}
							?>

 					</ul>


 					<div class="TabbedPanelsContentGroup">
 						<?php
							$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd Order by Grupo");
							while ($Row = mysqli_fetch_array($resultj)) {
								$ope = "'" . 'listadeequipos-1.php?grupo_nw=' . $Row['Grupo'] . "'";
								echo '<div class="TabbedPanelsContent">';
								echo '<table   width="500" border="0" cellspacing="0" >';
								echo '  <tr bgcolor="' . $bgclo[$Row['Grupo']] . '" ><th colspan="5" ><div align="right"><input name="" type="button" value="Incluir Equipo" onclick="opmenu(' . $ope . ');"/></div></th></tr>';
								echo '  <tr bgcolor="' . $bgclo[$Row['Grupo']] . '" >';
								echo '  <th   bgcolor="' . $bgclo[$Row['Grupo']] . '" width="5" ></th>';
								echo '  <th width="42"   bgcolor="' . $bgclo[$Row['Grupo']] . '" >No.Equipo</th>';
								echo '  <th width="200"  bgcolor="' . $bgclo[$Row['Grupo']] . '">Descripcion</th>';
								echo '  <th width="10"  bgcolor="' . $bgclo[$Row['Grupo']] . '">Siglas</th>';
								echo '  <th width="10"  bgcolor="' . $bgclo[$Row['Grupo']] . '">Logo</th>';
								echo '  </tr>   ';
								$resulte = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where (Grupo=" . $Row['Grupo'] . " or Grupo1=" . $Row['Grupo'] . " or Grupo2=" . $Row['Grupo'] . ") order by IDE");
								$i = 1;
								while ($Row2 = mysqli_fetch_array($resulte)) {
									if ($i == 1) :
										$bgh = "nom1";
										$i = 2;
									else :
										$bgh = "nom2";
										$i = 1;
									endif;
									echo '  <tr  id="la' . $Row2['IDE'] . '-' . $Row['Grupo'] . '" class="' . $bgh . '" onMouseOver="browsell(this,1,5);"   onMouseOut="browsell(this,2,5);" ondblclick="verlista4(' . $Row2['IDE'] . ');" >';
									echo '  <th  id="la' . $Row2['IDE'] . '-' . $Row['Grupo'] . '1" class="' . $bgh . '" width="5" ><img  src="media/esact.png" height="16" width="16"  /></th>';
									echo '  <th  id="la' . $Row2['IDE'] . '-' . $Row['Grupo'] . '2" width="42"   class="' . $bgh . '" >' . $Row2['IDE'] . '</th>';
									echo '  <th  id="la' . $Row2['IDE'] . '-' . $Row['Grupo'] . '3" width="200"  class="' . $bgh . '">' . $Row2['Descripcion'] . '</th>';
									echo '  <th  id="la' . $Row2['IDE'] . '-' . $Row['Grupo'] . '4" width="10"  class="' . $bgh . '">' . $Row2['Siglas'] . '</th>';
									echo '  <th  id="la' . $Row2['IDE'] . '-' . $Row['Grupo'] . '5" width="10"  class="' . $bgh . '"><img  src="images/logo/eq' . $Row2['IDE'] . '.png?' . md5(time()) . '"  height="32" width="48" /></th>';
									echo '  </tr>   ';
								}
								echo '</table>';
								echo '</div>';
							}
							?>


 					</div>
 				</div>
 			</th>
 		</tr>
 	</table>
 </div>




 <script type="text/javascript">
 	var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
 	Nifty('div#box10', 'big');
 </script>
 <?php
	/* f ($i==1):
											$bgh="nom1";
											$i=2;
										else:
											$bgh="nom2";
											$i=1;
										endif;	
	                                if ($Row['Estatus']==1):
									 $tde="media/esact.png";
									else:
									 $tde="media/esiact.png";
									endif; 
									$tb="'_tbjuegodd'";
									$grpu="'IDDD:".$Row['IDDD']."'";
									
									echo '<tr  id="la'.$Row['IDDD'].'" class="'.$bgh.'"  ondblclick="verlista3('.$Row['IDDD'].');"  onMouseOver="browsell(this,1,5);"   onMouseOut="browsell(this,2,5);" >';
									
									echo '<th  id="la'.$Row['IDDD'].'1" class="'.$bgh.'"  ><div  align="right"  > <img src="'.$tde.'" height="16" width="16" onclick="caet(this,'.$tb.','.$grpu.');"/></div></th>';
									
									echo '<th id="la'.$Row['IDDD'].'2" class="'.$bgh.'"  ><div align="center" >'.$Row['IDDD'].'</div></th>';
        							echo '<th id="la'.$Row['IDDD'].'3"class="'.$bgh.'"  ><div align="left" >'.$Row['Descripcion'].'</div></th>';
									echo '<th id="la'.$Row['IDDD'].'4"class="'.$bgh.'"  ><div align="left" >'.$Row['Desform'].'</div></th>';
									echo '<th id="la'.$Row['IDDD'].'5"class="'.$bgh.'"  ><div  align="left" >';
             
									echo '<img  src="media/'.$Row['imagen'].'"  height="32" width="32"  onmouseover="Pop(this,-50,-25,200,200,10,null);" onmouseout="Revert(this,10,null);"/>'.$Row['Desjuego'].'</div></th></tr>';
 */
	?>