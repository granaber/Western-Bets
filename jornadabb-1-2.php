<?php
require('prc_php.php');
require_once('dispacht.php');

$GLOBALS['link'] = Connection::getInstance();

$op = $_REQUEST['op'];
$idusu = $_REQUEST['idt'];
switch ($op) {
	case 1:
		$idc = $_REQUEST['idc'];
		$fc = $_REQUEST['fc'];
		$eqs = $_REQUEST['eq'];
		$hrs = $_REQUEST['hr'];
		$cant = $_REQUEST['cant'];
		$part = explode('/', $_REQUEST["lista"]);
		$equiDB = $_REQUEST['equiDB'];
		$p = $_REQUEST['p'];
		$gp = $_REQUEST['gp'];
		$e = $_REQUEST['e'];
		$dp = $_REQUEST['dp'];
		$Liga = $_REQUEST['liga'];
		$IDB = $_REQUEST['IDB'];
		$auto = $_REQUEST['auto'];

		$np = explode('|', $_REQUEST['np']);
		$ep = explode("|", $p);
		$egp = explode("|", $gp);
		$ee = explode("|", $e);
		$eq = explode("|", $eqs);
		$hr = explode("|", $hrs);

		$equiDBA = explode("|", $equiDB);
		$result = mysqli_query($GLOBALS['link'], "Select * from _jornadabb where IDJ=" . $idc . " and Grupo=" . $dp . "  and IDB=$IDB ");
		//echo ("Select * from _jornadabb where IDJ=".$idc." and Grupo=".$dp."  and IDB=$IDB ");
		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "INSERT INTO _jornadabb  VALUES (" . $idc . ",0,0,'" . $fc . "'," . $cant . "," . $dp . ",$IDB,0)");
		//	Logs( $idusu,-3,'Creacion de Logros Deportes'.$dp,1);
		else :
			$result = mysqli_query($GLOBALS['link'], "Update _jornadabb set Partidos=" . $cant . " where  IDJ=" . $idc . " and Grupo=" . $dp . " and IDB=$IDB");
		//	Logs( $idusu,-3,'Actualizacion de Logros Deportes'.$dp,1);
		endif;

		for ($j = 0; $j <= $cant - 1; $j++) {

			$idp = $j + 1;



			/// CREACION DE EQUIPOS NUEVOS ////

			$NewEqu = explode('$', $eq[$j]);
			if (count($NewEqu) == 2) :
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where Descripcion='" . $NewEqu[1] . "' and (Grupo=" . $dp . " or Grupo1=" . $dp . " or Grupo2=" . $dp . ")");
				if (mysqli_num_rows($result) == 0) :
					$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb Order by IDE DESC");
					$row = mysqli_fetch_array($result);
					$nIDE = $row['IDE'] + 1;
					$result = mysqli_query($GLOBALS['link'], "Insert _equiposbb Values ($nIDE,'" . $NewEqu[1] . "','000',$dp,0,0)");
					$result = mysqli_query($GLOBALS['link'], "Insert _tbequixml Values ($nIDE,$Liga,'" . $NewEqu[1] . "')");
					$eq1 = $nIDE;
				else :
					$row = mysqli_fetch_array($result);
					$eq1 = $row['IDE'];
					$result = mysqli_query($GLOBALS['link'], "Insert _tbequixml Values ($eq1,$Liga,'" . $NewEqu[1] . "')");
				endif;
			else :
				$eq1 = $eq[$j];
			endif;



			$NewEqu = explode('$', $eq[$j + $cant]);

			if (count($NewEqu) == 2) :
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where Descripcion='" . $NewEqu[1] . "' and (Grupo=" . $dp . " or Grupo1=" . $dp . " or Grupo2=" . $dp . ")");
				if (mysqli_num_rows($result) == 0) :
					$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb Order by IDE DESC");
					$row = mysqli_fetch_array($result);
					$nIDE = $row['IDE'] + 1;
					$result = mysqli_query($GLOBALS['link'], "Insert _equiposbb Values ($nIDE,'" . $NewEqu[1] . "','000',$dp,0,0)");
					$result = mysqli_query($GLOBALS['link'], "Insert _tbequixml Values ($nIDE,$Liga,'" . $NewEqu[1] . "')");

					$eq2 = $nIDE;
				else :
					$row = mysqli_fetch_array($result);
					$eq2 = $row['IDE'];
					$result = mysqli_query($GLOBALS['link'], "Insert _tbequixml Values ($eq2,$Liga,'" . $NewEqu[1] . "')");
				endif;
			else :
				$eq2 = $eq[$j + $cant];
			endif;
			//////////////////////////////////


			$pep1 = $ep[$j];
			$pep2 = $ep[$j + $cant];

			$egp1 = $egp[$j];
			$egp2 = $egp[$j + $cant];

			$ee1 = $ee[$j];
			$ee2 = $ee[$j + $cant];

			$hrx = $hr[$j];

			$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDP=" . $np[$j] . " and IDJ=" . $idc . " and Grupo=" . $dp);

			//   1|2|3|4|5|6|7|8|9|10|           
			// 0|1|2|3|4|5|6|7|8|9  
			$id1 = $j * 2;
			$id2 = $id1 + 1;

			if (mysqli_num_rows($result2) == 0) :
				$result2 = mysqli_query($GLOBALS['link'], "Insert _partidosbb values (" . $np[$j] . "," . $eq1 . "," . $eq2 . "," . $idc . ",'" . $hrx . "','" . $pep1 . "','" . $pep2 . "','" . $egp1 . "','" . $egp2 . "','" . $ee1 . "','" . $ee2 . "'," . $equiDBA[$id1] . "," . $equiDBA[$id2] . "," . $dp . ",$IDB)");

				$horaticket = Horareal($GLOBALS['minutosh'], "h:i:s A");
				$fechaactual = Fechareal($GLOBALS['minutosh'], "d/n/Y");

				$result3 = mysqli_query($GLOBALS['link'], "Insert _auditoria_logros_ext1 (IDP,IDJ,IDB,Despues,Ahora,Tipo,dat_hour,IDusu,Grupo) values (" . $np[$j] . "," . $idc . "," . $IDB . ",'Nuevo','" . $hrx . "',0,'" . $fechaactual . "-" . $horaticket . "', $idusu,$dp);");
				$result3 = mysqli_query($GLOBALS['link'], "Insert _auditoria_logros_ext1 (IDP,IDJ,IDB,Despues,Ahora,Tipo,dat_hour,IDusu,Grupo) values (" . $np[$j] . "," . $idc . "," . $IDB . ",'Nuevo','" . $eq1 . "',1,'" . $fechaactual . "-" . $horaticket . "', $idusu,$dp);");
				$result3 = mysqli_query($GLOBALS['link'], "Insert _auditoria_logros_ext1 (IDP,IDJ,IDB,Despues,Ahora,Tipo,dat_hour,IDusu,Grupo) values (" . $np[$j] . "," . $idc . "," . $IDB . ",'Nuevo','" . $eq2 . "',2,'" . $fechaactual . "-" . $horaticket . "', $idusu,$dp);");

			else :


				$row = mysqli_fetch_array($result2);
				$comHora = strcmp($row['Hora'], $hrx);
				$comEqui1 = ($eq1 != $row['IDE1'] ? true : false);
				$comEqui2 = ($eq2 != $row['IDE2'] ? true : false);

				$horaticket = Horareal($GLOBALS['minutosh'], "h:i:s A");
				$fechaactual = Fechareal($GLOBALS['minutosh'], "d/n/Y");

				if ($comHora != 0) :
					$result3 = mysqli_query($GLOBALS['link'], "Insert _auditoria_logros_ext1 (IDP,IDJ,IDB,Despues,Ahora,Tipo,dat_hour,IDusu,Grupo) values (" . $np[$j] . "," . $idc . "," . $IDB . ",'" . $row['Hora'] . "','" . $hrx . "',0,'" . $fechaactual . "-" . $horaticket . "', $idusu,$dp);");
				endif;

				if ($comEqui1) :
					$result3 = mysqli_query($GLOBALS['link'], "Insert _auditoria_logros_ext1 (IDP,IDJ,IDB,Despues,Ahora,Tipo,dat_hour,IDusu,Grupo) values (" . $np[$j] . "," . $idc . "," . $IDB . ",'" . $row['IDE1'] . "','" . $eq1 . "',1,'" . $fechaactual . "-" . $horaticket . "', $idusu,$dp);");
				endif;

				if ($comEqui2) :
					$result3 = mysqli_query($GLOBALS['link'], "Insert _auditoria_logros_ext1 (IDP,IDJ,IDB,Despues,Ahora,Tipo,dat_hour,IDusu,Grupo) values (" . $np[$j] . "," . $idc . "," . $IDB . ",'" . $row['IDE2'] . "','" . $eq2 . "',2,'" . $fechaactual . "-" . $horaticket . "', $idusu,$dp);");
				endif;

				$result2 = mysqli_query($GLOBALS['link'], "Update _partidosbb  Set  IDE1=" . $eq1 . ",IDE2=" . $eq2 . ",Hora='" . $hrx . "',PIDE1='" . $pep1 . "',PIDE2='" . $pep2 . "',JGP1='" . $egp1 . "',JGP2='" . $egp2 . "',EFEC1='" . $ee1 . "',EFEC2='" . $ee2 . "',CodEq1=" . $equiDBA[$id1] . ",CodEq2=" . $equiDBA[$id2] . " where IDB=$IDB and IDj=" . $idc . " and IDP=" . $np[$j] . " and Grupo=" . $dp);
			//echo ("Update _partidosbb  Set  IDE1=".$eq1.",IDE2=".$eq2.",Hora='".$hrx."',PIDE1='".$pep1."',PIDE2='".$pep2."',JGP1='".$egp1."',JGP2='".$egp2."',EFEC1='".$ee1."',EFEC2='".$ee2."',CodEq1=".$equiDBA[$id1].",CodEq2=".$equiDBA[$id2]." where IDB=$IDB and IDj=".$idc." and IDP=".$np[$j]." and Grupo=".$dp); 
			endif;
		}

		for ($j = 0; $j <= $cant - 1; $j++) {
			$idp = $j + 1;
			$valores = explode('*', $part[$j]);

			for ($y = 0; $y <= count($valores) - 1; $y++) {
				$subg = explode('[', $valores[$y]);

				$subg_sub = explode('-', $subg[0]);

				$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _configuracionjugadabb where IDB=$IDB and IDP=" . $idp . " and IDJ=" . $idc . " and IDDD=" . $subg_sub[0] . " and Grupo=" . $dp);
				// if ($subg_sub[0] == 8) {
				// 	echo ("SELECT * FROM _configuracionjugadabb where IDB=$IDB and IDP=" . $idp . " and IDJ=" . $idc . " and IDDD=" . $subg_sub[0] . " and Grupo=" . $dp);
				// }


				// <=auto
				$grabar = true;
				if ($auto == 1) :
					$lisAUTO = array();
					$resultnk = mysqli_query($GLOBALS['link'], "Select * from _agendaNT where Grupo=$dp and IDB=$IDB and idj=$idc");
					if (mysqli_num_rows($resultnk) != 0) :
						$rownk = mysqli_fetch_array($resultnk);
						$lisAUTO = explode(',', $rownk['IDDDs']);
					endif;
					$busIDDS = array_search($subg_sub[0], $lisAUTO);
					if ($busIDDS !== false) :
						$grabar = false;
					endif;
				endif;
				// <=auto
				if (mysqli_num_rows($result3) == 0) :
					$result3 = mysqli_query($GLOBALS['link'], "Insert _configuracionjugadabb values (" . $idc . "," . $idp . "," . $subg_sub[0] . ",'" . $subg[1] . "'," . $dp . ",0,$IDB)");
				else :
					if ($grabar) :
						$row = mysqli_fetch_array($result3);
						$s_vle = strcmp($row['Valores'], $subg[1]);
						$vda = $row['actualizado'];

						if ($s_vle != 0) :
							$vda++;
							$resultAudi = mysqli_query($GLOBALS['link'], "SELECT * FROM _auditoria_logros where IDB=$IDB and IDP=" . $idp . " and IDJ=" . $idc . " and IDDD=" . $subg[0] . " and Grupo=" . $dp . " Order by 	ID_Mod Desc ");
							$ID_Mod = 1;
							if (mysqli_num_rows($resultAudi) != 0) :
								$rowAudi = mysqli_fetch_array($resultAudi);
								$ID_Mod = $rowAudi['ID_Mod'] + 1;
							endif;
							$horaticket = Horareal($GLOBALS['minutosh'], "h:i:s A");
							$fechaactual = Fechareal($GLOBALS['minutosh'], "d/n/Y");
							$result3 = mysqli_query($GLOBALS['link'], "Insert _auditoria_logros values (" . $idc . "," . $idp . "," . $subg_sub[0] . ",'" . $row['Valores'] . "','" . $subg[1] . "'," . $dp . ",$IDB,'" . $fechaactual . "-" . $horaticket . "', $idusu,$ID_Mod, 0)");
						//echo ("Insert _auditoria_logros values (".$idc.",".$idp.",".$subg[0].",'".$row['Valores']."',".$dp.",$IDB,'".$fechaactual."-".$horaticket."', $idusu,$ID_Mod,0)" );		
						endif;
						$result3 = mysqli_query($GLOBALS['link'], "Update _configuracionjugadabb  Set  actualizado=" . $vda . ",Valores='" . $subg[1] . "' where IDB=$IDB and IDP=" . $idp . " and IDJ=" . $idc . " and IDDD=" . $subg_sub[0] . " and Grupo=" . $dp . "  and IDB=$IDB ");
					// else :
					// 	// Se actualiza solo el bloqueo en caso de que esta activado el  CaptaLogros Automatico
					// 	$result3 = mysqli_query($GLOBALS['link'], "Update _configuracionjugadabb  Set   where IDB=$IDB and IDP=" . $idp . " and IDJ=" . $idc . " and IDDD=" . $subg_sub[0] . " and Grupo=" . $dp . "  and IDB=$IDB ");
					endif;

				endif;
			}
		}

		dispatch($mode);
		echo json_encode($result3 && $result2);
		break;

	case 2:
		$idc = $_REQUEST['idc'];
		$dp = $_REQUEST['dp'];
		$IDB = $_REQUEST['IDB'];

		$result = mysqli_query($GLOBALS['link'], "Select * from _jornadabb where IDJ=" . $idc . " and Grupo=" . $dp . " and IDB=$IDB");
		if (mysqli_num_rows($result) == 0) :
			$no = 0;
		else :
			$row = mysqli_fetch_array($result);
			$no = $row['Partidos'];
		endif;
		echo json_encode($no);
		break;

	case 3:

		$desde = explode('-', $_REQUEST['desde']);
		$IDJ = $desde[0];
		$IDB = $desde[1];
		$gp = $desde[2];

		$hasta = explode('-', $_REQUEST['hasta']);
		$IDJH = $hasta[0];
		$IDBH = $hasta[1];
		$gpH = $hasta[2];



		$result = mysqli_query($GLOBALS['link'], "Select * from _jornadabb where IDJ=$IDJ and Grupo=$gp  and IDB=$IDB");
		$row = mysqli_fetch_array($result);


		$result3 = mysqli_query($GLOBALS['link'], "Select * from _jornadabb where IDJ=$IDJ and Grupo=$gp  and IDB=$IDBH");
		if (mysqli_num_rows($result3) == 0) :
			$result = mysqli_query($GLOBALS['link'], "INSERT INTO _jornadabb  VALUES ($IDJH,0,0,'" . $row['Fecha'] . "'," . $row['Partidos'] . ",$gpH,$IDBH)");
		else :
			$result = mysqli_query($GLOBALS['link'], "Update _jornadabb set Partidos=" . $row['Partidos'] . " where  IDJ=$IDJH and Grupo=$gpH and IDB=$IDBH");
		endif;


		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _configuracionjugadabb where IDB=$IDB and IDJ=$IDJ and Grupo=$gp Order by IDP");
		//	echo ("SELECT * FROM _configuracionjugadabb where IDB=$IDB and IDJ=$IDJ and Grupo=$gp Order by IDP");
		while ($row = mysqli_fetch_array($result)) {
			$resultSRCH = mysqli_query($GLOBALS['link'], "SELECT * FROM _configuracionjugadabb where IDP=" . $row['IDP'] . " and IDB=$IDBH and IDJ=$IDJH and Grupo=$gpH and IDDD=" . $row['IDDD']);
			if (mysqli_num_rows($resultSRCH) == 0) :
				$result3 = mysqli_query($GLOBALS['link'], "Insert _configuracionjugadabb values ($IDJ," . $row['IDP'] . "," . $row['IDDD'] . ",'" . $row['Valores'] . "',$gpH,0,$IDBH)");
			else :
				$result3 = mysqli_query($GLOBALS['link'], "Update _configuracionjugadabb  Set  actualizado=0,Valores='" . $row['Valores'] . "' where  IDB=$IDBH and IDJ=$IDJH and Grupo=$gpH and IDDD=" . $row['IDDD'] . " and IDP=" . $row['IDP']);
			//	echo ("Update _configuracionjugadabb  Set  actualizado=0,Valores='".$row['Valores']."' where  IDB=$IDBH and IDJ=$IDJH and Grupo=$gpH and IDDD=".$row['IDDD']." and IDP=".$row['IDP']); 
			endif;
			if (!$result3) : break;
			endif;
		}

		echo json_encode($result3);


		break;
}