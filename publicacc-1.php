<div id="box5" style="width:500px; background:#333333">
	<table width="498px" border="0" cellpadding="0" cellspacing="0">

		<tr bgcolor="#FFCC00">
			<th scope="col"><span style="color:#000000">Deporte</span></th>
			<th scope="col"><span style="color:#000000">Acceso</span></th>
		</tr>
		<?php
		require('prc_php.php');
		$GLOBALS['link'] = Connection::getInstance();

		$fc = $_REQUEST["fc"];
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "' ");
		$i = 0;
		if (mysqli_num_rows($resultj) != 0) :
			while ($row = mysqli_fetch_array($resultj)) {
				if ($i == 0) :
					$bkcolor = "#666666";
					$i = 1;
				else :
					$bkcolor = "#333333";
					$i = 0;
				endif;
				$idj = $row["IDJ"];
				$grp = $row["Grupo"];
				$resulpubli = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpublicaciones where IDJ=" . $idj . " and Grupo=" . $grp);
				if (mysqli_num_rows($resulpubli) != 0) :
					$row1 = mysqli_fetch_array($resulpubli);
				endif;
				$resulgrup = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where  Grupo=" . $grp);
				$row2 = mysqli_fetch_array($resulgrup);
		?>
				<tr bgcolor="<? echo $bkcolor; ?>">
					<th scope="col" align="left"><img src="media/estrella.png" width="8" height="8"><span style="color:#FFFFFF; font-size:12px"><? echo $row2['Descripcion'];  ?></span></th>
					<th scope="col" id=""><?
											if (mysqli_num_rows($resulpubli) != 0) :
												if ($row1['Publicar'] == 1) : /* 1=Desbloqueado ; 2=Bloqueado */
													echo '<img id="im' . $idj . '_' . $grp . '" src="media/ver2.png" width="32" height="24" onclick="publicardd(event,' . $idj . ',' . $grp . ');">';
												else :
													echo '<img id="im' . $idj . '_' . $grp . '" src="media/lock.png" width="32" height="24" onclick="publicardd(event,' . $idj . ',' . $grp . ');">';
												endif;
											else :
												echo '<img id="im' . $idj . '_' . $grp . '" src="media/lock.png" width="32" height="24" onclick="publicardd(event,' . $idj . ',' . $grp . ');">';
											endif;

											?></th>
				</tr>
		<? }
		endif;
		?>
	</table>

</div>