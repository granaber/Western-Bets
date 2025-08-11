<style type="text/css">
	<!--
	body {
		margin-left: 0px;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
	}

	.shadowcontainer {
		/* container width*/
		background-color: #d1cfd0;
	}

	.shadowcontainer .innerdiv {
		/* Add container height here if desired */
		background-color: white;
		border: 1px solid gray;
		padding: 6px;
		position: relative;
		left: -5px;
		/*shadow depth*/
		top: -5px;
		/*shadow depth*/
	}
	-->
</style>
<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$conse = $_REQUEST['cs'];
?>
<div id="box4" style="background: #333">
	<table width="1040" border="0" cellspacing="0">
		<tr bgcolor="#0066FF">
			<th colspan="8" style="background:#369">
				<div align="center" style="color: #FF0">Ver Jugada </div>
			</th>
		</tr>
		<tr>
			<th width="233" valign="middle">
				<div align="left" style="color:#FFFFFF">Jugada
					<select name="grupo" size="1" id="jgd" onchange="datosverjugadahi(0,0);">

						<?php $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegoshi order by IDJug");
						echo "<option  value=''></option>";
						echo '<option  value="0">Ganadores/Place/Shots</option>';
						while ($row = mysqli_fetch_array($result)) {
							echo "<option  value=" . $row["IDJug"] . ">" . $row["Descrip"] . "</option>";
						}
						?>
					</select>
				</div>
			</th>
			<?php
			if ($conse == -2 || $conse == -1) :
				echo '<th width="194" valign="middle">';
				echo '<div id="consec"align="left">';
				echo '<div align="left" style="color:#FFFFFF">Concesionario: ';
				echo '<select name="select" size="1" id="tcns" onchange="datosverjugadahi(0,0);"   >';
				echo "<option  value=0>Todos</option>";
				$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario order by IDC");
				while ($row3 = mysqli_fetch_array($result3)) {
					echo "<option  value='" . $row3["IDC"] . "'>" . $row3["IDC"] . "</option>";
				}
				echo '</select>';
				echo '</div>';
				echo '</div></th>';
			endif;
			?>
			<th width="239" valign="middle">
				<div align="left" style="color:#FFFFFF">Jornada
					<select size="1" id="jnd1" onchange="datosverjugadahi(0,0)">
						<?php
						$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
						$row2 = mysqli_fetch_array($result2);

						$result = mysqli_query($GLOBALS['link'], "SELECT IDCN,Fecha,_hipodromoshi.descripcion FROM _tconfjornadahi,_hipodromoshi where _tconfjornadahi.IDhipo=_hipodromoshi._idhipo order by _tconfjornadahi.idcn");
						echo "<option   value='0'></option>";
						while ($row = mysqli_fetch_array($result)) {
							echo "<option  " . ($row2["IDCN"] == $row["IDCN"] ? " selected='selected'" : " ") . " value=" . $row["IDCN"] . ">" . $row["Fecha"] . "-" . $row["descripcion"] . "</option>";
						}
						/*if ($conse != -5 && $conse != -4 && $conse != -3 && $conse != -2 && $conse != -1 ): echo '<div align="left">
            <input type="submit" name="Submit2" value="Eliminar" onclick="eliminarticket();" />
          </div>'; else:*/						?>
					</select>
				</div>
			</th>
			<th width="79" valign="middle">
			</th>
			<th width="62" valign="middle"><?php
											if ($conse != -5 && $conse != -4 && $conse != -3 && $conse != -2 && $conse != -1) : echo '<div align="left">
            <input type="submit" name="Submit2" value="Eliminar" onclick="eliminartickethi();" />
          </div>';
											else :
												if ($conse == -2) : echo '<div align="left">
            <input type="submit" name="Submit2" value="Eliminar" onclick="eliminartickethi();" />
          </div>';
												endif;
											endif; ?> </th>
			<th width="192" valign="middle">
				<?php
				if ($conse == -2 || $conse == -1) :
					echo '<div align="left">
            <input type="submit" name="Submit3" value="Buscar" onclick="cargarbusqhi();" />
          </div>';
				endif; ?></th>
			<td width="223" colspan="2" align="right" valign="middle"> </td>
		</tr>
		<tr onmousemove="sccc2();"><?php
									if ($conse == -2 || $conse == -1) :
										echo '<th valign="middle"  ><div align="left" style="color:#FFFFFF">Serial
            <input id="bserial" disabled"true" type="text" name="textfield" />
         	 </div></th>
          	<th width="194" valign="middle" >&nbsp;</th>
          	<th width="270" valign="middle" ></th>
          	<th width="79" valign="middle" ><div align="left">
          	  <input id="bacept" disabled"true" type="submit" name="Submit3" value="Aceptar" onclick="datosverjugadahi(-1,0);"/>
       	    </div></th>
          	<th colspan="2" valign="middle" >&nbsp;</th>
          	<td width="27" colspan="2" align="right" valign="middle"></td>';
									endif;
									?>
		</tr>


	</table>
</div>
<br />
<div id="lista" align="left"></div>

<script>
	Nifty('div#box4', 'big');
</script>