<?

require('prc_php.php');
require('fpdf.php');

class PDF extends FPDF
{

	function Header()
	{
		global $xpp;
		global $tt;
		global $ttex;
		global $ttex2;
		global $header;
		global $w;
		global $w1;
		$this->Sety(0);
		$this->Setx(0);
		$this->SetFont('Arial', 'I', 7);
		$this->text(10, 7, 'Reporte Detallado de Ventas Deporte x Dias');
		$this->text(10, 10, $ttex);
		$this->text(10, 20, $ttex2);
		//$this->Image('logo_pb.png',10,8,33);

		$this->SetFont('Arial', 'B', 7);
		//***********************************

		$_xp = $this->Gety();
		$_xp = $_xp + 10;
		$this->Sety($_xp);
		$this->Setx($xpp);
		$this->Cell(30, 3, 'Fecha:' . date("d/n/Y"));
		$this->Sety($_xp + 3);
		$this->Setx($xpp);
		$va = $this->PageNo();
		$this->Cell(30, 3, 'Pagina No:' . $va);
		$this->Sety($_xp + 6);
		$this->Setx($xpp);
		$this->Cell(30, 3, 'Hora:' . date("g:i a"));
		$this->rect(($xpp) - 1, 8, 39, 12, 'D');
		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->SetFont('Arial', 'B', 8);
		$this->Setx(1);

		for ($i = 0; $i < count($header); $i++)
			$this->Cell($w[$i], 3, $header[$i], 1, 0, $w1[$i]);

		$this->Ln();
	}

	function BasicTable($header, $w, $header2, $w2)
	{
		for ($i = 0; $i < count($header); $i++)
			$this->Cell($w[$i], 3, $header[$i], 1, 0, 'C');

		if (count($header2) != 0) :
			$_xp = $this->Gety();

			$this->Sety($_xp + 3);
			$this->Setx(33);

			for ($i = 0; $i < count($header2); $i++)
				$this->Cell($w2[$i], 3, $header2[$i], 1, 0, 'C');

		endif;

		$this->Ln();
	}


	function registro($varlo, $w, $w1)
	{
		$this->SetFont('Arial', 'B', 7);
		$this->Setx(1);
		for ($i = 0; $i < count($varlo); $i++)
			$this->Cell($w[$i], 4, $varlo[$i], 0, 0, $w1[$i]);

		$this->Ln();
	}
}
$GLOBALS['link'] = Connection::getInstance();
$arrayRelacion = array();
$desde = $_REQUEST['desdef'];
$hasta = $_REQUEST['hastaf'];
$tipo = $_REQUEST['tipo'];
$seleccion = $_REQUEST['seleccion'];


$add = '';
$desdeIDC = 0;
$hastaIDC = 0;

$result = mysqli_query($GLOBALS['link'], "Select IDJ From _tjornada Where Fecha BETWEEN STR_TO_DATE('" . $desde . "','%d/%m/%Y') and STR_TO_DATE('" . $hasta . "','%d/%m/%Y') Group by IDJ Order by IDJ");
$row = mysqli_fetch_array($result);

$desdeIDC = $row['IDJ'];
while ($row = mysqli_fetch_array($result)) {
	$hastaIDC = $row['IDJ'];
}
if ($hastaIDC == 0) : $hastaIDC = $desdeIDC;
endif;


$add = "and  (IDJ BETWEEN " . $desdeIDC . " and " . $hastaIDC . ") ";


$header2 = array();
$w2 = array();
$w1 = array();
$aa2 = array();
$header[0] = 'Zona(Z)/Inter(I)/Agencia(A)';
$w[0] = 50;
$w1[0] = 'L';
$header[1] = 'Ventas';
$w[1] = 20;
$w1[1] = 'R';
$header[2] = '%';
$w[2] = 20;
$w1[2] = 'R';
$header[3] = 'Premios';
$w[3] = 20;
$w1[3] = 'R';
$header[4] = 'Diferencia';
$w[4] = 20;
$w1[4] = 'R';
$header[5] = '%Part(P.V.)';
$w[5] = 20;
$w1[5] = 'R';
$header[6] = '%Part(Banca)';
$w[6] = 20;
$w1[6] = 'R';
$header[7] = 'Premio.Pag';
$w[7] = 20;
$w1[7] = 'R';
$header[8] = '% del Grupo';
$w[8] = 20;
$w1[8] = 'R';
$header[9] = 'A Pagar';
$w[9] = 20;
$w1[9] = 'R';
$pdf = new PDF('L', 'mm', 'Legal');
$pdf->AddPage();
$pdf->SetAutoPageBreak(true);
//Iniciar Busqueda de Niveles de la zona!
//echo $tipo.'-'.$seleccion;
if ($tipo == 4) :
	$arrayRelacion[] = $seleccion;
else :
	recursivoNivel($tipo . '-' . $seleccion, '');
endif;
///print_r($arrayRelacion);
$aa = array();
$nivelinferior = '-1'; // -1=Inicializacio, 0=Nivel Superios, Otro(3-2,4-2,..etc):Nivel Superior;
//print_r($arrayRelacion);

for ($i = 0; $i <= count($arrayRelacion) - 1; $i++) {
	if ($tipo == 4) :
		$relacion[] = $seleccion;
	else :
		$relacion = relacion($arrayRelacion[$i], 4);
	endif;
	$pasar = false;
	if (count($relacion) == 1) :
		if ($nivelinferior != '0') :
			$nivelinferior = '4-' . $arrayRelacion[$i];
			$pasar = true;
		endif;
	else :
		if ($nivelinferior != $relacion[count($relacion) - 2]) :
			$nivelinferior = $relacion[count($relacion) - 2];
			$pasar = true;
		endif;
	endif;

	if ($pasar) :
		if (count($aa) != 0) :
			//print_r($aa);
			$pdf->registro($aa, $w, $w1);
		endif;
		$aa = array();
		$aa = array(0, 0, 0, 0, 0, 0, 0);
		$DesNivelinferior = explode('-', $nivelinferior);
		tabla_tipo($DesNivelinferior[0], $Tabla, $Clave);
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM " . $Tabla . "  where " . $Clave . "=" . $DesNivelinferior[1]);

		//echo ("SELECT * FROM ".$Tabla."  where ".$Clave."=".$DesNivelinferior[1]);		
		//echo $nivelinferior.'<br>';

		$row = mysqli_fetch_array($result);
		$aa[0] = $row['Descripcion'];

		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbtipo where tipo=" . $DesNivelinferior[0]);
		$row = mysqli_fetch_array($result);
		$aa[0] = '(' . substr($row['Descripcion'], 0, 1) . ')' . $aa[0];


		$participacionNivelSG =		 0;
		$participacionNivelSP =		 0;
		$PorcentajeTerminalNivelS =	 0;
		$PorcentajeTripleNivelS =	 0;
		$PorcentajeTerminalazoNivelS = 0;
		$PorcentajeTripletazoNivelS = 0;

		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tporcentajes  where ID=" . $DesNivelinferior[1] . " and tipo=" . $DesNivelinferior[0]);
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$participacionNivelSG =		 $row['ParticipacionGana'];
			$participacionNivelSP =		 $row['ParticipacionPierde'];
			$PorcentajeTerminalNivelS =	 $row['PorcentajeTerminal'];
			$PorcentajeTripleNivelS =	 $row['PorcentajeTriple'];
			$PorcentajeTerminalazoNivelS = $row['PorcentajeTerminalazo'];
			$PorcentajeTripletazoNivelS = $row['PorcentajeTripletazo'];
		endif;
	endif;

	// Ventas de Triple / Terminal
	$ventasterminal = 0;
	$ventastriple = 0;
	$result = mysqli_query($GLOBALS['link'], "SELECT CHAR_LENGTH(numero) as NC, sum(_tjugada_data.monto) as venta FROM _tjugada,_tjugada_data  where _tjugada.serial=_tjugada_data.serial and IDC=1 and Activo=1  and adicional=0 and _tjugada.IDC=" . $arrayRelacion[$i] . "  " . $add . " group by CHAR_LENGTH(numero) ");

	while ($row = mysqli_fetch_array($result)) {
		switch ($row['NC']) {
			case 2:
				$aa[1] += $row['venta'];
				$ventasterminal = $row['venta'];
				break;
			case 3:
				$aa[1] += $row['venta'];
				$ventastriple = $row['venta'];
				break;
		}
	}

	// Ventas de Tripletazo / Terminalazo
	$ventasTerminalazo = 0;
	$ventasTripletazo = 0;
	$result = mysqli_query($GLOBALS['link'], "SELECT CHAR_LENGTH(numero) as NC, sum(_tjugada_data.monto) as venta FROM _tjugada,_tjugada_data  where _tjugada.serial=_tjugada_data.serial and IDC=1 and Activo=1  and adicional!=0 and _tjugada.IDC=" . $arrayRelacion[$i] . " " . $add . " group by CHAR_LENGTH(numero) ");
	while ($row = mysqli_fetch_array($result)) {
		switch ($row['NC']) {
			case 2:
				$aa[1] += $row['venta'];
				$ventasTerminalazo = $row['venta'];
				break;
			case 3:
				$aa[1] += $row['venta'];
				$ventasTripletazo = $row['venta'];
				break;
		}
	}

	$premios = 0;
	$result = mysqli_query($GLOBALS['link'], "SELECT sum(premio) as premio FROM _tbjugadapremio,_tjugada where _tbjugadapremio.serial=_tjugada.serial and IDC=" . $arrayRelacion[$i] . " and Activo=1 " . $add);
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$aa[3] += $row['premio'];
		$premios = $row['premio'];
	endif;

	$result = mysqli_query($GLOBALS['link'], "SELECT sum(premio) as premiop FROM _tpremiospagados,_tbjugadapremio,_tjugada where _tbjugadapremio.serial=_tjugada.serial and _tpremiospagados.serial=_tjugada.serial and _tjugada.IDC=" . $arrayRelacion[$i] . " and Activo=1 " . $add);
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$aa[7] += $row['premiop'];
	endif;

	$result = mysqli_query($GLOBALS['link'], "Select * From _tporcentajes where ID=" . $arrayRelacion[$i] . " and tipo=4");
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);

		$pterminal = ($ventasterminal * $row['PorcentajeTerminal']) / 100;
		$ptriple   = ($ventastriple * $row['PorcentajeTriple']) / 100;
		$pterminalz = ($ventasTerminalazo * $row['PorcentajeTerminalazo']) / 100;
		$ptriplez  = ($ventasTripletazo * $row['PorcentajeTripletazo']) / 100;

		$porcentaje = ($pterminal + $ptriple + $pterminalz + $ptriplez);

		$ventas = ($ventasterminal + $ventastriple + $ventasTerminalazo + $ventasTripletazo);

		$diferencia = ($ventas - ($premios + $porcentaje));


		$aa[2] += $porcentaje;

		$aa[4] += $diferencia;

		if ($diferencia >= 0) :
			$participacion = (($ventas * $row['ParticipacionGana']) / 100);
		else :
			$participacion = (($ventas * $row['ParticipacionPierde']) / 100);
		endif;


		$participacionBanca = ($ventas - $participacion);

		$aa[5] += $participacion;
		$aa[6] += $participacionBanca;

		$pterminal = ($ventasterminal * $PorcentajeTerminalNivelS) / 100;
		$ptriple   = ($ventastriple * $PorcentajeTripleNivelS) / 100;
		$pterminalz = ($ventasTerminalazo * $PorcentajeTerminalazoNivelS) / 100;
		$ptriplez  = ($ventasTripletazo * $PorcentajeTripletazoNivelS) / 100;


		$porcentaje = ($pterminal + $ptriple + $pterminalz + $ptriplez);



		if ($diferencia >= 0) :
			$calculo1 = (($porcentaje * $row['ParticipacionGana']) / 100);
			$aa[8] += $calculo1;
			$participacion = (($ventas * $row['ParticipacionGana']) / 100);
		else :
			$calculo1 = (($porcentaje * $row['ParticipacionPierde']) / 100);
			$aa[8] += $calculo1;
			$participacion = (($ventas * $row['ParticipacionPierde']) / 100);
		endif;


		$aa[9] += ($calculo1 + $participacionBanca);




	endif;
}
if (count($aa) != 0) :
	$pdf->registro($aa, $w, $w1);
endif;
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 4);
$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");
$pdf->Output(); 
/*$idcn=$_REQUEST['idcn'];
$idj=$_REQUEST['idj'];
$IDG=$_REQUEST['idg'];
$divi=$_REQUEST['div'];
$factor=$_REQUEST['fac'];
$concg=$_REQUEST['concg'];

$header2=array();
$w2=array();
$w1=array();
$result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tdjuegos where IDjug=".$idj );
$row = mysqli_fetch_array($result);
$tt=$row['Descrip'];
$form=$row['Formato'];
$conesc=explode('-',$row['op4']);
 $totaldeb=$row['CantidadCarr']-$conesc[$concg];	


$header[0]='Serial';$w[0]=16;$w1[0]='L';
$header[1]='Ori';$w[1]=7;$w1[1]='L';
if ($row['CantidadCarr']<=6):
	if ($form!=4):
 		$mc=$row['CantidadCarr'];
	else:
		$mc=1;
	endif; 
else: 
 $mc=$row['CantidadCarr'];

 if ($form!=4):
	 for ($ttt=6;$ttt<=$mc-1;$ttt++)
	 {
		$header2[$ttt-6]=($ttt+1).' Valida';$w2[$ttt-6]=42;$w1[$ttt-6]='L';
	 }
 	$mc=6;
 else:	
  	$mc=1;
 endif;
 
endif;

for ($ttt=1;$ttt<=$mc;$ttt++)
{   
    if ($form!=4):
		$header[$ttt+1]=$ttt.' Valida';$w[$ttt+1]=42;$w1[$ttt+1]='L';
	else:
	    $header[$ttt+1]='(Jugada)';$w[$ttt+1]=100;$w1[$ttt+1]='L';break; 
	endif;
}
$ctc=$row['CantidadCarr'];
$header[$mc+2]='Monto Jugada';$w[$mc+2]=15;$w1[$mc+2]='R';
$header[$mc+3]='Monto Pagado';$w[$mc+3]=15;$w1[$mc+3]='R';
$header[$mc+4]='ESCRUTE';$w[$mc+4]=20;$w1[$mc+4]='R';
$header[$mc+5]='a Pagar';$w[$mc+5]=20;$w1[$mc+5]='R';

if ($row['Formato']==2):
$header[$mc+6]='Tanda/Carr';$w[$mc+6]=10;$w1[$mc+6]='L';
endif;


$result = mysqli_query($GLOBALS['link'],"SELECT _tjugada.* FROM _tjugada,_tconsecionario where _tjugada.IDC=_tconsecionario.IDC and _tconsecionario.IDG=".$IDG." and IDJug=".$idj." and idcn=".$idcn." and Anulado=0 Order by  _tconsecionario.IDC");

$primeralinea=0;
if ($ctc>=5):
	$xpp=280;
else:
	$xpp=220;
endif;


$pdf=new PDF('L','mm','Legal');

$pdf->AddPage();
$pdf->SetAutoPageBreak(true);

$cabz=-1;
$cuento=0;
$numx=230;
$sumxletra=0;
$sumxGrupo=0;
$inicio=true;
$grupo=-1;
while($row = mysqli_fetch_array($result))
{ 
$arrayes=poolescrute($row['Serial']);
$atp=contarenblanco($arrayes,5);
			 
if ($atp==$totaldeb):	 
if ($inicio==true):
	$pagina++;
	$pdf->SetFont('Arial','I',7); 
	$pdf->text(10,7,'Reporte Detallado de Premios');
	$_xp=$pdf->Gety();
	$pdf->Sety($_xp);
	$pdf->Setx(10);
	$pdf->SetFont('Arial','B',7); 
	$pdf->MultiCell(50,3,'Grupo:'.$IDG);
	$pdf->MultiCell(100,3,'Concesionario:'.$row['IDC']); 
	$pdf->SetFont('Arial','B',4);  
	$pdf->BasicTable($header,$w,$header2,$w2);
	$pdf->SetFont('Arial','B',8);
	$inicio=false;
else:
	$_xp=$pdf->Gety();
	if ($_xp>=$numx):
		$pdf->Ln(2);
		$_xp=$pdf->Gety();
		$pdf->Sety($_xp);
		$pdf->Setx(10);	
		$pdf->SetFont('Arial','B',7); 
		$pdf->MultiCell(50,3,'Grupo:'.$IDG);
		$pdf->MultiCell(100,3,'Concesionario:'.$row['IDC']); 
		$pdf->SetFont('Arial','B',4);  
		$pdf->BasicTable($header,$w,$header2,$w2);
		$pdf->SetFont('Arial','B',8);
	endif;
endif;

if ($cabz==-1):
 $cabz=$row['IDC'];
 $grupo=$IDG;
endif;

    $aa2=array();
    $aa[0]=$row['Serial'];
	switch ($row['org'])
	{
	 case 1: $aa[1]='Tel';break;
	 case 2: $aa[1]='Bol';break;
	 case 3: $aa[1]='Fax';break;
	 case 4: $aa[1]='Onl';break;
     default:
	   $aa[1]='Onl';break;
	}
	if ($form!=4): 	
	 	$jg=explode('|',$row['Jugada']);
	else:
		$jg=str_replace('|','-',substr($row['Jugada'],1));
	endif;
	if ($ctc<=6):
		if ($form!=4): 	 
	 		$mc=$ctc;
		else:
			$mc=1;	 
		endif;
	else:	
	if ($form!=4): 	 
	 for ($uu=1;$uu<=$ctc-5;$uu++)
	  $aa2[$uu]=ordenar($jg[$uu+6]);	
	  $mc=6;	 
	else:
	  $mc=1;	 
	endif; 
	endif;
	
	for ($uu=1;$uu<=$mc;$uu++)
	{
	if ($form!=4):
	$aa[$uu+1]=ordenar($jg[$uu]);	
	else:
	$aa[$uu+1]=ordenart2($jg);	
	endif;
	}	
	$aa[$uu+1]=number_format($row['Valor_R'],2,',','.');
	$aa[$uu+2]=number_format($row['Valor_J'],2,',','.');
	if ($arrayes[2]!=0): $parti=$arrayes[2]; else: $parti=1; endif; 
	$aa[$uu+3]=$arrayes[0]*$parti.'+'.$arrayes[1]*$parti;
	
	$aa[$uu+4]=number_format(calculodepago($row['Valor_J'],$row['Valor_R'],$arrayes[0],$arrayes[1],$parti,$divi,$factor) ,2,',','.');
	
    if ($form==2):
    	$aa[$uu+5]=$row['carr'];
	endif;
	
if (strcmp($cabz,$row['IDC'])==0):
    $pdf->registro($aa,$w,$aa2,$w2,$w1);
	$sumxletra+=$row['Valor_J'];
	$sumxGrupo+=$row['Valor_J'];
    $pdf->Ln();
else:
    $_xp=$pdf->Gety();
	$pdf->Sety($_xp+3);
	$pdf->Setx($xpp-20);
	$pdf->SetFont('Arial','B',8); 
	$pdf->MultiCell(100,3,'Total Ventas('.$cabz.') : '.number_format($sumxletra,2,',','.'));
	if ($grupo!=$row['IDG']):
	$pdf->Ln();
	$pdf->Setx($xpp-20);
	$pdf->MultiCell(100,3,'Total Ventas Grupo('.$grupo.') : '.number_format($sumxGrupo,2,',','.'));
	$sumxGrupo=0;
	$grupo=$IDG;
	endif;
	$cabz=$row['IDC'];
	$sumxletra=0;
	
  	$pdf->Ln();
	$pdf->Ln();
    $_xp=$pdf->Gety();
	$pdf->Sety($_xp);
	$pdf->Setx(10);
	$pdf->SetFont('Arial','B',7); 
	$pdf->MultiCell(50,3,'Grupo:'.$IDG);
	$pdf->MultiCell(100,3,'Concesionario:'.$row['IDC']); 
	$pdf->SetFont('Arial','B',4);  
	$pdf->BasicTable($header,$w,$header2,$w2);
	$pdf->SetFont('Arial','B',8);
	$pdf->registro($aa,$w,$aa2,$w2,$w1);
	$sumxletra+=$row['Valor_J'];
	$sumxGrupo+=$row['Valor_J'];
    $pdf->Ln();
 endif;	
endif;
}

$_xp=$pdf->Gety();
$pdf->Sety($_xp+3);
$pdf->Setx($xpp-20);
$pdf->SetFont('Arial','B',8); 
$pdf->MultiCell(100,3,'Total Ventas('.$cabz.') : '.number_format($sumxletra,2,',','.'));
$pdf->Ln();
$pdf->Setx($xpp-20);
$pdf->MultiCell(100,3,'Total Ventas Grupo('.$grupo.') : '.number_format($sumxGrupo,2,',','.'));
$sumxGrupo=0;
$pdf->Ln(10);
$pdf->SetFont('Arial','B',4);
$pdf->Cell(1,1,date("d-m-y")." ".date("g:i a"),1,0,"L");
$pdf->Output(); 

function ordenar($s)
{
	$val=explode('-',$s);
	$stf='';
	for ($ii=1;$ii<=14;$ii++)
	{
	$en=true;
	 for($jj=0;$jj<=count($val)-1;$jj++)
	 {
	 	if ($val[$jj]==$ii):
		 $stf=$stf.$val[$jj].' ';
		 $en=false;
		 break;
		endif; 
	 }
	 if ($en):
 	  if ($ii>9):
     	 $stf=$stf.'    ';
      else:
	 	 $stf=$stf.'   ';
	  endif;   
     endif; 
	}
	return $stf;
}

function ordenart2($s)
{
	$val=explode('-',$s);
	$stf='';
	for ($ii=0;$ii<=count($val)-1;$ii++)
	{
 	  if (floatval($val[$ii])>9):
     	 $stf=$stf.$val[$ii].'  ';
      else:
	 	 $stf=$stf.'  '.$val[$ii].'  ';
	  endif;   
	}
	return $stf;
}*/
