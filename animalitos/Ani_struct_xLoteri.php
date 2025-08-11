<?
require_once('prc_phpDUK.php');

$strucPorcentaje = array();
function StructuData($IDJ, $IDC)
{

    global $link;
    global  $strucPorcentaje;
    $ventas = array();
    $porcen = array();
    $strucPorcentaje = array();
    if (intval($IDJ) !== 0) {
        $resultD = mysqli_query($link, "SELECT * FROM _Jugada_ani  where IDC='$IDC' and IDJ=$IDJ and Activo=1   ORDER BY IDJ");
        while ($Row = mysqli_fetch_array($resultD)) {
            $ventas = thisStructData($Row['Jugada'], $ventas);
        }

        $porcen =  thisPorcentaje($IDC, $ventas);
    }
    return array($ventas, $porcen, getLotteryAll(), $strucPorcentaje);
}

function thisStructData($jugada, $ventas)
{


    $data = unserialize(decoBaseK($jugada));
    foreach ($data as $i => $value) {
        $sorteo = $data[$i]->sorteo;
        $monto = $data[$i]->monto;
        $idl  = getLottey($sorteo);
        $ventas[$idl] = $ventas[$idl] ?? 0;
        $ventas[$idl] += $monto;
    }
    return $ventas;
}
function thisPorcentaje($IDC, $ventas)
{
    global  $strucPorcentaje;
    $porcen = array();
    foreach ($ventas as $idl => $value) {

        $procentaje =  Porcent($IDC, $idl);
        $strucPorcentaje[$idl] = $procentaje;
        $porcen[$idl] = $ventas[$idl] * $procentaje / 100;
    }
    return $porcen;
}

$cacheData = array();

function getLottey($sorteo)
{
    global $link;
    if (isset($cacheData)) {
        return $cacheData[$sorteo];
    }
    $result = mysqli_query($link, "SELECT IDL FROM _Jornada  where ID=$sorteo");
    if (mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_array($result);
        $cacheData[$sorteo] = $row['IDL'];
        return $row['IDL'];
    }
    return -1;
}

function Porcent($IDC, $IDL)
{
    global $link;
    $addtbl = $IDL == 1 ? '' : '_2';
    $whereAdd  = $IDL == 1 ? '' : ' and IDL=' . $IDL;
    $resultD2 = mysqli_query($link, "SELECT * FROM _Concesionario_Ani$addtbl WHERE IDC='" . $IDC . "' $whereAdd");
    if (mysqli_num_rows($resultD2) != 0) {
        $rowD1 = mysqli_fetch_array($resultD2);
        if (isset($rowD1['iPVentas'])) {
            if ($rowD1['iPVentas'] == 0) {
                if ($IDL == 1) {
                    return $rowD1['iPVenta'];
                } else {
                    $resultD2 = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE IDC='" . $IDC . "'");
                    $rowD1 = mysqli_fetch_array($resultD2);
                    return $rowD1['iPVenta'];
                }
            }
            return $rowD1['iPVentas'];
        }
    }

    return 0;
}

$loteris = array();
function  getLotteryAll()
{
    global $link;
    global $loteris;
    if (count($loteris) == 0) {
        $result = mysqli_query($link, "SELECT * FROM _Loterias ");
        while ($row = mysqli_fetch_array($result)) {
            $loteris[$row['IDL']] = $row['Nombre'];
        }
    }
    return $loteris;
}
