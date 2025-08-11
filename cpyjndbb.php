<?
class ConnectionsphBNAC
{

	protected $link;
	private $server, $username, $password, $db;
	private static $_singleton;

	public static function getInstance()
	{
		if (is_null(self::$_singleton)) {
			self::$_singleton = new ConnectionsphBNAC();
		}
		return self::$_singleton;
	}

	public function __construct()
	{
		$this->server = "losangeleshk.com"; //"sql213.xtreemhost.com";sphonline.net
		$this->username = "angeles_root"; //"xth_2440073";sphonlin_cateca sphonlin_root
		$this->password = "intra"; //"legna113";ctco%&
		$this->db = "angeles_db"; //"xth_2440073_cateca";sphonlin_cateca  sphonlin_sphonline
		$this->connect();
	}

	private function connect()
	{
		$this->link = mysqli_connect($this->server, $this->username, $this->password);
		mysql_select_db($this->db, $this->link);
	}
}

$fc = $_REQUEST["fc"];
$idjA = $_REQUEST['idj'];
require('prc_php.php');
$link2 = Connection::getInstance();

$resultx2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb where IDJ=" . $idjA . " and  Grupo=" . $_REQUEST['gp'] . " Order by IDP ");
if (mysqli_num_rows($resultx2) != 0) :
	$row =  mysqli_fetch_array($resultx2);
	$iniciop = $row['IDP'];
else :
	$resultx2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Order by IDP Desc");
	if (mysqli_num_rows($resultx2) != 0) :
		$row =  mysqli_fetch_array($resultx2);
		$iniciop = $row['IDP'] + 1;
	else :
		$iniciop = 1;
	endif;

endif;
//echo $iniciop;
$row1 = array();
$row2 = array();
$row3 = array();
$GLOBALS['link'] = ConnectionsphBNAC::getInstance();

$resultx1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "' and  Grupo=" . $_REQUEST['gp']);

if (mysqli_num_rows($resultx1) != 0) :

	$k = 0;
	while ($row = mysql_fetch_row($resultx1)) {

		$fields = mysql_num_fields($resultx1);
		$idj = $row[0];
		$lista1 .= '(';
		for ($i = 0; $i <= count($row) - 1; $i++) {
			if (mysql_field_name($resultx1, $i) == 'IDJ') :
				$lista1 .= $idjA;
			else :
				$type  = mysql_field_type($resultx1, $i);
				if ($type == 'string') :
					$lista1 .= "'" . $row[$i] . "'";
				else :
					$lista1 .= $row[$i];
				endif;
			endif;

			if ($i < count($row) - 1) : $lista1 .= ',';
			endif;
		}
		$lista1 .= ',1)';
		if ($k < mysqli_num_rows($resultx1) - 1) :
			$lista1 .= ',';
		endif;
		$k++;
	}

	$resultx2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDJ=" . $idj . " and   Grupo=" . $_REQUEST['gp'] . " Order by IDP");
	//	echo ("SELECT * FROM _partidosbb where IDJ=".$idj." and   Grupo=".$_REQUEST['gp']." Order by IDP" );	
	$k = 0;
	$inip = $iniciop;
	while ($row = mysql_fetch_row($resultx2)) {
		$fields = mysql_num_fields($resultx2);
		$lista2 .= '(';
		for ($i = 0; $i <= count($row) - 1; $i++) {
			if (mysql_field_name($resultx2, $i) == 'IDJ') :
				$lista2 .= $idjA;
			else :
				if (mysql_field_name($resultx2, $i) == 'IDP') :
					$lista2 .= $inip;
					$inip++;
				else :
					$type  = mysql_field_type($resultx2, $i);
					if ($type == 'string') :
						$lista2 .= "'" . $row[$i] . "'";
					else :
						$lista2 .= $row[$i];
					endif;
				endif;
			endif;
			if ($i < count($row) - 1) : $lista2 .= ',';
			endif;
		}
		$lista2 .= ',1)';
		if ($k < mysqli_num_rows($resultx2) - 1) :
			$lista2 .= ',';
		endif;
		$k++;
	}
	/*wq11t*/
	$resultx3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _configuracionjugadabb where IDJ=" . $idj . " and  Grupo=" . $_REQUEST['gp'] . " Order by IDP");
	// echo ("SELECT * FROM _configuracionjugadabb where IDJ=".$idj." and  Grupo=".$_REQUEST['gp']." Order by IDP" );
	$k = 0;
	$inip = $iniciop;
	$inipold = 0;

	while ($row = mysql_fetch_row($resultx3)) {
		$fields = mysql_num_fields($resultx3);
		$lista3 .= '(';
		for ($i = 0; $i <= count($row) - 1; $i++) {

			if (mysql_field_name($resultx3, $i) == 'IDJ') :
				$lista3 .= $idjA;
			else :

				$type  = mysql_field_type($resultx3, $i);
				if ($type == 'string') :
					$lista3 .= "'" . $row[$i] . "'";
				else :
					$lista3 .= $row[$i];
				endif;

			endif;
			if ($i < count($row) - 1) : $lista3 .= ',';
			endif;
		}
		$lista3 .= ',1)';
		if ($k < mysqli_num_rows($resultx3) - 1) :
			$lista3 .= ',';
		endif;
		$k++;
	}

	$link2 = Servidordual::getInstance();
	$resultx1 = mysqli_query($GLOBALS['link'], "Delete From _tbpublicaciones where IDJ=" . $idjA . " and  Grupo=" . $_REQUEST['gp']);
	/* Borrado de Jornada*/
	if ($resultx1) :
		$resultx1 = mysqli_query($GLOBALS['link'], "Delete From _jornadabb where IDJ=" . $idjA . " and  Grupo=" . $_REQUEST['gp']);
		$resultx1 = mysqli_query($GLOBALS['link'], "INSERT INTO _jornadabb  VALUES " . $lista1);
	endif;
	/* Borrado de Partidos*/
	if ($resultx2) :
		$resultx2 = mysqli_query($GLOBALS['link'], "Delete From _partidosbb where IDJ=" . $idjA . " and  Grupo=" . $_REQUEST['gp']);
		$resultx2 = mysqli_query($GLOBALS['link'], "INSERT INTO _partidosbb  VALUES " . $lista2);
	endif;
	/*Borrado de Configuracion de Jugadas*/
	if ($resultx3) :
		$resultx3 = mysqli_query($GLOBALS['link'], "Delete From _configuracionjugadabb where IDJ=" . $idjA . " and  Grupo=" . $_REQUEST['gp']);
		$resultx3 = mysqli_query($GLOBALS['link'], "INSERT INTO _configuracionjugadabb  VALUES " . $lista3);
	endif;

	if ($resultx1 && $resultx2 && $resultx3) :
		$stu[0] = true;
		$stu[1] = 0;
	else :
		$stu[0] = false;
		if (!$resultx1) : $stu[1] = 1;
		endif;
		if (!$resultx2) : $stu[1] = 2;
		endif;
		if (!$resultx3) : $stu[1] = 3;
		endif;
	endif;
/*echo $lista1.'<br>';
	  echo $lista2.'<br>';
	  echo $lista3.'<br>';*/


else :
	$stu[0] = true;
	$stu[1] = 1;
endif;

echo json_encode($stu);
