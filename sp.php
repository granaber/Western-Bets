<?
print_r(dSpe('6-107',4));
function dSpe($vlor,$pro){
	$ecua=false;
	
	
			$varl=$vlor;
			$es='';
			if ($pro==8): 
				$pos = strpos($varl, 'o');
				if ( !($pos===false)) $es='o';
				$pos = strpos($varl, 'u');
				if ( !($pos===false)) $es='u';
			endif;	
			///// con signo adelante y compuesto /////
			$signo = strpos($varl, '-');
			$slas = strpos($varl, '/');$cuentsig=substr_count($varl,'-');
			if ( $signo==0 && strlen($varl)>6 && $slas>0):
			  $vl=explode('/',$varl);$ecua=true; $vl[]=1;
			endif;
			if ( $signo>0 && strlen($varl)>6 && $slas==0):
			  $vl=explode('-',$varl);	
			  if ($pro!=4) $vl[1]='-'.$vl[1];
			  $ecua=true;$vl[]=2; echo 3;
			endif;
			
			if ( $signo>0 && strlen($varl)>=5 && $slas==0):
			  $vl=explode('-',$varl);
			  if ($pro!=4) $vl[1]='-'.$vl[1];
			  $ecua=true;$vl[]=2; echo 2;
			endif;
			if (  strlen($varl)>=5 && $slas==0 && $cuentsig==2):
			  $vl=explode('-',$varl);
			  $vl[0]='-'.$vl[1];
			  $vl[1]=$vl[2];
			  $vl[1]='-'.$vl[1];$ecua=true;$vl[2]=2; echo 1;
			endif;
			
			$mas=strpos($varl, '+');$cuentsig=substr_count($varl,'+');
			if ( $signo==0 && strlen($varl)>=5 && $slas==0 && $mas>0):
			  $vl=explode('+',$varl);
			  $vl[1]='+'.$vl[1];$ecua=true;$vl[]=2; 
			endif;
			
			
			if ( $signo==0 && strlen($varl)>6 && $slas==0 && $mas>0):
			  $vl=explode('+',$varl);
			  $vl[1]='+'.$vl[1];$ecua=true;$vl[]=2;
			endif;
			
			if ( $signo==0 && strlen($varl)>=5 && $slas==0 && $cuentsig==2):
			  $vl=explode('+',$varl);
			  $vl[0]='+'.$vl[1];
			  $vl[1]=$vl[2];
			  $vl[2]=2;
			  $vl[1]='+'.$vl[1];$ecua=true;
			endif;
			
			$letra=strpos($varl, 'o');
			if ( $letra>0):
			  $vl=explode('o',$varl);$ecua=true;$vl[]=2;
			endif;
			$letra=strpos($varl, 'u');
			if ( $letra>0):
			  $vl=explode('u',$varl);$ecua=true;$vl[]=2;
			endif;
	
	//if ($pro==7): if ($vl[2]==1):

	if ($ecua): if ($vl[0]=='pk') $vl[0]=0; $vl[]=$es; return($vl); else: return array($varl,0,0,$es); endif; 
	  
	  
  }

?>