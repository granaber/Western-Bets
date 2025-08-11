<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();
$IDC = $_REQUEST['IDC'];
$iHb = '';
$iVenta = '';
$iParti = '';
$iParti2 = '';
$iPremio = array();
$iMinimo = '';
$iMaximo = '';
$iMontSort = '';
$iTkElim = '';
$iTkPagar = 0;
$iPVentas = 0;
$iPremioTripleta = 0;
$iMontMaxTripleta = 0;
$isActiveTripleta = false;
$iPremioProx = -1;
$iAceptoPorcentaje = 100;

$resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani  Where IDC='$IDC'");
//echo ("SELECT * FROM _Concesionario_Ani  Where IDC='$IDC'");;
if (mysqli_num_rows($resultj) != 0) :
  $row = mysqli_fetch_array($resultj);
  $iHb = $row['iHb'];
  $iVenta = $row['iPVenta'];
  $iParti = $row['iPParti'];
  $iParti2 = $row['iPParti2'];
  $iPremio[0] = $row['iPremio'];
  $iMinimo = $row['iMontMin'];
  $iMaximo = $row['iMontMax'];
  $iMontSort = $row['iMontSort'];
  $iTkElim = $row['iTkElim'];
  $iTkPagar = $row['iTkPagar'];
  $iAceptoPorcentaje = $row['iAceptoPorcentaje'];
  $iPVentas = $row['iPVentas'];

  $iPremioTripleta = $row['iPremioTripleta'];
  $iMontMaxTripleta = $row['iMontMaxTripleta'];
  $isActiveTripleta = getTripleta(1);
  $iPremioProx = -1;

endif;

if ($iPVentas == 0) {
  $iPVentas = $iVenta;
}
?>
<br><br>
<div style="overflow:auto;height:800px;">


  <table width="400" border="0">
    <tr>
      <td width="257" align="right">
        <p style="font-size:12px"><input id="iHb" type="checkbox" value="" <? echo ($iHb == 1 ? 'checked' : '');
                                                                            ?> />&nbsp;Habilitar venta de Animalitos</p>
      </td>
      <td width="216"></td>
    </tr>
    <tr>
      <td>
        <p style="font-weight: bold;">% de Venta:</p>
      </td>
      <td><input id="iVenta" class="input-habilitar" value="<? echo $iVenta; ?>" type="text" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iParti') " onkeypress=' return permitebbDUK(event,"num");' /></td>
    </tr>
    <tr>
      <td>
        <p style="font-weight: bold;">% de Participacion:</p>
      </td>
      <td>
        <section style="display: flex;flex-direction: column;">

          <section>
            <label style="width: 62px;">Ganacia:</label><input id="iParti" class="input-habilitar" style="width: 50px;" value="<? echo $iParti; ?>" type="text" size="5" maxlength="5" onkeyup=" pressSpecialNMDUK(event,'iParti2') " onkeypress=' return permitebbDUK(event,"num");' />
          </section>
          <section>

            <label style="width: 62px;">Perdida:</label><input id="iParti2" class="input-habilitar" style="width: 50px;" value="<? echo $iParti2; ?>" type="text" size="5" maxlength="5" onkeyup=" pressSpecialNMDUK(event,'iPremio') " onkeypress=' return permitebbDUK(event,"num");' />
          </section>

        </section>
      </td>
    </tr>
    <tr>
      <td>
        <p style="font-weight: bold;">6.-Pagar Tickets:</p>
      </td>
      <td><input id="iTkPagar" type="checkbox" value="" <? echo ($iTkPagar == 1 ? 'checked' : ''); ?> /></td>
    </tr>
    <tr>
      <td>
        <p style="font-weight: bold;">5.-Ticket a Eliminar:</p>
      </td>
      <td><input id="iTkElim" class="input-habilitar" value="<? echo $iTkElim; ?>" type="text" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iAceptoPorcentaje') " onkeypress=' return permitebbDUK(event,"num");' /></td>
    </tr>
    <tr>
      <td>
        <p style="font-weight: bold;">7.-% de Numero permitidos vender:</p>
      </td>
      <td><input id="iAceptoPorcentaje" class="input-habilitar" value="<? echo $iAceptoPorcentaje; ?>" type="number" min="0" max="100" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iVenta') " onkeypress=' return permitebbDUK(event,"num");' />
      </td>
    </tr>
    <?
    $i = 1;

    $resultj2 = mysqli_query($link, "SELECT * FROM _Loterias ");
    while ($row2 = mysqli_fetch_array($resultj2)) {
      if ($row2['IDL'] != 1) :
        //iPremio,iMontSort,iMontMin,iMontMax
        $iMinimo = '';
        $iMaximo = '';
        $iMontSort = '';
        $iAceptoPorcentaje = 100;
        $iPVentas = 0;
        $iPremioTripleta = 0;
        $iMontMaxTripleta = 0;
        $isActiveTripleta = false;
        $iPremioProx = '';

        if ($row2['xFun'] == '0' || $row2['xFun'] == '-1' || $row2['xFun'] == '3' || $row2['xFun'] == '4') :
          if ($row2['Code'] == '') :
            $CantiPremios = 1;
          else :
            if ($row2['xFun'] == '4') :
              $CantiPremios = $row2['minimalNumber'];
            else :
              $CantiPremios = $row2['Code'];
            endif;
          endif;
          $iPremio[0] = '';
          $iPremio[1] = '';
          $iPremio[2] = '';
        else :
          $CantiPremios = 1;
          $iPremio[0] = '';
        endif;
        $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani_2  Where IDL=" . $row2['IDL'] . " and  IDC='$IDC'");
        if (mysqli_num_rows($resultj) != 0) :
          $row = mysqli_fetch_array($resultj);
          $iPremio[0] = $row['iPremio'];
          $iPremio[1] = $row['iPremio1'];
          $iPremio[2] = $row['iPremio2'];
          //print_r($iPremio);
          $iMinimo = $row['iMontMin'];
          $iMaximo = $row['iMontMax'];
          $iMontSort = $row['iMontSort'];
          $iAceptoPorcentaje = $row['iAceptoPorcentaje'];
          $iPVentas = $row['iPVentas'];
          $iPremioTripleta = $row['iPremioTripleta'];
          $iMontMaxTripleta = $row['iMontMaxTripleta'];
          $iPremioProx = $row['iPremioProx'];

          if ($row2['Code'] == '') :
            $CantiPremios = 1;
          endif;
          if ($iPVentas == 0) {
            $iPVentas = $iVenta;
          }

        /////

        endif;
      else :
        $CantiPremios = 1;
        $iPremio[0] = '';

      endif;

      $isActiveTripleta = getTripleta($row2['IDL']);
    ?>
      <tr>
        <td height="23" colspan="2" style=" background-color:<?= $lisColorsLottery[$row2['IDL'] - 1] ?>;
    font-size: 14px;
    font-weight: bold;
    color: #dee2e6;
    padding-top: 2px;">
          <p align="center">Restricciones de <?= $row2['Nombre']; ?></p>
        </td>
      </tr>
    <?
      $IDL = $row2['IDL'];
      include './Ani_Habilitar-2-1.php';
      $i++;
    }
    ?>

  </table>
</div>
<span id='cIDL' lang="<? echo $i - 1; ?>"></span>