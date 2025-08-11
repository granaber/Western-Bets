<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="prc.js"></script>
<script type="text/javascript" src="prcjuegos.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript" src="niftycube.js"></script>
<script type='text/javascript' src='x/lib/xtabpanelgroup.js'></script>
<script type='text/javascript' src='x/lib/x_core.js'></script>
<script type='text/javascript' src='x/lib/xevent.js'></script>
<script type="text/javascript" src="domnews.js"></script>


<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel='stylesheet' type='text/css' href='x/lib/v3.css'>
<link rel='stylesheet' type='text/css' href='x/lib/tpg_dyn.css'>
<style type="text/css">
  div#box1 {
    padding: 10px;
    margin: 0 auto;
    background: #999999;
    color: #FFFFFF
  }

  div#box2 {
    padding: 10px;
    margin: 0 auto;
    background: #333333;
    color: #FFFFFF
  }

  .nom1 {
    background: #0066CC;
    color: #FFFFFF
  }

  .nom2 {
    background: #0099FF;
    color: #FFFFFF
  }
</style>


<?php
$tj = $_GET['tj'];
$idc = $_GET['idc'];
$jnd = $_REQUEST['jnd'];
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $tj);
$row = mysqli_fetch_array($result);
$apm = $row['ApuestaMinima'];
// $result2 = mysqli_query($GLOBALS['link'],"Select sphonline.vx('Ticket') as num;",  $GLOBALS['link']);
// $row2 = mysqli_fetch_array($result2); 
// Cheque la configuracion activa
$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
// echo "SELECT * FROM _tconfjornada where Estatus=1 and fecha='".date("d/n/Y")."' order by IDCN";
if (mysqli_num_rows($result3) != 0) :
  $row3 = mysqli_fetch_array($result3);



  $result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig where IDCN=" . $row3["IDCN"]);
  //echo "SELECT * FROM _tconfig where IDCN=".$row3["IDCN"];
  $row3 = mysqli_fetch_array($result4);
  $config = explode("|", $row3["_Jug"]);
  $cantcb = explode("|", $row3["_Fab"]);
  $retira = explode("|", $row3["_Ret"]);
  $_tem = explode("*", $config[1]);
  $_xc = explode("-", $_tem[1]);
  // print_r($_xc);  print_r($cantcb);
  $cantcarr = count($_xc) - 1;

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
  <div id="box1" align="left">

    <a id="apm" lang="<?php echo $apm; ?>"></a>
    <table width="463" cellspacing="0" style="font-size:12px">
      <tr>
        <th colspan="16" align="center" scope="col"><span id='tj' title="<?php echo $tj; ?>" class="Estilo43"><img align="left" id="img" src="media/search.gif" style="display:none" /></span></th>
      </tr>
      <tr>
        <th colspan="15" align="left" valign="middle" scope="col">Monto a Monitorear:
          <span id="sprytextfield1">
            <input id="monto" type="text" size="10" maxlength="10" value="0" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span> <span class="Estilo41">
            <input type="submit" name="button" id="button" value="Buscar" lang='1' onclick="activarmonitor(<?php echo $jnd; ?>);" />
          </span>
        </th>
        <th align="left" valign="middle" scope="col"></th>
      </tr>
      <tr>
        <th colspan="14" align="left" valign="middle" scope="col">&nbsp;</th>
        <th id="multi" width="72" align="left" valign="middle" scope="col" title="<?php echo $row["Multip"]; ?>">
          <div align="center"></div>
        </th>
        <th width="177" align="center" valign="middle" scope="col">
          <div align="center" class="Estilo41"><?php if (!($idc == -2 || $idc == -1)) : ?><?php endif; ?>
          </div>
        </th>
      </tr>
      <tr>
        <th align="left" valign="middle" scope="col">
          <p align="right"></p>
        </th>
        <th width="0" align="left" valign="middle" scope="col">
          <p align="right"></p>
        </th>
        <th width="69" align="left" valign="middle" scope="col">
          <div align="center">Jugada</div>
        </th>
        <th width="93" align="left" valign="middle" scope="col">
          <div align="center">En Letras</div>
        </th>
      </tr>
      <tr>
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
          echo '<th width="17" scope="col" title="' . $cejem . '">' . $i . '.-</th>';
          echo '<th width="6" bordercolor="#808080" bgcolor="#FFFFFF" scope="col">&nbsp;</th>';
          if ($i == $cantcarr) :
            $g = "'v1'";
          else :
            $g = "'v" . ($i + 1) . "'";
          endif;
          $ty = "'num'";


          echo '<th width="30" bgcolor="#FFFFFF" scope="col"> <samp  id="v' . $i . '" ></samp></th>';
          echo '<th  id="tv' . $i . '"  width="400" bgcolor="#FFFFFF" scope="col"></th>';
          //  echo '<th width="103" bgcolor='.$row["Color"].' scope="col"></th>';
          echo '</tr>';
        }
        $result = mysqli_query($GLOBALS['link'], 'Select * from  _tbbloquecmb where IDJ=4 and IDCN=' . $jnd);
        $juga = '';
        $filel = 'unlock.png';
        if (mysqli_num_rows($result) != 0) :
          $row = mysqli_fetch_array($result);
          $juga = $row['Jugada'];
          $filel = 'lock.png';
        endif;
        ?>
        <th width="19" scope="row"><label></label></th>
        <th colspan="14" scope="row">Monto Acumulado
          <label>
            <input type="text" id="montoacum" disabled="disabled" />
          </label>
        </th>
        <th scope="row">&nbsp;</th>
      </tr>
      <tr>
        <th colspan="14" align="left" valign="middle" scope="col"><img id='blq' src="media/<?php echo $filel; ?>" width="32" height="32" lang="<?php echo $juga; ?>" onclick="blqjugada(<?php echo $jnd; ?>,4)" /></th>
        <th align="left" valign="middle" scope="col">&nbsp;</th>
        <th align="left" valign="middle" scope="col">&nbsp;</th>
      </tr>
    </table>



  </div>

  <div id="box2">
    <div id="ver">
      <? include('listaserialesm.php'); ?>
    </div>

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
<script type="text/javascript">
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {
    validateOn: ["blur"],
    useCharacterMasking: true
  });

  Nifty("div#box1", "big");
  Nifty("div#box2", "big");
</script>