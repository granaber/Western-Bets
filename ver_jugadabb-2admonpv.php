<style type="text/css">
	<!--
	.Estilo1 {
		color: #FFFFFF
	}
	-->
</style>
<div id="box4" style="width:1000px">
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<div id='tpg2' class='tabPanelGroup'>
					<div class='tabGroup'>
						<a href='#tpg21' class='tabDefault'>Ticket Impresos</a><span class='linkDelim'>&nbsp;|&nbsp;</span>
						<a href='#tpg22' class='tabDefault' onclick="$('printer2').innerHTML='';">Ticket Premiados</a><span class='linkDelim'>&nbsp;|&nbsp;</span>
					</div>
					<div id='tpg21' class='tabPanel'>


						<table width="720" border="0" cellspacing="0">
							<tr bgcolor="#0066FF">
								<th bgcolor="#FFFFFF">
									<div></div>
								</th>
								<th bgcolor="#FFFFFF">
									<div align="center">Serial</div>
								</th>
								<th bgcolor="#FFFFFF">Hora</th>
								<th bgcolor="#FFFFFF">Apuesta</th>
								<th bgcolor="#FFFFFF">A Cobrar</th>
								<th bgcolor="#FFFFFF">Apostador</th>
								<th bgcolor="#FFFFFF">Terminal</th>
								<th width="141" bgcolor="#FFFFFF"></th>
							</tr>

							<?php


							if (isset($_REQUEST['fc1'])) :
								require('prc_php.php');
								$GLOBALS['link'] = Connection::getInstance();
								$fc = $_REQUEST["fc1"];
								$idc = $_REQUEST["idc"];
								$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
								if (mysqli_num_rows($resultj) != 0) :
									$rowj = mysqli_fetch_array($resultj);
									$idj = $rowj["IDJ"];
								else :
									$idj = 0;
								endif;

							endif;

							if (isset($idj)) :
								$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb where IDJ=" . $idj . "  and IDC='" . $idc . "' Order by Serial");
								$insslq = "SELECT * FROM _tjugadabb where IDJ=" . $idj . "  and IDC='" . $idc . "' Order by Serial";
							endif;

							if (isset($_REQUEST['serial'])) :
								require('prc_php.php');
								$GLOBALS['link'] = Connection::getInstance();
								$serial = $_REQUEST["serial"];
								$idc = $_REQUEST["idc"];
								$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb where serial=" . $serial . "  and IDC='" . $idc . "' Order by Serial");
								$insslq = "SELECT * FROM _tjugadabb where serial=" . $serial . "  and IDC='" . $idc . "' Order by Serial";
							endif;

							$i = 1;

							while ($Row = mysqli_fetch_array($result)) {

								if (vescrute($Row['serial']) == false) :
									if ($i == 1) :
										$bgh = "nom1";
										$i = 2;
									else :
										$bgh = "nom2";
										$i = 1;
									endif;
									echo '<tr id="la' . $Row['serial'] . '" class="' . $bgh . '"  onMouseOver="browsell1(this,1,11);"   onMouseOut="browsell1(this,2,11);" class="' . $bgh . '">';

									if ($Row['activo'] == 1) :
										echo '<th  id="la' . $Row['serial'] . '1" class="' . $bgh . '"><div  align="right"  > <img id="bt' . $Row['serial'] . 'o" src="media/esact.png" height="16" width="16" onclick="opcionVerTk(' . $Row['serial'] . ',1);" /></div></th>';
									else :
										echo '<th id="la' . $Row['serial'] . '1" class="' . $bgh . '"><div  align="right"><img id="bt' . $Row['serial'] . 'o" src="media/esiact.png" height="16" width="16" onclick="opcionVerTk(' . $Row['serial'] . ');" /></div></th>';
									endif;
									echo '<th id="la' . $Row['serial'] . '2" class="' . $bgh . '"><div align="center" class="EstiloCC">' . $Row['serial'] . '</div></th>';
									echo '<th id="la' . $Row['serial'] . '3" class="' . $bgh . '"><div align="center" class="EstiloCC">' . $Row['hora'] . '</div></th>';


									echo '<th id="la' . $Row['serial'] . '4" class="' . $bgh . '"><div  align="right" class="EstiloCC">' . number_format($Row['ap'], 2, ',', '.') . '</div></th>';
									echo '<th id="la' . $Row['serial'] . '5" class="' . $bgh . '"><div  align="right" class="EstiloCC">' . number_format($Row['acobrar'], 2, ',', '.') . '</div></th>';
									echo '<th id="la' . $Row['serial'] . '6" class="' . $bgh . '"><div  align="right" class="EstiloCC">' . $Row['apostador'] . '</div></th>';
									echo '<th id="la' . $Row['serial'] . '7" class="' . $bgh . '"><div  align="right" class="EstiloCC">' . $Row['terminal'] . '</div></th>';
									if ($Row['activo'] == 1) :
										echo '<th id="la' . $Row['serial'] . '8" class="' . $bgh . '""><img id="bt' . $Row['serial'] . '" src="media/borrar2.png"  title="Eliminar"  onclick="eliminarticketbb(' . $Row['serial'] . ',this,0);"/><img id="bt' . $Row['serial'] . 'v" src="media/impresora.png"  height="24" width="24" title="Imprimir" onclick="reimprimirticketbb(' . $Row['serial'] . ')" /></th>';
									else :
										echo '<th id="la' . $Row['serial'] . '8" class="' . $bgh . '"></th>';
									endif;
									echo ' </tr>';
								endif;
							}
							?>
						</table>
					</div>

					<div id='tpg22' class='tabPanel'>
						<table width="625" border="0" cellspacing="0">
							<tr bgcolor="#0066FF">
								<th bgcolor="#FFFFFF" width="5" o>
									<div></div>
								</th>
								<th bgcolor="#FFFFFF" width="5" o>Pagar</th>
								<th bgcolor="#FFFFFF">
									<div align="center">Serial</div>
								</th>
								<th bgcolor="#FFFFFF">Hora</th>
								<th bgcolor="#FFFFFF">Apuesta</th>
								<th bgcolor="#FFFFFF">A Cobrar</th>
								<th bgcolor="#FFFFFF">Serial Elec.</th>
								<th bgcolor="#FFFFFF"></th>
							</tr>

							<?php
							$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb where IDJ=" . $idj . " and IDC='" . $idc . "'");
							$i = 1;
							while ($Row = mysqli_fetch_array($result)) {
								if (vescrute($Row['serial']) == true && $Row['activo'] == 1) :

									if ($i == 1) :
										$bgh = "#006699";
										$i = 2;
									else :
										$bgh = "#0099FF";
										$i = 1;
									endif;

									echo '<tr bgcolor="' . $bgh . '" >';
									if ($Row['pagado'] == 1) :
										echo '<th ><input id="chek' . $Row['serial'] . '" type="checkbox" value="" checked disabled/></th>';
									else :
										echo '<th ><input id="chek' . $Row['serial'] . '" type="checkbox" value="" onclick="return sverifacion(event,' . $Row['serial'] . ');"/></th>';
									endif;
									if ($Row['activo'] == 1) :
										echo '<th ><div  align="right"  > <img id="bt' . $Row['serial'] . 'o" src="media/esact.png" height="16" width="16" onclick="opcionVerTk(' . $Row['serial'] . ',2);" /></div></th>';
									else :
										echo '<th ><div  align="right"><img src="media/esiact.png" height="16" width="16" /></div></th>';
									endif;
									echo '<th ><div align="center" class="EstiloCC">' . $Row['serial'] . '</div></th>';
									echo '<th ><div align="center" class="EstiloCC">' . $Row['hora'] . '</div></th>';
									echo '<th ><div  align="right" class="EstiloCC">' . $Row['ap'] . '</div></th>';

									//echo '<th ><div  align="right" class="EstiloCC">'.$Row['apostador'].'</div></th>';								
									if ($Row['pagado'] == 1) :
										echo '<th ><div id="mt' . $Row['serial'] . '"  align="right" class="EstiloCC">' . $Row['acobrar'] . '</div></th>';
										echo '<th ><div id="se' . $Row['serial'] . '" align="right" class="EstiloCC">' . $Row['se'] . '</div></th>';
									else :
										echo '<th ><div id="mt' . $Row['serial'] . '"  align="right" lang="' . $Row['acobrar'] . '" class="EstiloCC">*******</div></th>';
										echo '<th ><div id="se' . $Row['serial'] . '" align="right" class="EstiloCC">************</div></th>';
									endif;
									if ($Row['activo'] == 1) :
										echo '<th ><img id="bt' . $Row['serial'] . 'v" src="media/impresora.png"  height="24" width="24" title="Imprimir" onclick="reimprimirticketbb(' . $Row['serial'] . ',2)" /></th>';
									else :
										echo '<th ></th>';
									endif;
									echo '</tr>';
								endif;
							}
							?>
						</table>
					</div>

				</div>
			</td>
			<td width="50px"></td>
			<td>
				<div id="verticket">
					<?php include('ticketbb-2.php'); ?>
				</div>
			</td>
		</tr>
	</table>
</div>
<p>&nbsp;</p>
<div id="box6">
	<table width="610" border="0">
		<tr>
			<th width="600" colspan="3" scope="col"><span class="Estilo1"><img src="media/esact.png" width="32" height="32" />Ticket Activo</span> <span class="Estilo1"><img src="media/esiact.png" width="32" height="32" />Ticket Eliminado <img src="media/borrar2.png" width="32" height="32" />Eliminar Ticket <img src="media/impresora.png" width="32" height="32" /> Imprimir Ticket</span></th>
		</tr>
	</table>
</div>

<samp id="inssql" lang="<?php echo $insslq; ?>" style="display:none"></samp>


<script>
	cargarcampos_v10();
	Nifty('div#box4', 'big');
	Nifty('div#box6', 'big');
	Nifty('div#box8', 'big');
	Nifty('div#box7', 'big');
	Nifty('div#box9', 'big');
	new xTabPanelGroup('tpg2', 725, 350, 40, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
</script>