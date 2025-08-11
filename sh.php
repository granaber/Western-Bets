<?
date_default_timezone_set('America/Caracas');
require('prc_php_skynet.php');
$GLOBALS['link'] = Connection::getInstance();
$fechab = date("Y-m-d");
$fechaactual = date("Ymd");
$token = 'qQI07q8ix1y5mc!_';
//echo $fechab;
$horamenos = 4;
$minutosmenos = 30;
$ok = false;

$niveldeCaptura = 1;
$result = mysqli_query($GLOBALS['link'], "Select * From _tbjornadaDB  where fechaDB='$fechab'");
if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	$ids = $row['ids'];
	$niveldeCaptura = 2;
else :
	$result = mysqli_query($GLOBALS['link'], "Select * From _tbjornadaDB ORDER BY ids DESC");
	if (mysqli_num_rows($result) == 0) :
		$ids = 1;
	else :
		$row = mysqli_fetch_array($result);
		$ids = $row['ids'] + 1;
	endif;
	$result = mysqli_query($GLOBALS['link'], "Insert _tbjornadaDB Values ($ids,'$fechr','$fechab')");
endif;

$xml = simplexml_load_file('http://xml.donbest.com/v2/schedule/?token=' . $token);
$s = simplexml_import_dom($xml);

//echo $s->date;

if (($s->date) == date("Ymd")) :
	for ($sp = 0;; $sp++) {
		if (isset($s->schedule->sport[$sp])) :
			$evento = $s->schedule->sport[$sp];

			//print_r($evento);

			for ($g = 0;; $g++) {

				if (isset($evento->league[$g])) :

					//print_r($evento->league[$g]->lines);
					//print_r($evento->league[$g]->lines->current);echo '<br>';
					// ids,liga,name,link
					$linkodds = $evento->league[$g]->lines->current['link'];
					$liga = $evento->league[$g]['id'];
					$nombre = $evento->league[$g]['name'];
					$result = mysqli_query($GLOBALS['link'], "Select * From _tbligaDB  where  	ids=$ids and liga=$liga");
					if (mysqli_num_rows($result) == 0) :
						$result = mysqli_query($GLOBALS['link'], "Insert _tbligaDB Values ($ids,$liga,'$nombre','$linkodds')");
					else :
						$row = mysqli_fetch_array($result);
						$liga = $row['liga'];
					endif;


					$hay = false;
					for ($i = 0;; $i++) {
						if (isset($evento->league[$g]->group[$i])) :

							$league = $evento->league[$g]->group[$i]; //print_r($league);echo '<br>';
							for ($j = 0;; $j++) {
								//print_r($league->event[$j]);echo '<br>';
								if (isset($league->event[$j])) :
									// print_r($league->event[$j]);	echo $league->event[$j]['season'];  echo $league->event[$j]->participant[1]->team['id'];  echo '<br>';echo '<br>';
									$fecha = explode('T', $league->event[$j]['date']);

									$rfecha = explode('-', $fecha[0]);
									$rhora = explode(":", $fecha[1]);

									$fechareal = date("c", mktime($rhora[0] - $horamenos, $rhora[1] - $minutosmenos, $rhora[2], $rfecha[1], $rfecha[2], $rfecha[0]));

									$fecha = explode('T', $fechareal);

									//print_r($league->event[$j]);	
									if (($league->event[$j]['season'] == 'REGULAR') && $fecha[0] == $fechab) :
										if (isset($league->event[$j]->participant[0]->team['name']) &&  isset($league->event[$j]->participant[0]->pitcher)) :
											$id   = $league->event[$j]['id'];


											$hora = explode('T', $league->event[$j]['date']);
											$rfecha = explode('-', $hora[0]);
											$rhora = explode(":", $hora[1]);
											$fechareal = date("c", mktime($rhora[0] - $horamenos, $rhora[1] - $minutosmenos, $rhora[2], $rfecha[1], $rfecha[2], $rfecha[0]));
											$hora = explode('T', $fechareal);

											$eqp1 = $league->event[$j]->participant[0]->team['name'];
											$eqp2 = $league->event[$j]->participant[1]->team['name'];
											$picher1 = $league->event[$j]->participant[0]->pitcher;
											$picher2 = $league->event[$j]->participant[1]->pitcher;
											$hay = true;
											//   ids,id,hora,equipo1,equipo2,liga,picher1,picher2
											$result = mysqli_query($GLOBALS['link'], "Select * From _tbequiposDB  where  	ids=$ids and id=$id");
											if (mysqli_num_rows($result) == 0) :
												$result = mysqli_query($GLOBALS['link'], "Insert _tbequiposDB Values ($ids,$id,'" . $hora[1] . "','$eqp1','$eqp2',$liga,'$picher1','$picher2')");
												if ($result) : $ok = true;
												else : $ok = false;
												endif;
											endif;
										endif;
									endif;
								else :
									break;
								endif;
							}
						else :
							break;
						endif;
					}

				else :
					if ($hay) :
						include "indexdb.php";
					//echo $linkodds.'<br>';
					endif;
					break;
				endif;
			}
		else :
			break;
		endif;
	}
endif;

echo json_encode($ok);

function rndlogro($nlogro)
{

	$cadena = strval($nlogro);
	$arr1 = str_split($cadena);

	$ultimo = intval($arr1[strlen($cadena) - 1]);

	if ($ultimo > 0 && 	$ultimo <= 5) :
		$arr1[strlen($cadena) - 1] = 5;
	else :
		if ($ultimo != 0) :
			$arr1[strlen($cadena) - 1] = 0;
			if (intval($arr1[strlen($cadena) - 2]) == 9) :
				if (intval($arr1[0]) < 0) :
					$arr1[0] = intval($arr1[0]) - 1;
				else :
					$arr1[0] = intval($arr1[0]) + 1;
				endif;

				$arr1[1] = 0;
			else :
				$arr1[strlen($cadena) - 2] = intval($arr1[strlen($cadena) - 2]) + 1;
			endif;
		endif;
	endif;

	return implode('', $arr1);
}
function iconver($nlogro)
{
	$cadena = strval($nlogro);
	$arr1 = str_split($cadena);

	return implode('', $arr1);
}
