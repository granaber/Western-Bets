<?

 switch($Tipo){
	 case   'MLB':
					$Grupo="INSERT INTO `_gruposdd` (`Grupo`, `Descripcion`, `Estatus`, `imagen`,escrute) VALUES($ValorG, '$Descripcion', 1, '$img',0);";
					$Formato ="INSERT INTO `_formatosbb` (`Formato`, `Descripcion`, `Grupo`) VALUES ($Valor1, 'Juego Completo', $ValorG);";
					$Apuestas ="INSERT INTO `_tbjuegodd` (`IDDD`, `Descripcion`, `Formato`, `Grupo`, `Columnas`, `Minimas`, `Opcion`, `Estatus`, `TDisplay`, `Tituloticket`, `AddTicket`, `Maximas`, `noCombinar`, `reporte`, `textorfila`, `tmc`, `procesoescrute`, `logrosxdefecto`, `ImpreTK`) VALUES
					($ValorJ1, 'A Ganar', $Valor1, $ValorG, 'AA$Firma|BB$Firma', 1, 'i', 1, '', 'Parlay', 'A Ganar $InicTicket', 8, '3|', 'Logro Jug. Completo', '', 80, 1, '', 0),
					(".($ValorJ1+1).", 'Alta/Baja', $Valor1, $ValorG, 'Ax$Firma|4-car$Firma|B$Firma|4-carB$Firma', 1, 'i', 1, '', 'Parlay', 'Alta $InicTicket|Baja $InicTicket', 8, '', 'Alta/Baja Completo', 'A|B', 80, 2, '', 0),
					(".($ValorJ1+2).", 'RunLine',  $Valor1, $ValorG, 'RU_1_$Firma|4-carR_1_$Firma|RU_2_$Firma|4-carR_2_$Firma', 1, 'i', 1, '', 'Parlay', 'RL $InicTicket', 8, '1|', 'RL ', '', 60, 4, '', 0);";
					
					
					$Escrute[0]="Update `_cngescrute` set IDDD_AESC=concat(IDDD_AESC,'|$ValorJ1|".($ValorJ1+1)."|".($ValorJ1+2)."') where IDCNGE=6;";
					 $ok=true;
					break;
	  
		case   'SOC':
					$Grupo="INSERT INTO `_gruposdd` (`Grupo`, `Descripcion`, `Estatus`, `imagen`,escrute) VALUES($ValorG, '$Descripcion', 1, '$img',0);";
					$Formato ="INSERT INTO `_formatosbb` (`Formato`, `Descripcion`, `Grupo`) VALUES ($Valor1, 'Juego Completo', $ValorG),(".($Valor1+1).", 'Empate',$ValorG);";
					$Apuestas ="INSERT INTO `_tbjuegodd` (`IDDD`, `Descripcion`, `Formato`, `Grupo`, `Columnas`, `Minimas`, `Opcion`, `Estatus`, `TDisplay`, `Tituloticket`, `AddTicket`, `Maximas`, `noCombinar`, `reporte`, `textorfila`, `tmc`, `procesoescrute`, `logrosxdefecto`, `ImpreTK`) VALUES
					($ValorJ1, 'A Ganar', $Valor1, $ValorG, 'AA$Firma|BB$Firma', 1, 'i', 1, '', 'Parlay', 'A Ganar $InicTicket', 8, '5|', 'Logro Jug. Completo', '', 80, 5, '', 0),
					(".($ValorJ1+1).", 'Alta/Baja', $Valor1, $ValorG, 'Ax$Firma|4-car$Firma|B$Firma|4-carB$Firma', 1, 'i', 1, '', 'Parlay', 'Alta $InicTicket|Baja $InicTicket', 8, '', 'Alta/Baja Completo', 'A|B', 80, 2, '', 0),
					(".($ValorJ1+2).", 'Empate', ".($Valor1+1).", $ValorG, 'LG$Firma', 1, 'i', 1, '', 'Parlay', 'Emp $InicTicket', 8, '1|', 'Empate ', '', 60, 4, '', 0);";
					
					
					$Escrute[0]="Update `_cngescrute` set IDDD_AESC=concat(IDDD_AESC,'|$ValorJ1|".($ValorJ1+1)."') where IDCNGE=1;";
					$Escrute[1]="Update `_cngescrute` set IDDD_AESC=concat(IDDD_AESC,'|".($ValorJ1+2)."') where IDCNGE=5; ";
					 $ok=true;
					break;
		case   'CFB':
					$Grupo="INSERT INTO `_gruposdd` (`Grupo`, `Descripcion`, `Estatus`, `imagen`,escrute) VALUES($Liga, '$Descripcion', 1, '$img',0);";
					$Formato ="INSERT INTO `_formatosbb` (`Formato`, `Descripcion`, `Grupo`) VALUES ($Valor1, 'Linea de Puntos', $Liga);";
					$Apuestas ="INSERT INTO `_tbjuegodd` (`IDDD`, `Descripcion`, `Formato`, `Grupo`, `Columnas`, `Minimas`, `Opcion`, `Estatus`, `TDisplay`, `Tituloticket`, `AddTicket`, `Maximas`, `noCombinar`, `reporte`, `textorfila`, `tmc`, `procesoescrute`, `logrosxdefecto`, `ImpreTK`) VALUES
					($ValorJ1, 'Line/Puntos', $Valor1, $Liga, 'RUB$Firma|5-carB$Firma|RUB2$Firma|5-carB$Firma', 1, 'i', 1, '', 'Parlay', 'Ptos $InicTicket', 20, '3|4|5|6|7|8|9|10|11|12|', 'Line/Puntos Completo', '', 80, 3, '-120|-120', 0),
					(".($ValorJ1+1).", 'Alta/Baja', $Valor1, $Liga, 'AxBS$Firma|5-car1ABS$Firma|ABS$Firma|5-car2ABS$Firma', 1, 'i', 1, '', 'Parlay', 'Al $InicTicket|Ba $InicTicket', 20, '4|5|6|7|8|9|10|11|12|', 'Alta|Baja', 'A|B', 80, 2, '-120|-120', 0),					
					(".($ValorJ1+2).", 'MoneyLine', $Valor1, $Liga, 'AAB$Firma|BBB$Firma', 1, 'i', 1, '', 'Parlay', 'MoneyLine $InicTicket', 12, '1|4|5|6|7|8|9|10|11|12|13|', 'MoneyLine', '', 80, 3, '', 0);";
					
					$Escrute[0]="Update `_cngescrute` set IDDD_AESC=concat(IDDD_AESC,'|$ValorJ1|".($ValorJ1+1)."|".($ValorJ1+2)."') where IDCNGE=1;";
					 $ok=true;
					break;	
		case   'MU':
					$Grupo="INSERT INTO `_gruposdd` (`Grupo`, `Descripcion`, `Estatus`, `imagen`,escrute) VALUES($ValorG, '$Descripcion', 1, '$img',0);";
					$Formato ="INSERT INTO `_formatosbb` (`Formato`, `Descripcion`, `Grupo`) VALUES ($Valor1, 'Total', $ValorG);";
					$Apuestas ="INSERT INTO `_tbjuegodd` (`IDDD`, `Descripcion`, `Formato`, `Grupo`, `Columnas`, `Minimas`, `Opcion`, `Estatus`, `TDisplay`, `Tituloticket`, `AddTicket`, `Maximas`, `noCombinar`, `reporte`, `textorfila`, `tmc`, `procesoescrute`, `logrosxdefecto`, `ImpreTK`) VALUES
					($ValorJ1, 'A Ganar', $Valor1, $ValorG, 'AAB$Firma|BBB$Firma', 1, 'i', 1, '', 'Parlay', 'AGanar $InicTicket', 12, '', 'AGanar', '', 80, 3, '', 0);";
					
					$Escrute[0]="Update `_cngescrute` set IDDD_AESC=concat(IDDD_AESC,'|$ValorJ1') where IDCNGE=1;";
					 $ok=true;
					break;	
		case 'NBA':
					$Grupo="INSERT INTO `_gruposdd` (`Grupo`, `Descripcion`, `Estatus`, `imagen`,escrute) VALUES($ValorG, '$Descripcion', 1, '$img',0);";
					$Formato ="INSERT INTO `_formatosbb` (`Formato`, `Descripcion`, `Grupo`) VALUES ($Valor1, 'Juego Completo', $ValorG);";
					$Apuestas ="INSERT INTO `_tbjuegodd` (`IDDD`, `Descripcion`, `Formato`, `Grupo`, `Columnas`, `Minimas`, `Opcion`, `Estatus`, `TDisplay`, `Tituloticket`, `AddTicket`, `Maximas`, `noCombinar`, `reporte`, `textorfila`, `tmc`, `procesoescrute`, `logrosxdefecto`, `ImpreTK`) VALUES
					($ValorJ1, 'Line/Puntos',  $Valor1, $ValorG, 'RUB$Firma|5-carB1$Firma|RUB2$Firma|5-carB$Firma', 1, 'i', 1, '', 'Parlay', 'Ptos $InicTicket', 20, '3|4|5|6|7|8|9|10|11|12|', 'Line/Puntos Completo', '', 80, 3, '-120|-120', 0),
					(".($ValorJ1+1).", 'Alta/Baja', $Valor1, $ValorG, 'AxBS$Firma|5-car1ABS$Firma|ABS$Firma|5-car2ABS$Firma', 1, 'i', 1, '', 'Parlay', 'Al $InicTicket|Ba $InicTicket', 20, '4|5|6|7|8|9|10|11|12|', 'Alta|Baja', 'A|B', 80, 2, '-120|-120', 0),					
					(".($ValorJ1+2).", 'MoneyLine', $Valor1, $ValorG, 'AAB$Firma|BBB$Firma', 1, 'i', 1, '', 'Parlay', 'MoneyLine $InicTicket', 12, '1|4|5|6|7|8|9|10|11|12|13|', 'MoneyLine', '', 80, 3, '', 0);";
					
					$Escrute[0]="Update `_cngescrute` set IDDD_AESC=concat(IDDD_AESC,'|$ValorJ1|".($ValorJ1+1)."|".($ValorJ1+2)."') where IDCNGE=1;";
					$ok=true;
					break;	
			case   'NHL':
				$Grupo="INSERT INTO `_gruposdd` (`Grupo`, `Descripcion`, `Estatus`, `imagen`,escrute) VALUES($ValorG, '$Descripcion', 1, '$img',0);";
				$Formato ="INSERT INTO `_formatosbb` (`Formato`, `Descripcion`, `Grupo`) VALUES ($Valor1, 'Juego Completo', $ValorG);";
				$Apuestas ="INSERT INTO `_tbjuegodd` (`IDDD`, `Descripcion`, `Formato`, `Grupo`, `Columnas`, `Minimas`, `Opcion`, `Estatus`, `TDisplay`, `Tituloticket`, `AddTicket`, `Maximas`, `noCombinar`, `reporte`, `textorfila`, `tmc`, `procesoescrute`, `logrosxdefecto`, `ImpreTK`) VALUES
				($ValorJ1, 'A Ganar', $Valor1, $ValorG, 'AA$Firma|BB$Firma', 1, 'i', 1, '', 'Parlay', 'A Ganar $InicTicket', 8, '3|', 'Logro Jug. Completo', '', 80, 1, '', 0),
				(".($ValorJ1+1).", 'Alta/Baja', $Valor1, $ValorG, 'Ax$Firma|4-car$Firma|B$Firma|4-carB$Firma', 1, 'i', 1, '', 'Parlay', 'Alta $InicTicket|Baja $InicTicket', 8, '', 'Alta/Baja Completo', 'A|B', 80, 2, '', 0),
				(".($ValorJ1+2).", 'PuckLine',  $Valor1, $ValorG, 'RU_1_$Firma|4-carR_1_$Firma|RU_2_$Firma|4-carR_2_$Firma', 1, 'i', 1, '', 'Parlay', 'Pk $InicTicket', 8, '1|', 'Pk ', '', 60, 4, '', 0);";
				
				
				$Escrute[0]="Update `_cngescrute` set IDDD_AESC=concat(IDDD_AESC,'|$ValorJ1|".($ValorJ1+1)."|".($ValorJ1+2)."') where IDCNGE=6;";
				 $ok=true;
				break;
		
	  
	  
	  
  }
  


?>