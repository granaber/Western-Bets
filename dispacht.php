<?
require('graphql.php');

function dispatch($mode)
{
	global $PRODUCCION;
	$endpointf = $mode == $PRODUCCION ? "https://ventas.westernbets.pro:4434/apply" : "http://localhost:8080/apply"; //
	$query3 = <<<'GRAPHQL'
     {
		ListIDPClose{
		  IDP
		  Time
		}
	  }
GRAPHQL;
	$rgraql = graphqlQueryLB($endpointf, $query3, ['lid' => 48]);
	$data = $rgraql->data;
	return $data;
}
