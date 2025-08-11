<?php
date_default_timezone_set('America/Caracas');
$GLOBALS['minutosh'] = 0;
$horasretro = 0;
$cantidadParlay = 10;

$server = '63.251.105.196';
$user = "parlayen_skynet"; //"root";angeles_root
$clv = 'tiqkSlT8y-!3';
$db = "parlayen_skynet"; //"angeles_db";losangeles

class Servidordual
{
    protected $link;
    private $server, $username, $password, $db;
    private static $_singleton;

    public static function getInstance()
    {
        if (is_null(self::$_singleton)) {
            self::$_singleton = new Servidordual();
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
