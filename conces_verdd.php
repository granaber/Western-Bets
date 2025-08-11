<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$idt = $_REQUEST['idt'];
$accesogp = accesolimitado($idt);
$fc = $_REQUEST["fc1"];			?>
<select name="select" id="tidc" onChange="jsonvalores_v9('<?php echo $fc; ?>')">
	<option value='0'>Todos</option>;
	<?
	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
	if (mysqli_num_rows($resultj) != 0) :
		$rowj = mysqli_fetch_array($resultj);
		$idj = $rowj["IDJ"];
	else :
		$idj = 0;
	endif;

	if ($accesogp == 0) :
		$result3 = mysqli_query($GLOBALS['link'], "SELECT IDC FROM _tjugadabb where IDJ=" . $idj . " group by IDC");
	else :
		$result3 = mysqli_query($GLOBALS['link'], "SELECT IDC FROM _tjugadabb where IDJ=" . $idj . " and IDC in (SELECT IDC FROM _tconsecionario where  IDG=" . $accesogp . " )  group by IDC");
	endif;
	while ($row3 = mysqli_fetch_array($result3)) {
		echo "<option  value='" . $row3["IDC"] . "'>" . $row3["IDC"] . "</option>";
	}
	?>
</select>