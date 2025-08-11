<body>

	<?php
	$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
	mysql_select_db("sphonlin_sphonline", $GLOBALS['link']);

	$tipo[1] = "Usuario";
	$tipo[2] = "Administrador";
	$tipo[3] = "Vendedor";
	$tipo[4] = "Info";
	$tipo[5] = "Sistema";
	$opc = $_REQUEST["opc"];
	$busq = $_REQUEST["bq"];
	$busq2 = $_REQUEST["bq2"];
	$ord = $_REQUEST["ord"];
	?>
	<div id="orden1">
		<table class="ta_borde" border="0" cellpadding="3" cellspacing="0" width="505">
			<tbody>
				<?php
				$blq = 0;
				if ($opc == 1) :
					$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Order By Usuario Asc",  $GLOBALS['link']);
				elseif ($opc == 2) :
					$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Order By Usuario Desc",  $GLOBALS['link']);
				elseif ($opc == 3) :
					if ($busq == 0) :
						$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu ",  $GLOBALS['link']);
					else :
						$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Where Tipo=" . $busq,  $GLOBALS['link']);
					endif;
				elseif ($opc == 4) :
					if ($ord == 1) :
						if ($busq == 0) :
							$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Order By Usuario Asc",  $GLOBALS['link']);
						else :
							$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Where Tipo=" . $busq . " Order By Usuario Asc",  $GLOBALS['link']);
						endif;
					else :
						if ($busq == 0) :
							$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Order By Usuario Desc",  $GLOBALS['link']);
						else :
							$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Where Tipo=" . $busq . " Order By Usuario Desc",  $GLOBALS['link']);
						endif;
					endif;
				elseif ($opc == 5) :
					if ($busq2 == 0) :
						if ($ord == 1) :
							$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Order By IDusu Asc",  $GLOBALS['link']);
						elseif ($ord == 2) :
							$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Order By IDusu Desc",  $GLOBALS['link']);
						else :
							$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu ",  $GLOBALS['link']);
						endif;
					else :
						$result2 = mysqli_query($GLOBALS['link'], "Select * From _tconsecionario Where IDG=" . $busq2, $GLOBALS['link']);
						if (mysqli_num_rows($result2) != 0) :
							while ($row2 = mysqli_fetch_array($result2)) {
								$busq3 = $row2["IDC"];
								if ($ord == 1) :
									$result = mysqli_query($GLOBALS['link'], "Select * From _tusu Where Tipo=3 and Asociado='" . $busq3 . "' Order By IDusu Asc", $GLOBALS['link']);
								elseif ($ord == 2) :
									$result = mysqli_query($GLOBALS['link'], "Select * From _tusu Where Tipo=3 and Asociado='" . $busq3 . "' Order By IDusu Desc", $GLOBALS['link']);
								else :
									$result = mysqli_query($GLOBALS['link'], "Select * From _tusu Where Tipo=3 and Asociado='" . $busq3 . "'", $GLOBALS['link']);
								endif;
								if (mysqli_num_rows($result) != 0) :
									$un = 1;
									while ($row = mysqli_fetch_array($result)) {
										if ($un == 1) :
											echo "<tr class='ta_tr_left' bgcolor='white'>";
											$un = 0;
										else :
											echo "<tr class='ta_tr_left' >";
											$un = 1;
										endif;
										echo "<td  width='10'> ";
										if ($row['bloqueado'] != 0) :
											echo "<img id='blk" . $row["IDusu"] . "' src='media/lock.png' height='16' width='16' onclick='desbloqueo(" . $row["IDusu"] . ");'/>";
										endif;
										echo "</td><td  width='300'> ";
										if ($row["Estatus"] == 1) :
											echo " <img src='media/user.png' />";
										endif;
										if ($row["Estatus"] == 2) :
											echo " <img src='media/delete.png' />";
										endif;
										echo "  ID: " . $row["IDusu"] . " Usuario: <u><strong>" . $row["Usuario"] . "</strong></u> Tipo: " . $tipo[$row["Tipo"]];

										echo "</td>";
										$vc = "'usuario.php?fc=" . $row["IDusu"] . "'";
										echo '<td > <input type="button" value="ver" title="' . $vc . '" onclick="javascript:makeRequest(' . $vc . ');">';

										echo "</td>";
									}
								endif;
							}

						endif;
						$blq = 1;

					endif;
				endif;

				if ($blq == 0) :

					if (mysqli_num_rows($result) != 0) :
						$un = 1;
						while ($row = mysqli_fetch_array($result)) {
							if ($un == 1) :
								echo "<tr class='ta_tr_left' bgcolor='white'>";
								$un = 0;
							else :
								echo "<tr class='ta_tr_left' >";
								$un = 1;
							endif;
							echo "<td  width='10'> ";
							if ($row['bloqueado'] != 0) :
								echo "<img id='blk" . $row["IDusu"] . "' src='media/lock.png' height='16' width='16' onclick='desbloqueo(" . $row["IDusu"] . ");'/>";
							endif;
							echo "</td><td  width='300'> ";
							if ($row["Estatus"] == 1) :
								echo " <img src='media/user.png' />";
							endif;
							if ($row["Estatus"] == 2) :
								echo " <img src='media/delete.png' />";
							endif;
							echo "  ID: " . $row["IDusu"] . " Usuario: <u><strong>" . $row["Usuario"] . "</strong></u> Tipo: " . $tipo[$row["Tipo"]];

							echo "</td>";
							$vc = "'usuario.php?fc=" . $row["IDusu"] . "'";
							echo '<td > <input type="button" value="ver" title="' . $vc . '" onclick="javascript:makeRequest(' . $vc . ');">';

							echo "</td>";
						}
					endif;
				endif;
				?>
				</tr>
			</tbody>
		</table>
	</div>
</body>