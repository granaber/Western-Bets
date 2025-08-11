<?php

 $oko=$_REQUEST['op'];
 $v1=explode("|",$_REQUEST['op2']);
 $v2=explode("-",$v1[1]);

 $uno=1; $dos=1; $tres=1;     $cuatro=1;
 $qep=0;
 $q1='';
 $q2='';
 $q3='';
 $q4='';

 $key = array_search('2', $v2);
 if ($key===false):
    $dos=0;
 else:	
	if ($qep==0) 
	{
	 $qep=2;
     $q2='class="current"';
	}
 endif;

 $key = array_search('3', $v2);
 if ($key===false):
    $cuatro=0;
  else:	
	if ($qep==0) 
	{
	 $qep=2;
     $q4='class="current"';
	}
 endif; 
 $key = array_search('1', $v2);
 if ($key===false):
    $tres=0;
  else:	
	if ($qep==0) 
	{
	 $qep=2;
     $q3='class="current"';
	}
 endif;
$i=1;
"'index.php'";
$tom="'topmenubb.php'";
// ;
?>

<ul class="glossymenu">
<?php 

if ($cuatro==1):$index="'".$i."'"; echo '<li id="'.$i.'"  '.$q4.'  ><a onclick="javascript:current('.$index.');makeRequestmn();"><b>Deportes</b></a></li>'; $i++; endif;

if ($tres==1): $index="'".$i."'";echo '<li id="'.$i.'" '.$q3.'  ><a onclick="javascript:current('.$index.');makeRequestidx();"><b>Loterias</b></a></li>'; $i++; endif;

if ($dos==1): $index="'".$i."'";echo '<li id="'.$i.'" '.$q2.'  ><a onclick="javascript:current('.$index.');"><b>Hipismo Internacional</b></a></li>'; $i++; endif;
?>

	
<li id="<?php echo $i; $i++;?>" ><a href=""><b>Ayuda</b></a></li>	
</ul><div id="topmenubb"></div>