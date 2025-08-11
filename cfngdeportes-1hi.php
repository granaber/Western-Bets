<?php
if (isset($_REQUEST['fc1'])) :
  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();
  $fc1 = $_REQUEST['fc1'];
  $hipo = $_REQUEST['hip'];
  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where Estatus=1 and fecha='" . $fc1 . "' and IDhipo=" . $hipo . " order by IDCN");
  if (mysqli_num_rows($result) != 0) :
    $row = mysqli_fetch_array($result);
    $nc =  $row['Cantcarr'];
    $IDCN = $row['IDCN'];
    $hipo = $row['IDhipo'];
  else :
    $nc = 0;
  endif;
endif;
?>
<div id="box2">
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
      $result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfighi where IDCN=" . $IDCN);
      $row2 = mysqli_fetch_array($result2);
      $canteje = explode('|', $row2['_Fab']);

      echo "<div id='tpg2" . $i . "' class='tabPanel' >";


      include('cfngdeportes-1-1hi.php');


      echo "</div> ";
    }
    ?>
  </div>
</div>

<script>
  cargarCamposHI();
  Nifty('div#box2', 'big');
  Nifty('div#box3', 'big');
  new xTabPanelGroup('tpg2', 725, 550, 40, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
</script>