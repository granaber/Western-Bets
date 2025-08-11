<?php
require 'vendor/autoload.php';

use EUAutomation\GraphQL\Client;

function graphqlQUY($endPoint, $query, $variables)
{

	$clientqp = new Client($endPoint);
	$response = $clientqp->json($query, $variables);
	$data = $response->data;

	return $data;
}

function graphqlQuery($endPoint, $query, $variables)
{

	$clientqp = new Client($endPoint);
	$response = $clientqp->json($query, $variables);
	$data = $response->data->tblogrosNT;

	return $data;
}

function graphqlQueryLB($endPoint, $query, $variables)
{

	$clientqp = new Client($endPoint);
	$response = $clientqp->json($query, $variables);

	return $response;
}


function posOdds($texto, $tpi)
{
	//// Primero Busco Cuartos 1Q, 2Q, 3Q, 4Q
	$pos = strpos($texto, '1Q');
	if (!($pos === false)) if ($tpi == 1) return 14;
	else return 4;
	$pos = strpos($texto, '2Q');
	if (!($pos === false)) if ($tpi == 1) return 15;
	else  return 5;
	$pos = strpos($texto, '3Q');
	if (!($pos === false))  if ($tpi == 1) return 16;
	else  return 6;
	$pos = strpos($texto, '4Q');
	if (!($pos === false))  if ($tpi == 1) return 17;
	else  return 7;
	// Busco primera mitad con 1 o 5
	$pos = strpos($texto, '1');
	if (!($pos === false))  if ($tpi == 1) return 11;
	else  return 1;
	$pos = strpos($texto, '5');
	if (!($pos === false))   if ($tpi == 1) return 11;
	else  return 1;
	// Busco seguna mitad con 2
	$pos = strpos($texto, '2');
	if (!($pos === false))  if ($tpi == 1) return 12;
	else return 2;

	return false;
}

function evalOdds($aOdds)
{
	$resp = true;
	for ($x = 0; $x <= count($aOdds) - 1; $x++) {
		if ($aOdds[$x] == '') {
			$resp = false;
			break;
		}
	}
	return $resp;
}

function searhcLG($Grupo, $link, $skynet2)
{
	$data = "null";

	$endpointf = "http://superpoolhipico.com:8910/serviceV2";
	$query3 = <<<'GRAPHQL'
query logosLegue($lid:Int!){
	logosLegue(lid:$lid)
}
GRAPHQL;
	// echo "SELECT * FROM `_tbligasNT`  where Grupo=$Grupo";
	$resultLGO = mysqli_query($link, "SELECT * FROM `_tbligasNT`  where Grupo=$Grupo");
	if (mysqli_num_rows($resultLGO) != 0) {
		$rowLGO = mysqli_fetch_array($resultLGO);
		$Nam = $rowLGO['nombre'];
		$resultLGO2 = mysqli_query($skynet2, "SELECT * FROM _tbligasNTnw where nombre='" . trim($Nam, " \t\n\r") . "'");
		if (mysqli_num_rows($resultLGO2) != 0) {
			$rowLGO2 = mysqli_fetch_array($resultLGO2);
			$lid = $rowLGO2['lid'];
			$rgraql = graphqlQueryLB($endpointf, $query3, ['lid' => intval($lid)]);
			$data = $rgraql->data->logosLegue;
		}
	}
	return $data;
}
