<div id='tablemenu'>
  <?php

  /*$fc=$_REQUEST['fc'];*/


  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();


  ?>
  <div id="box13" style="width:380px">
    <input type="submit" name="Submit" value="Agregar Juego" onclick="javascript: yq=true;makeRequest('agregarjuego.php?fc=0');" />
    <div id='tpg2' class='tabPanelGroup'>
      <div class='tabGroup'>
        <a href='#tpg21' class='tabDefault' onclick="$('printer2').innerHTML='';">Ticket Impresos</a><span class='linkDelim'>&nbsp;|&nbsp;</span>
      </div>
      <div id='tpg21' class='tabPanel'>
        <table class="ta_borde" border="0" cellpadding="3" cellspacing="0">
          <tbody>
            <?php
            $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos ");

            if (mysqli_num_rows($result) != 0) :
              $un = 1;
              while ($row = mysqli_fetch_array($result)) {
                if ($un == 1) :
                  echo "<tr >";
                  $un = 0;
                else :
                  echo "<tr bgcolor='#5F92C1'>";
                  $un = 1;
                endif;
                if ($row["Estatus"] == 1) :
                  echo "<td  width='300'> <img src='media/estrella.png' width='16' height='16' />";
                endif;
                if ($row["Estatus"] == 2) :
                  echo "<td  width='300'> <img src='media/estrellaout.gif' width='16' height='16' />";
                endif;
                echo "<span style='color:#FFFFFF' > Juego no:" . $row["IDJug"] . "-" . $row["Descrip"];

                echo "</span></td>";
                $vc = "'agregarjuego.php?fc=" . $row["IDJug"] . "'";
                echo '<td > <input type="button" value="ver" title="' . $vc . '" onclick="javascript:makeRequestHIPI(' . $vc . ');"></td>';
              }
            endif;
            ?>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
    <div id='tablemenu1'>
    </div>
    <script>
      Nifty('div#box13', 'big');
      new xTabPanelGroup('tpg2', 375, 450, 40, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
    </script>