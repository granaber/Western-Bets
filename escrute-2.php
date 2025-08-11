<?php

require('prc_php.php');
$link = Connection::getInstance();

$fc = $_REQUEST["fc"];
$resultj = mysqli_query($link, "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
if (mysqli_num_rows($resultj) != 0) :
	$rowj = mysqli_fetch_array($resultj);
	$idj = $rowj["IDJ"];
else :
	$idj = 0;
endif;
$LogoDefautl = "media/undefine.png"

?>

<div class="escruting-main-form ">
	<section class="escruting-form1">
		<?php

		$resultj = mysqli_query($link, "SELECT * FROM _gruposdd where Estatus=1 Order by Grupo");
		$i = 1;

		while ($Row = mysqli_fetch_array($resultj)) {




			$estatus = 4;
			$resultj1 = mysqli_query($link, "SELECT * FROM _jornadabb where Fecha='" . $fc . "' and Grupo=" . $Row['Grupo']);
			if (mysqli_num_rows($resultj1) != 0) :
				$Row_1 = mysqli_fetch_array($resultj1);

				$resultj2 = mysqli_query($link, "SELECT count(IDJ) as TotaldeepartidosCerrado FROM _cierrebb where IDJ=" . $idj . " and Grupo=" . $Row['Grupo'] . "  Group by IDJ");
				if (mysqli_num_rows($resultj2) != 0) :
					$Row_2 = mysqli_fetch_array($resultj2);
					if ($Row_1['Partidos'] != $Row_2['TotaldeepartidosCerrado']) :
						$estatus = 1;
					else :
						$resultj3 = mysqli_query($link, "SELECT * FROM _tbescrute where IDJ=" . $idj . " and Grupo=" . $Row['Grupo']);
						if (mysqli_num_rows($resultj3) != 0) :
							$estatus = 2;
						else :
							$estatus = 3;
						endif;
					endif;
				else :
					$estatus = 3;
				endif;

				$grpu = "'escrute-1.php?idj=" . $idj . "&idg=" . $Row['Grupo'] . "'";
				$onclick =  ($estatus == 2 || $estatus == 3  || $estatus == 1) ? 'onclick = "get_escrute(this,' . $grpu . ');"' : '';
				$add_class = "";

				switch ($estatus) {
					case 3:
						$add_class = "escruting-button-partidos-no-cerrados";
						break;
					case 2:
						$add_class = "escruting-button-partidos-listo-para-escrutar";
						break;
					case 1:
						$add_class = "escruting-button-partidos-en-procesos";
						break;
				}
				echo '<button class="escruting-button-option ' . $add_class . '"  id="la' . $Row['Grupo'] . '"  ' . $onclick . ' >' . $Row['Descripcion'] . '</button>';
			endif;
			// $nameEqui = 'media/' . $Row['imagen'];
			// if (!file_exists($nameEqui)) {
			// 	$nameEqui = $LogoDefautl;
			// }

			// 	echo '<th id="la' . $Row['Grupo'] . '1"class="' . $bgh . '"  ><div  align="center" ><img  src="' . $nameEqui . '"  height="32" width="32"  /></div></th>';


			// 	echo '</tr>';
			// endif;
		}
		?>
	</section>
	<section id="select-escrute-from">
	</section>

</div>