<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$conf = 0;
$fc = $_REQUEST["fc"];
$resultx = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
$rowx = mysqli_fetch_array($resultx);

$idj = $rowx["IDJ"];
$conf = 1;
$lg1 = $rowx['LogroSN'];
$lg2 = $rowx['LogroAB'];

?>
<div align="left">
  <table width="1205" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="396" rowspan="2">
        <div align="right">
          <div class="shadowcontainerx2">
            <p align="center"> Logro:
              <input type="text" id="lgsn" size="10" maxlength="10" disabled="disabled" value="<?php echo $lg1; ?>" />
              <input type="text" id="lgab" size="10" maxlength="10" disabled="disabled" style=" display:none" value="<?php echo $lg2; ?>" />
              Apuesta:
              <input type="text" id="ap" size="10" maxlength="10" onkeypress="formatclick();" />
              <input type="submit" name="Submit3" value="Imprimir" onclick="	impticketbb();" />
            </p>
            <div align="center" style="font-size:14px"><strong>Ticket Virtual </strong></div>
            <table width="346" height="380" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="21"></td>
              </tr>
              <tr>
                <td><samp id="printer2"></samp></td>
              </tr>
            </table>
          </div>
  </table>
</div>