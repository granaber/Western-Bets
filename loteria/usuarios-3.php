<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$sql = $_REQUEST['SQL']; /// Instruccion en SQL
$id = $_REQUEST['id'];   /// Id del Select
$idSelect = $_REQUEST['idS']; /// Valor de Value
$idDescrip = $_REQUEST['idD']; /// Valor a Mostrar en Select
$vSelecct = $_REQUEST['Seleccion']; /// Seleccion Marcada

$resultj = mysqli_query($GLOBALS['link'], $sql);
echo '<select  id="' . $id . '">';
while ($row = mysqli_fetch_array($resultj)) {
  $TxtSeleccion = '';
  if ($row[$idSelect] == $vSelecct) : $TxtSeleccion = 'selected="selected"';
  endif;
  echo '<option value="' . $row[$idSelect] . '"  ' . $TxtSeleccion . '>' . $row[$idDescrip] . '</option>';
}
echo '</select>';
