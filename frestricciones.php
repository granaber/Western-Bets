<?		require('prc_php.php'); 
  	    $GLOBALS['link'] = Connection::getInstance(); 
		  $op=$_REQUEST["op"];
		  $conce=$_REQUEST["conce"];
		  $idj=$_REQUEST["idj"];
		  $cantidad=$_REQUEST["cantidad"];

		  if ($op==1):

			  $equic=$_REQUEST["equic"]; 

			  $idddc=$_REQUEST["idddc"];

	   		  echo json_encode(restricciones1($conce,$idj,$equic,$cantidad,$idddc));

		  endif;

		  if ($op==2):

			  $equil=$_REQUEST["equic"]; 

			  $idddl=$_REQUEST["idddc"];
			  
			  $acobrar=$_REQUEST["acobrar"];
			  $ap=intval($_REQUEST["ap"]);
			   	
	   		  echo json_encode(restricciones2($conce,$idj,$equil,$cantidad,$idddl,$acobrar,$ap));

		  endif;
		  
		   if ($op==3):

			  $equil=$_REQUEST["equic"]; 

			  $idddl=$_REQUEST["idddc"];
			  
			  $acobrar=$_REQUEST["acobrar"];
			  $ap=intval($_REQUEST["ap"]);
			   	
	   		  echo json_encode(restricciones3($conce,$idj,$equil,$cantidad,$idddl,$acobrar,$ap));

		  endif;
