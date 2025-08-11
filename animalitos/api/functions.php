<?
require_once('../prc_phpDUK.php');
require_once('../func_grabar_animalitos.php');
require_once('../function_check_is_active.php');

$link = ConnectionAnimalitos::getInstance();

function getSorteo($IDL, $usu)
{
    global $link;
    $IDJ = _FechaDUK();

    $cierre = _check_cierre_sorteo($usu);
    $Sorteos = [];
    if (count($cierre) == 0) :
        $add = '';
    else :
        if ($cierre[0] == false) :
            return json_encode($Sorteos);
        else :
            $add = '  and not _Jornada.ID  in (' . implode(",", $cierre) . ')';
        endif;
    endif;
    $sql = "Select *,_JornadaStandar.Descripcion from _Jornada,_JornadaStandar where _JornadaStandar.Hora=_Jornada.`HoraCierre` and _JornadaStandar.IDL=_Jornada.IDL and Activa=1 and IDJ=" . $IDJ . $add . "  and _Jornada.IDL=$IDL order by HoraCierre ASC";
    $resultj2 = mysqli_query($link, $sql);
    while ($Row2 = mysqli_fetch_array($resultj2)) {
        $Sorteos[] = array("id" => intval($Row2['ID']),  "hora" => $Row2['Descripcion'],);
    }

    return json_encode($Sorteos);
}
function getLotterias($usu)
{
    global $link;

    $ListaA = array();
    $ListaB = array();
    $Color = [];
    $BgColor = [];

    $IDJ = _FechaDUK();
    $DataAnimals = [];

    $resultj = mysqli_query($link, "SELECT * FROM _Loterias  Where Activa=1 order by Ord");
    while ($row = mysqli_fetch_array($resultj)) {
        $ListaA[] = $row['IDL'];
        $ListaB[] = $row['Nombre'];
        $Color[] = $row['colors'];
        $BgColor[] = $row['bg'];

        $IDL = $row['IDL'];
        $sql = "Select * from _NumeroAnimatios where Activo=1 and IDL=$IDL and num!='-1'  order by num"; //and num!='-1'
        $resultj2 = mysqli_query($link, $sql);
        $NumberAnimals = [];
        while ($Row2 = mysqli_fetch_array($resultj2)) {
            $NumberAnimals[] = array("id" => $Row2['num'], 'numberA' => $Row2['num'], "nombre" => strtoupper($Row2['nombre']));
        }

        $sql = "Select * from _Conf_premio_esp where IDL=$IDL order by numero";
        $resultj2 = mysqli_query($link, $sql);
        $NumberAnimalsEsp = [];
        while ($Row2 = mysqli_fetch_array($resultj2)) {
            $NumberAnimalsEsp[] = array("numberA" => $Row2['numero']);
        }



        $cierre = _check_cierre_sorteo($usu);

        $Sorteos = [];
        if (count($cierre) == 0) :
            $add = '';
        else :
            if ($cierre[0] == false) :
                $DataAnimals[] = [
                    "idl" => intval($IDL),
                    "nombre" => $row['Nombre'],
                    "logo" => $row['logo'],
                    "listSorteos" => $Sorteos,
                    "numeros" => $NumberAnimals,
                    "especiales" =>  $NumberAnimalsEsp
                ];
                continue;
            else :
                $add = '  and not _Jornada.ID  in (' . implode(",", $cierre) . ')';
            endif;
        endif;


        $sql = "Select *,_JornadaStandar.Descripcion from _Jornada,_JornadaStandar where _JornadaStandar.Hora=_Jornada.`HoraCierre` and _JornadaStandar.IDL=_Jornada.IDL and Activa=1 and IDJ=" . $IDJ . $add . "  and _Jornada.IDL=$IDL order by HoraCierre ASC";
        $resultj2 = mysqli_query($link, $sql);
        while ($Row2 = mysqli_fetch_array($resultj2)) {
            $Sorteos[] = array("id" => intval($Row2['ID']),  "hora" => $Row2['Descripcion'],);
        }

        $DataAnimals[] = [
            "idl" =>
            intval($IDL),
            "nombre" => $row['Nombre'],
            "logo" => $row['logo'],
            "listSorteos" => $Sorteos,
            "numeros" => $NumberAnimals,
            "especiales" =>  $NumberAnimalsEsp
        ];
    }

    return json_encode($DataAnimals);
}


function saveData($IDC, $data, $vf, $usu, $deb)
{

    activeAnimalitos($IDC);
    $r = saveTicket($IDC, $data, "0", $usu, $deb);

    return $r;
}


function getIdUsusFromIDC($IDC)
{
    global $serverD;
    global $userD;
    global $clvD;
    global $dbD;
    $conexion = mysqli_connect($serverD, $userD, $clvD, $dbD);
    $sql = "Select * from _tusu where Asociado='$IDC'";
    $q = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($q) != 0) {
        $r = mysqli_fetch_array($q);
        return $r['IDusu'];
    }

    return -1;
}


function getDataLogon($rand)
{
    global $serverD;
    global $userD;
    global $clvD;
    global $dbD;
    $conexion = mysqli_connect($serverD, $userD, $clvD, $dbD);
    $val = intval($rand);
    if ($val != 0) {
        $resultij = mysqli_query($conexion, "select * from _tusu where  bloqueado=$val");
        if (mysqli_num_rows($resultij) != 0) {
            $rowij = mysqli_fetch_array($resultij);
            $IDusu = $rowij['IDusu'];
            $IDC = $rowij['Asociado'];
            $Tipo = $rowij['Tipo'];
            $Nombre = $rowij['Nombre'];
            $resultij = mysqli_query($conexion, "select * from _tconsecionario where  IDC='$IDC'");
            if (mysqli_num_rows($resultij) != 0) {
                $rowij = mysqli_fetch_array($resultij);
                $phone = $rowij['celular'];
                $idm = $rowij['idm'];
                $resultij = mysqli_query($conexion, "select * from sbmonedas where id=$idm");
                $rowij = mysqli_fetch_array($resultij);
                $moneda = $rowij['moneda'];
            }
            return json_encode(["IDusu" => strval($IDusu), "IDC" => $IDC, "Tipo" => strval($Tipo), "Nombre" => $Nombre, 'phone' => $phone, 'moneda' => $moneda]);
        }
    }
    return json_encode(["IDusu" => "-1", "IDC" => 'test', "Tipo" => "0", "Nombre" => 'TEST', 'phone' => "", 'moneda' => "\$"]);
}

function isModeDark($idusu)
{
    global $serverD;
    global $userD;
    global $clvD;
    global $dbD;
    $conexion = mysqli_connect($serverD, $userD, $clvD, $dbD);
    $sql = "Select * from _tusu_ext where IDusu=$idusu";
    $q = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($q) != 0) {
        $r = mysqli_fetch_array($q);

        return json_encode(["status" => $r['dark'] == 1]);
    }



    return json_encode(["status" => true]);
}