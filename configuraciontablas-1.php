<?php
if (isset($_REQUEST['fc1'])) :
  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();
  $fc1 = $_REQUEST['fc1'];
  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where Estatus=1 and fecha='" . $fc1 . "' order by IDCN");
  if (mysqli_num_rows($result) != 0) :
    $row = mysqli_fetch_array($result);
    $nc =  $row['Cantcarr'];
    $IDCN = $row['IDCN'];
  else :
    $nc = 0;
  endif;
endif;
?>
<br /><br />
<div id="box4">
  <div id='tpg2' class='tabPanelGroup'>
    <div class='tabGroup'>
      <?php

      for ($i = 1; $i <= $nc; $i++) {
        echo "<a href='#tpg2" . $i . "' class='tabDefault' >Carrera No. " . $i . "</a><span class='linkDelim' >&nbsp;|&nbsp;</span>";
      }
      ?>
    </div>
    <?php
    for ($i = 1; $i <= $nc; $i++) {
      $result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig where IDCN=" . $IDCN);
      $row2 = mysqli_fetch_array($result2);
      $canteje = explode('|', $row2['_Fab']);
      $retirados = explode('|', $row2['_Ret']);

      echo "<div id='tpg2" . $i . "' class='tabPanel' >";


      include('configuraciontablas-1-1.php');


      echo "</div> ";
    }
    ?>
  </div>
</div>

<script>
  cargarcampos_v14();
  Nifty('div#box4', 'big');
  Nifty('div#box5', 'big');
  new xTabPanelGroup('tpg2', 725, 550, 40, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
  });
</script>