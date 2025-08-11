<?php
		  require('prc_php.php'); 
          $GLOBALS['link'] = Connection::getInstance();  
		  
		  $serial=$_REQUEST["serial"];

	      echo json_encode(poolescrute($serial));
