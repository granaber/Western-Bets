<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$idj = $_REQUEST["idj"];
$cant = $_REQUEST["cant"];
$dp = $_REQUEST["dp"];
$IDB = $_REQUEST["IDB"];
$fc = $_REQUEST["fc"];
$auto = $_REQUEST['auto'] ?? 0;

/* $result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tbpublicaciones where IDJ=".$idj." and Grupo=".$dp." and IDB=$IDB");
 if (mysqli_num_rows($result)!=0 ): 
	 $row3 = mysqli_fetch_array($result);
	 $entrar=($row3['Publicar']==2);
 else:*/
$entrar = true;
/* endif;*/

if ($entrar) :
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $idj . " and Grupo=" . $dp . " and IDB=$IDB");
	if (mysqli_num_rows($result) != 0) :  $row = mysqli_fetch_array($result);
		$auto = $row['auto'];
	else : $auto = 0;
	endif;

	$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDJ=" . $idj . " and Grupo=" . $dp . " Order by IDP");
	if (mysqli_num_rows($resultp) != 0) :
		$i = 0;
		while ($rowp = mysqli_fetch_array($resultp)) {
			$i++;
			$np[$i] = $rowp["IDP"];
			$eq1[$i] = $rowp["IDE1"];
			$eq2[$i] = $rowp["IDE2"];
			$pide1[$i] = $rowp["PIDE1"];
			$pide2[$i] = $rowp["PIDE2"];
			$JGP1[$i] = $rowp["JGP1"];
			$JGP2[$i] = $rowp["JGP2"];
			$efec1[$i] = $rowp["EFEC1"];
			$efec2[$i] = $rowp["EFEC2"];
			$hrx[$i] = $rowp["Hora"];
			$CodigoEq1[$i] = $rowp["CodEq1"];
			$CodigoEq2[$i] = $rowp["CodEq2"];
		}
		if ($i != $cant) :

			$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb   Order by IDP Desc");
			if (mysqli_num_rows($resultp) != 0) :
				$rowp = mysqli_fetch_array($resultp);
				$ini_p =  $rowp['IDP'] + 1;
			else :
				$ini_p = 1;
			endif;
			for ($j = $i + 1; $j <= $cant; $j++) {
				$np[$j] = $ini_p;
				$eq1[$j] = "0";
				$eq2[$j] = "0";
				$hrx[$j] = "";
				$pide1[$j] = '';
				$pide2[$j] = '';
				$JGP1[$j] = '';
				$JGP2[$j] = '';
				$efec1[$j] = '';
				$efec2[$j] = '';
				$CodigoEq1[$j] = 0;
				$CodigoEq2[$j] = 0;
				$ini_p++;
			}
		endif;

	else :
		$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb   Order by IDP Desc");
		if (mysqli_num_rows($resultp) != 0) :
			$rowp = mysqli_fetch_array($resultp);
			$ini_p =  $rowp['IDP'] + 1;
		else :
			$ini_p = 1;
		endif;
		for ($i = 1; $i <= $cant; $i++) {
			$np[$i] = $ini_p + ($i - 1);
			$eq1[$i] = "0";
			$eq2[$i] = "0";
			$hrx[$i] = "";
			$pide1[$i] = '';
			$pide2[$i] = '';
			$JGP1[$i] = '';
			$JGP2[$i] = '';
			$efec1[$i] = '';
			$efec2[$i] = '';
			$CodigoEq1[$i] = 0;
			$CodigoEq2[$i] = 0;
		}
	endif;
	$lista = '';
	$ltexto = '';

	$liga = 0;
	if (isset($_REQUEST['skynet'])) :

		$Equipos1 = explode('|', $_REQUEST['equiz1']);
		$Equipos2 = explode('|', $_REQUEST['equiz2']);
		$ptch1 = explode('|', $_REQUEST['ptch1']);
		$ptch2 = explode('|', $_REQUEST['ptch2']);
		$code1 = explode('|', $_REQUEST['code1']);
		$code2 = explode('|', $_REQUEST['code2']);
		$hra = explode('|', $_REQUEST['hra']);
		$liga = $_REQUEST['liga'];
		for ($i = 0; $i <= $cant - 1; $i++) {
			$eq1[$i + 1] =  $Equipos1[$i];
			$eq2[$i + 1] =  $Equipos2[$i];
			$pide1[$i + 1] = $ptch1[$i];
			$pide2[$i + 1] = $ptch2[$i];
			$CodigoEq1[$i + 1] = $code1[$i];
			$CodigoEq2[$i + 1] = $code2[$i];
			$hrx[$i + 1] = $hra[$i];
		}
		$logros = json_decode(str_replace("\\", "", $_REQUEST['logros']), true);
	endif;
?>
<div id="fromJornada" style=" width: 100%; height: 100%; overflow: auto; font-family: Tahoma; font-size: 11px;">
    <span id='fc' lang='<? echo $fc; ?>'></span><span id='cant_p' lang='<? echo $cant; ?>'></span> <span id='Grupo'
        lang='<? echo $dp; ?>'></span> <span id='IDB' lang='<? echo  $IDB; ?>'></span>
    <samp id="n_idc" title="<?php echo $idj; ?>"></samp>
    <?
		$nover = array();
		for ($i = 1; $i <= $cant; $i++) {


			$nover[$i] = '';
			$uno = '';
			$dos = 'style="display:none"';

			if ($hrx[$i] != '' && $hrx[$i] != ':') :
				$hora = convertirMilitar(Horareal($GLOBALS['minutosh'], "h:i:s A"));
				if (diferenciadehoras('1/1/2009', $hrx[$i], $hora)) :
					$nover[$i] = 'style="display:none"';
					$uno = 'style="display:none"';
					$dos = '';

				endif;
			endif;
			echo '<img id="imgLmenos_' . $i . '" src="images/elbow-minus-nl.gif" onclick="mas_menos(1,' . $i . ')" title="on Partido ' . $np[$i] . '" ' . $uno . ' />';
			echo '<img id="imgLmas_' . $i . '" src="images/elbow-plus-nl.gif" onclick="mas_menos(2,' . $i . ')"  title="off Partido ' . $np[$i] . '" ' . $dos . '  />';
		}
		?>

    <table border="0">

        <tr>
            <td valign="top">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr style="background: #400000">
                        <td height="28px">
                            <div align="center" style="color: #FFF"><strong>N.P</strong></div>
                        </td>
                        <td width="110">
                            <div align="center" style="color:#FFF"><strong>(HH:MM) </strong></div>
                        </td>
                        <td width="58">
                            <div align="center" style="color:#FFF "><strong>Equipo(1)</strong></div>
                        </td>
                        <td width="13">&nbsp;</td>
                        <td width="61">
                            <div align="center" style="color:#FFF "><strong>Equipo(2)</strong></div>
                        </td>
                    </tr>
                    <?
						for ($i = 1; $i <= $cant; $i++) {

							if (($i % 2) == 0) :
								$bkcolor = "#CCC";
							else :
								$bkcolor = "#829BB0";
							endif;

							echo '<tr  id="linea_' . $i . '" bgcolor="' . $bkcolor . '" ' . $nover[$i] . ' >';
							echo '<td height="40px" >';

							echo '<div id="np' . $i . '"  lang="' . $np[$i] . '" align="center" style="color:#FFFFFF">' . $np[$i];
							echo ' </div></td><td ><div  align="center">';
							$uno = "'min" . $i . "'";
							$dos = "'hora" . $i . "'";
							$dis = "";
							//  if ($permitirmod): $dis=""; else: $dis="disabled"; endif; 
							if ($i <= count($hrx)) :
								$hos = explode(':', $hrx[$i]);
								if (count($hos) != 1) :
									echo '<input id="hora' . $i . '" name="textfield"  type="text" size="2" maxlength="2" value="' . $hos[0] . '" onkeypress="focusobjbbg(event,' . $uno . ',1);"  ' . $dis . '>:';
									echo '<input id="min' . $i . '"  name="textfield" type="text" size="2" maxlength="2" value="' . $hos[1] . '"  onkeypress="focusobjbbg(event,' . $dos . ',2);"  ' . $dis . '>';
								else :
									echo '<input id="hora' . $i . '" name="textfield" type="text" size="2" maxlength="2"  onkeypress="focusobjbbg(event,' . $uno . ',1);"  ' . $dis . '>:';
									echo '<input id="min' . $i . '"  name="textfield" type="text" size="2" maxlength="2"  onkeypress="focusobjbbg(event,' . $dos . ',2);"  ' . $dis . '>';
								endif;
							else :

								echo '<input id="hora' . $i . '" name="textfield"  type="text" size="2" maxlength="2" value="" onkeypress="focusobjbbg(event,' . $uno . ',1);"  ' . $dis . '>:';
								echo '<input id="min' . $i . '"  name="textfield" type="text" size="2" maxlength="2" value=""  onkeypress="focusobjbbg(event,' . $dos . ',2);"  ' . $dis . '>';

							endif;

							echo ' </div></td><td ><div align="center">';
							if (!(strrpos($eq1[$i], '$') === false)) :
								$newequi = explode('*', $eq1[$i]);
								echo '<img id="equipoDev' . $i . '" src="images/redo.gif"  style="display:none" lang="' . $newequi[1] . '" onclick="Devolver(' . $i . ',' . $dp . ',' . $liga . ')"/>';
								echo "<input id='ButonAct" . $i . "' type='button' value='..' onclick='verEquipos(" . $i . "," . $dp . "," . $liga . ")'/><span  title='2k' id='equipo" . $i . "' lang='0'  style='background:#C00; color:#FFF'>" . $newequi[1] . "</span></div></td>";
							else :
								echo '<select name="select2" size="1" id="equipo' . $i . '" onchange="colocarTexto(' . $i . ')" >';
								$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where  ( _equiposbb.Grupo=" . $dp . " or _equiposbb.Grupo1=" . $dp . " or _equiposbb.Grupo2=" . $dp . " ) order by Descripcion,IDE");

								while ($row = mysqli_fetch_array($result)) {

									if ($i <= count($eq1)) {
										echo "<option " . ($eq1[$i] == $row["IDE"] ? " selected='selected'" : " ") . " value=" . $row["IDE"] . ">" . $row["Descripcion"] . "</option>";
									} else {
										echo "<option value=" . $row["IDE"] . ">" . $row["Descripcion"] . "</option>";
									}
								}

								echo  '</select></div></td>';
							endif;
							$n = $i + $cant;

							echo '<td><div align="center" style="color:#FFFFFF"><strong>vs</strong></div></td>
          <td ><div align="center">';

							if (!(strrpos($eq2[$i], '$') === false)) :
								$newequi = explode('*', $eq2[$i]);
								echo '<img id="equipoDev' . $n . '" src="images/redo.gif"  style="display:none" lang="' . $newequi[1] . '" onclick="Devolver(' . $n . ',' . $dp . ',' . $liga . ')"/>';
								echo "<input id='ButonAct" . $n . "' type='button' value='..' onclick='verEquipos(" . $n . "," . $dp . "," . $liga . ")' /><span  title='2k'  id='equipo" . $n . "'  lang='0' style='background:#C00; color:#FFF'>" . $newequi[1] . "</span></div></td>";
							else :
								echo '<select name="select2" size="1" id="equipo' . $n . '"  onchange="colocarTexto(' . $n . ')">';
								$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where  ( _equiposbb.Grupo=" . $dp . " or _equiposbb.Grupo1=" . $dp . " or _equiposbb.Grupo2=" . $dp . " ) order by Descripcion,IDE");
								while ($row = mysqli_fetch_array($result)) {
									if ($i <= count($eq2)) {
										echo "<option " . ($eq2[$i] == $row["IDE"] ? " selected='selected'" : " ") . " value=" . $row["IDE"] . ">" . $row["Descripcion"] . "</option>";
									} else {
										echo "<option  value=" . $row["IDE"] . ">" . $row["Descripcion"] . "</option>";
									}
								}


								echo '</select></div></td>';
							endif;
							echo '</tr>';
						}

						?>
                </table>

                <table border="0" cellspacing="0" cellpadding="0">
                </table>

                <table border="0" cellspacing="0" cellpadding="0">
                </table>
            </td>
            <td valign="top">
                <div id="tabbar" style="width:850px; height:5000px;"> </div>
            </td>
        </tr>

    </table>


</div>

<div id="pr"></div>
<br />

<?
	$k = 1;
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb  where Grupo=" . $dp . "  Order by Formato");
	if (mysqli_num_rows($result) != 0) :
		$listdv = [];

		while ($row3 = mysqli_fetch_array($result)) {


			$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where Formato=" . $row3['Formato']);
			while ($row2 = mysqli_fetch_array($result2)) {
				$lista .= $row2['IDDD'] . ',';
				$ltexto .= $row3['Descripcion'] . '-' . $row2['Descripcion'] . ',';

				echo "<div id='tpg_" . $row2['IDDD'] . "' >";
				echo '<table border="0" cellspacing="0" cellpadding="0"> ';
				for ($i = 1; $i <= $cant; $i++) {
					if (($i % 2) == 0) :
						$bkcolor = "#CCC";
					else :
						$bkcolor = "#829BB0";
					endif;
					$blck = "return $(this.id).style.backgroundColor='#FFFFFF'";

					$col = explode('|', $row2['Columnas']);


					echo '<tr  id="tpg_' . $row2['IDDD'] . '_' . $i . '" bgcolor="' . $bkcolor . '" lang="' . $row2['Columnas'] . '"   ' . $nover[$i] . '>   <td  height="40px"> <samp id="ERR_' . $row2['IDDD'] . '_' . $i . '"  ></samp><div  id=j"' . $row2['IDDD'] . '" lang="' . count($col) . '" style=" background:' . $bkcolor . '">';

					$key = strpos($row2['Columnas'], 'RU');

					if ($key === false) :
						$evaluar = 0;
						$coleval = "''";
					else :
						$evaluar = 1;
						$coleval = "'" . $row2['Columnas'] . "'";
					endif;
					if ($evaluar == 0) :
						$key = strpos($row2['Columnas'], 'Ax');
						if ($key === false) :
							$evaluar = 0;
							$coleval = "''";
						else :
							$evaluar = 2;
							$coleval = "'" . $row2['Columnas'] . "'";
						endif;
					endif;
					$resultRlx = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglamentologros where IDDD=" . $row2['IDDD']);
					if (mysqli_num_rows($resultRlx) != 0) :
						$rowtRlx = mysqli_fetch_array($resultRlx);
						$IDDCPY = $rowtRlx['IDDD_cpy'];
						$divcrr = $rowtRlx['DvdCrr'];
						$resultRlx = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where IDDD=$IDDCPY");
						$rowtRlx = mysqli_fetch_array($resultRlx);
						$acpy = explode('|', $rowtRlx['Columnas']);
					//print_r($acpy);
					else :
						$acpy = -1;
					endif;
					$cmpOdds = [];
					for ($ii = 0; $ii <= count($col) - 1; $ii++) {

						$dividirCrr = 1;
						$subcol = explode('-', $col[$ii]);
						if ($acpy != -1) :
							$subnomcpy = explode('-', $acpy[$ii]);
						endif;
						if (count($subcol) == 1) :
							$tm = 8;
							$nomc = $col[$ii];
							if ($acpy != -1) :
								$nomcpy = $acpy[$ii];
								$dividirCrr = 0;
							endif;
							$stl = '';
							$blck = "return $(this.id).style.backgroundColor='#FFFFFF'";
						else :
							$pos = strpos($subcol[1], 'car');

							if ($pos == 0) :
								$stl = "background-color: #ADD5F1";
								$blck = "return $(this.id).style.backgroundColor='#ADD5F1'";
							else :
								$stl = '';
								$stl = '';
								$blck = "return $(this.id).style.backgroundColor='#FFFFFF'";
							endif;

							$tm = $subcol[0];
							$nomc = $subcol[1];
							if ($acpy != -1) :
								$nomcpy = $subnomcpy[1];
								if ($divcrr == 1) :   $dividirCrr = 1;
								else : $dividirCrr = 0;
								endif;
							endif;
						endif;
						if (isset($_REQUEST['skynet'])) :
							//   echo $i.'-'.$row2['IDDD'].'<br>';
							if (isset($logros[$i - 1][$row2['IDDD']])) :
								$valoresdd = explode('|', $logros[$i - 1][$row2['IDDD']]);
								if ($row2['logrosxdefecto'] == '') :
									$cualv = $valoresdd[$ii];
								else :
									$cualv = $valoresdd[$ii];
									$valoresdd1 = explode('|', $row2['logrosxdefecto']);
									if ($ii == 0) : $cualv = $valoresdd1[$ii];
									endif;
									if (count($col) == 4) :
										if ($ii == 2) : $cualv = $valoresdd1[1];
										endif;
									endif;
									if (count($col) == 2) :
										if ($ii == 1) : $cualv = $valoresdd1[1];
										endif;
									endif;

								endif;
							else :
								$cualv = '';
							endif;

						else :
							$bloqq = 0;
							$result5 = mysqli_query($GLOBALS['link'], "SELECT * FROM _configuracionjugadabb where IDP=" . $i . " and IDJ=" . $idj . " and IDDD=" . $row2['IDDD'] . " and Grupo=" . $dp . "  and IDB=$IDB ");
							if (mysqli_num_rows($result5) != 0) :
								$row5 = mysqli_fetch_array($result5);
								$bloqq = $row5['blq'] ?? 0;
								$valoresdd = explode('|', $row5['Valores']);
								$cualv = $valoresdd[$ii];
							else :
								$cualv = '';
							endif;
						endif;
						$listdv[$i] = ($listdv[$i] ?? '') . '|' . $nomc . '' . $i;
						$ty = "'num'";
						if ($acpy != -1) :
							$Tnomcpy = "'" . $nomcpy . $i . "'";
						endif;
						$asiacc = "$('obc" . $row2['IDDD'] . $i . "').lang='" . $nomc . "'";
						//*******************************************************//
						if ($cualv == '' && $row2['logrosxdefecto'] != '') :
							$valoresdd = explode('|', $row2['logrosxdefecto']);
							if ($ii == 0) : $cualv = $valoresdd[$ii];
							endif;
							if (count($col) == 4) :
								if ($ii == 2) : $cualv = $valoresdd[1];
								endif;
							endif;
							if (count($col) == 2) :
								if ($ii == 1) : $cualv = $valoresdd[1];
								endif;
							endif;
						endif;
						//*******************************************************//
						if ($acpy == -1) :
							echo '<input ' . ($bloqq ? 'disabled' : '') . ' id="' . $nomc . '' . $i . '" lang="' . $row2['IDDD'] . '" type="text" size="' . $tm . '" maxlength="' . $tm . '" style="' . $stl . '" onkeyup="focusobjbb(event,' . $i . ')" onkeypress="return permitebb(event,' . $ty . ',' . $evaluar . ',' . $coleval . ',' . $i . ');" onclick="' . $asiacc . '" value="' . $cualv . '" onfocus="' . $blck . '" />';
						else :
							echo '<input ' . ($bloqq ? 'disabled' : '') . ' id="' . $nomc . '' . $i . '" lang="' . $row2['IDDD'] . '" type="text" size="' . $tm . '" maxlength="' . $tm . '" style="' . $stl . '" onkeyup="focusobjbb(event,' . $i . ')" onkeypress="return copiarCaracterLogros(event,' . $Tnomcpy . ',' . $dividirCrr . ',' . $evaluar . ',' . $coleval . ',' . $i . ');"  onclick="' . $asiacc . '" value="' . $cualv . '" onfocus="' . $blck . '" />';

						endif;
						$cmpOdds[] = $nomc . '' . $i;
					}
					$parmTR = "'" . join(',', $cmpOdds) . "'";
					echo '<input ' . ($bloqq ? 'checked' : '') . ' class="checkHbi" type="checkbox" name=""  id="habiChk-' . $row2['IDDD'] . '-' . $i . '" onclick="blkOdds(' . $parmTR . ',' . $i . ',' . $row2['IDDD'] . ',' . $dp . ')"  data-toggle="tooltip" data-placement="top" title="Bloquear ' . $row2['Descripcion'] . ' ">';
					echo '<img ' . ($bloqq ? 'disabled' : '') . ' id="obc' . $row2['IDDD'] . $i . '" title="' . $i . '" src="media/add.png" width="16" height="16"  onclick="copiarvaloresjsonbb(event)"/></div></td></tr>';
				}
				echo '</table>';
				echo '</div>';
			}
		}
		echo '<div id="tpg_pitcher"><table border="0" cellspacing="0" cellpadding="0"> <tr > ';
		//  echo '<td  style="color:#333;background:#BEC8D8 "></td>';.'_'.$i.'
		//	  echo '<td  style="color:#333;"><div align="center" style="color:#333;font-size:7px"><strong>G-P</strong></div></td>';
		//	  echo '<td  style="color:#333;background:#BEC8D8  "><div align="center" style="color:#333;font-size:7px "><strong>Efectividad</strong></div></td> </tr> ';   
		for ($i = 1; $i <= $cant; $i++) {
			$n = $i + $cant;
			if (($i % 2) == 0) :
				$bkcolor = "#000";
			else :
				$bkcolor = "#829BB0";
			endif;
			$ssg1 = "'pc2" . $n . "'";
			$ssg2 = "'pc1" . $i . "'";
			echo ' <tr  id="tpg_pitcher' . '_' . $i . '" height="40px"  style=" background:' . $bkcolor . '">';
			echo   '<td style="color:#FFFFFF"> <input id="pc1' . $i . '" type="text"  size=30 value="' . $pide1[$i] . '" onkeyup="focusobjbb2(event,' . $ssg1 . ')"/><input id="pc2' . $n . '"  type="text" size=30 value="' . $pide2[$i] . '" onkeyup="focusobjbb2(event,' . $ssg2 . ')"/></td></tr>';
			//$ssg1="'GP2".$n."'";	
			//$ssg2="'efe1".$i."'";  
			echo   '<input id="GP1' . $i . '" style="display:none"   type="text" size=3 value="' . $JGP1[$i] . '" onkeyup="focusobjbb2(event,' . $ssg1 . ')" /><input id="GP2' . $n . '" type="text" size=3 value="' . $JGP2[$i] . '" style="display:none" onkeyup="focusobjbb2(event,' . $ssg2 . ')"/>';
			//$ssg1="'efe2".$n."'";	
			//$ssg2="'pc1".$i."'"; 
			echo   '<input id="efe1' . $i . '" type="text" style="display:none" size=3 value="' . $efec1[$i] . '" onkeyup="focusobjbb2(event,' . $ssg1 . ')"/><input id="efe2' . $n . '" type="text" size=3  style="display:none" value="' . $efec2[$i] . '" onkeyup="focusobjbb2(event,' . $ssg2 . ')"/>';
		}
		echo '</table></div>';

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		echo '<div id="tpg_codigo" ><table width="200" border="0"> ';
		//  echo '<td>Equipo</td><td>Codigo</td><td>Equipo</td><td>Codigo</td></tr>';
		for ($i = 1; $i <= $cant; $i++) {
			$n = $i + $cant;
			if (($i % 2) == 0) :
				$bkcolor = "#000";
			else :
				$bkcolor = "#829BB0";
			endif;
			$ssg1 = "'CodigoEq2_" . ($i) . "'";
			echo ' <tr id="tpg_codigo' . '_' . $i . '" height="38px"  style=" background:' . $bkcolor . '">';
			echo   '<td style="color:#FFFFFF"><span id="Equi_' . $i . '"></span> </td>';
			echo   '<td style="color:#FFFFFF"><input id="CodigoEq1_' . $i . '"  type="text" size=5 value="' . $CodigoEq1[$i] . '" onkeyup="focusobjbb2(event,' . $ssg1 . ')" /></td>';
			if ($i == $cant) :
				$ssg1 = "'CodigoEq1_1'";
			else :
				$ssg1 = "'CodigoEq1_" . ($i + 1) . "'";
			endif;
			echo   '<td style="color:#FFFFFF"><span id="Equi_' . ($i + $cant) . '"></span></td>';
			echo   '<td style="color:#FFFFFF"><input id="CodigoEq2_' . $i . '"  type="text" size=5 value="' . $CodigoEq2[$i] . '" onkeyup="focusobjbb2(event,' . $ssg1 . ')" /></td>';
			echo "</tr>";
		}
		echo '</table></div>';
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	endif;
	for ($t = 0; $t <= count($listdv); $t++) {
		echo '<samp id="cv' . $t . '" lang="' . ($listdv[$t] ?? "")  . '"></samp>';
	}

	echo '<samp id="ntc" lang="' . ($cc ?? "") . '"></samp></tr>';
	$lista .= 'pitcher,codigo,';
	$ltexto .= 'Pitchers,Codigos,';
	?>

<div id="tablemenu1"></div>
<div id="supcl"></div>
<script>
var cant = <?= $cant; ?>;
var liga = <?= $liga; ?>;
var idRow = 0;
var lista = '<? echo $lista; ?>';
var ltexto = '<? echo $ltexto; ?>';
var auto = <?= $auto; ?>;
valoreslista = lista.split(',');
valoresltexto = ltexto.split(',');

function clicktoolBar(id) {
    switch (id) {
        case "Cerrar_":
            dhxWins1.window("w1").close();
            break;
        case "Importar_":
            makeResultwin('jornadabb-1-5.php?idj=' + $('n_idc').title + '&dp=' + $('Grupo').lang + '&IDB=' + $('IDB')
                .lang + '&fc=' + $('fc').lang, 'tablemenu1');
            break;
        case "Modificar_":
            if (idRow != 0) {
                dhxWins1.window("w1").close();
                makeResultwin('usuario.php?fc=' + idRow + '&idt=<?= $vc ?? 1; ?>', 'tablemenu');
            } else
                nalert('ERROR', 'DEBE SELECCIONAR PRIMERO EL USUARIO A MODIFICAR!!');
            break;
        case "Grabar_":
            guardarjorbb(liga, <?= $auto; ?>);
            //	makeResultwin('SuperUsuario.php?liga='+liga,'supcl');
            break;
        case "Copiar_":
            VerificarLogros(true);
            break;
        case "Auto_":
            makeResultwin('jornadabbauto.php?idj=' + $('n_idc').title + '&grupo=' + $('Grupo').lang + '&idb=' + $('IDB')
                .lang, 'tablemenu1');
            break;
    }
}

function doOnRowSelected(id) {
    idRow = id;
}

dhxWins1 = new dhtmlXWindows();
dhxWins1.setImagePath("codebase/imgs/");
w1 = dhxWins1.createWindow("w1", 150, 255, 1000, 450);
w1.setText('Configuracion de Jornada BANCA:<? echo $IDB; ?> JORNADA No.<?php echo $idj; ?>');
w1.attachObject('fromJornada');
dhxWins1.window("w1").button('close').hide();

/*dhxWins1.window("w1").button('minmax1').hide();
dhxWins1.window("w1").button('minmax2').hide();*/
dhxWins1.window("w1").button('park').hide();
dhxWins1.window('w1').setModal(true);
dhxWins1.window('w1').maximize();

var bar = w1.attachToolbar();
bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
bar.addButton("Copiar_", 1, "Chequeo de Logros", "images/select_all.gif", "images/select_all.gif");
bar.addButton("Importar_", 1, "Importar Partidos", "images/leaf_pro_new.gif", "images/leaf_pro_new.gif");
bar.addButton("Grabar_", 1, "Grabar Configuracion", "images/dhtmlxajax_icon.gif", "images/dhtmlxajax_icon.gif");
bar.addButton("Futuras_", 1, "Jugada Futuras", "images/dhtmlxajax_icon.gif", "images/dhtmlxcalendar_icon");
if (auto == 1) bar.addButton("Auto_", 1, "Apuesta Aumaticas", "images/dhtmlxajax_icon.gif",
    "images/dhtmlxajax_icon.gif");

bar.attachEvent("onClick", clicktoolBar);
//ocant=cant;
//cant*=2;

tabbar = new dhtmlXTabBar("tabbar", "top");
tabbar.setStyle("dhx_skyblue");
tabbar.setImagePath("codebase/imgs/");
tabbar.enableAutoReSize(true);
//tabbar.addTab("a_1",'prueba',"150px"); tabbar.setContent("a_1","pr");
for (i = 0; i <= valoreslista.length - 2; i++) {
    tabbar.addTab("a_" + valoreslista[i], valoresltexto[i], "200px");
    tabbar.setContent("a_" + valoreslista[i], "tpg_" + valoreslista[i]);
}

tabbar.enableScroll(true);
tabbar.setTabActive("a_" + valoreslista[0]);

for (i = 1; i <= cant; i++) {
    index = $("equipo" + i).selectedIndex
    $('Equi_' + i).innerHTML = $("equipo" + i).options[index].text;
    index = $("equipo" + (i + cant)).selectedIndex
    $('Equi_' + (i + cant)).innerHTML = $("equipo" + (i + cant)).options[index].text;
}
</script>
<?
else :
?>
<script>
/// Alerta de LLamada no poder acceder!
nalert('Publicacion ', 'La Publicacion Esta Activada No Puede Modifcar los Logros');
</script>
<?
endif;
?>