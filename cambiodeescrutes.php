 <?php
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();
	$i = 0;

	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbescrute where Grupo=4");
	while ($row = mysqli_fetch_array($resultj)) {
		$descomp = explode('|', $row['Escrute']);
		for ($i = 0; $i <= count($descomp) - 1; $i++) {
			if ($descomp[$i] == '1') :
				$descomp[$i] = '6';
				$comprimir = implode('|', $descomp);
				echo $comprimir . '<br>';

				$result1 = mysqli_query($GLOBALS['link'], "Update  _tbescrute  set Escrute='" . $comprimir . "' where Ides=" . $row['Ides']);

				break;
			endif;
		}
	}

	$result1 = mysqli_query($GLOBALS['link'], "update _tbescrute set juegocompleto=1 WHERE Grupo=4");
	?>