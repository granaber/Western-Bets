<?php

date_default_timezone_set('America/Caracas');
$server1 = '206.81.7.118';
$user1 = "parlayen_skynet"; //"root";zuliana_root
$clv1 = 'tiqkSlT8y-!3'; //QW58aX43^=$r/intra
$db1 = "parlayen_skynet"; //"zuliana_banca";bancazuliana
$IDCLIENT = 1;
class Skynet
{
    protected $link;
    private $server1, $username1, $password1, $db1;
    private static $_singleton;

    public static function getInstance()
    {
        if (is_null(self::$_singleton)) {
            self::$_singleton = new Skynet();
        }
        return self::$_singleton;
    }

    public function __construct()
    {
        global $server1;
        global $user1;
        global $clv1;
        global $db1;

        $this->server = $server1; //"sql213.xtreemhost.com";
        $this->username = $user1; //"xth_2440073";sphonlin_cateca
        $this->password = $clv1; //"legna113";ctco%&
        $this->db = $db1; //"xth_2440073_cateca";sphonlin_cateca
        $this->connect();
    }

    private function connect()
    {
        $this->link = mysqli_connect($this->server, $this->username, $this->password);
        mysql_select_db($this->db, $this->link);
    }
}

class SkynetN2
{
    protected $link;
    private $server1, $username1, $password1, $db1;
    private static $_singleton;

    public static function getInstance()
    {
        if (is_null(self::$_singleton)) {
            self::$_singleton = new SkynetN2();
        }
        return self::$_singleton;
    }

    public function __construct()
    {
        global $server1;
        global $user1;
        global $clv1;
        global $db1;

        $this->server = $server1; //"sql213.xtreemhost.com";
        $this->username = $user1; //"xth_2440073";sphonlin_cateca
        $this->password = $clv1; //"legna113";ctco%&
        $this->db = $db1; //"xth_2440073_cateca";sphonlin_cateca
        $this->connect();
    }

    private function connect()
    {
        $this->link = mysqli_connect($this->server, $this->username, $this->password);
        mysql_select_db($this->db, $this->link);
    }
}
