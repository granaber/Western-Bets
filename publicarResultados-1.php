<div id="fromJornada1" style="width: 100%; height: 100%; overflow: auto;">
    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">

        <tr class="tb-public-result-head">
            <th scope="col">
                <h5>Deporte</h5>
            </th>
            <th scope="col">
                <h5>Publicar</h5>
            </th>
        </tr>
        <?php
		require('prc_php.php');
		$link = Connection::getInstance();

		$fc = $_REQUEST["fc"];
		$resultj = mysqli_query($link, "SELECT * FROM _jornadabb where Fecha='" . $fc . "' ");
		$i = 0;
		if (mysqli_num_rows($resultj) != 0) :
			while ($row = mysqli_fetch_array($resultj)) {
				// if ($i == 0) :
				// 	$bkcolor = "#666666";
				// 	$i = 1;
				// else :
				// 	$bkcolor = "#333333";
				// 	$i = 0;
				// endif;
				$idj = $row["IDJ"];
				$grp = $row["Grupo"];
				$resulpubli = mysqli_query($link, "SELECT * FROM _tbpubliresultados where IDJ=" . $idj . " and Grupo=" . $grp);
				if (mysqli_num_rows($resulpubli) != 0) :
					$row1 = mysqli_fetch_array($resulpubli);
				endif;
				$resulgrup = mysqli_query($link, "SELECT * FROM _gruposdd where  Grupo=" . $grp);
				$row2 = mysqli_fetch_array($resulgrup);
		?>
        <tr class="tb-public-resul-row">
            <th scope="col" align="left">
                <?= trim($row2['Descripcion']);  ?>
            </th>
            <th scope="col" id="">
                <input id="im<?= $idj ?>_<?= $i ?>" data-gp="<?= $grp ?>" class="checkbox-resul" type="checkbox"
                    <?= mysqli_num_rows($resulpubli) != 0 && $row1['Publicar'] == 1 ? 'checked' : '' ?> />
                <?
						// if (mysqli_num_rows($resulpubli) != 0) :
						// 	if ($row1['Publicar'] == 1) : /* 1=Desbloqueado ; 2=Bloqueado */

						// 		echo '<img id="im' . $idj . '_' . $grp . '" src="media/ver2.png" width="32" height="24" onclick="publicarResultados(event,' . $idj . ',' . $grp . ');">';
						// 	else :
						// 		echo '<img id="im' . $idj . '_' . $grp . '" src="media/lock.png" width="32" height="24" onclick="publicarResultados(event,' . $idj . ',' . $grp . ');">';
						// 	endif;
						// else :
						// 	echo '<img id="im' . $idj . '_' . $grp . '" src="media/lock.png" width="32" height="24" onclick="publicarResultados(event,' . $idj . ',' . $grp . ');">';
						// endif;

						?>
            </th>
        </tr>
        <? $i++;
			}
		endif;
		?>
    </table>
</div>
<section id="info-data" data-idj="<?= $idj ?>" data-ln="<?= $i ?>" />