<?
require_once('prc_phpDUK.php');

function get_data_animalitos($d1, $d2, $IDC)
{
    $link = ConnectionAnimalitos::getInstance();

    $d1 = _ConverFecha($d1);
    $d2 = _ConverFecha($d2);
    // $IDC = $_REQUEST['IDC'];

    $SumC1 = 0;
    $SumC2 = 0;
    $SumC3 = 0;

    $result = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha BETWEEN '" . $d1 . "' and '" . $d2 . "' ");
    if (mysqli_num_rows($result) != 0) :
        $sihay = true;
        $verdatos = '';
        $i = 1;
        while ($row = mysqli_fetch_array($result)) {
            /*$hastaIDC=$row['IDJ']; */
            $verdatos .= ' IDJ=' . $row['IDJ'];
            if ($i < mysqli_num_rows($result)) :
                $verdatos .= ' or ';
                $i++;
            endif;
        }

        $add = " and  (" . $verdatos . " ) ";


        $result2 = mysqli_query($link, "SELECT IDJ,count( serial ) AS cuanto, Sum( monto ) AS Venta FROM _Jugada_ani  where IDC='" . $IDC . "' and Activo=1 " . $add . " GROUP BY IDJ ORDER BY IDJ");
        while ($row2 = mysqli_fetch_array($result2)) {

            $Ventas = $row2['Venta'];
            $SumC1 += $row2['cuanto'];

            $resultN2 = mysqli_query($link, "SELECT Sum(premio) as Premio FROM _Jugada_ani_prem WHERE Serial IN ( SELECT serial FROM _Jugada_ani WHERE IDC='" . $IDC . "' and Activo=1 and IDJ=" . $row2['IDJ'] . " )");
            $row2N = mysqli_fetch_array($resultN2);
            $Premios = $row2N['Premio'];

            $SumC2 += $Ventas;
            $SumC3 += $Premios;
        }

    endif;

    return array(
        'cuanto' => $SumC1,
        'ventas' => $SumC2,
        'premios' => $SumC3
    );
}
