<?

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$Formato	= $_REQUEST['Formato'];



?>

<select name="select2" id="iAddcional">
	<option value="0">Todos</option>
	<?
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria_formato WHERE Formato=  $Formato");
	$row = mysqli_fetch_array($result);

	$IFormx = explode('|',  $row['Lista']);

	for ($i = 0; $i <= count($IFormx) - 1; $i++)
		echo '   <option value="' . ($i + 1) . '">' . $IFormx[$i] . '</option>';



	?>
</select>