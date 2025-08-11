 <?php
  require('prc_php.php');
  $GLOBALS['link'] = Servidordual::getInstance();


  $tp = $_REQUEST['tp'];
  $cr = $_REQUEST['cr'];
  $IDCN = $_REQUEST['idcn'];
  $et = $_REQUEST['ept'];
  $crv = $_REQUEST['crv'];
  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierre where  IDJug=" . $tp . " and ct=" . $crv . " and IDCN=" . $IDCN);
  if (mysqli_num_rows($result) == 0) :
    $result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig where IDCN=" . $IDCN);
    $row3 = mysqli_fetch_array($result4);
    $config = explode("|", $row3["_Jug"]);
    $cantcb = explode("|", $row3["_Fab"]);
    $retira = explode("|", $row3["_Ret"]);
    for ($k = 0; $k <= count($config) - 1; $k++) {
      $_tem = explode("*", $config[$k]);
      if ($_tem[0] == $tp) :
        break;
      endif;
    }
    $_xc = explode("-", $_tem[1]);

    if ($et == 2) :
      $result5 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $tp);
      $row5 = mysqli_fetch_array($result5);

      if (((count($_xc) + 1) / $row5['CantidadCarr']) >= $cr) :
        $ici = ($row5['CantidadCarr'] * $cr) - $row5['CantidadCarr'];
      else :
        $ici = 0;
      endif;

      $cvde = array_slice($_xc, $ici, $row5['CantidadCarr']);


      if (count($cantcb) != 0) :
        for ($e = 0; $e <= count($cvde) - 1; $e++) {
          $cb[$e] = $cantcb[$cvde[$e] - 1];
        }
      endif;
      echo "true||" . implode('-', $cb) . "||" . implode('-', $cvde);
    else :
      $carrr = $_xc[$cr] - 1;
      $cejem = $cantcb[$carrr];
      echo "true||" . $cejem . "||" . $retira[$carrr];
    endif;


  else :
    echo "false||0";
  endif
  ?>
