<head>
  <?php
  date_default_timezone_set('America/Caracas');
  $tj = $_GET['tj'];
  $idc = $_GET['idc'];
  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();

  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $tj);
  $row = mysqli_fetch_array($result);
  $apm = $row['ApuestaMinima'];
  // $result2 = mysqli_query($GLOBALS['link'],"Select sphonline.vx('Ticket') as num;" );
  // $row2 = mysqli_fetch_array($result2); 
  // Cheque la configuracion activa
  $result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
  // echo "SELECT * FROM _tconfjornada where Estatus=1 and fecha='".date("d/n/Y")."' order by IDCN";
  if (mysqli_num_rows($result3) != 0) :
    $row3 = mysqli_fetch_array($result3);
    $macuare = $row3["Macuare"];
    $result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierre where IDJug=" . $tj . " and IDCN=" . $row3["IDCN"]);

    if (mysqli_num_rows($result4) == 0) :

      $result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig where IDCN=" . $row3["IDCN"]);
      //echo "SELECT * FROM _tconfig where IDCN=".$row3["IDCN"];
      $row3 = mysqli_fetch_array($result4);
      $config = explode("|", $row3["_Jug"]);
      $cantcb = explode("|", $row3["_Fab"]);
      $retira = explode("|", $row3["_Ret"]);
      $_tem = explode("*", $config[1]);
      $_xc = explode("-", $_tem[1]);

      // print_r($_xc);  

      $cantcarr = count($_xc) - 1;


    else :
      $cantcarr = -1;
    endif;
  else :
    for ($k = 0; $k <= $row["CantidadCarr"] + 1; $k++) {
      $_xc[$k] = $k + 1;
      $cantcb[$k] = 0;
      $retira[$k] = 0;
    }
    $cantcarr = 0;
  endif;
  // print_r($_xc);  print_r($cantcb);
  ?>


</head>

<?php if ($cantcarr > 0) : ?>
  <div id="box_j" style="background:<?php echo $row["Color"] ?>">

    <a id="apm" lang="<?php echo $apm; ?>"></a>

    <table width="575" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th colspan="17" align="left" bgcolor="<?php echo $row["Color"] ?>" scope="col"><span id='tj' title="<?php echo $tj; ?>" style="font-size:16px"><?php echo $row["Descrip"] ?></span></th>
      </tr>
      <tr bgcolor="<?php echo $row["Color"] ?>">
        <th colspan="17" align="left" valign="middle" scope="col"><?php if ($idc == '-2' || $idc == '-1') : ?> Concesi.:
            <input id="cons" type="text" size="10" maxlength="10" onkeyup="this.value = this.value.toUpperCase();validar_con_ju(event,4,'nom');" onfocus="$('nom').disabled='disabled';  for (iii=1;iii<=parseInt($('carr').title);iii++) {  $('v'+iii).disabled='disabled';	}" onchange="" />


            <img id="imgcons" src="media/ee.ico" style=" display:none" /> Nombre:
            <input id="nom" onKeyUp="validar_con_ju(event,5);pulsart(event,'org1');" onkeypress="this.value = this.value.toUpperCase();" disabled="disabled" /> <img id="imgnom" src="media/ee.ico" style=" display:none" />
            Origen:
            <input type="radio" name="radio" id="org1" value="1" checked="checked" onKeyUp="pulsart(event,'v1');" />
            Tel
            <input type="radio" name="radio" id="org2" value="2" onKeyUp="pulsart(event,'v1');" />
            Bol
            <input type="radio" name="radio" id="org3" value="3" onKeyUp="pulsart(event,'v1');" />
            Fax<?php endif; ?>
        </th>
      </tr>
      <tr bgcolor="<?php echo $row["Color"] ?>">
        <th colspan="15" align="left" valign="middle" scope="col"><span class="Estilo3"><strong>N.Ticket:</strong> <span id='numet' title="" class="Estilo12"> </span>
            </p>
          </span></th>
        <th id="multi" width="130" align="left" valign="middle" scope="col" title="<?php echo $row["Multip"]; ?>">
          <div align="center">Logro: <br /> <span style="color:#FC0; font-size:14px">1x<? echo  $macuare;  ?></span></div>
        </th>
        <th width="131" align="center" valign="middle" scope="col">
          <div align="center" class="Estilo41"><?php if (!($idc == -2 || $idc == -1)) : ?>
              <input type="submit" name="button" id="button" value="Reimprimir" onclick="_reimpresionticket(<?php echo $tj; ?>);" /><?php endif; ?>
          </div>
        </th>
      </tr>
      <tr bgcolor="<?php echo $row["Color"] ?>">
        <th colspan="15" align="left" valign="middle" scope="col">
          <p align="right">En Letras </p>
        </th>
        <th colspan="2" align="left" valign="middle" scope="col">
          <div align="center"></div>
        </th>
      </tr>
      <tr>
        <th width="150" rowspan="<?php echo $cantcarr; ?>" bgcolor="<?php echo $row["Color"] ?>" scope="col">
          <p id="carr" class="Estilo40" title="<?php echo $cantcarr; ?>">Monto a Pagar:</p>
          <p><br />
            </label>
            <input id="idmonto" type="text" onkeyup="pulsar(event,3,4,<?php echo $row["calculo"]; ?>)" disabled="disabled" />
          </p>
          <p>+: Para Introducir el monto a pagar. </p>
          <label> </label>
        </th>

        <?php
        // 
        if ($idc == -2 || $idc == -1) :
          $tcx = 'disabled="disabled"';
        else :
          $tcx = '';
        endif;
        for ($i = 1; $i <= $cantcarr; $i++) {
          if ($i != 1) :
            echo '<tr>';
          endif;
          $cejem = $cantcb[$_xc[$i - 1] - 1];
          $retirado = explode("-", $retira[$_xc[$i - 1] - 1]);
          echo '<th width="17" scope="col" bgcolor=' . $row["Color"] . ' title="' . $cejem . '">' . $i . '.-</th>';
          echo '<th width="6" bordercolor="#808080" bgcolor="#FFFFFF" scope="col">&nbsp;</th>';
          if ($i == $cantcarr) :
            $g = "'v1'";
          else :
            $g = "'v" . ($i + 1) . "'";
          endif;
          $ty = "'num'";


          echo '<th width="30" bgcolor="#FFFFFF" scope="col"> <input type="text" id="v' . $i . '" size="3"  onkeypress="return permite(event, ' . $ty . ');"  onkeyup = "pulsartcl(event,' . $g . ',' . $cejem . ');" ' . $tcx . '  /></th>';
          echo '<th  id="tv' . $i . '"  width="400" bgcolor="#FFFFFF" scope="col"></th>';
          //  echo '<th width="103" bgcolor='.$row["Color"].' scope="col"></th>';
          echo '</tr>';
        }
        ?>
        <th width="9" bgcolor="<?php echo $row["Color"] ?>" scope="row"><label></label></th>
        <th colspan="15" bgcolor="<?php echo $row["Color"] ?>" scope="row"><label> </label></th>
        <td width="10" bgcolor="<?php echo $row["Color"] ?>">&nbsp;</td>
      </tr>
    </table>

    <script type="text/javascript">
      ticketassig();
      Nifty('div#box_j');
    </script>

  </div>
<?php else :
  switch ($cantcarr) {
    case 0:
      echo "No hay configuracion!";
      break;
    case -1:
      echo '<div align="center">
<div class="dialogx">
 <div class="hdx"><div class="cx"></div></div>
 <div class="bdx">
  <div class="cx">
   <div class="sx"><div align="center" style=" font-size:24px; font:bold">Jugada Cerrada</p>
  <table width="300" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center" style="font-size:18px; font:bold"; font:#ffffff>Les notificamos que la jugada ha sido bloqueda para la venta</div></td>
	
  </tr>
</table></div> </div>
  </div>
 </div>
 <div class="ftx"><div class="cx"></div></div>
</div></div>';
      break;
  }
endif; ?>
<input id="c" type="text" style="display:none" />