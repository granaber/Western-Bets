<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$idTipo = $_REQUEST['idTipo'];
$tabla = '';
$camclave = '';
tabla_tipo($idTipo, $tabla, $camclave);
echo '<select id="seleccion" >';
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM " . $tabla . " order by " . $camclave);
while ($row = mysqli_fetch_array($result)) {
  echo '<option value="' . $row[$camclave] . '">' . $row['Descripcion'] . '</option>';
}
echo '</select>';
