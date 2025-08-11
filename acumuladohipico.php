<head>
  <?php
  //$fc=$_REQUEST['fc'];
  $tj = 6;
  $GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
  mysql_select_db("sphonline", $GLOBALS['link']);

  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $tj,  $GLOBALS['link']);
  $row = mysqli_fetch_array($result);

  $result2 = mysqli_query($GLOBALS['link'], "Select sphonline.vx('Ticket') as num;",  $GLOBALS['link']);
  $row2 = mysqli_fetch_array($result2);
  // Cheque la configuracion activa
  $result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN",  $GLOBALS['link']);
  // echo "SELECT * FROM _tconfjornada where Estatus=1 and fecha='".date("d/n/Y")."' order by IDCN";
  if (mysqli_num_rows($result3) != 0) :
    $row3 = mysqli_fetch_array($result3);
    $result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig where IDCN=" . $row3["IDCN"],  $GLOBALS['link']);
    //echo "SELECT * FROM _tconfig where IDCN=".$row3["IDCN"];
    $row3 = mysqli_fetch_array($result4);
    $config = explode("|", $row3["_Jug"]);
    $cantcb = explode("|", $row3["_Fab"]);
    $retira = explode("|", $row3["_Ret"]);
    $_tem = explode("*", $config[$tj]);
    $_xc = explode("-", $_tem[1]);
  // print_r($_xc);  print_r($cantcb);
  else :
    for ($k = 0; $k <= $row["CantidadCarr"] + 1; $k++) {
      $_xc[$k] = $k + 1;
      $cantcb[$k] = 0;
      $retira[$k] = 0;
    }
  endif;
  // print_r($_xc);  print_r($cantcb);
  ?>


</head>


<div align="left">



  <table width="590" height="392" bgcolor="#999999">
    <tr bgcolor="#FFCC33">
      <th colspan="19" align="left" bgcolor="#FFB32D" scope="col"><span id='tj' title="<?php echo $tj; ?>" class="Estilo43">ACUMULADO HIPICO</span></th>
    </tr>
    <tr bgcolor="#FFCC33">
      <th colspan="17" align="left" valign="middle" bgcolor="#FFB32D" scope="col"><span class="Estilo3"><strong>N.Ticket:</strong> <span id='numet' title="<?php echo $row2["num"]; ?>" class="Estilo12"><?php echo $row2["num"]; ?> </span>
          </p>
        </span></th>
      <th align="center" valign="middle" bgcolor="#FFB32D" title="<?php echo $row["Multip"]; ?>" scope="col">
        <div align="center">X <?php echo $row["Multip"]; ?></div>
      </th>
      <th align="center" valign="middle" bgcolor="#FFB32D" scope="col">
        <div align="center" class="Estilo41">
          <input type="submit" name="button" id="button" value="Reimprimir" onclick="impre('uno');return false" />
        </div>
      </th>
    </tr>
    <tr>
      <th width="144" rowspan="<?php echo $row["CantidadCarr"]; ?>" bgcolor="#FFB32D" scope="col">
        <p id="carr" class="Estilo40" title="<?php echo $row["CantidadCarr"]; ?>">Valida:</p>
        <label>
          <input type="text" id="valida" onkeyup="pulsar(event,1)" />
        </label>
        <p id="ejemp" class="Estilo40" title="<?php echo $row["EjemxCarr"]; ?>">Ejemplar:</p>
        <label>
          <input type="text" id="ejem" onkeyup="pulsar(event,2)" />
          <br />
          <p class="Estilo40"> Monto:</p><br />
        </label>
        <input id="idmonto" type="text" onkeyup="pulsar(event,3)" disabled="disabled" />

        <label> </label>
      </th>

      <?php
      //
      for ($i = 1; $i <= $row["CantidadCarr"]; $i++) {
        if ($i != 1) :
          echo '<tr>';
        endif;
        $cejem = $cantcb[$_xc[$i - 1] - 1];
        $retirado = explode("-", $retira[$_xc[$i - 1] - 1]);
        echo '<th width="17" scope="col" bgcolor="#FFB32D" title="' . $cejem . '">' . $i . '.-</th>';
        echo '<th width="6" bordercolor="#808080" bgcolor="#FFFFFF" scope="col">&nbsp;</th>';
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
          if (!(array_search($j, $retirado) === false)) :
            $numk = '';
            $activo = '#0066FF';
          endif;

          echo '<th id="celda' . $i . '' . $j . '" width="13" scope="col" bgcolor="' . $activo . '" title="' . $numk . '" bordercolor="#000000"><span class="Estilo42">' . $j . '</span></th>';
        }
        echo '<th width="30" bgcolor="#FFFFFF" scope="col"> <input type="text" id="v' . $i . '" size="3" /></th>';
        echo '<th width="103" bgcolor="#FFB32D" scope="col"></th>';
        echo '</tr>';
      }
      ?>

      <th bgcolor="#FFB32D"><label></label></th>
      <th colspan="17" bgcolor="#FFB32D"><label> </label>
        <div align="right"><span class="Estilo40">Total Bs.F.</span>
          <input type="text" name="Total" id="Total" />
        </div>
      </th>
      <td bgcolor="#FFB32D">&nbsp;</td>
    </tr>
  </table>


</div>