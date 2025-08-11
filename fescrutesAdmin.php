<?php
		require('prc_php.php'); 
		  $serial=$_REQUEST["serial"];
				
			
	      echo json_encode(pescrute($serial,0,false));
		  
		


?>