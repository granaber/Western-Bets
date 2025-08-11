<?php
$idc = $_REQUEST["idc"];
$op = $_REQUEST["op"];




if ($op == 1) :
  $fc = $_REQUEST["fc"];
  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();

  $idt = $_REQUEST['idt'];
  $accesogp = accesolimitado($idt);



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

  if (($idc == -2 || $idc == -1 || $idc == -4) && $op == 1) : ?>
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
  <? endif; ?>
  <tr>
    <td rowspan="2">
      <div align="right" style="margin-top:0px; margin-left:0px">
        <div class="shadowcontainerx2"> <?php if ($op == 1) : ?>
            <p align="center" style="color:#000"> Apuesta:
              <input name="text2" type="text" id="ap" onkeypress=' return permitebb(event,"num");' onkeyup="formatclick('0',0);" size="10" maxlength="10" />
              <input type="submit" id="btnprint" value="Imprimir" onclick="impticketbb();" disabled="disabled" />
            </p> <?php endif; ?>
          <div class="innerdivx2">
            <div align="center" style="font-size:14px;color:#000"><strong>Ticket Virtual </strong></div>
            <table height="320" border="0" cellpadding="0" cellspacing="0">

              <tr>
                <td align="left"><samp id="printer3"></samp></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </td>
  </tr>
  <tr> </tr>
</table>
</div>