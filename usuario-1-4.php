<?
/*require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance(); 

	$v=explode("|",$_REQUEST['Acceso']);
	$v2=explode("-",$_REQUEST['AccesoP']); */

?>
<div id="box12" style="background:#BAC6D8; height:1000px">
	<div id="TabbedPanels1" class="TabbedPanels">
		<ul class="TabbedPanelsTabGroup">

			<li class="TabbedPanelsTab" tabindex="0" style="font-size:12px">Deportes</li>
		</ul>
		<div class="TabbedPanelsContentGroup">



			<div class="TabbedPanelsContent">
				<?php
				$key = array_search('3', $v2);
				$check = 'checked="checked"';
				$sty = '';
				if ($key === false) :
					$check = '';
					$sty = 'style="display:none"';
				endif;
				?>
				<div style="font-size:12px" onclick="MM_effectHighlight(this, 1000, '#ffffff', '#ff0000', '#ffffff', true)">
					<input id="deportes" name="" type="checkbox" value="" <?php echo $check; ?> onclick="if ($('lis3').style.display=='none') {$('lis3').style.display='';}else{$('lis3').style.display='none';}" />
					Habilitado
				</div>
				<div id="lis3" style="overflow:auto; height:58%" <?php echo $sty; ?>>
					<table cellspacing="0">
						<tr>
							<th align="left" class="Estilo51">
								<div id="Deportesl" title="<?php $result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tmenu where Modulo='DEPORTES' ");
															echo mysqli_num_rows($result1); ?>" align="center" style="color:#000000">Menu</div>
							</th>
							<th width="30" align="right" class="Estilo50">
								<div align="center"></div>
							</th>
						</tr>
						<?php
						switch ($tp) {
							case 1:
								$campo = 'Usuario';
								break;
							case 2:
								$campo = 'Administrador';
								break;
							case 3:
								$campo = 'Vendedor';
								break;
							case 4:
								$campo = 'Info';
								break;
							case 5:
								$campo = 'Sistema';
								break;
						}
						$arrn = 1;
						$cot = 1;
						$arra1 = array();
						$resultS = mysqli_query($GLOBALS['link'], " SELECT SUBMODULO  FROM _tmenu where Modulo='DEPORTES' Group by SUBMODULO");
						while ($row = mysqli_fetch_array($resultS)) {


							$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tmenu where Modulo='DEPORTES' ");
							$cj = 1;
							while ($row = mysqli_fetch_array($result1)) {
								$arra1[$arrn][$cj] = $row["Descripcion"] . "|d" . $cot . '|' . $row["variable"];
								$cj++;
								$cot++;
							}
							$arrn++;
						}


						$i = 1;
						$j = 1;
						$ji = 1;
						$rt = 1;
						$dete = true;
						while ($row = mysqli_fetch_array($result1)) {
							if ($i == 1) :
								$bkcolor = '#E2E7EF';
								$i = 2;
							else :
								$bkcolor = '#FFFFFF';
								$i = 1;
							endif;
							$en = "checked";
							for ($ii = 0; $ii <= count($v) - 1; $ii++) {
								$nivel = substr($v[$ii], 2, 1);
								if ($nivel == '1') :
									$nivel = substr($v[$ii], 3);
									if ($nivel == $row["IDJug"]) :
										$en = '';
										break;
									endif;
								endif;
							}

							if ($dete) :
								$expo = explode('|', $arra1[$rt][$ji]);

								$resultMENU = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tmenu where variable='" . $expo[2] . "' and " . $campo . "=1");

								if (mysqli_num_rows($resultMENU) != 0) :
									$en = "checked";
								else :
									if (count($v) != 0) :
										$en = "checked";
									else :
										$en = '';
									endif;
								endif;
								for ($ii = 0; $ii <= count($v) - 1; $ii++) {
									if ($v[$ii] == $expo[2]) :
										$en = '';
										break;
									endif;
								}

								if ($accesogp != 0) :
									$en2 = 'disabled="disabled"';
								else :
									$en2 = '';
								endif;

								if ($idt != 2 && $idt != 1) :
									if ('op68' == trim($expo[1])) :  $en2 = 'disabled="disabled"';
									endif;
								endif;
								echo  '<td align="center" bgcolor="' . $bkcolor . '" style="color:#000000">' . $expo[0] . '</td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ><div align="center">';
								echo  '<input type="checkbox" id="' . $expo[1] . '"  title="' . $expo[1] . '" value="checkbox" ' . $en . ' ' . $en2 . '/>';
								echo  '</div></th>';
							else :
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
							endif;
							//  echo  '<td align="center" bgcolor="'.$bkcolor.'" >&nbsp;</td>';		 
							//  echo '</tr>';
							if ($ji <= count($arra1[$rt]) - 1) :
								$ji++;
							else :
								if ($rt <= count($arra1) - 1) :
									$rt++;
									$ji = 1;
								else :
									$dete = false;
								endif;
							endif;
							$j++;
						}

						for ($uu = $rt; $uu <= (count($arra1[$rt])); $uu++) {
							if ($i == 1) :
								$bkcolor = '#E2E7EF';
								$i = 2;
							else :
								$bkcolor = '#FFFFFF';
								$i = 1;
							endif;
							echo '<tr>';
							echo  '<th align="left" bgcolor="' . $bkcolor . '" class="Estilo51"></th>';
							echo  '<th align="left" bgcolor="' . $bkcolor . '"  class="Estilo51"></th>';
							if ($dete) :
								$expo = explode('|', $arra1[$rt][$ji]);


								$resultMENU = mysqli_query($GLOBALS['link'], " SELECT *  FROM _tmenu where variable='" . $expo[2] . "' and " . $campo . "=1");
								if (mysqli_num_rows($resultMENU) != 0) :
									$en = "checked";
								else :
									if (count($v) != 0) :
										$en = "checked";
									else :
										$en = '';
									endif;
								endif;
								for ($ii = 0; $ii <= count($v) - 1; $ii++) {
									if ($v[$ii] == $expo[2]) :
										$en = '';
										break;
									endif;
								}
								if ($accesogp != 0) :
									$en2 = 'disabled="disabled"';
								else :
									$en2 = '';
								endif;

								if ($idt != 2 && $idt != 1) :
									if ('op68' == trim($expo[2])) :  $en2 = 'disabled="disabled"';
									endif;
								endif;
								echo '<tr>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" style="color:#000000">' . $expo[0] . '</td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ><div align="center">';
								echo  '<input type="checkbox" id="' . $expo[1] . '"  title="' . $expo[2] . '" value="checkbox" ' . $en . ' ' . $en2 . '/>';
								echo  '</div></tr>';
							else :
								echo '<tr>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
								echo  '</tr>';
							endif;
							if ($ji <= count($arra1[$rt]) - 1) :
								$ji++;
							else :
								if ($rt <= count($arra1) - 1) :
									$rt++;
									$ji = 1;
								else :
									$dete = false;
								endif;
							endif;
							$j++;
						}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>

	<p id='estuu' class="Estilo13">&nbsp;</p>
</div>