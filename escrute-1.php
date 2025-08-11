<div id="box4" style="padding: 1px;background:#EFEFEF">

	<?php

	require('prc_php.php');
	$link = Connection::getInstance();
	$_IS_EMPATE = 5;
	$idj = $_REQUEST["idj"];
	$idg = $_REQUEST["idg"];
	$get_data = get_col_escruting($idg);
	$CODE_SUSPEND = "!";
	$CODE_NOT_RESULT = "*";
	$form_imput = [];
	$public_result = false;
	$resultj = mysqli_query($link, "SELECT * FROM _tbpubliresultados where IDJ=" . $idj . " and Grupo=" . $idg);
	if (mysqli_num_rows($resultj) != 0) :
		$Row_resul = mysqli_fetch_array($resultj);
		$public_result = $Row_resul['Publicar'] == 1;
	endif;
	?>
	<?
	if ($public_result) : ?>
		<button class="escrute-btn-despublicar" data-set="<?= $idj . "-" . $idg ?>">
			DES-PUBLICAR
		</button>
	<? endif; ?>
	<table id="<?= $idg ?>" style="background:#EFEFEF" border="0" cellspacing="0"
		class="<?= $public_result ?  "escrutin-desactive-all" : "" ?> ">
		<thead class="">
			<tr>
				<th scope="col" class="tb-escrute-head">
					No. Partido
				</th>
				<th scope="col" class="tb-escrute-head">
					Equipos
				</th>
				<?
				foreach ($get_data as $clave => $valor) { ?>
					<th scope="col" class="tb-escrute-head">
						<?= $valor['descripcion'] ?>
					</th>
				<? }
				?>
			</tr>
		</thead>
		<tbody id='fmr-data'>
			<?php

			$resultj = mysqli_query($link, "SELECT * FROM _partidosbb where IDJ=" . $idj . " and Grupo=" . $idg);
			$i = 1;
			while ($Row = mysqli_fetch_array($resultj)) {
				$DATA_LATR = "la" . $Row['IDP'];
				$no_active = false;
				$Esrute_Data = [];
				$jc = true;
				$resultj3 = mysqli_query($link, "SELECT * FROM _tbescrute where IDJ=" . $idj . " and Grupo=" . $Row['Grupo'] . " and IDP=" . $Row['IDP']);
				if (mysqli_num_rows($resultj3) != 0) :
					$Row_esc = mysqli_fetch_array($resultj3);
					$Esrute_Data = explode("|", $Row_esc['Escrute']);
					$jc = $Row_esc['juegocompleto'] == 1;
					$suspend  = 0;
					$total_record_escrute = count($Esrute_Data);
					for ($i = 1; $i < $total_record_escrute; $i += 2) {
						if (str_contains($Esrute_Data[$i], $CODE_SUSPEND)) {
							$suspend++;
						}
					}
					$no_active = (($total_record_escrute - 1) / 2) == $suspend;

				endif;
				$state_btnSpecial = "";
				if ($public_result) {
					$state_btnSpecial = "disabled";
				}

				$grpu = "'escrute-1-1.php?idj=" . $idj . "&idg=" . $Row['Grupo'] . "&idp=" . $Row['IDP'] . "'";

				$idCLoset = "btClose-" . $Row['IDP'];
				echo '<tr  id="' . $DATA_LATR  . '" class="tb-escrute-line"   >';
				$button_optional = "<div  id='" . $idCLoset . "'><label class='switch'><input autocomplete='off'  id='a-" . $idCLoset . "' $state_btnSpecial data-type='s' data-idp='" . $Row['IDP'] . "' " . ($no_active ? '' : 'checked') . " type='checkbox'><span class='slider round'></span></label></div>";
				$state = "";
				$resultj2 = mysqli_query($link, "SELECT  * FROM _cierrebb where IDP=" . $Row['IDP']);
				if (mysqli_num_rows($resultj2) == 0) {
					$button_optional = "<div  id='" . $idCLoset . "'><button id='a-" . $idCLoset . "'  $state_btnSpecial class='escrute-btn-close' data-type='c' data-idp='" . $Row['IDP'] . "-" . $Row['Grupo'] . "-" . $idj . "'>Cerrar</button></div>";
					$state = "disabled";
				}
				if ($no_active) {
					$state = "disabled";
				}
				if ($public_result) {
					$state = "disabled";
				}
				echo '<th id="la' . $Row['IDP'] . '-1"   ><h3 class="tb-escrute-line-idp">' . $Row['IDP'] . '</h3>' . $button_optional . '</th>';

				$resultj2 = mysqli_query($link, "SELECT * FROM _equiposbb where IDE=" . $Row['IDE1']);
				$Row_equi = mysqli_fetch_array($resultj2);
				echo '<th id="la' . $Row['IDP'] . '-2"   ><div  class="tb-escrute-name " >' . strtolower($Row_equi['Descripcion']) . '</div>';
				$resultj2 = mysqli_query($link, "SELECT * FROM _equiposbb where IDE=" . $Row['IDE2']);
				$Row_equi = mysqli_fetch_array($resultj2);
				echo '<div  class="tb-escrute-name " >' . strtolower($Row_equi['Descripcion']) . '</div></th>';

				$label_radio = 'No';
				$r = 0;

				foreach ($get_data as $clave => $valor) {
					$id1 = "c1-" .  $Row['IDP'] . "-" . $r;
					$id2 = "c2-" .  $Row['IDP'] . "-" . $r;
					echo '<th >';
					$idEsc = $valor['id'];
					$key = array_search($idEsc, $Esrute_Data);
					$resul = ["", ""];
					if (!($key === false)) :
						$resul = explode('-', $Esrute_Data[$key + 1]);
					endif;
					switch ($valor['formato']) {
						case 3:
						case 1:
							$sc1 =  $resul[0] == $CODE_SUSPEND ? '' : ($resul[0] == $CODE_NOT_RESULT ? '' : $resul[0]);
							$sc2 =  $resul[1] == $CODE_SUSPEND ? '' : ($resul[1] ==	$CODE_NOT_RESULT ? '' : $resul[1]);
							echo
							'<div  class="tb-escrute-input-val " ><input autocomplete="off" ' . $state . '  id="' . $id1 . '" type="text" size="4" value="' . $sc1 . '" data-tr="' . $DATA_LATR . '" data-ft="' . $idEsc . '-1" 	class="escrute-input-score"></div>';
							echo
							'<div  class="tb-escrute-input-val " ><input autocomplete="off" ' . $state . '  id="' . $id2 . '" type="text" size="4" value="' . $sc2 . '" data-tr="' . $DATA_LATR . '" data-ft="' . $idEsc . '-2" class="escrute-input-score"></div>';
							$form_imput[] = $id1;
							$form_imput[] = $id2;
							break;
						case 4:
							$label_radio = 'Si';
						case 2:
							$ch1 = $resul[0] == "" || $resul[0] == $CODE_SUSPEND ? '' : ($resul[0] == "1" ? "checked" : "");
							$ch2 = $resul[1] == "" || $resul[1] == $CODE_SUSPEND ? '' : ($resul[1] == "1" ? "checked" : "");
							if ($valor['formato'] == $_IS_EMPATE) {
								if (count($Esrute_Data) == 0) {
									$ch1 = '';
									$ch2 = 'checked';
								}
							}
							echo '<div  class="tb-escrute-input-val " ><input autocomplete="off" data-type="r" ' . $ch1 . ' ' . $state . '  id="' . $id1 . '-r" name="c' .   $Row['IDP'] . "-" . $r . '-' . $valor['formato'] . '" data-tr="' . $DATA_LATR . '" data-ft="' . $idEsc . '-1"  type="radio" class="escrute-radio-score" />Si</div>';
							echo '<div  class="tb-escrute-input-val " ><input autocomplete="off" data-type="r" ' . $ch2 . ' ' . $state . '  id="' . $id2 . '-r" name="c' .   $Row['IDP'] . "-" . $r . '-' . $valor['formato'] . '" data-tr="' . $DATA_LATR . '" data-ft="' . $idEsc . '-2" type="radio" class="escrute-radio-score" />' . $label_radio . '</div>';
							break;
						case 5:
							$ch1 = $jc ? "checked" : "";
							echo
							'<div  class="tb-escrute-input-val " ><input  autocomplete="off" data-type="r"  ' . $ch1 . ' ' . $state . '  id="' . $id1 . '-c" type="checkbox"  data-tr="' . $DATA_LATR . '" data-ft="' . $idEsc . '-1"   class="escrute-check-score"></div>';
					}
					echo '</th>';
					$r++;
				}



				echo '</tr>';
			}
			?>
		</tbody>

	</table>


</div>
<div id="data-fields" data-fields="<?= implode(",", $form_imput) ?>"> </div>

<?

function get_col_escruting($IDG)
{
	global $link;
	$gme = [];
	$list_return = [];
	$resultj = mysqli_query($link, "SELECT * FROM _cngescrute order by posicion");
	while ($Row = mysqli_fetch_array($resultj)) {
		$gme[] = array("id" => $Row['IDCNGE'], "posicion" => $Row['posicion'], 'descripcion' => $Row['Descripcion'], 'formato' => $Row['Formato'], 'iddd' => $Row['IDDD_AESC']);
	}

	$resultj2 = mysqli_query($link, "SELECT * FROM _tbjuegodd where Grupo=$IDG order by IDDD,Formato");
	while ($Row = mysqli_fetch_array($resultj2)) {
		foreach ($gme as $clave => $valor) {
			$iddds = explode('|', $valor['iddd']);
			$key = array_search($Row['IDDD'], $iddds);
			if ($key === false) {
				continue;
			}

			$list_return[$valor['id']] = array('id' => $valor['id'], 'descripcion' => $valor['descripcion'], "posicion" => $valor['posicion'], 'formato' => $valor['formato']);
			if ($valor['formato'] == 3) {
				$list_return[$valor['id'] . '-3'] = array('id' => 'jc', 'descripcion' => 'Full', "posicion" => $valor['posicion'], 'formato' => 5);
			}
		}
	}
	return $list_return;
}

?>

<script>
	obsdata = document.getElementById('data-fields').dataset.fields
	listobjs = obsdata.split(',')
	f = document.getElementById('fmr-data')
	f.addEventListener("keyup", (event) => {
		const ENTER = 13
		const tg = event.target
		if (tg.nodeName === 'INPUT') {
			if (event.keyCode === ENTER) {
				const id = tg.id
				const idx = listobjs.findIndex(o => o === id)
				if (idx !== -1) {
					let rIdx = idx + 1;
					const [, IDP] = id.split('-')
					set_procces_save_Data(IDP, true, false, 1)
					set_focus_element(rIdx)
				}

			}
		}
	});
	f.addEventListener('click', (event) => {

		const NODE_BUTTON = 'BUTTON'
		const NODE_INPUT = 'INPUT'

		const IS_CLOSE_PLAY = 'c'
		const IS_SUSPEN_PLAY = 's'
		const IS_SET_SCORE = 'r'

		const tg = event.target
		if (!tg.disabled) {
			if (tg.nodeName === NODE_BUTTON) {
				const type = tg.dataset.type
				if (type === IS_CLOSE_PLAY) {
					const data = tg.dataset.idp
					close_play(data)
				}
			}
			if (tg.nodeName === NODE_INPUT) {
				const type = tg.dataset.type

				if (type === IS_SET_SCORE) {
					const [, IDP] = tg.id.split('-')
					set_procces_save_Data(IDP, true, false, 1)
				}
				if (type === IS_SUSPEN_PLAY) {
					const IDP = tg.dataset.idp
					const activo = tg.checked
					const stateSave = set_procces_save_Data(IDP, activo, true, !1)
					if (!stateSave) {
						event.preventDefault()
					}
				}
			}

		}
	})

	ds = document.querySelector('.escrute-btn-despublicar')
	ds.addEventListener('click', (event) => {
		const tg = event.target
		const [IDJ, IDG] = tg.dataset.set.split("-")
		handle_set_despublic(IDJ, IDG, tg)
	})


	set_focus_element(0)
</script>