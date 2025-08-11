<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbcuadre where IDCierre = " . $_REQUEST['IDCierre']);
$rowj = mysqli_fetch_array($resultj);
$IDCierre = $rowj["IDCierre"];

$resultAgencia = mysqli_query($GLOBALS['link'], "SELECT * FROM _tagencias where IDC = " . $rowj["IDC"]);
$rowjAgencia = mysqli_fetch_array($resultAgencia);


?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" align="center">Cierre de Caja</td>
  </tr>
  <tr>
    <td colspan="2">Agencia:</td>
    <td colspan="2"><? echo '(' . $rowjAgencia['IDC'] . ')-' . $rowjAgencia['Descripcion']; ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center">Relacion de Venta</td>
  </tr>
  <tr>
    <td colspan="4">Premios Pagados Bsf.:<? echo $rowj['PremiosPagados']; ?></td>
  </tr>
  <tr>
    <td colspan="4">Total de Venta Bsf.:<? echo $rowj['TotalVenta']; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center">Relacion de Gastos</td>
  </tr>
  <tr>
    <td>Hora</td>
    <td colspan="2">Descripcion</td>
    <td width="96">Monto</td>
  </tr>
  <?
  $sumadegastos = 0;
  $resultjGastos = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgastos where IDC=" . $rowj['IDC'] . " and IDJ=" . $rowj['IDJ']);
  while ($RowGastos = mysqli_fetch_array($resultjGastos)) {
    echo '<tr>';
    echo '<td >' . $RowGastos['Hora'] . '&nbsp;&nbsp;</td>';
    echo '<td colspan="2">' . $RowGastos['Descripcion'] . '&nbsp;</td>';
    echo '<td >' . $RowGastos['Monto'] . '</td>';
    echo '</tr>';
    $sumadegastos += $RowGastos['Monto'];
  }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">---------------------------------------</td>
  </tr>
  <tr>
    <td colspan="3">Total de Gastos:</td>
    <td><? echo $sumadegastos; ?></td>
  </tr>
  <tr>
    <td colspan="4">---------------------------------------</td>
  </tr>
  <tr>
    <td colspan="4" align="center">Cuadre de Caja</td>
  </tr>
  <tr>
    <td colspan="2">Cantidad</td>
    <td>Denominacion</td>
    <td>Total</td>
  </tr>
  <?
  $sumacuadre = 0;
  $resultj = mysqli_query($GLOBALS['link'], "SELECT Cantidad,TxtDenomiacion,Cantidad as Cantidad2,_tbdenominaciones.Denominacion FROM _tbdenominaciones  LEFT JOIN _tbcuadre_denominacion  ON _tbdenominaciones.Denominacion=_tbcuadre_denominacion.Denominacion and IDCierre=" . $_REQUEST['IDCierre'] . " Order by posicion asc");
  while ($Row = mysqli_fetch_array($resultj)) {
    echo '<tr>';
    if (is_null($Row['Cantidad'])) :
      echo '<td colspan="2" align="center">0</td>';
    else :
      echo '<td colspan="2" align="center">' . $Row['Cantidad'] . '</td>';
    endif;
    echo '<td  align="center">' . $Row['TxtDenomiacion'] . '</td>';
    if (is_null($Row['Cantidad'])) :
      echo '<td align="center">0</td>';
    else :
      echo '<td align="center">' . ($Row['Cantidad2'] * $Row['Denominacion']) . '</td>';
      $sumacuadre += ($Row['Cantidad2'] * $Row['Denominacion']);
    endif;
    echo '</tr>';
  }

  $resultjAp = mysqli_query($GLOBALS['link'], "SELECT * FROM _tapertura where IDAp=" . $rowj['IDAp']);
  $RowAp = mysqli_fetch_array($resultjAp);


  ?>

  <tr>
    <td colspan="4">---------------------------------------</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>Total de Cuadre:</td>
    <td><? echo $sumacuadre; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>Fondo de Caja:</td>
    <td><? echo $RowAp['MontodeApetura']; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>Diferencia:</td>
    <td><? echo (($rowj['TotalVenta'] + $RowAp['MontodeApetura']) - ($rowj['PremiosPagados'] + $sumadegastos) - $sumacuadre); ?></td>
  </tr>
</table>
-<br />
-<br />
-<br />
-<br />
-<br />
-<br />
-<br />
-<br />