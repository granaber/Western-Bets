<style type="text/css">
  .shadowcontainerx {
    width: 310px;
    /* container width*/
    background-color: #d1cfd0;
  }

  .shadowcontainerx .innerdivx {
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

  .Estilo2 {
    color: #FFFFFF
  }

  .Estilo3 {
    color: #000000
  }
</style>
<?php
class Connectionsph
{

  protected $link;
  private $server, $username, $password, $db;
  private static $_singleton;

  public static function getInstance()
  {
    if (is_null(self::$_singleton)) {
      self::$_singleton = new Connectionsph();
    }
    return self::$_singleton;
  }

  public function __construct()
  {
    $this->server = "jugarparlay.com"; //"sql213.xtreemhost.com";sphonline.net
    $this->username = "jugarpar_root"; //"xth_2440073";sphonlin_cateca sphonlin_root
    $this->password = "intra"; //"legna113";ctco%&
    $this->db = "jugarpar_jugarparlay"; //"xth_2440073_cateca";sphonlin_cateca  sphonlin_sphonline
    $this->connect();
  }

  private function connect()
  {
    $this->link = mysqli_connect($this->server, $this->username, $this->password);
    mysql_select_db($this->db, $this->link);
  }
}
require('prc_php.php');
$GLOBALS['link'] = Connectionsph::getInstance();

$fc = $_REQUEST["fc"];
$idj = 0;
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  $idj = $rowj["IDJ"];
  $cant = $rowj["Partidos"];
endif;

?>
<br>
<br>

<div id="box16" style="width:300px; background:#933">
  <table width="292" height="145" border="0">
    <tr>
      <th height="27" colspan="2" align="center" bgcolor="#333333" scope="col">
        <div align="center"><span class="Estilo2">Imprimir Logros SPH</span></div>
      </th>
    </tr>
    <tr>
      <th height="30" scope="col"><span style="color:#FFFFFF">Indique la Fecha:</span></th>
      <th width="129" scope="col"><input name="fc" type="text" id="fc" lang="<?php echo $idj; ?>" onfocus="cargarcampos6();" size="10" value="<?php echo $fc; ?>" /></th>
    </tr>
    <tr>
      <th height="28" scope="col"><span style="color:#FFFFFF">Seleccione el Grupo:</span></th>
      <th scope="col">


        <?php

        echo "<span style='color:#000000; background:#FFFFFF; font-size:12px'><input id='chk0' type='checkbox' value='0' onclick='marcat(0)'/>TODOS</span><br />";

        $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where  Estatus=1 Order by grupo ");
        $y = 1;
        while ($row = mysqli_fetch_array($resultj)) {
          echo "<input id='chk0" . $y . "' type='checkbox' lang=" . $row["Grupo"] . " /><span style='color:#FFFFFF'>" . $row["Descripcion"] . '</span><br />';
          $y++;
        }
        ?>


      </th>
    </tr>
    <tr>
      <th scope="col"><input type="submit" id='btncargar' value="Imprimir" onclick="imprimirlogrosph(<? echo $y; ?>);" /><input id="cant_p" type="text" style="display:none" /></th>
      <th scope="col">&nbsp;</th>
    </tr>
  </table>
  <samp id="totalg" lang="<? echo $y; ?>"></samp>
  <div id='coc'></div>
</div>


<script>
  Nifty('div#box16', 'big');
</script>