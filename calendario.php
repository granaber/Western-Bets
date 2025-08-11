<?php
function UltimoDia($a,$m){
  if (((fmod($a,4)==0) and (fmod($a,100)!=0)) or (fmod($a,400)==0)) {
    $dias_febrero = 29;
  } else {
    $dias_febrero = 28; 
  }
  switch($m) {
    case  1: $valor = 31; break;
    case  2: $valor = $dias_febrero; break;
    case  3: $valor = 31; break;
    case  4: $valor = 30; break;
    case  5: $valor = 31; break;
    case  6: $valor = 30; break;
    case  7: $valor = 31; break;
    case  8: $valor = 31; break;
    case  9: $valor = 30; break;
    case 10: $valor = 31; break;
    case 11: $valor = 30; break;
    case 12: $valor = 31; break;
  }
  return $valor;
}

function nombre_mes($m){
  switch($m) {
    case  1: $valor = "Enero";		break;
    case  2: $valor = "Febrero";	break;
    case  3: $valor = "Marzo";		break;
    case  4: $valor = "Abril";		break;
    case  5: $valor = "Mayo";		break;
    case  6: $valor = "Junio";		break;
    case  7: $valor = "Julio";		break;
    case  8: $valor = "Agosto";		break;
    case  9: $valor = "Septiembre"; break;
    case 10: $valor = "Octubre";	break;
    case 11: $valor = "Noviembre";	break;
    case 12: $valor = "Diciembre";	break;
  }
  return $valor;
}

function numero_dia_semana($d,$m,$a){ 
  $f = getdate(mktime(0,0,0,$m,$d,$a)); 
  $d = $f["wday"];
  if ($d==0) {$d=7;}
  return $d;
} 

function nombre_dia_semana($d,$m,$a){ 
  $f = getdate(mktime(0,0,0,$m,$d,$a)); 
  switch($f["wday"]) {
    case 1: $valor = "Lunes";		break;
    case 2: $valor = "Martes";		break;
    case 3: $valor = "Miercoles";	break;
    case 4: $valor = "Jueves";		break;
    case 5: $valor = "Viernes";		break;
    case 6: $valor = "Sabado";		break;
    case 0: $valor = "Domingo";		break;
  }
  return $valor;
}
$posic=$_GET["poss"];
$hoy = getdate();
$anhohoy = $hoy["year"];
$meshoy  = $hoy["mon"];
$diahoy  = $hoy["mday"];

$anho = $_REQUEST["anho"];
$mes  = $_REQUEST["mes"];
$dia  = 1;
if (($anho==0)||($mes==0)){
  $anho=$anhohoy;
  $mes =$meshoy;
}
$dias_mes = UltimoDia($anho,$mes);
$NombreMes = nombre_mes($mes);
$NumeroSemanas = ceil(($dias_mes+(numero_dia_semana($dia,$mes,$anho)-1))/7);
if ($mes==1) {
  $anhoant = $anho-1;
  $mesant = 12;
  $anhosig = $anho;
  $messig = $mes+1;
} else if ($mes==12) {
  $anhoant = $anho;
  $mesant = $mes-1;
  $anhosig = $anho+1;
  $messig = 1;
} else {
  $anhoant = $anho;
  $mesant = $mes-1;
  $anhosig = $anho;
  $messig = $mes+1;
}
$anhoanterior  = $anho-1;
$anhosiguiente = $anho+1;
echo "<html>";
echo "<body link='navy' alink='navy' vlink='navy'>";
echo "<form method='post' name='calendario' action='./calandario.php'>";
echo "<table border='0' bgcolor='navy' width='30%'>";
echo "<tr>";
echo "<td align='center' bgcolor='silver' width='14%'>";
echo "<font face='arial' color='navy' size='2'><a href=./calendario.php?anho=".$anhoanterior."&mes=".$mes."&poss=".$posic."><b><<</b></a></font>";
echo "</td>";
echo "<td align='center' bgcolor='silver' width='15%'>";
echo "<font face='arial' color='navy' size='2'><a href=./calendario.php?anho=".$anhoant."&mes=".$mesant."&poss=".$posic."><b><<b></a></font>";
echo "</td>";
echo "<td align='center' bgcolor='silver' colspan='3' width='43%'>";
echo "<font face='arial' color='navy' size='2'><b>".$NombreMes." - ".$anho."</b></font>";
echo "</td>";
echo "<td align='center' bgcolor='silver' width='14%'>";
echo "<font face='arial' color='navy' size='2'><a href=./calendario.php?anho=".$anhosig."&mes=".$messig."&poss=".$posic."><b>></b></a></font>";
echo "</td>";
echo "<td align='center' bgcolor='silver' width='14%'>";
echo "<font face='arial' color='navy' size='2'><a href=./calendario.php?anho=".$anhosiguiente."&mes=".$mes."&poss=".$posic."><b>>></b></a></font>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td align='center' bgcolor='navy' width='14%'>";
echo "<font face='arial' color='white' size='3'><b>L</b></font>";
echo "</td>";
echo "<td align='center' bgcolor='navy' width='15%'>";
echo "<font face='arial' color='white' size='3'><b>M</b></font>";
echo "</td>";
echo "<td align='center' bgcolor='navy' width='15%'>";
echo "<font face='arial' color='white' size='3'><b>M</b></font>";
echo "</td>";
echo "<td align='center' bgcolor='navy' width='14%'>";
echo "<font face='arial' color='white' size='3'><b>J</b></font>";
echo "</td>";
echo "<td align='center' bgcolor='navy' width='14%'>";
echo "<font face='arial' color='white' size='3'><b>V</b></font>";
echo "</td>";
echo "<td align='center' bgcolor='navy' width='14%'>";
echo "<font face='arial' color='white' size='3'><b>S</b></font>";
echo "</td>";
echo "<td align='center' bgcolor='navy' width='14%'>";
echo "<font face='arial' color='white' size='3'><b>D</b></font>";
echo "</td>";
echo "</tr>";
for ($semana=1;$semana<=$NumeroSemanas;$semana++){
  echo "<tr>";
  for ($diasem=1;$diasem<=7;$diasem++){ 
    $dow = numero_dia_semana($dia,$mes,$anho);
	if (($dow==2)||($dow==3)) {$ancho='15%';} else {$ancho='14%';}
	if (($dow==6)||($dow==7)) {$color='red';} else {$color='navy';}
    if ($anho*10000+$mes*100+$dia==$anhohoy*10000+$meshoy*100+$diahoy) {$colorfondo='yellow';} else {$colorfondo='white';}	
	if (($dow==$diasem) && ($dia<=$dias_mes)) {
	  $valor = $dia;
	  $dia++;
	} else {
	  $valor = "&nbsp;";
	}
	echo "<td align='right' bgcolor=$colorfondo width=$ancho>";
	if ($valor!="&nbsp;"):
	 $fexp=$valor."/".$mes."/".$anho;
     echo "<font face='arial' color=$color size='3'><a href='enviar.php?fecha=$fexp&pos=$posic'><b>$valor</b></font>";
     //echo "<font face='arial' color=$color size='3'><a href='javascript:window.opener.document.GrabForm.fecha1.value='$fexp><b>$valor</b></font>";
	
	else:
	 echo "<font face='arial' color=$color size='3'><b>$valor</b></font>";
	endif;
	echo "</td>";
  } 
  echo "</tr>";
}
echo "<tr>";
echo "<td align='center' colspan='7'>";
echo "<font face='arial' size='1' color='yellow'>";
echo "<b>Hoy: ".nombre_dia_semana($diahoy,$meshoy,$anhohoy)." ".$diahoy." de ".nombre_mes($meshoy)." del ".$anhohoy."</b>";
echo "</font>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</form>";
echo "</body>";
echo "</html>";
?>

