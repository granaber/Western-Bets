<?
$tuArray=array(strval(6.5),strval(6.5),'6.5','6','6.5');
echo moda($tuArray);

function moda($tuArray){
$cuenta = array_count_values($tuArray);
    arsort($cuenta);
    return key($cuenta);
}

?>