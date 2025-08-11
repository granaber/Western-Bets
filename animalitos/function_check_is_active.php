<?
require_once('prc_phpDUK.php');

$link = ConnectionAnimalitos::getInstance();
function activeAnimalitos($IDC)
{
    global $link;

    $q = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE IDC='$IDC'");
    if (mysqli_num_rows($q) == 0) {

        $data = parameterDefault();
        $rq = mysqli_query($link, "Insert _Concesionario_Ani  values('$IDC'," . $data["iHb"] . "," . $data["iPVenta"] . "," . $data["iPParti"] . "," . $data["iPParti2"] . "," . $data["iPremio"] . "," . $data["iMontMin"] . "," . $data["iMontMax"] . "," . $data["iMontSort"] . "," . $data["iTkElim"] . "," . $data["iTkPagar"] . "," . $data["iAceptoPorcentaje"] . "," . $data["iPVentas"] . "," . $data["iPremioTripleta"] . "," . $data["iMontMaxTripleta"] . ")");


        $q = mysqli_query($link, "SELECT * FROM _Loterias WHERE Activa=1 and IDL!=1");
        while ($r = mysqli_fetch_array($q)) {
            $IDL = $r['IDL'];


            $data = parameterDefault_2();


            $rq = mysqli_query($link, "Insert _Concesionario_Ani_2  values('$IDC',$IDL," . $data["iPremio"] . "," . $data["iMontSort"] . "," . $data["iMontMin"] . "," . $data["iMontMax"] . "," . $data["iPremioProx"] . "," . $data["iPremio1"] . "," . $data["iPremio2"] . "," . $data["iAceptoPorcentaje2"] . "," . $data["iPVentas"] . "," . $data["iPremioTripleta"] . "," . $data["iMontMaxTripleta"] . ")");
        }
    }
}


function parameterDefault()
{
    return [
        "iHb" => 1,
        "iPVenta" => 0,
        "iPParti" => 0,
        "iPParti2" => 0,
        "iPremio" => 30,
        "iMontMin" => 1,
        "iMontMax" => 1000,
        "iMontSort" => 1000,
        "iTkElim" => 10,
        "iTkPagar" => 0,
        "iAceptoPorcentaje" => 100,
        "iPVentas" => 100,
        "iPremioTripleta" => 10,
        "iMontMaxTripleta" => 1000
    ];
}
function parameterDefault_2()
{
    return [
        "iPremio" => 30,
        "iMontSort" => 100,
        "iMontMin" => 1,
        "iMontMax" => 100,
        "iPremioProx" => 10,
        "iPremio1" => 0,
        "iPremio2" => 0,
        "iAceptoPorcentaje2" => 100,
        "iPVentas" => 10,
        "iPremioTripleta" => 50,
        "iMontMaxTripleta" => 100
    ];
}