<style type="text/css">
	html {
		--back-view-main: #b0b0b0
	}

	.Estilo1 {
		color: #000
	}

	.box-view-serial {
		padding: 4px;
		border-radius: 6px;
		background: var(--back-view-main);
	}

	.view_serials_list_pv {
		background: var(--back-view-main);
		cursor: pointer;
		height: 37px;

	}

	.view_serials_list_pv:nth-child(even) {
		background: #628ca9;
	}

	.view_serials_list_pv:hover {
		background: #ffc107;
	}

	.view-title-pv {
		text-align: center;
		font-size: 15px;
		color: #000;
	}

	.view-field-pv {
		font-size: 13px;
		color: #fff;
		margin-top: 5px;
	}

	.active-delete-tk {
		background-image: url(./media/icons8-eliminar-16.png);
		height: 13px;
		width: 16px;
		background-repeat: no-repeat;
		display: inline-block;
		margin-left: -15px;
	}
</style>
<div class="box-view-serial" style="width:900px">
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>

				<div id='tpg2' class='tabPanelGroup'>
					<div class='tabGroup'>
						<a href='#tpg21' class='tabDefault' onclick="$('printer2').innerHTML='';">Ticket
							Impresos</a><span class='linkDelim'>&nbsp;|&nbsp;</span>
						<a href='#tpg22' class='tabDefault' onclick="$('printer2').innerHTML='';">Ticket
							Premiados</a><span class='linkDelim'>&nbsp;|&nbsp;</span>
					</div>
					<div id='tpg21' style="margin-left: 1px;" class='tabPanel'>


						<table width="626" border="0" cellspacing="0">
							<tr bgcolor="#0066FF">
								<th bgcolor="#FFFFFF">
									<h4 class="view-title-pv">Serial</h4>
								</th>
								<th bgcolor="#FFFFFF">
									<h4 class="view-title-pv">Hora</h4>
								</th>
								<th bgcolor="#FFFFFF">
									<h4 class="view-title-pv">Apuesta</h4>
								</th>
								<th bgcolor="#FFFFFF">
									<h4 class="view-title-pv">A Cobrar</h4>
								</th>
								<th bgcolor="#FFFFFF">
									<h4 class="view-title-pv">Acciones</h4>
								</th>
								<th bgcolor="#FFFFFF">
								</th>
							</tr>

							<?php


							if (isset($_REQUEST['fc1'])) :
								require('prc_php.php');
								$link = Connection::getInstance();
								$fc = $_REQUEST["fc1"];
								$idc = $_REQUEST["idc"];
								$resultj = mysqli_query($link, "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
								if (mysqli_num_rows($resultj) != 0) :
									$rowj = mysqli_fetch_array($resultj);
									$idj = $rowj["IDJ"];
								else :
									$idj = 0;
									$idc = '';
								endif;
							endif;
							$listado = array();
							$iserial = array();
							$whatsapp = array();
							$result = mysqli_query($link, "SELECT * FROM _tjugadabb where IDJ=" . $idj . " and IDC='" . $idc . "'");
							while ($Row = mysqli_fetch_array($result)) {
								$listado[] = $Row;
								$iserial[] = $Row['serial'];
							}


							$conexion = mysqli_connect($server, $user, $clv);
							mysqli_select_db($conexion, $db);


							$i = 1;
							foreach ($listado as $clave => $Row) {

								if (vescrute($Row['serial']) == false || $Row['activo'] == 2) :
									$onclick = ' onclick="opcionVerTk(' . $Row['serial'] . ',1);"';
									echo '<tr  ' . $onclick . ' class="view_serials_list_pv" >';
									$eliminad = $Row['activo'] == 1 ? '<div  id="bt' . $Row['serial'] . 'o"  ></div>' : '<div  class="active-delete-tk" ></div>';
									echo '<th ><div align="center" class="view-field-pv">' . $eliminad  . $Row['serial'] . '</div></th>';
									echo '<th ><div align="center" class="view-field-pv">' . $Row['hora'] . '</div></th>';
									echo '<th ><div  align="center" class="view-field-pv">' . $Row['ap'] . '</div></th>';
									echo '<th ><div  align="center" class="view-field-pv">' . $Row['acobrar'] . '</div></th>';
									// if (isset($whatsapp[$Row['serial']])) :
									// 	//if ($whatsapp[$Row['serial']]['err']==0):
									// 	if ($whatsapp[$Row['serial']]['ENV'] == 0) : $enviado = 'checkmark.png';
									// 	else : $enviado = 'doubletick.png';
									// 	endif;
									// 	// echo '<th ><div  align="right" class="view-field-pv">'.$whatsapp[$Row['serial']]['telefono'].'<img src="media/'.$enviado.'" height="16" width="16" /></div></th>';
									// 	//else:
									// 	//	echo substr($whatsapp[$Row['serial']]['telefono'],-10);
									// 	echo '<th ><div  align="right" class="view-field-pv"><input type="text" id="tele-' . $Row['serial'] . '" size="10" value="' . substr($whatsapp[$Row['serial']]['telefono'], -10) . '"/><img src="media/' . $enviado . '" height="16" width="16" /></div></th>';
									// //endif;
									// else :
									// 	echo '<th ><div  align="right" class="view-field-pv"></div></th>';
									// endif;


									if ($Row['activo'] == 1) :
										// if (isset($whatsapp[$Row['serial']])) :
										// 	echo '<th ><img id="bt' . $Row['serial'] . '" src="media/icons8-basura-16.png"  title="Eliminar"  onclick="eliminarticketbb(' . $Row['serial'] . ',this,0);"/><img id="bt' . $Row['serial'] . 'v" src="media/icons8-enviar-a-la-impresora-16.png"  height="24" width="24" title="Enviar" onclick="ReSendMsgtk(' . $Row['serial'] . ',1)" /></th>';
										// else :
										echo '<th ><img id="bt' . $Row['serial'] . '" src="media/icons8-basura-24.png"  title="Eliminar"  onclick="eliminarticketbb(' . $Row['serial'] . ',this,0);"/><img id="bt' . $Row['serial'] . 'v" src="media/icons8-imprimir-24.png"  height="24" width="24" title="Imprimir" onclick="reimprimirticketbb(' . $Row['serial'] . ',1)" /></th>';
									// endif;
									else :
										echo '<th ></th>';
									endif;
									echo '<th ></th>';

								endif;
							}
							?>
						</table>
					</div>

					<div id='tpg22' class='tabPanel'>
						<table width="627" border="0" cellspacing="0">
							<tr bgcolor="#0066FF">
								<th bgcolor="#FFFFFF" width="5">
									<h4 class="view-title-pv">Pagar</h4>
								</th>
								<th bgcolor="#FFFFFF">
									<h4 class="view-title-pv">Serial</h4>
								</th>
								<th bgcolor="#FFFFFF">
									<h4 class="view-title-pv">Hora</h4>
								</th>
								<th bgcolor="#FFFFFF">
									<h4 class="view-title-pv">Apuesta</h4>
								</th>
								<th bgcolor="#FFFFFF">
									<h4 class="view-title-pv">A Cobrar</h4>
								</th>
								<th bgcolor="#FFFFFF">
									<h4 class="view-title-pv">Serial Elec.</h4>
								</th>
								<th bgcolor="#FFFFFF">
									<h4 class="view-title-pv">Acciones</h4>
								</th>
							</tr>

							<?php
							$i = 1;
							foreach ($listado as $clave => $Row) {
								if (vescrute($Row['serial']) == true && $Row['activo'] == 1) :

									echo '<tr class="view_serials_list_pv"  onclick="opcionVerTk(' . $Row['serial'] . ',2);">';
									$extpagado = $Row['pagado'] == 1 ? 'checked disabled' : ' onclick="return sverifacion(event,' . $Row['serial'] . ');"';
									echo '<th ><input class="checkbox-resul" style="margin: 6px;" id="chek' . $Row['serial'] . '" type="checkbox" value="" ' . $extpagado . '/></th>';
									echo '<th ><div align="center" class="view-field-pv">' . $Row['serial'] . '</div></th>';
									echo '<th ><div align="center" class="view-field-pv">' . $Row['hora'] . '</div></th>';
									echo '<th ><div  align="center" class="view-field-pv">' . $Row['ap'] . '</div></th>';
									if ($Row['pagado'] == 1) :
										echo '<th ><div id="mt' . $Row['serial'] . '"  align="center" class="view-field-pv">' . $Row['acobrar'] . '</div></th>';
										echo '<th ><div id="se' . $Row['serial'] . '" align="center" class="view-field-pv">' . $Row['se'] . '</div></th>';
									else :
										echo '<th ><div id="mt' . $Row['serial'] . '"  align="center" lang="' . $Row['acobrar'] . '" class="view-field-pv">*******</div></th>';
										echo '<th ><div id="se' . $Row['serial'] . '" align="center" class="view-field-pv">************</div></th>';
									endif;
									echo '<th class="view-field-pv" ><img id="bt' . $Row['serial'] . 'v" src="media/icons8-imprimir-24.png" height="24" width="24" title="Imprimir" onclick="reimprimirticketbb(' . $Row['serial'] . ',2)" /></th>';

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
<script>
	new xTabPanelGroup('tpg2', 630, 500, 40, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
	cargarcampos7();
</script>