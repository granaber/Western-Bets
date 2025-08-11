<?

function getParamUser($rndusr, $coneccion)
{

    $resultij = mysqli_query($coneccion, "select * from _tusu where  bloqueado=$rndusr");
    if (mysqli_num_rows($resultij) != 0) {
        $rowij = mysqli_fetch_array($resultij);
        $IDusu = $rowij['IDusu'];
        $IDC = $rowij['Asociado'];
        $Tipo = $rowij['Tipo'];
        $Nombre = $rowij['Nombre'];
        $resultij = mysqli_query($coneccion, "select * from _tconsecionario where  IDC='$IDC'");
        if (mysqli_num_rows($resultij) != 0) {
            $rowij = mysqli_fetch_array($resultij);
            $phone = $rowij['celular'];
            $idm = $rowij['idm'];
            $resultij = mysqli_query($coneccion, "select * from sbmonedas where id=$idm");
            $rowij = mysqli_fetch_array($resultij);
            $moneda = $rowij['moneda'];
        }
        return (["IDusu" => $IDusu, "IDC" => $IDC, "Tipo" => $Tipo, "Nombre" => $Nombre, 'phone' => $phone, 'moneda' => $moneda]);
    }
    return (["IDusu" => -1, "IDC" => '', "Tipo" => 0, "Nombre" => 'TEST']);
}
