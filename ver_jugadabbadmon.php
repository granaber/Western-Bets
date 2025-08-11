<style type="text/css">
  <!--
  body {
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
  }

  .shadowcontainer5 {
    /* container width*/
    background-color: #d1cfd0;
  }

  .shadowcontainer5.innerdiv {
    /* Add container height here if desired */
    background-color: white;
    border: 1px solid gray;
    padding: 6px;
    position: relative;
    left: -5px;
    /*shadow depth*/
    top: -5px;
    /*shadow depth*/
  }

  .Estilo4 {
    color: #FFFFCC
  }

  .Estilo5 {
    color: #FFFFFF
  }

  .Estilo6 {
    color: #000000
  }
  -->
</style>
<?php
require('prc_php.php');

$GLOBALS['link'] = Connection::getInstance();

$fc = $_REQUEST["fc"];
$idc = $_REQUEST["idc"];
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  $idj = $rowj["IDJ"];
else :
  $idj = 0;
  $idc = '';
endif;
$idt = $_REQUEST['idt'];
$accesogp = accesolimitado($idt);

?>

<samp id="idt" lang="<? echo $idt; ?>"></samp>
<div id="box8" style="background:#333">
  <table width="734" border="0" cellspacing="0">
    <tr>
      <th colspan="2" align="center">
        <div align="center" class="Estilo4" style="background:#333">
          <div align="left">Indique la Fecha:
            <input name="fc" type="text" id="fc" lang="<?php echo $idj; ?>" size="10" value="<?php echo $fc; ?>" />
          </div>
      </th>
      <th width="112" rowspan="2" align="center" bgcolor="#333333">
        <p align="center"><img src="media/impripan.png" width="32" height="32" onclick="if($('box9').style.display=='none') { $('box9').style.display=''; }else { $('box9').style.display='none'; }" /></p>
        <p align="center" class="Estilo5">Imprimir Listado</p>
      </th>
      <th width="108" rowspan="2" align="center" bgcolor="#333333">
        <p align="center"><img src="media/buscar.png" width="32" height="32" onclick="if($('box7').style.display=='none') { $('box7').style.display=''; }else { $('box7').style.display='none'; }" /></p>
        <p align="center" class="Estilo5">Buscar Ticket</p>
      </th>
      <th width="224" rowspan="2" align="center" bgcolor="#333333">
        <p align="right" class="Estilo5">&nbsp;</p>
      </th>
    </tr>
    <tr bgcolor="#333333">
      <th colspan="2" bgcolor="#333333" align="center">
        <div align="left"><span class="Estilo5">
            Concesionario:<span id="cns_1" align="left"> <select name="select" id="tidc">
                <?php
                if ($accesogp == 0) :
                  $result3 = mysqli_query($GLOBALS['link'], "SELECT IDC FROM _tjugadabb where IDJ=" . $idj . " group by IDC");
                else :
                  $result3 = mysqli_query($GLOBALS['link'], "SELECT IDC FROM _tjugadabb where IDJ=" . $idj . " and IDC in (SELECT IDC FROM _tconsecionario where  IDG=" . $accesogp . " ) group by IDC");
                endif;
                while ($row3 = mysqli_fetch_array($result3)) {
                  echo "<option  value='" . $row3["IDC"] . "'>" . $row3["IDC"] . "</option>";
                }
                ?>
              </select></span>
          </span></div>
      </th>
    </tr>
  </table>


</div>
<br />
<div id="box7" style="display:none">
  <table width="853" border="0">
    <tr>
      <th width="217" scope="col"><span class="Estilo6">Serial:<span id="sprytextfield1">
            <label>
              <input type="text" name="bserial" id="bserial" value="0" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></span></th>
      <th width="276" scope="col">
        <p><span class="Estilo6">Monto Apostado:
          </span><span id="sprytextfield2"><span id="sprytextfield4">
              <input type="text" name="bmonto" id="bmonto" value="0" />
              <span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span> </p>
      </th>
      <th width="283" scope="col"><span class="Estilo6">Monto Ticket:</span> <span id="sprytextfield3"><span id="sprytextfield5">
            <input type="text" name="bmonto2" id="bmonto2" value="0" />
            <span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></th>
      <th width="59" scope="col">
        <input type="submit" name="button" id="button" value="Buscar" onclick="jsonvalores_v8();$('box7').style.display='none';" />
      </th>
    </tr>
  </table>
</div>
<div id="box9" style="display:none">
  <table width="853" border="0">
    <tr>
      <th width="217" scope="col">
        <input name="radio" type="radio" id="ti" value="radio" checked="checked" />
        <span class="Estilo6">Ticket Impresos </span>&nbsp;&nbsp;
        <input type="radio" name="radio" id="tp" value="radio" />
        <span class="Estilo6">Ticket Premiados </span>
      </th>
      <th width="217" scope="col"><input name="" type="button" value="Imprimir" onclick="$('box3').style.display='none';impresionverticketdd();" /></th>
    </tr>
  </table>
</div>

<br />
<div id="tabl">
  <?php include('ver_jugadabb-2admon.php'); ?>
</div>



<span class="Estilo4"></span>
<script type="text/javascript">
  <!--
  var sprytextfield1 = new Spry.Widget.ValidationTextField("bserial", "integer", {
    validateOn: ["blur", "change"],
    isRequired: false,
    useCharacterMasking: true
  });
  var sprytextfield4 = new Spry.Widget.ValidationTextField("bmonto", "integer", {
    validateOn: ["blur", "change"],
    isRequired: false,
    useCharacterMasking: true
  });
  var sprytextfield5 = new Spry.Widget.ValidationTextField("bmonto2", "integer", {
    validateOn: ["blur", "change"],
    isRequired: false,
    useCharacterMasking: true
  });
  //
  -->
</script>