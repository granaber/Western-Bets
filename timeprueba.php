<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$time = time();
define('TABLE_PREFIX', '');
$sql = ("select " . TABLE_PREFIX . "_tusu.IDusu, " . TABLE_PREFIX . "_tusu.Nombre, " . TABLE_PREFIX . "_tusu.lastactivity, cometchat_status.message, cometchat_status.status from " . TABLE_PREFIX . "userlist join " . TABLE_PREFIX . "_tusu on  " . TABLE_PREFIX . "userlist.relationid = " . TABLE_PREFIX . "_tusu.IDusu left join cometchat_status on " . TABLE_PREFIX . "_tusu.IDusu = cometchat_status.userid where " . TABLE_PREFIX . "userlist.friend = 'yes' and " . TABLE_PREFIX . "userlist.userid = 1 order by Nombre asc");

$query = mysqli_query($GLOBALS['link'], $sql);

while ($chat = mysqli_fetch_array($query)) {

	echo $time - $chat['lastactivity'] . '<br>';
}
