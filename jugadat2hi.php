<head>
	<?php
	date_default_timezone_set('America/Caracas');
	$tj = $_GET['tj'];
	$idc = $_GET['idc'];
	$hipodromosArray = array();
	$codeHipo = array();
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();
	$listadeIdcnRech = array();
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegoshi where IDJug=" . $tj);
	$row = mysqli_fetch_array($result);
	if ($row["Tandas"] == 2) :
		$tex = "Tanda";
		$tex2 = 'Carrera';
	else :
		$tex = "Carrera";
		$tex2 = 'Puesto';
	endif;
	$inicioCarr = 0;
	$apm = $row['ApuestaMinima'];
	$idcn = 0;
	$config = 0;
	$cantcb = 0;
	$retira = 0;
	$_xc = array();
	$cantida_Carrera = $row["CantidadCarr"];
	$Tandas = $row["Tandas"];
	$Compartir = $row["Compartir"];
	$se_Activo = true;
	$masde = false;
	$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
	$cantidacng = mysqli_num_rows($result3);
	?>
	<style type="text/css">
		<!--
		.Estilo1 {
			font-family: Arial, Helvetica, sans-serif;
			color: #FFFFFF;
			font-size: 14px;
		}

		.dhx_toolbar_base_dhx_skyblue {
			height: 80px !important;
			background-image: url(common/toolbar33/dhxtoolbar_bg_33px.gif);
		}
		-->
	</style>
</head>
<?php
$activar = 0;
$Tandas = $row["Tandas"];
$pric = -1;
if ($row["Tandas"] == 1) :
	while ($activar == 0) {
		configuracionLX();
		$listadeIdcnRech[] = $idcn;
		if (count($listadeIdcnRech) > $cantidacng) :

			$activar = 0;
			break;
		endif;
		for ($r = 0; $r <= count($_xc) - 2; $r++) {
			$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where  IDJug=" . $tj . " and ct=" . $_xc[$r] . " and IDCN=" . $idcn);
			if (mysqli_num_rows($result4) == 0) :
				$activar = $_xc[$r];
				if ($pric == -1) :
					$pric = $r;
				endif;
			endif;
		}
	}
else :
	while ($activar == 0) {
		configuracionLX();
		$listadeIdcnRech[] = $idcn;
		if (count($listadeIdcnRech) > $cantidacng) :
			$activar = 0;
			break;
		endif;

		$ct = 0;
		$tt = 1;


		for ($r = 0; $r <= count($_xc) - 1; $r++) {
			$ct++;

			if ($ct == $cantida_Carrera) :
				$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where  IDJug=" . $tj . " and ct=" . $tt . " and IDCN=" . $idcn);
				//	echo ("SELECT * FROM _cierrehi where  IDJug=".$tj." and ct=".$tt." and IDCN=".$idcn.'<br>'  );
				if (mysqli_num_rows($result4) == 0) :
					$activar = $tt;
					$tt++;
					if ($pric == -1) :
						$pric = $ct;
					endif;
				else :
					$tt++;
				endif;
				$ct = 0;
			endif;
		}
	}
endif;


if ($activar != 0) : ?>
	<span id='TIDCN' lang="<? echo $idcn; ?>"></span>
	<div id="box_j" style="background:<?php echo $row["Color"] ?>; height:1000px">

		<a id="apm" lang="<?php echo $apm; ?>"></a>

		<table width="590" border="0" cellpadding="0" cellspacing="1">
			<tr>
				<th colspan="19" align="left" bgcolor="<?php echo $row["Color"] ?>" scope="col"><span id='tj' title="<?php echo $tj; ?>" style="color: #FFFFFF; font-size:18px"><?php echo $row["Descrip"] ?></span><br />
					<?php /*if ($masde==true): 
echo " <div  style='color: #FFCC00; font-size:12px'> Seleccione la Jornada: <select  size='1' id='jndv'  onChange='cambiodejornadahi(".$tj.",".$row["Tandas"].",".$activar.");' >";
                  												$result4 = mysqli_query($GLOBALS['link'],"SELECT _tconfjornadahi.fecha,_tconfjornadahi.IDCN,_hipodromoshi.siglas FROM _tconfjornadahi,_hipodromoshi where _tconfjornadahi.IDhipo=_hipodromoshi._IDhipo and _hipodromoshi.estatus=1 and fecha='".date("d/n/Y")."' order by idcn " ); 
								    							while($row4 = mysqli_fetch_array($result4)) {
																	 $Selec="";
																	 if ($row4["IDCN"]==$idcn):
																	 	 $Selec="selected='selected'";
																	 endif;
																	echo "<option value='".$row4["IDCN"]."' ".$Selec.">".$row4["fecha"].'-'.$row4["siglas"]."</option>";
										} 
										echo "</select></div>";
										endif;*/

					$result4 = mysqli_query($GLOBALS['link'], "SELECT _tconfjornadahi.fecha,_tconfjornadahi.IDCN,_hipodromoshi.siglas,_hipodromoshi.Descripcion FROM _tconfjornadahi,_hipodromoshi where _tconfjornadahi.IDhipo=_hipodromoshi._IDhipo and _hipodromoshi.estatus=1 and fecha='" . date("d/n/Y") . "' order by idcn ");
					while ($row4 = mysqli_fetch_array($result4)) {
						$hipodromosArray[] = $row4["Descripcion"];
						$codeHipo[] = $row4["IDCN"];
					}
					?></th>
			</tr>
			<tr bgcolor="<?php echo $row["Color"] ?>">
				<th colspan="19" align="left" valign="middle" scope="col"><?php if ($idc == '-2' || $idc == '-1') : ?> Concesi.:
						<input id="cons" type="text" size="10" maxlength="10" onkeyup="this.value = this.value.toUpperCase();validar_con_ju(event,1);pulsart(event,'nom');" onfocus="$('nom').disabled='disabled';$('valida').disabled='disabled';$('ejem').disabled='disabled';$('carre_v').disabled='disabled';$('valida').value='1';" onchange="" />


						<img id="imgcons" src="media/ee.ico" style=" display:none" /> Nombre:
						<input id="nom" onKeyUp="validar_con_ju(event,2);pulsart(event,'org1');" onkeypress="this.value = this.value.toUpperCase();" disabled="disabled" /> <img id="imgnom" src="media/ee.ico" style=" display:none" />
						Origen:
						<input type="radio" name="radio" id="org1" value="1" checked="checked" onKeyUp="pulsart(event,'valida');" />
						Tel
						<input type="radio" name="radio" id="org2" value="2" onKeyUp="pulsart(event,'valida');" />
						Bol
						<input type="radio" name="radio" id="org3" value="3" onKeyUp="pulsart(event,'valida');" />
						Fax<?php endif; ?>
				</th>
			</tr>
			<tr bgcolor="<?php echo $row["Color"] ?>">
				<th colspan="8" align="left" valign="middle" scope="col"><span style="color: #FFCC00"><strong>N.Ticket:</strong> <span id='numet' title="" class="Estilo12"> </span>
						</p>
					</span></th>
				<th colspan="8" align="left" valign="middle" scope="col"><span style="color:#FFF; font-size:16px">Faltan:</span><span style="color: #FC0; font-size:16px" id="minrestan">min</span></th>
				<th id="multi" colspan="<?php echo $row["EjemxCarr"] - 13; ?>" align="right" width="30px" valign="middle" scope="col" title="<?php echo $row["Multip"]; ?>">
					<div align="right" style="color: #FFCC00; font-size:16px">X <?php echo $row["Multip"]; ?></div>
				</th>
				<!--<th align="center" valign="middle" scope="col"><div align="center" class="Estilo41"><?php if (!($idc == -2 || $idc == -1)) : ?>
                  <input type="submit" name="button" id="button" value="Reimprimir"   onclick="_reimpresionticket(<?php echo $tj; ?>);"/><?php endif; ?>
              </div></th>-->
			</tr>
			<tr>
				<th width="144" rowspan="<?php echo $row["CantidadCarr"]; ?>" bgcolor="<?php echo $row["Color"] ?>" scope="col">
					<p id="carr" class="Estilo40" title="<?php echo $row["CantidadCarr"]; ?>"><?php echo $tex;    ?>:</p>
					<label id="inclcarr">
						<? include('jugadat2-2hi.php'); ?>
					</label>
					<p title="<?php echo $row["CantidadCarr"]; ?>"><? echo $tex2; ?>:</p>
					<label>
						<input type="text" id="valida" value="1" onkeyup="pulsarhi(event,1,2,<?php echo $row["calculo"]; ?>)" <?php if ($idc == -2 || $idc == -1) : 	echo 'disabled="disabled"';
																																else : echo '';
																																endif; ?> />
					</label>
					<p id="ejemp" class="Estilo40" title="<?php echo $row["EjemxCarr"]; ?>">Ejemplar:</p>
					<label>
						<input type="text" id="ejem" onkeyup="pulsarhi(event,2,2,<?php echo $row["calculo"]; ?>)" <?php if ($idc == -2 || $idc == -1) : 	echo 'disabled="disabled"';
																													else : echo '';
																													endif; ?> />
						<br />
						<span style="color:#000000"> Monto:</span><br />
						<br />
					</label>
					<input id="idmonto" type="text" onkeyup="pulsarhi(event,3,2,<?php echo $row["calculo"]; ?>)" disabled="disabled" />
					</p>
					</p>
					<label> </label>
				</th>

				<?php
				//
				if ($row["Tandas"] == 1) :
					if ($pric != -1) :
						$carrr = $_xc[$pric] - 1;
						$cejem = $cantcb[$carrr];
					else :
						$activo1 = 0;
						for ($k = 0; $k <= $row["CantidadCarr"] + 1; $k++) {
							$_xc[$k] = $k + 1;
							$cantcb[$k] = 0;
							$retira[$k] = 0;
						}
						$carrr = 0;
						$cejem = $cantcb[$carrr];
					endif;
				endif;



				for ($i = 1; $i <= $row["CantidadCarr"]; $i++) {
					if ($row["Tandas"] == 2) :


						if ((count($_xc) - 1) != 0) :
							$cejem = $cantcb[$_xc[$pric] - 1];
							$retirado = explode("-", $retira[$_xc[$pric] - 1]);
							$pric++;
						else :
							$cejem = 0;
							$retirado[0] = 0;
						endif;

					else :
						$retirado = explode("-", $retira[$carrr]);
					endif;

					if ($i != 1) :
						echo '<tr>';
					endif;
					if ($row["Tandas"] == 2) :
						echo '<th width="17" scope="col" bgcolor=' . $row["Color"] . ' title="' . $cejem . '"><span  id="car' . $i . '" style="color:#000000; font-size:16px">' . $_xc[$pric - 1] . '.-</span></th>';
						if ($inicioCarr == 0) : $inicioCarr = $_xc[$pric - 1];
						endif;
					else :
						echo '<th width="17" scope="col" bgcolor=' . $row["Color"] . ' title="' . $cejem . '"><span style="color:#000000; font-size:16px">' . $i . '.-</span></th>';
					// if ( $inicioCarr==0): $inicioCarr=$i; endif;
					endif;
					echo '<th width="6" bordercolor="#ffffff" bgcolor="#FFFFFF" scope="col"><img src="media/marcar_todos_blanco.bmp" onclick="celdasicons(' . $i . ',' . $row["calculo"] . ');" /></th>';
					//print_r($retirado);
					//echo $cejem;
					//echo $_xc[$i-1]-1;

					for ($j = 1; $j <= $row["EjemxCarr"]; $j++) {
						if ($j <= $cejem) :
							$activo = '#26354A';
							$numk = $j;
						else :
							$numk = '';
							$activo = '#999999';
						endif;
						if (!(array_search($j, $retirado) === false)) :
							/*  if ($row["Tandas"]!=2):*/
							$numk = '';/*#0066FF*/
							$activo = '#FF0000';
						/*	endif;*/
						endif;

						echo '<th  id="celda' . $i . '' . $j . '" width="13" scope="col" bgcolor="' . $activo . '" title="' . $numk . '" bordercolor="#ffffff" onclick="cambiarcelda(event,' . $row["calculo"] . ',' . $i . ');"><span class="Estilo1">' . $j . '</span></th>';
					}
					echo '<th width="30" bgcolor="#FFFFFF" scope="col"> <input type="text" id="v' . $i . '" size="3"  disabled="disabled" /></th>';
					echo '<th width="103" bgcolor=' . $row["Color"] . ' scope="col"></th>';
					echo '</tr>';
				}
				?>
				<th bgcolor="<?php echo $row["Color"] ?>" scope="row"><label></label></th>
				<th colspan="17" bgcolor="<?php echo $row["Color"] ?>" scope="row"><label> </label>
					<div align="right"><span style="color: #000000; font-size:16px">Total Bs.F.</span>
						<input type="text" name="Total" id="Total" disabled="disabled" size="8" style="background:#FFF; font-size:18px; color:#F90" />
					</div>
				</th>
				<td bgcolor="<?php echo $row["Color"] ?>">&nbsp;</td>
			</tr>
		</table>
		<samp id="inicioCarr" lang="<? echo $inicioCarr; ?>"></samp>

		<script type="text/javascript">
			var tj = '<? echo $tj; ?>';
			var Tandas = '<? echo $Tandas; ?>';
			var activar = '<? echo $activar; ?>';
			var idcn = '<? echo $idcn; ?>';
			var hipodromosArray = '<? echo implode(',', $hipodromosArray); ?>';
			var codeHipo = '<? echo implode(',', $codeHipo); ?>';

			valorescodeHipo = codeHipo.split(',');


			function clicktoolBar(id) {
				switch (id) {
					case "Cerrar_":
						stop_func();
						dhxWins1.window("w1").close();
						break;
				}
			}

			function clicktoolBar_SelectHipo(id, state) {
				stop_func();
				barSelectHipo.forEachItem(function(itemId) {
					if (id != itemId)
						barSelectHipo.setItemState(itemId, 0);
				});
				id_A = id.split('_');

				cambiodejornadahi(tj, Tandas, activar, valorescodeHipo[id_A[1]]);
				EstableTime();

			}

			dhxWins1 = new dhtmlXWindows();
			dhxWins1.setImagePath("codebase/imgs/");
			w1 = dhxWins1.createWindow("w1", 170, 270, 670, 400);
			w1.setText($('tj').innerHTML);
			w1.attachObject('box_j');
			dhxWins1.window("w1").button('close').hide();
			//dhxWins1.window("w1").button('minmax1').hide();
			//dhxWins1.window("w1").button('minmax2').hide();
			dhxWins1.window("w1").button('park').hide();
			//dhxWins1.window("w1").denyResize();
			//dhxWins1.window("w1").denyMove();  var bar = w1.attachToolbar();
			dhxWins1.window("w1").centerOnScreen();





			var barSelectHipo = w1.attachToolbar();
			barSelectHipo.addButton("Cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif");
			cantidadHipo = hipodromosArray.split(',');
			for (i = 0; i <= cantidadHipo.length - 1; i++) {
				barSelectHipo.addButtonTwoState("hipo_" + i, i + 1, cantidadHipo[i], "images/hipodromo.png", "images/hipodromo.png");
			}

			barSelectHipo.forEachItem(function(itemId) {
				id_A = itemId.split('_');
				if (valorescodeHipo[id_A[1]] == idcn)
					barSelectHipo.setItemState(itemId, 1);
			});


			barSelectHipo.attachEvent("onStateChange", clicktoolBar_SelectHipo);
			barSelectHipo.attachEvent("onClick", clicktoolBar);
			EstableTime();
			ticketassig();
		</script>

	</div>
<? else : ?>
	<script>
		alert('Disculpe pero ya Este Juego.\nSe encuentra Cerrado.');
	</script>
<? endif;
function abuscar($aguja, $pajar)
{
	$existe = false;
	for ($v = 0; $v <= count($pajar) - 1; $v++)
		if ($pajar[$v] == $aguja) :
			$existe = true;
		endif;

	return $existe;
}
function configuracionLX()
{
	global $idcn;
	global $config;
	global $cantcb;
	global $retira;
	global $masde;
	global $tj;
	global $listadeIdcnRech;
	global $_xc;
	global $cantida_Carrera;
	global $Tandas;
	global $Compartir;

	$masde = false;

	if (count($listadeIdcnRech) != 0) :
		$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
		while ($row3 = mysqli_fetch_array($result3)) {

			if (!abuscar($row3["IDCN"], $listadeIdcnRech)) :
				$idcn = $row3["IDCN"];
				break;
			endif;
		}
	else :
		$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
		if (mysqli_num_rows($result3) != 0) :
			$row3 = mysqli_fetch_array($result3);
			$idcn = $row3["IDCN"];
		endif;
	endif;



	if (mysqli_num_rows($result3) != 0) :
		if (mysqli_num_rows($result3) > 1) :
			$masde = true;
		endif;

		if ($row3["IDCN"] != '') :
			$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfighi where IDCN=" . $row3["IDCN"]);

			$row3 = mysqli_fetch_array($result4);


			$config = explode("|", $row3["_Jug"]);
			$cantcb = explode("|", $row3["_Fab"]);
			$retira = explode("|", $row3["_Ret"]);
			for ($k = 0; $k <= count($config) - 1; $k++) {
				if ($Tandas == 2) :
					$_tem1 = explode("*", $config[$k]);
					$_tem = explode("$", $_tem1[0]);

					if ($_tem[0] == $tj) :
						break;
					endif;
				else :
					$_tem = explode("*", $config[$k]);
					if ($_tem[0] == $tj) :
						break;
					endif;
				endif;
			}

		endif;
		$incremento = 0;
		if ($Tandas == 2) :
			if ($Compartir == 0) :
				$_xc = explode("-", $_tem1[1]);
			else :
				$_xc = array();
				for ($jj = 0; $jj <= count($config) - 1; $jj++) {
					$_tem1 = explode("*", $config[$jj]);
					$_tem = explode("$", $_tem1[0]);
					$h = 0;
					if ($_tem[0] == $tj) :

						$_xcprototype = explode("-", $_tem1[1]);
						$carreras = 0;
						$h += $incremento;
						for ($ii = 0; $ii <= count($_xcprototype) - 2; $ii++) {
							if ($carreras != $cantida_Carrera) :
								$_xc[$h] = $_xcprototype[$ii];
								$h++;
								$carreras++;
							else :
								$h += $cantida_Carrera;
								$carreras = 0;
								$_xc[$h] = $_xcprototype[$ii];
								$h++;
								$carreras++;
							endif;
						}
						$incremento += $cantida_Carrera;

					endif;
				}

			endif;
		else :
			$_xc = explode("-", $_tem[1]);
		endif;
		ksort($_xc);

		$activo1 = 1;
	else :
		$activo1 = 0;
		$idcn = 0;

		for ($k = 0; $k <= $cantida_Carrera + 1; $k++) {

			$_xc[$k] = $k + 1;
			/*if ($k<count($cantcb)):
		$cantcb[$k]=0;
		$retira[$k]=0;
	endif;*/
		}
	endif;
}

?>
<input id="c" type="text" style="display:none" />