<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();
$IDG = $_REQUEST['IDG'];


?>
<div style="overflow:auto;height:800px;">


  <table width="400" border="0">
    <?
    $i = 1;

    $resultj2 = mysqli_query($link, "SELECT * FROM _Loterias ");
    while ($row2 = mysqli_fetch_array($resultj2)) {
      $IDL = $row2['IDL'];
      $iMontSort = '';
      $iMontMaxNum = '';

      $resultj = mysqli_query($link, "SELECT * FROM _Grupos_topes  Where IDG=$IDG and IDL=$IDL");
      //echo ("SELECT * FROM _Concesionario_Ani  Where IDC='$IDC'");;
      if (mysqli_num_rows($resultj) != 0) :
        $row = mysqli_fetch_array($resultj);
        $iMontSort = $row['iMontSort'];
        $iMontMaxNum = $row['iMontMaxNum'];
      endif;
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
      include './Ani_Habilitar-2-1-G.php';
      $i++;
    }
    ?>

  </table>
</div>
<span id='cIDL' lang="<? echo $i - 1; ?>"></span>