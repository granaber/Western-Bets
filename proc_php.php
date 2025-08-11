<?php

//****************  Clase Connection  ********************************


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
		$this->server = "localhost"; //"sql213.xtreemhost.com";
		$this->username = "sphonlin_root"; //"xth_2440073";sphonlin_cateca
		$this->password = "intra"; //"legna113";ctco%&
		$this->db = "sphonlin_sphonline"; //"xth_2440073_cateca";sphonlin_cateca
		$this->connect();
	}

	private function connect()
	{
		$this->link = mysqli_connect($this->server, $this->username, $this->password);
		mysql_select_db($this->db, $this->link);
	}
}

class ConnectionPDO
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
		$this->server = "localhost";
		$this->username = "root";
		$this->password = "1";
		$this->db = "cateca";
		$this->connect();
	}

	private function connect()
	{
		$this->link = new PDO('mysql:host=localhost;dbname=' . $this->db, $this->username, $this->password);
	}

	public function sql($sql)
	{
		$sth = $GLOBALS['link']->query($sql);
		return $this->$sth;
	}
}

function caltime($h1, $h2)
{
	$ch1 = explode(':', $h1);
	$ch2 = explode(':', $h2);

	$h1 = intval($ch1[0]);
	$m1 = intval($ch1[1]);

	$h2 = intval($ch2[0]);
	$m2 = intval($ch2[1]);

	if (trim($ch1[2]) == 'p') :
		$h1 = $h1 + 12;
	endif;


	if (trim($ch2[2]) == 'p') :
		$h2 = $h2 + 12;
	endif;



	$ht1 = mktime($h1, $m1, 0, 0, 0, 0);
	$ht2 = mktime($h2, $m1, 0, 0, 0, 0);
	$dif = abs($ht2 - $ht1) / 60;

	return ($dif / 60);
}

function printtime($h1, $h2)
{
	$ch1 = explode(':', $h1);
	$ch2 = explode(':', $h2);

	$h1 = str_repeat("0", 2 - strlen(trim($ch1[0]))) . trim($ch1[0]);
	$m1 = str_repeat("0", 2 - strlen(trim($ch1[1]))) . trim($ch1[1]);

	$h2 = str_repeat("0", 2 - strlen(trim($ch2[0]))) . trim($ch2[0]);
	$m2 = str_repeat("0", 2 - strlen(trim($ch2[1]))) . trim($ch2[1]);

	if (trim($ch1[2]) == 'p') :
		$a = 'PM';
	else :
		$a = 'AM';
	endif;


	if (trim($ch2[2]) == 'p') :
		$b = 'PM';
	else :
		$b = 'AM';
	endif;



	$ht1 = $h1 . ':' . $m1 . ',' . $a;
	$ht2 = $h2 . ':' . $m2 . ',' . $b;


	return ($ht1 . '|' . $ht2);
}
function fecha($fech)
{
	$diat = date_create($fech);

	return $fech;
}



function acceso($usu, $pwd)
{
	$acceso = false;
	$result = mysqli_query($GLOBALS['link'], "Select * from _tbusuarios where Usuario='" . $usu . "'");
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		/*  if (crypt($row['pwd'],'neoyorquinoo%')==$pwd): */
		if ($row['pwd'] == $pwd) :
			$acceso = true;
		else :
			$acceso = false;
		endif;
	endif;
	echo json_enconde($acceso);
}
