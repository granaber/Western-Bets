<div id="box12" style="width:800px; height:700px; background: #517899 ">



	<?

	require_once('prc_php.php');

	$GLOBALS['link'] = Connection::getInstance();



	$fc = $_REQUEST["fc1"];





	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");

	if (mysqli_num_rows($resultj) != 0) :

		$rowj = mysqli_fetch_array($resultj);

		$IDJ = $rowj["IDJ"];

	else :

		$IDJ = 0;

	endif;



	$arreglolote = array();



	$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDJ=" . $IDJ . " and Grupo>=2 Order by Hora,IDP");

	$primerahora = 0;
	$i = 0;
	$cadatres = 0;

	while ($rowp = mysqli_fetch_array($resultp)) {



		if (strcmp($primerahora, $rowp['Hora']) != 0) :

			if ($primerahora != 0) : echo '</div>';
			endif;

			$primerahora = $rowp['Hora'];

			$i++;
			$serial = 1;



			$allado = "float:left";



			echo '<div style="width:250px; height:150px;' . $allado . '  "><input id="l' . $i . '" type="checkbox" value=""><strong style="font-size:14px"> Lote No.' . $i . '</strong><br>';

		endif;

		$result1 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $rowp['IDE1']);
		$row1 = mysqli_fetch_array($result1);
		$nequipo1 = $row1['Descripcion'];

		$result1 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $rowp['IDE2']);
		$row1 = mysqli_fetch_array($result1);
		$nequipo2 = $row1['Descripcion'];



		$arreglolote[] = $i . '|' . $rowp['IDP'] . '|' . $nequipo1 . '|' . $nequipo2 . '|' . $rowp['Hora'];

		$resultcierre = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrebb where IDP=" . $rowp['IDP'] . " and Grupo>=2");

		if (mysqli_num_rows($resultcierre) != 0) :

			echo '<img id="e_' . $i . '_' . $serial . '" lang="1" src="media/estrella.png" width="16" height="16">' . $nequipo1 . '-' . $nequipo2 . ' ' . $rowp['Hora'] . '<br>';

		else :

			echo '<img id="e_' . $i . '_' . $serial . '" lang="0" src="media/lock.png" width="16" height="16">' . $nequipo1 . '-' . $nequipo2 . ' ' . $rowp['Hora'] . '<br>';

		endif;

		$serial++;
	}





	?>

	<samp id="ultimo" lang="<? echo $i; ?>"></samp><samp id="IDJ" lang="<? echo $IDJ; ?>"></samp>

</div>

<script>
	serial = 1;

	for (i = 1; i <= parseInt($('ultimo').lang); i++)

	{



		while (isset('e_' + i + '_' + serial))

		{

			if ($('e_' + i + '_' + serial).lang == '0') {
				$('l' + i).disabled = "disabled";
				break;
			}

			serial++;

		}

		serial = 1;

	}
</script>