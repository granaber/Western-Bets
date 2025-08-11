<?
date_default_timezone_set('America/Caracas');

$server = 'localhost';
$user = "parlayen_skynet"; //"root";angeles_root
$clv = 'tiqkSlT8y-!3';
$db = "parlayen_skynet"; //"angeles_db";losangeles

$actual = date("Ymd");
class Connection
{
  protected $link;
  private $server, $username, $password, $db;
  private static $_singleton;
  public static function getInstance()
  {
    if (is_null(self::$_singleton)) {
      self::$_singleton = new Connection();
    }
    return self::$_singleton;
  }

  public function __construct()
  {
    global $server;
    global $user;
    global $clv;
    global $db;

    $this->server = $server; //"sql213.xtreemhost.com";
    $this->username = $user; //"xth_2440073";sphonlin_cateca
    $this->password = $clv; //"legna113";ctco%&
    $this->db = $db; //"xth_2440073_cateca";sphonlin_cateca
    $this->connect();
  }


  private function connect()
  {
    $this->link = mysqli_connect($this->server, $this->username, $this->password);
    mysql_select_db($this->db, $this->link);
  }
}




$op = $argv[1];
switch ($op) {
  case '1':
    $valor = _CaptaLotto();
    $ici = 'LA';
    break;

  case '2':
    $valor = _CaptaFruta();
    $ici = 'FM';
    break;

  case '3':
    $valor = _CaptaGranjaFruta();
    $ici = 'GMF';
    break;

  case '4':
    $valor = _Captalagranjita();
    $ici = 'LG';
    break;
}
//print_r($valor);
$GLOBALS['link'] = Connection::getInstance();
$result = mysqli_query($GLOBALS['link'], "select * from _tbANIResul where lot='$ici' and fecha='$actual'");
if (mysqli_num_rows($result) == 0) :
  $result = mysqli_query($GLOBALS['link'], "insert _tbANIResul (fecha,lot,result) values ('" . $actual . "','" . $ici . "','" . serialize($valor) . "')");
//  echo ("insert _tbANIResul (fecha,lot,result) values ('".$actual."','".$ici."','".serialize($valor)."')");
else :
  $result = mysqli_query($GLOBALS['link'], "update _tbANIResul  set result= '" . serialize($valor) . "' where lot='$ici' and fecha='$actual'");
endif;
function _CaptaGranjaFruta()
{
  $url = "http://www.granjamillonaria.com/Resource?a=hoyf"; // url de la pagina que queremos obtener
  $contents = file_get_contents($url);
  $contents = utf8_encode($contents);
  $results = json_decode($contents);
  $valor = $results->rss;
  $Numero = array();
  foreach ($valor as $i => $delta) {
    // print_r($valor);print_r($i);print_r($delta);
    print_r($delta);
    $Numero[] = intval($delta->nu);
  }
  return ($Numero);
}

function _CaptaFruta()
{
  $lineas = file('http://frutamillonaria.com/', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  //print_r($lineas);
  $Valores = array();
  foreach ($lineas as $num_linea => $linea) {
    $ocurr = strstr($linea, 'img/img-sorteos/FM');
    if (($ocurr !== false)) $Valores[] = $linea;
  }
  $Numero = array();
  for ($i = 0; $i <= count($Valores) - 1; $i++) {
    $ecn = strpos($Valores[$i], 'FM_');
    $rest = substr($Valores[$i], $ecn + 3, 3);
    $Numero[] = intval($rest);
  }
  return ($Numero);
}
function _CaptaLotto()
{
  $lineas = file('https://www.tuazar.com/loteria/lottoactivo/resultados/', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  //print_r($lineas);
  $primerstr = '<h1 class="maintitle">';
  foreach ($lineas as $num_linea => $linea) {
    //
    $sr = ($linea);
    $ecn = strpos($sr, $primerstr);
    if (($ecn !== false)) :

      //echo $sr;echo '<br>';echo '<br>';echo '<br>**************';
      //$ocurr=strstr($sr,'img-responsive');
      $arr2 = explode('<div>', $sr);
      //print_r($arr2);
      $Valores = array();
      for ($i = 0; $i <= count($arr2) - 1; $i++) {
        $ocurr = strstr($arr2[$i], '<img class="img-responsive" alt=');
        if (($ocurr !== false)) $Valores[] = $arr2[$i];
      }
      //print_r($Valores);
      $Numero = array();
      for ($i = 0; $i <= count($Valores) - 1; $i++) {
        $ecn = strpos($Valores[$i], 'alt');
        $rest = substr($Valores[$i], $ecn + 5, 10);
        //  echo $rest; echo ' * ';
        $x = explode('-', $rest);
        //print_r($x);
        $Numero[] = str_replace(' ', '', $x[0]);
      }
      return ($Numero);
    endif;
  }
}


function _Captalagranjita()
{
  $lineas = file('https://www.tuazar.com/loteria/lagranjita/resultados/', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  //print_r($lineas);
  $primerstr = '<h1 class="maintitle">';
  foreach ($lineas as $num_linea => $linea) {
    //
    $sr = ($linea);
    $ecn = strpos($sr, $primerstr);
    if (($ecn !== false)) :

      //echo $sr;echo '<br>';echo '<br>';echo '<br>**************';
      //$ocurr=strstr($sr,'img-responsive');
      $arr2 = explode('<div>', $sr);
      //print_r($arr2);
      $Valores = array();
      for ($i = 0; $i <= count($arr2) - 1; $i++) {
        $ocurr = strstr($arr2[$i], '<img class="img-responsive" alt=');
        if (($ocurr !== false)) $Valores[] = $arr2[$i];
      }
      //print_r($Valores);
      $Numero = array();
      for ($i = 0; $i <= count($Valores) - 1; $i++) {
        $ecn = strpos($Valores[$i], 'alt');
        $rest = substr($Valores[$i], $ecn + 5, 10);
        //  echo $rest; echo ' * ';
        $x = explode('-', $rest);
        //print_r($x);
        $Numero[] = str_replace(' ', '', $x[0]);
      }
      print_r($Numero);
      return ($Numero);
    endif;
  }
}
