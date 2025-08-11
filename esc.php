<?
///////////////////////////
$serverCA = '159.65.224.175';
$userCA = "parlayen_skynet";
$clvCA = 'tiqkSlT8y-!3';
$dbCA = "parlayen_skynet";
////////////////////////////
$server = '159.65.224.175'; //localhost;
$user = "plinea_root"; //"root";
$clv = '8I#q}*7sGWC]'; //intra//
$db = "plinea_parlayenlinea"; //




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
	$resultjj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb where serial=" . $serial);
	if (mysqli_num_rows($resultjj) != 0) :
		$row2 = mysqli_fetch_array($resultjj);
		$jud = $row2['Jugada'];
		$jgdad = explode('*', $jud);
		//$resul_escrute=unserialize ($row2['escrute']);
		//$resul_proceso=unserialize ($row2['proceso']);


		$resul_proceso1 = array();
		$resul_escrute = array();



		print_r($jgdad);

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

				$resultjtf = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where IDDD=" . trim($iddd));
				$row_tf = mysqli_fetch_array($resultjtf);

				$resultj3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where grupo=" . $row_tf['Grupo'] . " and IDJ=" . $row2['IDJ'] . " and ( IDE1=" . $equi . " or IDE2=" . $equi . ")");

				echo ("SELECT * FROM _partidosbb where grupo=" . $row_tf['Grupo'] . " and IDJ=" . $row2['IDJ'] . " and ( IDE1=" . $equi . " or IDE2=" . $equi . ")");

				if (mysqli_num_rows($resultj3) != 0) :
					$row3 = mysqli_fetch_array($resultj3);
					$resultj4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbescrute where IDP=" . $row3['IDP'] . " and IDJ=" . $row2['IDJ'] . ' and Grupo=' . $row3['Grupo']);
					echo ("SELECT * FROM _tbescrute where IDP=" . $row3['IDP'] . " and IDJ=" . $row2['IDJ'] . ' and Grupo=' . $row3['Grupo']);

					//echo ("SELECT * FROM _tbescrute where IDP=".$row3['IDP']." and IDJ=".$row2['IDJ'].'<br>' );
					if (mysqli_num_rows($resultj4) != 0) :
						$row4 = mysqli_fetch_array($resultj4);

						$resulpubli = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpubliresultados where IDJ=" . $row2['IDJ'] . " and Grupo=" . $row3['Grupo']);
						echo ("SELECT * FROM _tbpubliresultados where IDJ=" . $row2['IDJ'] . " and Grupo=" . $row3['Grupo']);
						echo '<br>';
						//   echo ("SELECT * FROM _tbpubliresultados where IDJ=".$row2['IDJ']." and Grupo=".$row3['Grupo'] );
						if (true) :
							// echo '1';
							$rowPublic = mysqli_fetch_array($resulpubli);

							if (true) :

								$opcion = explode('|', $row4['Escrute']);

								print_r($opcion);
								echo '<br>' . $escrute_v . '<br>';
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



									if (!($op1 === '!')) :

										switch ($row_tf['procesoescrute']) {

											case 1:/*A Ganar*/
												echo $op1 . '-' . $op2 . '<br>';
												echo $row3['IDE1'] . '-' . $equi . '<br>';
												echo $row3['IDE2'] . '-' . $equi . '<br>';
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

		if (!($key === false) || $row2['recalculo'] == 1) :

			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb  where serial=" . $serial);

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
				endif;
				if ($row4['acobrar'] == $row4['ap']) :
					$result = mysqli_query($GLOBALS['link'], "Update _tjugadabb set  hc='ANULADO/SISTEMA',activo=2,recalculo=1,acobrar=" . $valorini . " where serial=" . $serial);
					$resul_escrute[0] = 0;
				else :
					$result = mysqli_query($GLOBALS['link'], "Update _tjugadabb set  recalculo=1,acobrar=" . $valorini . " where serial=" . $serial);
				endif;
			endif;
		else :
			$valorini = $row2['acobrar'];
		endif;

		$result = mysqli_query($GLOBALS['link'], "Update  _tjugadabb  set  escrute='" . serialize($resul_escrute) . "' where serial=" . $serial);


		if ($map == 1) :

			array_push($resul_escrute, round($valorini));

		endif;

	else :
		$resul_escrute[0] = 'NE';
	endif;
	print_r($resul_escrute);

	return ($resul_escrute);
}


pescrute($_REQUEST['serial'], 1);
