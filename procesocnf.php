<?
$texto=explode(" ",$_REQUEST['dato']);

$ejemplo=nl2br($_REQUEST['dato']);
//echo $ejemplo;
$texto=explode("\n",$ejemplo);
//print_r( $texto );


echo convertirMilitar($texto[1]);


function convertirMilitar($Hora)
{
$PMAM = explode(" ",$Hora);
$horaM = explode(":",$PMAM[0]);
if (strtoupper($PMAM[1])=='PM'): 
 if (intval($horaM[0])!=12):
	 $horaM[0]=intval($horaM[0])+12;
 endif;	 
endif;
return implode(':',$horaM);;
}
?>