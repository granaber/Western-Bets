<?php

global $esseguro;
$pasa = true;
//if ($esseguro): $pasa=true; else: if ($iSecury[3]==="intro.php"): $pasa=true; endif; endif;
if ($pasa) :

	date_default_timezone_set('America/Caracas');
	$GLOBALS['minutosh'] = 0;
	$horasretro = 0;
	$cantidadParlay = 8;

	$server = 'localhost'; //localhost;'zubanca0001.db.5144062.hostedresource.com
	$user = "zubanca_nroot"; //"root";superlog_parlay
	$clv = 'Qi3PMMlMPw*f'; //intra//Gustavo0001\
	$db = "zubanca_parlay"; //"zubanca0001";superlog_parlay


	$server2 = 'parlayenlinea.net'; //localhost;'zubanca0001.db.5144062.hostedresource.com
	$user2 = "parlayen_dhkbk"; //"root";superlog_parlay
	$clv2 = 'G;]^Il^hg?eK'; //intra//Gustavo0001\
	$db2 = "parlayen_dhkbk"; //"zubanca0001";superlog_parlay


	////***** Este Server es que hara la sincronizacion para actulizar en linea las tablas Usuario,Concesionario,Grupo,Logros,Resultados,Publicaciones
	$server3 = '72.55.153.242'; //64.15.156.20
	$user3 = "guille_guiparlay"; //zubanca_nroot
	$clv3 = '}-v&zXMD$F77'; //?ZPKp8c4XX~u
	$db3 = "guille_parlay"; //"zubanca_parlay


	class ServidorTrial
	{
		protected $link;
		private $server3, $username3, $password3, $db3;
		private static $_singleton;

		public static function getInstance()
		{
			if (is_null(self::$_singleton)) {
				self::$_singleton = new ServidorTrial();
			}
			return self::$_singleton;
		}

		public function __construct()
		{
			global $server3;
			global $user3;
			global $clv3;
			global $db3;

			$this->server = $server3; //"sql213.xtreemhost.com";
			$this->username = $user3; //"xth_2440073";sphonlin_cateca
			$this->password = $clv3; //"legna113";ctco%&
			$this->db = $db3; //"xth_2440073_cateca";sphonlin_cateca
			$this->connect();
		}

		private function connect()
		{
			$this->link = mysqli_connect($this->server, $this->username, $this->password);
			mysql_select_db($this->db, $this->link);
		}
	}



	class Servidordual
	{
		protected $link;
		private $server2, $username2, $password2, $db2;
		private static $_singleton;

		public static function getInstance()
		{
			if (is_null(self::$_singleton)) {
				self::$_singleton = new Servidordual();
			}
			return self::$_singleton;
		}

		public function __construct()
		{
			global $server2;
			global $user2;
			global $clv2;
			global $db2;

			$this->server = $server2; //"sql213.xtreemhost.com";
			$this->username = $user2; //"xth_2440073";sphonlin_cateca
			$this->password = $clv2; //"legna113";ctco%&
			$this->db = $db2; //"xth_2440073_cateca";sphonlin_cateca
			$this->connect();
		}

		private function connect()
		{
			$this->link = mysqli_connect($this->server, $this->username, $this->password);
			mysql_select_db($this->db, $this->link);
		}
	}



	class Connection
	{
		protected $link;
		private $server, $username, $password, $db;
		private static $_singleton;



		public static function getInstance()
		{
			if (is_null(self::$_singleton)) {
				self::$_singleton = new Connection();
			}
			return self::$_singleton;
		}

		public function __construct()
		{
			global $server;
			global $user;
			global $clv;
			global $db;

			$this->server = $server; //"sql213.xtreemhost.com";
			$this->username = $user; //"xth_2440073";sphonlin_cateca
			$this->password = $clv; //"legna113";ctco%&
			$this->db = $db; //"xth_2440073_cateca";sphonlin_cateca
			$this->connect();
		}


		private function connect()
		{
			$this->link = mysqli_connect($this->server, $this->username, $this->password);
			mysql_select_db($this->db, $this->link);
		}
	}
else :
	echo 'ACCESO NEGADO/ACCESS DENIED/Zugriff verweigert';
	exit;
endif;
function asignacion($montov, $idc)

{

	$result_d = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd_tb where IDC='" . $idc . "' and " . $montov . " BETWEEN  montodesde and montohasta");



	if (mysqli_num_rows($result_d) != 0) :

		$row_d = mysqli_fetch_array($result_d);

		$pos = strrpos($row_d['aCobrar'], "%");

		if ($pos === false) :

			$mona = $row_d['aCobrar'];

		else :

			$mona = ($montov * intval($row_d['aCobrar'])) / 100;

		endif;

	else :

		$mona = 0;

	endif;





	return $mona;
}









function convertir($valorss, $ndiv, $ilos)
{

	if ($valorss != '') :
		if ($ndiv == false) :
			if (abs($valorss) <= 99) :
				$valordysplay = $valorss;
				$r = fmod($valorss, 1);
			else :
				$valordysplay = $valorss / 10;
				$r = fmod($valorss, 10);
			endif;
		else :
			$valordysplay = $valorss;
			$r = fmod($valorss, 1);
		endif;


		if ($r != 0) :

			if ($valorss < 0) :

				$valordysplay = $valordysplay + .5;

			else :

				$valordysplay = ($valordysplay - .5);

			endif;

			$valordysplay = $valordysplay . chr(189);

		endif;



		$anexo = '';





		if ($valorss > 0) :

			if ($ilos) :

				$anexo = '+';

			else :

				$anexo = ' ';

			endif;

		endif;







		$valordysplay = $anexo . $valordysplay;





		return  $valordysplay;





	else :

		return '';

	endif;
}















function convertirtk($valorss, $ndiv)







{







	if ($valorss != '') :







		if ($ndiv == false) :







			if (abs($valorss) <= 99) :







				$valordysplay = $valorss;







				$r = fmod($valorss, 1);







			else :







				$valordysplay = $valorss / 10;







				$r = fmod($valorss, 10);







			endif;







		else :







			$valordysplay = $valorss;







			$r = fmod($valorss, 1);







		endif;















		if ($r != 0) :







			if ($valorss < 0) :







				$valordysplay = $valordysplay + .5;







			else :







				$valordysplay = ($valordysplay - .5);







			endif;







			$valordysplay = $valordysplay . '.5';







		endif;















		$anexo = '';







		if ($valorss > 0) :







			$anexo = '+';







		endif;















		$valordysplay = $anexo . $valordysplay;















		return  $valordysplay;







	else :







		return '';







	endif;
}







function convertirhora($hor)







{







	if ($hor != '') :







		$fho = explode(':', $hor);







		if ($fho[0] < 12) :







			$ann = 'a';







		endif;















		if ($fho[0] == 12) :







			$ann = 'm';







		endif;















		if ($fho[0] > 12) :







			$ann = 'p';







			$horr = $fho[0] - 12;







		else :







			$horr = $fho[0];







		endif;















		$aa = $horr . ':' . $fho[1] . $ann;























		return $aa;







	else :







		return '';







	endif;
}







function Es_numero($IDDD)







{







	$escrute_v = 0;







	$formato = 0;















	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd");







	while ($row = mysqli_fetch_array($resultj)) {







		// Voy a determinar quien Gano







		if ($row['IDDD'] == $IDDD) : // A Ganar







			$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute ");







			while ($row2 = mysqli_fetch_array($resultj)) {







				$lis_1 = explode('|', $row2['IDDD_AESC']);







				$key = array_search($row['IDDD'], $lis_1);







				if (!($key === false)) :







					$escrute_v = $row2['IDCNGE'];







					$formato = $row2['Formato'];







					break;







				endif;
			}







		endif;
	}







	return array($escrute_v, $formato);
}

function pescrute($serial, $map)
{

	$GLOBALS['link'] = Connection::getInstance();
	$resultjj = mysqli_query($GLOBALS['link'], "SELECT * FROM tbljgdprnk where serial=" . $serial);
	$row2 = mysqli_fetch_array($resultjj);
	$jud = $row2['Jugada'];
	$jgdad = explode('*', $jud);
	//$resul_escrute=unserialize ($row2['escrute']);
	//$resul_proceso=unserialize ($row2['proceso']);


	$resul_proceso1 = array();
	$resul_escrute = array();



	//print_r($jgdad);

	for ($i = 0; $i <= count($jgdad) - 2; $i++) {

		$resul_escrute[$i] = -1;
		$opcion = explode('|', $jgdad[$i]);
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);
		$carr = $opcion1[1];
		$opcion2 = explode('-', $opcion1[0]);
		$equi = $opcion2[0];
		$iddd = $opcion2[1];

		if ($equi != '' && $iddd != '') :
			$v_d_escrute = Es_numero($iddd);
			$escrute_v = $v_d_escrute[0];
			$formato = $v_d_escrute[1];

			$resultj3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDJ=" . $row2['IDJ'] . " and ( IDE1=" . $equi . " or IDE2=" . $equi . ")");



			if (mysqli_num_rows($resultj3) != 0) :
				$row3 = mysqli_fetch_array($resultj3);
				$resultj4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbescrute where IDP=" . $row3['IDP'] . " and IDJ=" . $row2['IDJ'] . ' and Grupo=' . $row3['Grupo']);
				//echo ("SELECT * FROM _tbescrute where IDP=".$row3['IDP']." and IDJ=".$row2['IDJ'].'<br>' );
				if (mysqli_num_rows($resultj4) != 0) :
					$row4 = mysqli_fetch_array($resultj4);

					$resulpubli = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpubliresultados where IDJ=" . $row2['IDJ'] . " and Grupo=" . $row3['Grupo']);
					if (mysqli_num_rows($resulpubli) != 0) :
						$rowPublic = mysqli_fetch_array($resulpubli);

						if ($rowPublic['Publicar'] == 1) :
							$opcion = explode('|', $row4['Escrute']);
							$juegocompleto = 1;
							$key = array_search($escrute_v, $opcion);

							if (!($key === false)) :
								$val1 = explode('-', $opcion[$key + 1]);
								$op1 = $val1[0];
								$op2 = $val1[1];

								//echo $escrute_v.'<br>';

								if ($formato == 3) :
									$juegocompleto = $row4['juegocompleto'];
								else :
									$juegocompleto = 1;
								endif;
								if ($op1 == 'NaN' || $op2 == 'NaN') :
									$juegocompleto = 0; //echo 'a';
								endif;
							endif;

							if (!($key === false)) :

								$resultjtf = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where IDDD=" . trim($iddd));

								/* echo"SELECT * FROM _tbjuegodd where IDDD=".trim($iddd ) ; */

								$row_tf = mysqli_fetch_array($resultjtf);

								if (!($op1 === '!')) :

									switch ($row_tf['procesoescrute']) {

										case 1:/*A Ganar*/


											//if ($juegocompleto==1):

											if ($op1 > $op2) :

												if ($row3['IDE1'] == $equi) :

													$resul_escrute[$i] = 1;

												else :

													$resul_escrute[$i] = 0;

												endif;

											endif;



											if ($op1 < $op2) :

												if ($row3['IDE2'] == $equi) :

													$resul_escrute[$i] = 1;

												else :

													$resul_escrute[$i] = 0;

												endif;

											endif;



											if ($op1 == $op2) :

												$resul_escrute[$i] = 2;

											endif;
											// else:
											//	$resul_escrute[$i]=2;
											// endif;


											break;



										case 2:/*Alta y Baja*/

											if ($juegocompleto == 1) :
												$totaldc = $op1 + $op2;
												//echo $totaldc.'-'.$carr.'<br>';	
												if ($totaldc < $carr) :
													if ($row3['IDE2'] == $equi) :
														$resul_escrute[$i] = 1;
													else :
														$resul_escrute[$i] = 0;
													endif;
												endif;

												if ($totaldc > $carr) :
													if ($row3['IDE1'] == $equi) :
														$resul_escrute[$i] = 1;
													else :
														$resul_escrute[$i] = 0;
													endif;
												endif;

												if ($totaldc == $carr) :
													$resul_escrute[$i] = 2;
												endif;
											else :
												$resul_escrute[$i] = 2;
											endif;

											break;



										case 3:/*RunLine*/

											if ($juegocompleto == 1) :
												$equim = $op1;
												$equih = $op2;
												$equipo1 = $row3['IDE1'];
												$equipo2 = $row3['IDE2'];
												if ($carr < 0) :
													if ($row3['IDE2'] == $equi) :
														$equim = $op2;
														$equih = $op1;
														$equipo1 = $row3['IDE2'];
														$equipo2 = $row3['IDE1'];
													endif;
												else :
													if ($row3['IDE1'] == $equi) :
														$equim = $op2;
														$equih = $op1;
														$equipo1 = $row3['IDE2'];
														$equipo2 = $row3['IDE1'];
													endif;
												endif;
												$totaldc = $equim - $equih;
												$resultado = false;
												if ($totaldc > 0) :
													if ($equipo1 == $equi) :
														if ($totaldc >  abs($carr)) : $resultado = 1;
														endif;
														if ($totaldc == abs($carr)) : $resultado = 2;
														endif;
														if ($totaldc <  abs($carr)) : $resultado = 0;
														endif;
													endif;
													if ($equipo2 == $equi) :
														if ($totaldc <  abs($carr)) : $resultado = 1;
														endif;
														if ($totaldc == abs($carr)) : $resultado = 2;
														endif;
														if ($totaldc >  abs($carr)) : $resultado = 0;
														endif;
													endif;
												endif;
												if ($totaldc < 0) :
													if ($equipo1 == $equi) :
														$resultado = 0;
													endif;
													if ($equipo2 == $equi) :
														$resultado = 1;
													endif;
												endif;





												if ($totaldc == 0) :

													if ($equipo1 == $equi) :

														if ($totaldc >  abs($carr)) : $resultado = 1;
														endif;

														if ($totaldc == abs($carr)) : $resultado = 2;
														endif;

														if ($totaldc <  abs($carr)) : $resultado = 0;
														endif;

													endif;

													if ($equipo2 == $equi) :

														if ($totaldc <  abs($carr)) : $resultado = 1;
														endif;

														if ($totaldc == abs($carr)) : $resultado = 2;
														endif;

														if ($totaldc >  abs($carr)) : $resultado = 0;
														endif;

													endif;

												endif;

												$resul_escrute[$i] = $resultado;

											else :

												$resul_escrute[$i] = 2;

											endif;

											break;



										case 4:/*SI y NO*/

											if ($op1 == 1) :

												if ($row3['IDE1'] == $equi) :

													$resul_escrute[$i] = 1;

												else :

													$resul_escrute[$i] = 0;

												endif;

											endif;

											if ($op2 == 1) :

												if ($row3['IDE2'] == $equi) :

													$resul_escrute[$i] = 1;

												else :

													$resul_escrute[$i] = 0;

												endif;

											endif;

											break;



										case 5:/*A Ganar Sin Empate*/


											if ($juegocompleto == 1) :
												if ($op1 > $op2) :

													if ($row3['IDE1'] == $equi) :

														$resul_escrute[$i] = 1;

													else :

														$resul_escrute[$i] = 0;

													endif;

												endif;



												if ($op1 < $op2) :

													if ($row3['IDE2'] == $equi) :

														$resul_escrute[$i] = 1;

													else :

														$resul_escrute[$i] = 0;

													endif;

												endif;



												if ($op1 == $op2) :

													$resul_escrute[$i] = 0;

												endif;

											else :
												$resul_escrute[$i] = 2;
											endif;

											break;

										case 6:/*Par o Impar*/
											$total = $op1 + $op2;

											if (($total % 2) == 0) :    // Par
												if ($row3['IDE1'] == $equi) :
													$resul_escrute[$i] = 1;
												else :
													$resul_escrute[$i] = 0;
												endif;
											endif;

											if (($total % 2) == 1) :  //Impar
												if ($row3['IDE2'] == $equi) :
													$resul_escrute[$i] = 1;
												else :
													$resul_escrute[$i] = 0;
												endif;
											endif;

											if ($op1 == 0 && $op2 == 0) :
												$resul_escrute[$i] = 2;
											endif;

											break;
									}



								else :

									$resul_escrute[$i] = 2;

								endif;



							//***************************************//		



							endif;

						endif;

					endif;

				endif;

			endif;

		endif;

		if ($resul_escrute[$i] == 0) : break;
		endif;
	}



	//************** Realiza el Nuevo monto a ganar por haber un juego Suspendido ************************/

	$key = array_search(2, $resul_escrute);
	//print_r( $resul_escrute);
	if (!($key === false) || $row2['recalculo'] == 1) :

		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM tbljgdprnk  where serial=" . $serial);

		$row4 = mysqli_fetch_array($result);

		$jud = $row4['Jugada'];

		$jgdad = explode('*', $jud);

		$ap = $row4['ap'];

		$valorini = 0;

		for ($u = 0; $u <= count($jgdad) - 2; $u++) {

			if ($resul_escrute[$u] != 2) :

				$opcion = explode('|', $jgdad[$u]);

				$logro = intval($opcion[1]);

				// ********************  Calculo del Parlay ***********************************

				if ($logro < 0) {

					$valorf = $logro * -1;      // Factor  <0 100/Logro + 1 * Apuesta

					$factor = (100 / $valorf) + 1;

					$ap = ($factor * $ap);

					$valorini = $ap;
				} else {

					$factor = ($logro / 100) + 1; // Factor  >0 Logro/100 + 1 * Apuesta

					$ap = ($factor * $ap);

					$valorini = $ap;
				}

			//*********************************************************************************

			endif;
		}








		if (round($valorini) != $row4['acobrar']) :
			if ($valorini == 0) :
				$valorini = $row4['ap'];
				$result = mysqli_query($GLOBALS['link'], "Update tbljgdprnk set  hc='ANULADO/SISTEMA',activo=2,recalculo=1,acobrar=" . $valorini . " where serial=" . $serial);
			//$resul_escrute[0]=0;
			else :
				if ($row4['hc'] == 'ANULADO/SISTEMA') :
					$result = mysqli_query($GLOBALS['link'], "Update tbljgdprnk set  hc='',activo=1,recalculo=1,acobrar=" . $valorini . " where serial=" . $serial);
				else :
					$result = mysqli_query($GLOBALS['link'], "Update tbljgdprnk set recalculo=1,acobrar=" . $valorini . " where serial=" . $serial);
				endif;
			endif;
		endif;
	else :
		$valorini = $row2['acobrar'];
	endif;

	$result = mysqli_query($GLOBALS['link'], "Update  tbljgdprnk  set  escrute='" . serialize($resul_escrute) . "' where serial=" . $serial);


	if ($map == 1) :

		array_push($resul_escrute, round($valorini));

	endif;



	return ($resul_escrute);
}




function vescruteBytree($serial)
{
	$arr = pescrute($serial, 0);
	$tipo = 3; // El ticket es GANADOR

	$key0 = array_search(0, $arr);
	if (!($key0 === false)) :
		$tipo = 1;  /// Ticket Perdido
	else :
		$key_1 = array_search(-1, $arr);
		if (!($key_1 === false)) : $tipo = 2;
		endif;
	endif; /// Ticket No Hay Escrutes




	return $tipo;
}



function vescrute($serial)
{
	$arr = pescrute($serial, 0);
	$key0 = array_search(0, $arr);
	$key_1 = array_search(-1, $arr);
	return (($key0 === false) && ($key_1 === false));
}
function k1escrute($arr)
{
	$key0 = array_search(0, $arr);
	$key_1 = array_search(-1, $arr);
	return (($key0 === false) && ($key_1 === false));
}
function mescrute($serial)
{
	$arr = pescrute($serial, 1);
	$key0 = array_search(0, $arr);
	$key_1 = array_search(-1, $arr);

	$arr2['condicion'] = (($key0 === false) && ($key_1 === false));
	$arr2['acobrar'] = $arr[count($arr) - 1];

	return ($arr2);
}

function kescrute($arr, $pago)
{
	$key0 = array_search(0, $arr);
	$key_1 = array_search(-1, $arr);

	$arr2['condicion'] = (($key0 === false) && ($key_1 === false));
	$arr2['acobrar'] = $pago;
	return ($arr2);
}













function fecha_dia($fecha)
{
	switch (date('N', str2date($fecha))) {
		case 7:
			$di = 'Dom';
			break;
		case 1:
			$di = 'Lun';
			break;
		case 2:
			$di = 'Mar';
			break;
		case 3:
			$di = 'Mie';
			break;
		case 4:
			$di = 'Jue';
			break;
		case 5:
			$di = 'Vie';
			break;
		case 6:
			$di = 'Sab';
			break;
	}
	return $di;
}











function str2date($in)
{
	$t = split("/", $in);
	if (count($t) != 3) $t = split("-", $in);







	if (count($t) != 3) $t = split(" ", $in);







	if (count($t) != 3) return -1;







	if (!is_numeric($t[0])) return -1;







	if (!is_numeric($t[1])) return -2;







	if (!is_numeric($t[2])) return -3;















	if ($t[2] < 1902 || $t[2] > 2037) return -3;







	return mktime(0, 0, 0, $t[1], $t[0], $t[2]);
}























function resstruc_tick($serial)

{





	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM tbljgdprnk  where serial=" . $serial);

	$row4 = mysqli_fetch_array($result);



	$result7 = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb  where IDJ=" . $row4['IDJ']);

	$row7 = mysqli_fetch_array($result7);



	$jud = $row4['Jugada'];





	$jgdad = explode('*', $jud);



	$Lineaticket = array();





	$Lineaticket[0] = $row4['hora'] . '|' . $row7['Fecha'] . '|' . $row4['ap'] . '|' . $row4['acobrar'] . '|' . $row4['se'];









	for ($u = 0; $u <= count($jgdad) - 2; $u++) {





		$opcion = explode('|', $jgdad[$u]);















		/* 	if ($row4['Grupo']>=2): */







		$logro = $opcion[1];







		$opcion1 = explode('%', $opcion[0]);







		$carr = $opcion1[1];







		$opcion2 = explode('-', $opcion1[0]);







		$equi = $opcion2[0];







		$iddd = $opcion2[1];







		/* 	endif; */















		if ($row4['Grupo'] == 1) :







			$opcion2 = explode(' ', $opcion[1]);







			$opcionv = $opcion2[0];







			$logro = $opcion2[1];







			$opcion2 = explode('-', $opcion[0]);







			$part = $opcion2[0];







			$iddd = $opcion2[1];







		endif;























		/* if ($row4['Grupo']>=2): */


		$result1 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $equi);
		$row1 = mysqli_fetch_array($result1);
		$result2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where (IDE1=" . $equi . " or IDE2=" . $equi . ") and IDJ=" . $row4['IDJ']);
		$row2 = mysqli_fetch_array($result2);
		if ($row2['IDE1'] == $equi) : $code = $row2['CodEq1'];
		endif;
		if ($row2['IDE2'] == $equi) : $code = $row2['CodEq2'];
		endif;
		$result3 = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd Where IDDD=" . $iddd);
		$row3 = mysqli_fetch_array($result3);







		if ($row2['IDE1'] == $equi) :







			$y = 0;







		endif;







		if ($row2['IDE2'] == $equi) :







			$y = 1;







		endif;







		$cln = explode('|', $row3['AddTicket']);







		if (count($cln) == 1) :



			$valoaad = $row3['AddTicket'];



		else :



			$valoaad = $cln[$y];



		endif;







		$Lineaticket[$u + 1] = $u . '|' . convertirhora($row2['Hora']) . '|' . $code . '-' . htmlentities($row1['Descripcion']) . ' ' . convertirtk($carr, true) . ' ' . $valoaad . '|' . convertirtk($logro, false);



		$Lineaticket[$u + 2] = $row4['IDC'];

















		/* 	endif; */















		if ($row4['Grupo'] == 1) :







			$result2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where IDP=" . $equi . " and IDJ=" . $row4['IDJ']);







			$row2 = mysqli_fetch_array($result2);















		endif;
	}







	return ($Lineaticket);
}































function restricciones1($conce, $idj, $equic, $cantidad, $idddc)

{

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd  where idc='" . $conce . "'");

	$arr = array(true, 0, 0);

	if (mysqli_num_rows($result) != 0) :

		$row = mysqli_fetch_array($result);

		if ($row['mma'] != 0) :

			$arr[0] = false;

			$arr[1] = 0;

			$arr[2] = intval($row['mma']);

		endif;

		if ($row['mmjpd'] != 0 && $cantidad == 1) :

			$suma = 0;

			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM tbljgdprnk  where idc='" . $conce . "' and idj=" . $idj . " and activo=1");

			while ($row2 = mysqli_fetch_array($result)) {

				$jud = $row2['Jugada'];

				$jgdad = explode('*', $jud);

				if (count($jgdad) == 2) :

					$opcion = explode('|', $jgdad[0]);

					$logro = $opcion[1];

					$opcion1 = explode('%', $opcion[0]);

					$carr = $opcion1[1];

					$opcion2 = explode('-', $opcion1[0]);

					$equi = $opcion2[0];

					$iddd = $opcion2[1];



					if (intval($equi) == intval($equic) && intval($iddd) == intval($idddc)) :

						$suma += intval($row2['ap']);

					endif;

				endif;
			}

			$arr[0] = false;

			$arr[1] = intval($row['mmjpd']) - $suma;

		else :
			$arr = array(true, 0, 0);
		endif;

	endif;

	return ($arr);
}







function restricciones2($conce, $idj, $lequic, $cantidad, $lidddc, $acobrar, $ap)

{



	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd  where idc='" . $conce . "'");

	$arr = array(true, 0);

	if (mysqli_num_rows($result) != 0) :

		$row = mysqli_fetch_array($result);

		$valuar = true;

		if ($row['mmdp'] != 0) :
			$mmda = $row['mmdp'] * $ap;
			if (($acobrar - $ap) > $mmda) : $valuar = false;
			endif;
		endif;

		if ($row['maxpremio'] != 0) :
			if (($acobrar - $ap) > $row['maxpremio']) : $valuar = false;
			endif;
		endif;

		if ($valuar) :

			if ($row['mmjpp'] != 0 && $cantidad != 1) :

				$suma = 0;

				$equia = explode('|', $lequic);
				array_pop($equia);
				sort($equia);

				$iddda = explode('|', $lidddc);
				array_pop($iddda);
				sort($iddda);

				$equic = array();
				$idddc = array();

				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM tbljgdprnk  where idc='" . $conce . "' and idj=" . $idj . " and activo=1");



				while ($row2 = mysqli_fetch_array($result)) {



					$jud = $row2['Jugada'];

					$jgdad = explode('*', $jud);



					if ((count($jgdad) - 1) == $cantidad) :



						for ($k = 0; $k <= (count($jgdad) - 1); $k++) {

							$opcion = explode('|', $jgdad[$k]);

							$logro = $opcion[1];

							$opcion1 = explode('%', $opcion[0]);

							$carr = $opcion1[1];

							$opcion2 = explode('-', $opcion1[0]);

							$equi = $opcion2[0];

							$iddd = $opcion2[1];

							$equic[$k] = $equi;
							$idddc[$k] = $iddd;
						}



						array_pop($equic);
						sort($equic);

						array_pop($idddc);
						sort($idddc);







						$result1 = array_diff($equia, $equic);

						$result2 = array_diff($iddda, $idddc);





						/* 					 print_r($idddc);print_r($iddda);echo "<br>"; 



 */



						if (count($result1) == 0 && count($result2) == 0) :

							$suma += intval($row2['ap']);

						/*    print_r($equic);print_r($equia);echo "<br>"; */

						endif;

					endif;
				}

				$arr[0] = false;

				$arr[1] = intval($row['mmjpp']) - $suma;

			endif;

		else :

			$arr[0] = true;

			$arr[1] = 'A';

		endif;

	endif;



	return ($arr);
}


function poolescrute($serial)
{
	//|1*6-7-8-9-10-11-0|2*6-7-8-9-10-11-0|3*2-3-4-5-6-7-8-9-10-11-0|4*6-7-8-9-10-11-0|5*1-2-3-4-5-6-0|6*5-6-7-8-9-10-11-0|7*1-2-3-4-5-6-7-8-9-10-11-0|8*1-2-3-4-5-6-7-8-9-10-11-0|9*1-2-3-4-5-6-7-8-9-10-11-0|11*0|12*0|13*0

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugada  where Serial=" . $serial);
	$row = mysqli_fetch_array($result);
	$jud = explode("|", $row['Jugada']);
	$IDCN = $row['IDCN'];
	$IDJug = $row['IDJug'];
	$VR = $row['Valor_R'];
	$VJ = $row['Valor_J'];
	$tanda = $row['carr'];



	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos  where IDjug=" . $IDJug);
	$row = mysqli_fetch_array($result);
	$calculo = $row['calculo'];
	$portanda = $row['Tandas'];
	$cantidadcarr = $row['CantidadCarr'];


	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig  where IDCN=" . $IDCN);
	$row = mysqli_fetch_array($result);
	$config = explode("|", $row["_Jug"]);
	$retirado = explode("|", $row["_Ret"]);
	$canti = explode("|", $row["_Fab"]);
	for ($y = 1; $y <= count($config); $y++) {
		$_tem = explode("*", $config[$y]);
		if ($_tem[0] == $IDJug) {
			$_xc = explode("-", $_tem[1]);
			break;
		}
	}

	$carreras = array();
	$j = 0;
	if ($portanda == 2) :
		$inicio = $cantidadcarr * ($tanda - 1);
	else :
		$inicio = 0;
	endif;

	for ($i = $inicio; $i <= count($_xc) - 1; $i++) {
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _ganadores  where carr=" . $_xc[$i] . " and IDCN=" . $IDCN);

		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$carreras[$j] = $row['ganadores'];
		else :
			$carreras[$j] = '0|0|0|0';
		endif;
		$j++;
	}

	//// |1-2-3-4-5-6-7-8-|2-|5-|4-|5-6-|1-2-4-   
	//// "1|0|0|0|","2|0|0|0|","3|0|0|0|","4|0|0|0|","5|0|0|0|","6|0|0|0|"
	//// Chequear Ganadores
	/// 5|6|6|10|5|6|9|10|5|6|

	$numerop = 1;
	$ganar = array();
	$g = 0;
	$paticipaciones = 0;
	switch ($calculo) {
		case 1:
			for ($i = 1; $i <= count($jud) - 1; $i++) {
				$jugada = explode("-", $jud[$i]);
				$carr = explode("|", $carreras[$i - 1]);
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos_escrute  where IDJug=" . $IDJug . " and NumeroEje=" . $canti[($_xc[$i - 1] - 1)]);
				if (count($jugada) != 1) : array_pop($jugada);
				endif;

				if (mysqli_num_rows($result) != 0) :
					$row = mysqli_fetch_array($result);
					$numerop = $row['NumeroPuesto'];
				else :
					$numerop = 0;
				endif;

				// Retirados
				$retir = explode("-", $retirado[($_xc[$i - 1] - 1)]);
				for ($k = 0; $k <= count($retir) - 1; $k++) {
					do {
						$key = array_search($retir[$k], $jugada);
						if (!($key === false)) :
							if ($jugada[$key] == 14) :
								$jugada[$key] = 1;
							else :
								$jugada[$key]++;
							endif;
						else :
							break;
						endif;
					} while (true);
				}

				//*******************	

				if ($numerop != 0) :
					for ($j = 0; $j <= count($carr) - 1; $j++) {
						$carremp = explode("-", $carr[$j]);
						for ($k = 0; $k <= count($carremp) - 1; $k++) {
							$key = array_search($carremp[$k], $jugada);

							if (!($key === false)) :
								$numerop1 = contarvalor($jugada, $carremp[$k]);
								$ganar[$g] = $ganar[$g] . $carremp[$k] . '*' . $numerop1 . '-';
							/* if ($numerop1>$paticipaciones):
						$paticipaciones=$numerop1;
					endif; */

							else :
								$ganar[$g] = $ganar[$g] . ' ';
							endif;
						}
						if (($j + 1) >= $numerop) : break;
						endif;
					}
				endif;
				if ($ganar[$g] == ' ') : $ganar[$g] = '0';
				endif;
				$g++;
			}
			// Calulo del boleto Bueno/Malo 


			$paticipaciones = calculoparticipaciones($ganar);
			if ($paticipaciones == 1) : $paticipaciones = 0;
			endif;
			if ($VR != 0) :
				$Divi = ($VJ / $VR);
				$BB = INTVAL($Divi);
				if (($Divi - $BB) != 0) :  $BM = 1;
				else :   $BM = 0;
				endif;
				array_unshift($ganar, $BB, $BM, $paticipaciones, $VR, $VJ);
			else :
				array_unshift($ganar, 1, 0, $paticipaciones, $VR, $VJ);
			endif;

			break;

		case 2:
			//|2-5-6-
			//|2-5-6-8-10-
			//|2-5-6-8-9-10-12-
			// |2-3-5-6-8-9-10-11-12-

			for ($i = 1; $i <= count($jud) - 1; $i++) {
				$jugada = explode("-", $jud[$i]);
				$carr = explode("|", $carreras[$tanda - 1]);
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos_escrute  where IDJug=" . $IDJug . " and NumeroEje=" . $canti[($tanda - 1)]);
				if (count($jugada) != 1) : array_pop($jugada);
				endif;

				if (mysqli_num_rows($result) != 0) :
					$row = mysqli_fetch_array($result);
					$numerop = $row['NumeroPuesto'];
				else :
					$numerop = 0;
				endif;

				// Retirados
				$sihay = false;
				$retir = explode("-", $retirado[($tanda - 1)]);
				for ($k = 0; $k <= count($retir) - 1; $k++) {
					do {
						$key = array_search($retir[$k], $jugada);
						if (!($key === false)) :
							$jugada[$key] = '';
							$sihay = true;
						else :
							break;
						endif;
					} while (true);
				}

				if ($sihay) :
					$valor = calularcarra($jud);
				else :
					$valor = -1;
				endif;
				//*******************	

				if ($numerop != 0 && $valor != 0) :
					$carremp = explode("-", $carr[$g]);
					for ($k = 0; $k <= count($carremp) - 1; $k++) {
						$key = array_search($carremp[$k], $jugada);
						//echo $carremp[$k].'_';print_r($jugada);echo '<br>';
						if (!($key === false)) :
							$numerop = contarvalor($jugada, $carremp[$k]);
							$ganar[$g] = $ganar[$g] . $carremp[$k] . '*' . $numerop . '-';
							if ($numerop > $paticipaciones) :
								$paticipaciones = $numerop;
							endif;
						else :
							$ganar[$g] = $ganar[$g] . ' ';
						endif;
						//  if (($j+1)>=$numerop): break; endif;
					}
				else :
					break;
				endif;
				$g++;
			}
			// Calulo del boleto Bueno/Malo
			if ($valor == 0) :
				array_unshift($ganar, 'NULO');
			else :
				$paticipaciones = calculoparticipaciones($ganar);
				if ($paticipaciones == 1) : $paticipaciones = 0;
				endif;
				if ($VR != 0) :
					$Divi = ($VJ / $VR);
					$BB = INTVAL($Divi);
					if (($Divi - $BB) != 0) :  $BM = 1;
					else :   $BM = 0;
					endif;
					array_unshift($ganar, $BB, $BM, $paticipaciones, $VR, $VJ);
				else :
					array_unshift($ganar, 1, 0, $paticipaciones, $VR, $VJ);
				endif;

			endif;
			break;
	}
	return ($ganar);
}


function contarvalor($arr, $valor)
{
	$cuen = 0;

	for ($c = 0; $c <= count($arr) - 1; $c++) {
		if (intval($arr[$c]) == intval($valor)) :
			$cuen++;
		endif;
	}
	return $cuen;
}

function contarenblanco($arr, $desde)
{
	$cuen = 0;
	for ($c = $desde; $c <= count($arr) - 1; $c++) {
		if ($arr[$c] == 0) :
			$cuen++;
		endif;
	}
	return $cuen;
}


function calculodepago($vj, $vr, $pb, $pm, $parti, $divi, $factor)
{
	//calulo del pago
	$pago = 0;
	if ($pb != 0) :
		$pago = $parti * $divi;
	endif;
	if ($pm != 0) :
		$pago += $parti * (($factor * $vj) / $vr);
	endif;
	return $pago;
}


function calularcarra($jug)

{

	switch (count($jug)) {

		case 4:

			$valorm = 0;

			$l1 = explode("-", $jug[1]);

			$l2 = explode("-", $jug[2]);

			$l3 = explode("-", $jug[3]);

			$l4 = explode("-", $jug[4]);



			for ($a = 1; $a <= count($l1) - 1; $a++) {

				for ($b = 1; $b <= count($l2) - 1; $b++) {

					for ($c = 1; $c <= count($l3) - 1; $c++) {

						for ($d = 1; $d <= count($l4) - 1; $d++) {

							if ($l1[$a] != $l2[$b] && $l1[$a] != $l3[$c] && $l1[$a] != $l4[$d]) {

								if ($l2[$b] != $l3[$c] && $l2[$b] != $l4[$d]) {

									if ($l3[$c] != $l4[$d]) {

										$valorm++;
									}
								}
							}
						} //d

					} //c

				} //b

			} //a

			//alert (valorm);

			break;

		case 3:

			$valorm = 0;

			$l1 = explode("-", $jug[1]);

			$l2 = explode("-", $jug[2]);

			$l3 = explode("-", $jug[3]);



			for ($a = 1; $a <= count($l1) - 1; $a++) {

				for ($b = 1; $b <= count($l2) - 1; $b++) {

					for ($c = 1; $c <= count($l3) - 1; $c++) {

						if ($l1[$a] != $l2[$b] && $l1[$a] != $l3[$c] && $l1[$a] != $l4[$d]) {

							if ($l2[$b] != $l3[$c] && $l2[$b] != $l4[$d]) {

								if ($l3[$c] != $l4[$d]) {

									$valorm++;
								}
							}
						}
					} //d

				} //c

			} //b

			break;



		case 2:

			$valorm = 0;

			$l1 = explode("-", $jug[1]);

			$l2 = explode("-", $jug[2]);



			for ($a = 1; $a <= count($l1) - 1; $a++) {

				for ($b = 1; $b <= count($l2) - 1; $b++) {

					if ($l1[$a] != $l2[$b] && $l1[$a] != $l3[$c] && $l1[$a] != $l4[$d]) {

						if ($l2[$b] != $l3[$c] && $l2[$b] != $l4[$d]) {

							if ($l3[$c] != $l4[$d]) {

								$valorm++;
							}
						}
					}
				} //d

			} //c



			break;
	} //switch (parseInt($('carr').title) {



	return $valorm;
}



function participaciones($array, $tp)

{

	$suma = 0;

	for ($c = 0; $c <= count($array) - 1; $c++) {

		$suma += $array[$c][$tp];
	}

	return $suma;
}
function calculoparticipaciones($array)
{
	$part = 1;

	for ($c = 0; $c <= count($array) - 1; $c++) {
		$key = substr_count($array[$c], '*');
		if ($key != 0) :
			$part = $part * $key;
		endif;

		$vepar = explode('-', $array[$c]);

		for ($hv = 0; $hv <= count($vepar) - 2; $hv++) {
			$vepar1 = explode('*', $vepar[$hv]);
			$part = $part * $vepar1[1];
		}
	}
	return $part;
}
function Horareal($minutos, $fm)/*"h:i:s A"*/

{

	$x = date("H i s m d Y", time());

	$fecha = explode(" ", $x);

	$fecha[1] = $fecha[1] + $minutos;

	$fecha2 = date($fm, mktime($fecha[0], $fecha[1], $fecha[2], $fecha[3], $fecha[4], $fecha[5]));

	return $fecha2;
}

function Fechareal($minutos, $formato)

{

	$x = date("H i s m d Y", time());

	$fecha = explode(" ", $x);

	$fecha[1] = $fecha[1] + $minutos;

	$fecha2 = date($formato, mktime($fecha[0], $fecha[1], $fecha[2], $fecha[3], $fecha[4], $fecha[5]));

	return $fecha2;
}



function getip()
{

	if ($_SERVER) {

		if ($_SERVER[HTTP_X_FORWARDED_FOR]) {

			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif ($_SERVER["HTTP_CLIENT_IP"]) {

			$realip = $_SERVER["HTTP_CLIENT_IP"];
		} else {

			$realip = $_SERVER["REMOTE_ADDR"];
		}
	} else {

		if (getenv('HTTP_X_FORWARDED_FOR')) {

			$realip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif (getenv('HTTP_CLIENT_IP')) {

			$realip = getenv('HTTP_CLIENT_IP');
		} else {

			$realip = getenv('REMOTE_ADDR');
		}
	}



	return $realip;
}

function accesolimitado($idu)

{
	if ($idu != '') :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM tbukn  where IDusu=" . $idu);

		if (mysqli_num_rows($result) != 0) :

			$row = mysqli_fetch_array($result);

			return $row['AGrupo'];

		else :

			return 0;

		endif;
	else :
		return 0;
	endif;
}



function Bitacora($texto)

{

	$result = mysqli_query($GLOBALS['link'], "Insert _logs values('" . Horareal(-30, "h:i:s A") . "','" . Fechareal(-30, "d/m/y") . "','" . $texto . "')");
}

function permitemodif($dp, $idj)

{

	$rjuh = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrebb_bloqueo where IDJ=" . $idj . " and Grupo=" . $dp);

	if (mysqli_num_rows($rjuh) == 0) :

		return true;

	else :

		return false;

	endif;
}

function cierresph($idcn, $lc, $brr)
{
	$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig where IDCN=" . $idcn);
	if (mysqli_num_rows($result4) != 0) :
		$reg_nb[0] = -1;
		$f = 1;
		//print_r($lc);
		$row3 = mysqli_fetch_array($result4);
		$config = explode("|", $row3["_Jug"]);
		for ($i = 0; $i <= count($config) - 1; $i++) {
			$_tem = explode("*", $config[$i]);

			if (count($_tem) > 1) :
				$_xc = explode("-", $_tem[1]);

				for ($j = 0; $j <= count($lc) - 1; $j++) {

					if ($lc[$j] == 1) :

						$key = array_search(($j + 1), $_xc);
						if (is_int($key)) :

							//echo "entre--->".($j+1)."**".var_dump(is_int($key))."<br>";

							$resultij = mysqli_query($GLOBALS['link'], "select * from _tdjuegos where  IDJug=" . $_tem[0]);
							$rowij = mysqli_fetch_array($resultij);

							if ($rowij['Tandas'] == 2) :
								$tac = qt(($j + 1), $_xc, $rowij['CantidadCarr']);
							else :
								$tac = ($j + 1);
							endif;


							$resulti = mysqli_query($GLOBALS['link'], "select * from _cierre where IDCN=" . $idcn . " and IDJug=" . $_tem[0] . " and ct=" . $tac);

							if (mysqli_num_rows($resulti) == 0) :
								$resultok = mysqli_query($GLOBALS['link'], "Insert _cierre values (" . $idcn . "," . $_tem[0] . ",'" . Horareal(-30, "H:i:s") . "','" . date("d/m/y") . "'," . $tac . ")");
								$reg_nb[$f] = $i + '-' + $tac;
								$f++;
							endif;

						endif;
					else :
						if ($brr == 1) :
							$key = array_search(($j + 1), $_xc);
							if (is_int($key)) :

								$resultij = mysqli_query($GLOBALS['link'], "select * from _tdjuegos where  IDJug=" . $_tem[0]);
								$rowij = mysqli_fetch_array($resultij);

								if ($rowij['Tandas'] == 2) :
									$tac = qt(($j + 1), $_xc, $rowij['CantidadCarr']);
								else :
									$tac = ($j + 1);
								endif;
								$key = array_search($i + '-' + $tac, $reg_nb);
								if (!is_int($key)) :
									$resulti = mysqli_query($GLOBALS['link'], "Delete from _cierre where IDCN=" . $idcn . " and IDJug=" . $_tem[0] . " and ct=" . $tac);
								endif;
							endif;
						endif;
					endif;
				}
			endif;
		}


	endif;
}

function convertirvtk($valorss, $ndiv, $ilos)
{

	if ($valorss != '') :
		if ($ndiv == false) :
			if (abs($valorss) <= 99) :
				$valordysplay = $valorss;
				$r = fmod($valorss, 1);
			else :
				$valordysplay = $valorss / 10;
				$r = fmod($valorss, 10);
			endif;
		else :
			$valordysplay = $valorss;
			$r = fmod($valorss, 1);
		endif;


		if ($r != 0) :
			if ($valorss < 0) :
				$valordysplay = $valordysplay + .5;
			else :
				$valordysplay = ($valordysplay - .5);
			endif;
			$valordysplay = $valordysplay . '.5';
		endif;

		$anexo = '';

		if ($valorss > 0) :
			if ($ilos) :
				$anexo = '+';
			else :
				$anexo = ' ';
			endif;
		endif;

		$valordysplay = $anexo . $valordysplay;

		return  $valordysplay;

	else :
		return '';
	endif;
}
function recalculoTK($jud, $ap)
{

	$jgdad = explode('*', $jud);
	$valorini = 0;
	for ($u = 0; $u <= count($jgdad) - 2; $u++) {

		$opcion = explode('|', $jgdad[$u]);
		$logro = intval($opcion[1]);
		// ********************  Calculo del Parlay ***********************************
		if ($logro < 0) {
			$valorf = $logro * -1;      // Factor  <0 100/Logro + 1 * Apuesta
			$factor = (100 / $valorf) + 1;
			$ap = ($factor * $ap);
			$valorini = $ap;
		} else {
			$factor = ($logro / 100) + 1; // Factor  >0 Logro/100 + 1 * Apuesta
			$ap = ($factor * $ap);
			$valorini = $ap;
		}
		//*********************************************************************************

	}
	return $valorini;
}



function restricciones3($conce, $idj, $lequic, $cantidad, $lidddc, $acobrar, $ap)
{

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where idc='" . $conce . "'");
	$arr = array(true, 0);

	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$valuar = true;

		/*if ($row['mmdp']!=0):
		$mmda=$row['mmdp']*$ap;
	    if   (($acobrar-$ap)>$mmda): $valuar=false;   endif;
	endif;*/
		$idg = $row['IDG'];
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _trestricionesbb where IDG=" . $row['IDG']);


		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			if ($valuar) :
				if ($row['MxP'] != 0 && $cantidad != 1) :
					$suma = 0;
					$monto = $row['MxP'];
					$equia = explode('|', $lequic);
					array_pop($equia);
					sort($equia);
					$iddda = explode('|', $lidddc);
					array_pop($iddda);
					sort($iddda);
					$equic = array();
					$idddc = array();

					$result = mysqli_query($GLOBALS['link'], "SELECT * FROM tbljgdprnk  where idj=" . $idj . " and activo=1 and IDC in (select IDC from _tconsecionario where IDG=" . $idg . ")");

					while ($row2 = mysqli_fetch_array($result)) {
						$jud = $row2['Jugada'];
						$jgdad = explode('*', $jud);

						if ((count($jgdad) - 1) == $cantidad) :
							for ($k = 0; $k <= (count($jgdad) - 1); $k++) {
								$opcion = explode('|', $jgdad[$k]);
								$logro = $opcion[1];
								$opcion1 = explode('%', $opcion[0]);
								$carr = $opcion1[1];
								$opcion2 = explode('-', $opcion1[0]);
								$equi = $opcion2[0];
								$iddd = $opcion2[1];
								$equic[$k] = $equi;
								$idddc[$k] = $iddd;
							}

							array_pop($equic);
							sort($equic);
							array_pop($idddc);
							sort($idddc);
							$result1 = array_diff($equia, $equic);
							$result2 = array_diff($iddda, $idddc);

							if (count($result1) == 0 && count($result2) == 0) :
								$suma += intval($row2['ap']);
							endif;
						endif;
					}

					$arr[0] = false;
					$arr[1] = intval($monto) - $suma;
				else :
					if ($row['MxD'] != 0 && $cantidad == 1) :
						///////
						$monto = $row['MxD'];
						$suma = 0;
						$result = mysqli_query($GLOBALS['link'], "SELECT * FROM tbljgdprnk  where idj=" . $idj . " and activo=1 and IDC in (select IDC from _tconsecionario where IDG=" . $idg . ")");

						while ($row2 = mysqli_fetch_array($result)) {
							$jud = $row2['Jugada'];
							$jgdad = explode('*', $jud);
							if (count($jgdad) == 2) :
								$opcion = explode('|', $jgdad[0]);
								$logro = $opcion[1];
								$opcion1 = explode('%', $opcion[0]);
								$carr = $opcion1[1];
								$opcion2 = explode('-', $opcion1[0]);
								$equi = $opcion2[0];
								$iddd = $opcion2[1];

								if (intval($equi) == intval($lequic) && intval($iddd) == intval($lidddc)) :
									$suma += intval($row2['ap']);
								endif;
							endif;
						}

						$arr[0] = false;
						$arr[1] = intval($monto) - $suma;
					///////
					endif;
				endif;
			else :
				$arr[0] = true;
				$arr[1] = 'A';
			endif;
		endif;

	endif;


	return ($arr);
}
function decrypt($string, $key)
{
	$result = '';
	$string = base64_decode($string);
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) - ord($keychar));
		$result .= $char;
	}
	return $result;
}
function encrypt($string, $key)
{
	$result = '';
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) + ord($keychar));
		$result .= $char;
	}
	return base64_encode($result);
}

function convertirMilitar($Hora)
{
	$PMAM = explode(" ", $Hora);
	$horaM = explode(":", $PMAM[0]);
	if (strtoupper($PMAM[1]) == 'PM') :
		if (intval($horaM[0]) != 12) :
			$horaM[0] = intval($horaM[0]) + 12;
		endif;
	endif;
	return implode(':', $horaM);
}

function EntreHoras($hora, $horaDesde, $horaHasta)
{
	$horaM = explode(":", $horaDesde);
	$fechaMK = explode("/", '1/1/2009');
	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;
	$fechaDESDE = mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);


	$horaM = explode(":", $horaHasta);
	$fechaMK = explode("/", '1/1/2009');
	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;
	$fechaHASTA =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);


	$horaM = explode(":", $hora);
	$fechaMK = explode("/", '1/1/2009');
	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;
	$fechaACTUAL =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

	$respuesta =	($fechaACTUAL >= $fechaDESDE  and  $fechaACTUAL <= $fechaHASTA);
	return $respuesta;
}
function WhatBancaByUsuario($IDT)
{

	$result = mysqli_query($GLOBALS['link'], "SELECT _tgrupo.IDB FROM `tbukn` , _tgrupo WHERE tbukn.AGrupo = _tgrupo.IDG AND IDusu = $IDT");

	$rowIDC = mysqli_fetch_array($result);

	return $rowIDC['IDB'];
}
function WhatBanca($IDC)
{

	$result = mysqli_query($GLOBALS['link'], "SELECT _tgrupo.IDB FROM `_tconsecionario` , _tgrupo WHERE _tconsecionario.IDG = _tgrupo.IDG AND IDC = '$IDC'");

	$rowIDC = mysqli_fetch_array($result);

	return $rowIDC['IDB'];
}
function WhatGrupo($IDC)
{
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM `_tconsecionario`  WHERE IDC = '$IDC'");
	$rowIDC = mysqli_fetch_array($result);
	return $rowIDC['IDG'];
}

function calculodeMinutos($fecha, $hora1, $hora2)
{
	$horaM = explode(":", $hora1);
	$fechaMK = explode("/", $fecha);
	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;
	$fechaMK1 = mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);


	$horaM = explode(":", $hora2);
	$fechaMK = explode("/", $fecha);
	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;
	$fechaMK2 =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

	$respuesta = $fechaMK2 - $fechaMK1;
	return ($respuesta / 60);
}
function bticket()
{

	$result2 = mysqli_query($GLOBALS['link'], "START TRANSACTION");
	$result2 = mysqli_query($GLOBALS['link'], "SELECT N_x  FROM _conteo Where Modulo='Ticket' FOR UPDATE");
	$result2 = mysqli_query($GLOBALS['link'], "UPDATE _conteo SET N_x = LAST_INSERT_ID(N_x + 1) Where Modulo='Ticket'");
	$result2 = mysqli_query($GLOBALS['link'], "SELECT LAST_INSERT_ID() as N_x;");
	$row2 = mysqli_fetch_array($result2);
	$result2 = mysqli_query($GLOBALS['link'], "COMMIT");

	$tik = $row2["N_x"];

	return $tik;
}

function evaluarLogro($logro)
{
	/*if ($logro>0):
	    
		if (strlen($logro)==3 || strlen($logro)==4 ):
			return true;
		else:	
			
			return false;
		endif;
	else:
		if (strlen($logro)==4 || strlen($logro)==5):
			return true;
		else:	
			return false;
		endif;
	endif;*/

	return true;
}
function escrutesticket($IDJ)
{
	$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbpubliresultados  where IDJ=$IDJ  ");
	if (mysqli_num_rows($result2) != 0) :
		$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbescrute  where IDJ=$IDJ  ");
		if (mysqli_num_rows($result2) != 0) :
			$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM tbljgdprnk  where IDJ=$IDJ  Order By IDJ");
			while ($row2 = mysqli_fetch_array($result2)) {
				////////////////////////////////////////////////////////////////////////////////////////
				$resultOpen = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbcierresemana  where IDJ=" . $row2['IDJ']);
				if (mysqli_num_rows($resultOpen) != 0) :
					$rowOpen = mysqli_fetch_array($resultOpen);
					if ($rowOpen['Cierre'] == 1) :
						if ($row2['escrute'] == '') :
							$cod = pescrute($row2['serial'], 1, false);
						endif;
					else :
						if ($row2['escrute'] == '') :
							$cod = pescrute($row2['serial'], 1, false);
						endif;
					endif;
				else :
					if ($row2['escrute'] == '') :
						$cod = pescrute($row2['serial'], 1, false);
					endif;
				endif;
				////////////////////////////////////////////////////////////////////////////////////////	
			}
		endif;
	endif;
}
function HoraNormal($HoraM)
{
	$fho = explode(':', $HoraM);
	if ($fho[0] < 12) :
		$ann = 'a';
	endif;
	if ($fho[0] == 12) :
		$ann = 'm';
	endif;
	if ($fho[0] > 12) :
		$ann = 'p';
		$horr = $fho[0] - 12;
	else :
		$horr = $fho[0];
	endif;

	return ($horr . ':' . $fho[1] . $ann);
}
function Logs($IDusu, $IDM, $Actividad, $Estatus)
{
	$horaticket = Horareal($GLOBALS['minutosh'], "h:i:s A");
	$fechaactual = Fechareal($GLOBALS['minutosh'], "d/n/Y");
	$ip = getip();
	if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
	endif;

	$resultLogs = mysqli_query($GLOBALS['link'], "Insert _auditoria_accesos (IDusu, IDM, fecha,hora, ip, actividad,estatus) values ($IDusu,$IDM,'" . $fechaactual . "','" . $horaticket . "','$ip','$Actividad',$Estatus)");
}
function SendMail($iemail, $motivo, $texto, $correp)
{
	if ($iemail != '') :
		$header = 'From: noresponder<' . $correp . '>\n';
		$header .= 'MIME-Version: 1.0\n';
		$header .= 'Content-type: text/html; charset=iso-8859-1';
		$msj = $motivo . "\"\n";
		$msj .= $texto . "\"\n";
		$dest = $iemail; //$rowj['email'];//<- Aqui debo colocar el correo que recibira la clave BLI
		$asunto = 'Sistema de Notificaciones SKYNET';
		$ok = @mail($dest, $asunto, $msj, $header);
		return $ok;
	endif;
}
function namerand()
{

	//To Pull 7 Unique Random Values Out Of AlphaNumeric

	//removed number 0, capital o, number 1 and small L
	//Total: keys = 32, elements = 33
	$characters = array(
		"A", "B", "C", "D", "E", "F", "G", "H", "J", "K", "L", "M",
		"N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
		"1", "2", "3", "4", "5", "6", "7", "8", "9"
	);

	//make an "empty container" or array for our keys
	$keys = array();

	//first count of $keys is empty so "1", remaining count is 1-6 = total 7 times
	while (count($keys) < 7) {
		//"0" because we use this to FIND ARRAY KEYS which has a 0 value
		//"-1" because were only concerned of number of keys which is 32 not 33
		//count($characters) = 33
		$x = mt_rand(0, count($characters) - 1);
		if (!in_array($x, $keys)) {
			$keys[] = $x;
		}
	}
	//print_r($characters);
	$random_chars = '';
	foreach ($keys as $key) {
		$random_chars .= $characters[$key];
		//echo $random_chars;echo '<br>';
	}

	return  $random_chars;
}

function decoBase($_decoParam)
{
	// Proceso DECODE param
	$_utxprm = urldecode(base64_decode($_decoParam));
	$_utxprm = explode(',', $_utxprm);
	// print_r($_utxprm);
	for ($i = 0; $i <= count($_utxprm) - 1; $i++) {
		$varibles = explode(':', $_utxprm[$i]);
		$_REQUEST[$varibles[0]] = $varibles[1];
	}
	// Fin Proceso DECODE						   

}
function ecoBase($_ecoParam)
{
	// Proceso DECODE param
	$_utxprm = base64_encode(urlencode($_ecoParam));
	return $_utxprm;
}
function decoBaseNew($_ecoParam)
{
	// Proceso ENCODE param
	$_utxprm = urldecode(base64_decode($_ecoParam));
	return $_utxprm;
}
///////////////////////////////////////////////////  CREDITOS ////////////////////////////////////////////////////
function  cRdSaldo($IDC, $Monto, $IDCN, $Tipo, $Ref)
{
	$queda = array(true, 0);
	$resultij = mysqli_query($GLOBALS['link'], "select * from _tbcrdcredito  where  IDC='$IDC'");
	if (mysqli_num_rows($resultij) != 0) :
		$AuCredito = 0;
		$rowij = mysqli_fetch_array($resultij);
		if ($rowij['saldo'] != 0) : $AuCredito = cRdCredito($IDC);
		endif;

		if ($rowij['saldo'] == 0) : $valorSaldo = $rowij['credito'];
		else :  $valorSaldo = $rowij['saldo'];
		endif;
		if (($valorSaldo + $AuCredito) >= $Monto) :

			if ($rowij['saldo'] == 0) :
				$SaldoN = $rowij['credito'] - $Monto;
			else :
				$SaldoN = $rowij['saldo'] - $Monto;
			endif;
			//echo $rowij['saldo']+$AuCredito;
			$fecha = Fechareal($minutosa, "d/n/Y");
			$hora = Horareal($minutosa, "h:i:s A");
			$ultran = $fecha . '-' . $hora;
			$resultij = mysqli_query($GLOBALS['link'], "Update _tbcrdcredito set saldo=$SaldoN,ultimtrans='$ultran' where  IDC='$IDC'");
			//echo ("Update _tbcrdcredito set saldo=$SaldoN,ultimtrans='$ultran' where  IDC='$IDC'");	
			$resultij = mysqli_query($GLOBALS['link'], "Insert _tbcrdtranss (IDJ,Ref,fechahora,tipo,monto,saldo) values  ($IDCN,'$Ref','$ultran','$Tipo',$Monto,$SaldoN)");
			return $queda;
		else :
			$queda = array(false, $valorSaldo);
			return $queda;
		endif;
	else :
		return $queda;
	endif;
}

function cRdCredito($IDC)
{
	global $minutosa;
	$fecha = Fechareal($minutosa, "d/n/Y");
	$aIDCNr = array();
	$TotalIDCN = array();
	// Buscar Fecha de Hoy///
	$resultCONFI = mysqli_query($GLOBALS['link'], "Select * from _jornadabb  where  	Fecha='" . $fecha . "' order by IDJ");
	while ($rowgrupo = mysqli_fetch_array($resultCONFI)) {
		$resultCONFI2 = mysqli_query($GLOBALS['link'], "Select * from _tbcrdtranss  where IDJ='" . $rowgrupo['IDJ'] . "' and Ref='" . $IDC . "' order by IDJ");
		if (mysqli_num_rows($resultCONFI2) == 0) :
			$aIDCNr[] = $rowgrupo['IDJ'];
			$TotalIDCN[$rowgrupo['IDJ']] = 0;
		endif;
	}
	/////////////////////////
	$totalsuma = 0;
	for ($ir = 0; $ir <= count($aIDCNr) - 1; $ir++) {
		$resultCONFIn2 = mysqli_query($GLOBALS['link'], "Select * from  tbljgdprnk where IDJ=" . $aIDCNr[$ir] . " and IDC='$IDC' and Activo=1");
		while ($rowgrupo2 = mysqli_fetch_array($resultCONFIn2)) {
			$premacion = mescrute($rowgrupo2["serial"]); //EscrutarHI($rowgrupo2["Serial"],1);		
			if ($premacion['condicion']) :
				$totalsuma += $premacion['acobrar'];
			endif;
		}
	}

	$resultCONFI2 = mysqli_query($GLOBALS['link'], "Update _tbcrdcredito set CreditoDiario=$totalsuma where  IDC='$IDC'");
	return  $totalsuma;
}


function cRdCreditoAnt($IDC)
{
	global $minutosa;

	$resultij = mysqli_query($GLOBALS['link'], "select * from _tbcrdcredito  where  IDC='$IDC'");
	if (mysqli_num_rows($resultij) != 0) :
		$rowij = mysqli_fetch_array($resultij);

		if ($rowij['CierreDebi'] != FechaAnt("d/n/Y") && $rowij['nuevo'] != Fechareal($minutosa, "d/n/Y")) :

			$SaldoN = $rowij['saldo'];
			$aIDCNr = array();
			$TotalIDCN = array();
			$FC = explode('-', $rowij['ultimtrans']);
			$FechaUltima = $FC[0];
			// Buscar Fecha de Ayer///
			$resultCONFI = mysqli_query($GLOBALS['link'], "Select IDJ,Fecha from _jornadabb  where Fecha='" . $FechaUltima . "' group by IDJ order by IDJ ");
			while ($rowgrupo = mysqli_fetch_array($resultCONFI)) {
				$resultCONFI2 = mysqli_query($GLOBALS['link'], "Select * from _tbcrdtranss  where IDJ='" . $rowgrupo['IDJ'] . "' and Ref='" . $IDC . "' order by IDJ");
				if (mysqli_num_rows($resultCONFI2) == 0) :
					$aIDCNr[] = $rowgrupo['IDJ'];
					$TotalIDCN[$rowgrupo['IDJ']] = 0;
				endif;
			}
			/////////////////////////

			$totalsuma = 0;

			for ($ir = 0; $ir <= count($aIDCNr) - 1; $ir++) {
				$resultCONFI2 = mysqli_query($GLOBALS['link'], "Select * from tbljgdprnk where 	IDJ=" . $aIDCNr[$ir] . " And IDC='$IDC' and activo=1");
				while ($rowgrupo2 = mysqli_fetch_array($resultCONFI2)) {
					$premacion = mescrute($rowgrupo2["serial"]); //EscrutarHI($rowgrupo2["Serial"],1);		
					if ($premacion['condicion']) :
						$TotalIDCN[$aIDCNr[$ir]] += $premacion['acobrar'];
						$totalsuma += $premacion['acobrar'];
					endif;
				}
			}

			$fecha = FechaAnt("d/n/Y");
			$hora = Horareal($minutosa, "h:i:s A");
			$ultran = $fecha . '-' . $hora;
			$Tipo = 'C';
			$resultij = true;
			mysqli_query($GLOBALS['link'], "begin");
			///////////////////////////////////// DEBO INCLUIR EN TRANSACCIONES /////////////////////////////
			$SaldoNv = $SaldoN;
			foreach ($TotalIDCN as $KeyN2 => $Valor) {
				$SaldoNv += $Valor;
				$resultij = mysqli_query($GLOBALS['link'], "Insert _tbcrdtranss (IDJ,Ref,fechahora,tipo,monto,saldo) values  ($KeyN2,'$IDC','$ultran','$Tipo',$Valor,$SaldoNv)");
				if (!$resultij) : exit;
				endif;
			}

			if (!$resultij) :
				mysqli_query($GLOBALS['link'], "rollback");
			else :
				mysqli_query($GLOBALS['link'], "commit");
				$SaldoN += $totalsuma;
				$resultij = mysqli_query($GLOBALS['link'], "Update _tbcrdcredito set saldo=$SaldoN,ultimtrans='$ultran',CierreDebi='" . $FechaUltima . "',CreditoDiario=0 where  IDC='$IDC'");
			endif;



		//////////////////////////////////////////////////////////////////////////////////////////////////
		endif;
	endif;
	return true;
}
function FechaAnt($formato)
{
	$x = date("H i s m d Y", time());
	$fecha = explode(" ", $x);
	$fecha[4] = $fecha[4] - 1;
	$fecha2 = date($formato, mktime($fecha[0], $fecha[1], $fecha[2], $fecha[3], $fecha[4], $fecha[5]));
	return $fecha2;
}
function dSpe($vlor, $pro)
{
	$ecua = false;


	$varl = $vlor;
	$es = '';
	if ($pro == 8) :
		$pos = strpos($varl, 'o');
		if (!($pos === false)) $es = 'o';
		$pos = strpos($varl, 'u');
		if (!($pos === false)) $es = 'u';
	endif;
	///// con signo adelante y compuesto /////
	$signo = strpos($varl, '-');
	$slas = strpos($varl, '/');
	$cuentsig = substr_count($varl, '-');
	if ($signo == 0 && strlen($varl) > 6 && $slas > 0) :
		$vl = explode('/', $varl);
		$ecua = true;
		$vl[] = 1;
	endif;
	if ($signo > 0 && strlen($varl) > 6 && $slas == 0) :
		$vl = explode('-', $varl);
		if ($pro != 4) $vl[1] = '-' . $vl[1];
		$ecua = true;
		$vl[] = 2;
	endif;

	if ($signo > 0 && strlen($varl) >= 5 && $slas == 0) :
		$vl = explode('-', $varl);
		// if ($pro!=4)
		$vl[1] = '-' . $vl[1];
		$ecua = true;
		$vl[] = 2;
	endif;
	if (strlen($varl) >= 5 && $slas == 0 && $cuentsig == 2) :
		$vl = explode('-', $varl);
		$vl[0] = '-' . $vl[1];
		$vl[1] = $vl[2];
		$vl[1] = '-' . $vl[1];
		$ecua = true;
		$vl[2] = 2;
	endif;

	$mas = strpos($varl, '+');
	$cuentsig = substr_count($varl, '+');
	if ($signo == 0 && strlen($varl) >= 5 && $slas == 0 && $mas > 0) :
		$vl = explode('+', $varl);
		$vl[1] = '+' . $vl[1];
		$ecua = true;
		$vl[] = 2;
	endif;


	if ($signo == 0 && strlen($varl) > 6 && $slas == 0 && $mas > 0) :
		$vl = explode('+', $varl);
		$vl[1] = '+' . $vl[1];
		$ecua = true;
		$vl[] = 2;
	endif;

	if ($signo == 0 && strlen($varl) >= 5 && $slas == 0 && $cuentsig == 2) :
		$vl = explode('+', $varl);
		$vl[0] = '+' . $vl[1];
		$vl[1] = $vl[2];
		$vl[2] = 2;
		$vl[1] = '+' . $vl[1];
		$ecua = true;
	endif;

	$letra = strpos($varl, 'o');
	if ($letra > 0) :
		$vl = explode('o', $varl);
		$ecua = true;
		$vl[] = 2;
	endif;
	$letra = strpos($varl, 'u');
	if ($letra > 0) :
		$vl = explode('u', $varl);
		$ecua = true;
		$vl[] = 2;
	endif;

	//if ($pro==7): if ($vl[2]==1):

	if ($ecua) : if ($vl[0] == 'pk') $vl[0] = 0;
		$vl[] = $es;
		return ($vl);
	else : return array($varl, 0, 0, $es);
	endif;
}

function Detect($valores)
{
	if ($valores < 0) $valores = $valores * -1;

	if (strlen($valores) >= 4) :
		$tipo = 1;
	else :
		if ($valores > 100) $tipo = 1;
		else $tipo = 0;
	endif;

	return $tipo;
}
function redonl($vlor)
{
	$decil = explode('.', $vlor);
	if (count($decil) == 2) :
		if ($decil[1] != 5) :
			if ($decil[1] < 5) :
				$vf = $decil[0];
			else :
				if ($decil[0] < 0) $vf = $decil[0] - 1;
				else $vf = $decil[0] + 1;
			endif;
		else :
			$vf = $vlor;
		endif;

	else :
		$vf = $vlor;
	endif;
	return $vf;
}
function DBconver($idCnv, $LogroM, $modo, $macho, $eAB, $TablaxLogro)
{
	//echo $idCnv.'*'.$TablaxLogro.'*'.$eAB;
	if ($TablaxLogro == 0) :
		if ($eAB) :
			$CampoM = 'AMacho';
			$CampoH = 'BHembra';
		else :
			switch ($idCnv) {
				case  1:
					$CampoM = 'A20M';
					$CampoH = 'A20H';
					break;
				case  2:
					$CampoM = 'A30M';
					$CampoH = 'A30H';
					break;
				case  3:
					$CampoM = 'A40M';
					$CampoH = 'A40H';
					break;
				case  4:
					$CampoM = 'AMacho';
					$CampoH = 'BHembra';
					break;
				case  5:
					$CampoM = 'ApreMedM';
					$CampoH = 'ApreMedH';
					break;
				case  6:
					$CampoM = 'ApreUnM';
					$CampoH = 'ApreUnH';
					break;
				case  7:
					$CampoM = 'ApreUnMedM';
					$CampoH = 'ApreUnMedH';
					break;
				case  8:
					$CampoM = 'MoneyLM';
					$CampoH = 'MoneyLH';
					break;
				case  9:
					$CampoM = 'Logro5inM';
					$CampoH = 'Logro5inH';
					break;
			}
		endif;
	else :
		$idCnv = $TablaxLogro;
		switch ($idCnv) {
			case  1:
				$CampoM = 'A20M';
				$CampoH = 'A20H';
				break;
			case  2:
				$CampoM = 'A30M';
				$CampoH = 'A30H';
				break;
			case  3:
				$CampoM = 'A40M';
				$CampoH = 'A40H';
				break;
			case  4:
				$CampoM = 'AMacho';
				$CampoH = 'BHembra';
				break;
			case  5:
				$CampoM = 'ApreMedM';
				$CampoH = 'ApreMedH';
				break;
			case  6:
				$CampoM = 'ApreUnM';
				$CampoH = 'ApreUnH';
				break;
			case  7:
				$CampoM = 'ApreUnMedM';
				$CampoH = 'ApreUnMedH';
				break;
			case  8:
				$CampoM = 'MoneyLM';
				$CampoH = 'MoneyLH';
				break;
			case  9:
				$CampoM = 'Logro5inM';
				$CampoH = 'Logro5inH';
				break;

				/*case  2:
			$CampoM='A30M';$CampoH='A30H';break;	
		case  3:
			$CampoM='A40M';$CampoH='A40H';break;*/
		}
	endif;
	//echo $CampoM.'_'.$CampoH;
	$LogroM = round($LogroM);
	//	echo ("SELECT *  FROM _DBconver  where BaseM=$LogroM  " ); echo '*'.$modo.'*';echo '*'.$macho.'*';
	$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _DBconver  where BaseM=$LogroM  ");
	if (mysqli_num_rows($result2) != 0) :
		$rowOpen = mysqli_fetch_array($result2);
		if ($modo == 3) :
			if ($macho == 1) :
				$NewLogro = array($rowOpen[$CampoH], $rowOpen[$CampoM]);
			else :
				$NewLogro = array($rowOpen[$CampoM], $rowOpen[$CampoH]);
			endif;
		else :
			if ($macho == 2) :
				$NewLogro = array($rowOpen[$CampoH], 0, $rowOpen[$CampoM], 0);
			else :
				$NewLogro = array($rowOpen[$CampoM], 0, $rowOpen[$CampoH], 0);
			endif;
		//  print_r($NewLogro);
		endif;
	else :
		$NewLogro = array($LogroM, $LogroH);
	endif;
	//print_r($NewLogro);
	return $NewLogro;
}
function moda($tuArray)
{
	$cuenta = array_count_values($tuArray);
	arsort($cuenta);
	return key($cuenta);
}
