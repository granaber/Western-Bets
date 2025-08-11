<?
require_once('prc_phpDUK.php');

$iud = $_REQUEST['uid'];

decoBaseAnimalitos($iud);

include $_REQUEST['filephp'];
