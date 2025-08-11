<style type="text/css">
  .lbl-moneda-txt {
    font-size: 14px;
    font-weight: bold;
  }

  .alermsg {
    width: 250px;
  }
</style>
<?php
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$idc = $_REQUEST["idc"] ?? '-2';
$op = $_REQUEST["op"] ?? 0;



if ($op == 1) :
  $fc = $_REQUEST["fc"];
  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();


  $idt = $_REQUEST['idt'];
  $accesogp = accesolimitado($idt);

  $resultx = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu where 	IDusu=" . $idt);
  $rowx = mysqli_fetch_array($resultx);
  $impremsg = $rowx['impremsg'];


  $resultx = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
  if (mysqli_num_rows($resultx) != 0) :
    $rowx = mysqli_fetch_array($resultx);
    $idj = $rowx["IDJ"];
    $lg1 = $rowx['LogroSN'];
    $lg2 = $rowx['LogroAB'];
  else :
    $idj = 0;
    $lg1 = 0;
    $lg2 = 0;
  endif;
  echo '<div  >';
else :
  echo '<div>';
endif;
?>

<?php if ($op == 1) : ?>
  <samp id="jornada" title="<?php echo $idj; ?> "> </samp>
<?php endif; ?>
<table height="420" border="0" cellpadding="0" cellspacing="0">
  <?

  if (($idc == '-2' || $idc == '-1' || $idc == '-4') && $op == 1) : ?>
    <tr>
      <td>
        <div align="left" style="margin-top:0px; margin-left:0px">
          <div class="shadowcontainerx2">
            <p align="center" style="color:#000"> Letra:
              <select name='IDC' id='IDC'>
                <option></option>
                <?
                if ($accesogp == 0) :
                  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where IDC!=-2 order by IDC");
                else :
                  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where IDG=" . $accesogp . " and IDC!=-2 order by IDC");
                endif;
                while ($row = mysqli_fetch_array($result)) {
                  echo "<option value=" . $row["IDC"] . ">" . $row["IDC"] . "</option>";
                }

                ?>
              </select>
            </p>
          </div>
        </div>
      </td>
    </tr>
    <script>
      var converted = new Ext.form.ComboBox({
        typeAhead: true,
        triggerAction: 'all',
        transform: 'IDC',
        width: 135,
        selectOnFocus: true,
        forceSelection: true,
        emptyText: 'Seleccione la Letra..',
        forceSelection: true
      });
    </script>
  <?
    $moneda = "?";
  else :
    $idc = $idc == '-1' || $idc == '-4' ? '-2' : $idc;
    $result2 = mysqli_query($GLOBALS['link'], "SELECT sbmonedas.* FROM _tconsecionario,sbmonedas where _tconsecionario.idm=sbmonedas.id and IDC='" . $idc . "'");
    $row2 = mysqli_fetch_array($result2);
    $moneda = $row2['moneda'];
  endif; ?>
  <!-- style="display:none" -->
  <div id="alertmsg" class="alert alert-danger alermsg" style="display:none" role="alert">
    <div class="badge badge-danger text-wrap" style="width: 6rem;">
      <h5>Cierre de partido</h5>
    </div>
    <div>
      <img src="/node_modules/bootstrap-icons/icons/alert-triangle.svg" alt="" width="16" height="16"
        title="info">
      <span id="alertmsg-time" class="font-weight-bold">11:20pm</span> Cerramos un partido
    </div>
  </div>
  <tr>
    <td rowspan="2">
      <div align="right" style="margin-top:0px; margin-left:0px">
        <div class="shadowcontainerx2"> <?php if ($op == 1) : ?>
            <div
              style="color: #000;padding-top: 10px;background: #f1f1f1;height: 38px;     text-align: center;">
              Apuesta
              <label class="lbl-moneda-txt">
                <? echo $moneda; ?>
              </label> :
              <input name="text2" type="text" id="ap" onkeypress=' return permitebb(event,"num");'
                onkeyup="formatclick('0',0,0,0,0,'<? echo $moneda; ?>');" size="10" maxlength="10" style="
                            height: 21px;
                            font-size: 11px;
                            padding: 1px;
                            border: none;
                            border-radius: 3px;" />
              <input type="submit" id="btnprint" value="Imprimir"
                onclick="impticketbb(0,'<? echo $moneda; ?>');" disabled="disabled" style="
                            height: 21px;
                            width: 46px;
                            border-radius: 2px;
                            border: none;
                            background: #5e99e8;
                            color: #fff;
                            font-weight: 500;" />
              <input type=" submit" id="btnprint2" value="WhatsApp"
                onclick="impticketbb(1,'<? echo $moneda; ?>');" disabled="disabled" style="
                            height: 21px;
                            width: 49px;
                            border-radius: 2px;
                            border: none;
                            background: #128C7E;
                            color: #fff;
                            font-weight: 500;" <? if ($impremsg != 1) echo 'style="display:none"'; ?> />
            </div> <?php endif; ?>
          <div class="innerdivx2">
            <div align="center" style="font-size:14px;color:#000"><strong>Ticket Virtual </strong></div>
            <div style="height: 500px;overflow: auto;">

              <samp id="printer2" style="position:relative"></samp>
            </div>
          </div>
        </div>
      </div>
    </td>
  </tr>
  <tr> </tr>
</table>
</div>