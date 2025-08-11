<?
	 require('prc_php.php');   
	 $GLOBALS['link'] = Connection::getInstance(); 
 
	 Logs($_REQUEST['idt'],$_REQUEST['Idm'],$_REQUEST['asun'],$_REQUEST['act']);
