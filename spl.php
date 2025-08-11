<?
$Ldldc1=array( 0 ,-107 , 0 ,0 , -105); 
$ldc1=array('1','1','1','1.5','1.5');
$proceso=4;
$logro1[0]=0;$logro1[1]=-212;
$l1[0]=0;$l2[1]=2;
echo 'logrodes:';print_r($Ldldc1); echo 'moda:';print_r($ldc1);
			$PCarrera1=moda($ldc1);
			echo 'NUMERO MODA:'.$PCarrera1;echo '<br>';
			if ($proceso!=8):
			for ($e=0;$e<=count($ldc1)-1;$e++)
				if ($ldc1[$e]!=$PCarrera1):	
				    echo $Ldldc1[$e]; echo '<br>';
					if ($Ldldc1[$e]>0):  $logro1[0]=$logro1[0]-$Ldldc1[$e]; if ($Ldldc1[$e]!=0): $l1[0]--;endif;
					else:                $logro1[1]=$logro1[1]-$Ldldc1[$e]; if ($Ldldc1[$e]!=0): $l1[1]--;endif; endif;		
				endif;
			endif;	
			if ($proceso==8):
				for ($e=0;$e<=count($ldlSel)-1;$e++){
				 $eval=	$ldlSel[$e];
				 if ($eval[0]!=$PCarrera1):	$eval[1]=0;$ldlSel[$e]=$eval; endif;
				}
			endif;
			
		print_r($logro1);print_r($l1);
		
function moda($tuArray){
$cuenta = array_count_values($tuArray);
    arsort($cuenta);
    return key($cuenta);
}

?>