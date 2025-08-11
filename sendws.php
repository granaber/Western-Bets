//Your number 584246522692 with the following password wGm2aO51Pt14Oa6xhW6WyP1mVaw= is not blocked
<?php
require_once 'src/whatsprot.class.php';
//require 'src/events/MyEvents.php';
$username = "584246522692";
$password = "wGm2aO51Pt14Oa6xhW6WyP1mVaw=";
$wa = new WhatsProt($username, 0, "Enaijize System", true);
$wa->connect();
$wa->loginWithPassword($password);
$dst='584146894013';
$msg='Este un mensajes de WS por PHP';
$wa->sendMessage($dst, $msg);
echo "<b>Disconnecting...</b>";
$wa->disconnect();
echo "<b>Done.</b>";
?>
