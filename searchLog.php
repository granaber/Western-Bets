<?
function searhcLG($Grupo, $link)
{
    global $server1;
    global $user1;
    global $clv1, $db1;
    $data = "null";
    $skynet = mysqli_connect($server1, $user1, $clv1);
    mysqli_select_db($skynet, $db1);
    $endpointf = "http://superpoolhipico.com:8910/serviceV2";
    $query3 = <<<'GRAPHQL'
            query logosLegue($lid:Int!){
                logosLegue(lid:$lid)
              }
        GRAPHQL;
    $resultLGO = mysqli_query($GLOBALS['link'], "SELECT * FROM `_tbligasNT`  where Grupo=$Grupo", $GLOBALS['link']);
    if (mysqli_num_rows($resultLGO) != 0) {
        $rowLGO = mysqli_fetch_array($resultLGO);
        $Nam = $rowLGO['nombre'];
        $resultLGO = mysqli_query($GLOBALS['link'], "SELECT * FROM `_tbligasNTnw`  where nombre='" . trim($Nam, " \t\n\r") . "'", $skynet);
        if (mysqli_num_rows($resultLGO) != 0) {
            $rowLGO = mysqli_fetch_array($resultLGO);
            $lid = $rowLGO['lid'];
            $rgraql = graphqlQueryLB($endpointf, $query3, ['lid' => intval($lid)]);
            $data = $rgraql->data->logosLegue;
        }
    }
    return $data;
}
