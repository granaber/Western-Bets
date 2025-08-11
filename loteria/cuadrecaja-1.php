<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

if ($_REQUEST['IDCtrr'] == -2) :
  $x = 1;
else :
  $x = $_REQUEST['IDCtrr'];
endif;

$Ventas = ConsultadeVentas($x, $_REQUEST['IDJ']);
$Fondo = ConsultadeFondo($x, $_REQUEST['IDJ']);
$Gastos = ConsultadeGastos($x, $_REQUEST['IDJ']);
$Premios = ConsultadePremiosPagados($x, $_REQUEST['IDJ']);

$resultChq1 = mysqli_query($GLOBALS['link'], "SELECT IDAp FROM _tapertura where IDC=" . $x . " and IDJ=" . $_REQUEST['IDJ']);

$row = mysqli_fetch_array($resultChq1);
?>
<span id="IDAp" lang="<? echo  $row['IDAp']; ?>"></span>
<table border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#BCD5FE">
    <td width="193"><span style="font-size:12px">Premios Pagados(-):</span></td>
    <td width="125">
      <input type="text" name="textfield" id="PremioP" size="10" value="<? echo $Premios; ?>">
    </td>
  </tr>
  <tr>
    <td><span style="font-size:12px">Total de Gastos(-):</span></td>
    <td><input type="text" name="textfield" id="TotalG" size="10" value="<? echo $Gastos; ?>"></td>
  </tr>
  <tr bgcolor="#BCD5FE">
    <td><span style="font-size:12px">Total de Venta(+):</span></td>
    <td><input type="text" name="textfield" id="TotalV" size="10" value="<? echo $Ventas; ?>"></td>
  </tr>
  <tr>
    <td><span style="font-size:12px">Sub-Total (=)</span></td>
    <td><input type="text" name="textfield" id="TotalC" size="10" value="<? echo $Ventas - ($Premios + $Gastos); ?>"></td>
  </tr>
  <tr bgcolor="#BCD5FE">
    <td><span style="font-size:12px">Fondo de Caja(+):</span></td>
    <td><input type="text" name="textfield" id="Fondo" size="10" value="<? echo $Fondo; ?>"></td>
  </tr>
  <tr>
    <td><span style="font-size:12px">Tota Cuadre(A Entregar):</span></td>
    <td><input type="text" name="textfield" id="Cuadre" size="10" value="0"></td>
  </tr>
  <tr bgcolor="#F87E61">
    <td><span id='Dif' style="font-size:12px" lang='<? echo (($Ventas + $Fondo) - ($Premios + $Gastos)); ?>'>Diferencia:</span></td>
    <td><input type="text" name="textfield" id="Diferencia" size="10" value="<? echo (($Ventas + $Fondo) - ($Premios + $Gastos)); ?>"></td>
  </tr>
</table>