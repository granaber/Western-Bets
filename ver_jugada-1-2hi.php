 <?php
	require('prc_php.php');
	$GLOBALS['link'] = Servidordual::getInstance();

	$idc = $_REQUEST['idc'];
	if ($idc == '-2') : $admin = true;
	else : $admin = false;
	endif;
	// $result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tbrestricionessph where IDC='".$idc."'");
	if ($admin) :
		// if (mysqli_num_rows($result)!=0 ): $row = mysqli_fetch_array($result); $anul=$row['anul']; else: $anul=0; endif;
		if ($anul != 0 || $admin) :
			$tk = $_REQUEST['tk'];
			$lista = explode("|", $tk);
			$resp[] = true;
			$resp[] = 0;
			//print_r($lista);
			for ($i = 0; $i <= count($lista) - 2; $i++) {
				$result = mysqli_query($GLOBALS['link'], "Select * from _tjugadahi where Anulado=0 and Serial=" . $lista[$i]);

				if (mysqli_num_rows($result) != 0) :
					$result = mysqli_query($GLOBALS['link'], "Update _tjugadahi set Anulado=1 where Serial=" . $lista[$i]);
				//echo "Update _tjugada set Anulado=1 where Serial=".$lista[$i];
				else :
					$result = mysqli_query($GLOBALS['link'], "Update _tjugadahi set Anulado=0 where Serial=" . $lista[$i]);
				//echo "Update _tjugada set Anulado=0 where Serial=".$lista[$i];
				endif;
			}
		else :
			$resp[] = false;
		endif;
	else :
		$resp[] = false;
	endif;
	echo json_encode($resp);
	/*$idc=$_REQUEST['idc']; $IDCN=$_REQUEST['IDCN'];
 $result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tbrestricionessph where IDC='".$idc."'");
 if (mysqli_num_rows($result)!=0):
   $row = mysqli_fetch_array($result) ;
   if ($row['anul']!=0):
    $anul=$row['anul'];
    $result = mysqli_query($GLOBALS['link'],"SELECT count(Serial) as cant FROM _tbrestricionessph where  Anulado=1 and IDCN=".$IDCN);
	$row = mysqli_fetch_array($result) ;
	if ($row['cant']<=$anul):
		$tk=$_REQUEST['tk'];
 		$lista=explode("|",$tk);
 		//print_r($lista);
		for ($i=0;$i<=count($lista);$i++)
		 {	 	 
  		 $result = mysqli_query($GLOBALS['link'],"Select * from _tjugada where Anulado=0 and Serial=".$lista[$i]);	 
	  	 if (mysqli_num_rows($result)!=0):
  	      if ($i<=$anul):
		  	$result = mysqli_query($GLOBALS['link'],"Update _tjugada set Anulado=1 where Serial=".$lista[$i]);
			$resp[]=true;$resp[]=0; 
		  else:
		  	$resp[]=false;$resp[]=$i; break;
		  endif;
  	 	 //echo "Update _tjugada set Anulado=1 where Serial=".$lista[$i];
 		 else:
   		  $result = mysqli_query($GLOBALS['link'],"Update _tjugada set Anulado=0 where Serial=".$lista[$i]);
			//echo "Update _tjugada set Anulado=0 where Serial=".$lista[$i];
  		 endif;
		}
     else:
		$resp[]=false;$resp[]=0; 
	 endif;
   else:
    $resp[]=false;$resp[]=0;
   endif;	
 else:
  $resp[]=false;$resp[]=0;
 endif;*/
	?>
