<head>
  <?php
  date_default_timezone_set('America/Caracas');
  $tj = $_GET['tj'];
  $idc = $_GET['idc'];
  $masde = false;
  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();



  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $tj);
  $row = mysqli_fetch_array($result);
  $apm = $row['ApuestaMinima'];
  //$result2 = mysqli_query($GLOBALS['link'],"Select sphonline.vx('Ticket') as num;" );
  // $row2 = mysqli_fetch_array($result2); 


  // Cheque la configuracion activa
  $result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
  //echo "SELECT * FROM _tconfjornada where Estatus=1 and fecha='".date("d/n/Y")."' order by IDCN";
  if (mysqli_num_rows($result3) != 0) :


    if (mysqli_num_rows($result3) > 1) :
      $masde = true;
    endif;

    $row3 = mysqli_fetch_array($result3);

    $result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierre where IDJug=" . $tj . " and IDCN=" . $row3["IDCN"]);

    if (mysqli_num_rows($result3) == 0) :

      $result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig where IDCN=" . $row3["IDCN"]);
      //echo "SELECT * FROM _tconfig where IDCN=".$row3["IDCN"];
      $row3 = mysqli_fetch_array($result4);
      $config = explode("|", $row3["_Jug"]);
      $cantcb = explode("|", $row3["_Fab"]);
      $retira = explode("|", $row3["_Ret"]);
      $_tem = explode("*", $config[$tj]);
      $_xc = explode("-", $_tem[1]);
      // print_r($_xc);  print_r($cantcb);
      $activar = 1;

    else :
      $activar = 2;
    endif;

  else :
    for ($k = 0; $k <= $row["CantidadCarr"] + 1; $k++) {
      $_xc[$k] = $k + 1;
      $cantcb[$k] = 0;
      $retira[$k] = 0;
    }
    $activar = 1;

  endif;


  // print_r($_xc);  print_r($cantcb);
  ?>



  <style type="text/css">
    <!--
    .Estilo1 {
      color: #FFFFFF
    }
    -->
  </style>
</head>

<?php if ($activar == 1) : ?>

  <div align="left">

    <a id="apm" lang="<?php echo $apm; ?>"></a>
    <div id="box_j" style="background:<?php echo $row["Color"] ?>">
      <table width="590" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="">
          <th colspan="19" align="left" bgcolor="<?php echo $row["Color"] ?>" scope="col"><span id='tj' title="<?php echo $tj; ?>" class="Estilo43"> <br /><?php echo $row["Descrip"] ?></span> <?php if ($masde == true) :
                                                                                                                                                                                                  echo " <div aling='left'> Seleccionar Jornada: <select  size='1' id='jndv' >";
                                                                                                                                                                                                  $result4 = mysqli_query($GLOBALS['link'], "SELECT _tconfjornada.fecha,_tconfjornada.IDCN,_hipodromos.siglas FROM _tconfjornada,_hipodromos where _tconfjornada.IDhipo=_hipodromos._IDhipo and _hipodromos.estatus=1 and fecha='" . date("d/n/Y") . "' order by idcn ");
                                                                                                                                                                                                  while ($row4 = mysqli_fetch_array($result4)) {
                                                                                                                                                                                                    echo "<option value='" . $row4["IDCN"] . "||" . $row4["fecha"] . "'>" . $row4["fecha"] . '-' . $row4["siglas"] . "</option>";
                                                                                                                                                                                                  }
                                                                                                                                                                                                  echo "</select></div>";
                                                                                                                                                                                                endif;
                                                                                                                                                                                                ?>
          </th>
        </tr>
        <tr bgcolor="<?php echo $row["Color"] ?>">
          <th colspan="19" align="left" valign="middle" scope="col"><?php if ($idc == '-2' || $idc == '-1') : ?> Concesi.:
              <input id="cons" type="text" size="10" maxlength="10" onkeyup="validar_con_ju(event,1);pulsart(event,'nom');" onkeypress="this.value = this.value.toUpperCase();" />
              <img id="imgcons" src="media/ee.ico" style=" display:none" /> Nombre:
              <input id="nom" onKeyUp="validar_con_ju(event,2);pulsart(event,'org1');" onkeypress="this.value = this.value.toUpperCase();" disabled="disabled" /> <img id="imgnom" src="media/ee.ico" style=" display:none" />
              Origen:
              <input type="radio" name="radio" id="org1" value="1" checked="checked" onKeyUp="pulsart(event,'valida');" />
              Tel
              <input type="radio" name="radio" id="org2" value="2" onKeyUp="pulsart(event,'valida');" />
              Bol
              <input type="radio" name="radio" id="org3" value="3" onKeyUp="pulsart(event,'valida');" />
              Fax<?php endif; ?>
          </th>
        </tr>
        <tr bgcolor="<?php echo $row["Color"]; ?>">
          <th colspan="17" align="left" valign="middle" scope="col"><span class="Estilo3"><strong>N.Ticket:</strong> <span id='numet' title="" class="Estilo12"> </span>
              </p>
            </span></th>
          <th id="multi" align="center" valign="middle" scope="col" title="<?php echo $row["Multip"]; ?>">
            <div align="center">X <?php echo $row["Multip"]; ?></div>
          </th>
          <th align="center" valign="middle" scope="col">
            <div align="center" class="Estilo41"><?php if (!($idc == -2 || $idc == -1)) : ?>
                <input type="submit" name="button" id="button" value="Reimprimir" lang="" onclick="_reimpresionticket(<?php echo $tj; ?>);" /><?php endif; ?>

            </div>
          </th>
        </tr>
        <tr>
          <th width="144" rowspan="<?php echo $row["CantidadCarr"]; ?>" bgcolor="<?php echo $row["Color"] ?>" scope="col">
            <p id="carr" class="Estilo40" title="<?php echo $row["CantidadCarr"]; ?>">Valida:</p>
            <label>
              <input type="text" id="valida" value="1" onkeyup="pulsar(event,1,0,<?php echo $row["calculo"]; ?>)" <?php if ($idc == -2 || $idc == -1) :   echo 'disabled="disabled"';
                                                                                                                  else : echo '';
                                                                                                                  endif; ?> />
            </label>
            <p id="ejemp" class="Estilo40" title="<?php echo $row["EjemxCarr"]; ?>">Ejemplar:</p>
            <label>
              <input type="text" id="ejem" onkeyup="pulsar(event,2,0,<?php echo $row["calculo"]; ?>)" <?php if ($idc == -2 || $idc == -1) :   echo 'disabled="disabled"';
                                                                                                      else : echo '';
                                                                                                      endif; ?> />
              <br />
              <p class="Estilo40"> Monto:</p>
              <input id="idmonto" type="text" onkeyup="pulsar(event,3,0,<?php echo $row["calculo"]; ?>)" disabled="disabled" />

              <label> </label>
          </th>

          <?php
          //
          for ($i = 1; $i <= $row["CantidadCarr"]; $i++) {
            if ($i != 1) :
              echo '<tr>';
            endif;
            if ($i < count($_xc)) :
              $cejem = $cantcb[$_xc[$i - 1] - 1];
              $retirado = explode("-", $retira[$_xc[$i - 1] - 1]);
            else :
              $cejem = '';
              $retirado = array();
            endif;
            echo '<th width="17" scope="col" bgcolor=' . $row["Color"] . ' title="' . $cejem . '">' . $i . '.-</th>';
            echo '<th bordercolor="#808080" bgcolor="#FFFFFF" scope="col"><img src="media/marcar_todos_blanco.bmp" onclick="celdasicons(' . $i . ',' . $row["calculo"] . ');" /></th>';
            //print_r($retirado);
            //echo $cejem;
            //echo $_xc[$i-1]-1;
            for ($j = 1; $j <= $row["EjemxCarr"]; $j++) {
              if ($j <= $cejem) :
                $activo = '#26354A';
                $numk = $j;
              else :
                $numk = '';
                $activo = '#999999';
              endif;
              //if (!(array_search($j, $retirado)===false)):
              //$numk='';
              // $activo='#0066FF' ;
              //endif;

              echo '<th id="celda' . $i . '' . $j . '" width="13" scope="col" bgcolor="' . $activo . '" title="' . $numk . '" bordercolor="#000000" onclick="cambiarcelda(event,' . $row["calculo"] . ',' . $i . ');"><span class="esbk">' . $j . '</span></th>';
            }
            echo '<th width="30" bgcolor="#FFFFFF" scope="col"> <input type="text" id="v' . $i . '" size="3"  disabled="disabled"/></th>';
            echo '<th width="103" bgcolor=' . $row["Color"] . ' scope="col"></th>';
            echo '</tr>';
          }
          ?>

          <th bgcolor="<?php echo $row["Color"] ?>" scope="row" onclick=""><label></label></th>
          <th colspan="17" bgcolor="<?php echo $row["Color"] ?>" scope="row"><label> </label>
            <div align="right"><span class="Estilo40">Total Bs.F.</span>
              <input type="text" name="Total" id="Total" disabled="disabled" />
            </div>
          </th>
          <td bgcolor="<?php echo $row["Color"] ?>">&nbsp;</td>
        </tr>
      </table>
      <br />
    </div><br />


    <script type="text/javascript">
      ticketassig();
      Nifty('div#box_j');
    </script>
  </div>

  <p>
  <?php else :
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
endif; ?>
  </p>
  <input id="c" type="text" style="display:none" />