<style type="text/css">
    @media print {

        .header {
            display: none
        }

        div,
        a {
            display: none
        }

        span {
            display: none
        }

    }
</style>

<?php

require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$d1 = _ConverFecha($_REQUEST['d1']);
$d2 = _ConverFecha($_REQUEST['d2']);
$arraF = array();
$result = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha BETWEEN '" . $d1 . "' and '" . $d2 . "' ");
//echo ("SELECT * FROM _Jornarda_fecha  Where Fecha BETWEEN '".$d1."' and '".$d2."' ");
if (mysqli_num_rows($result) != 0) :
    $sihay = true;
    $verdatos = '';
    $i = 1;
    $IDJ = 0;
    while ($row = mysqli_fetch_array($result)) {
        /*$hastaIDC=$row['IDJ']; */
        $arraF[$row['IDJ']] = $row['Fecha'];
        if ($IDJ == 0) $IDJ = $row['IDJ'];
        $verdatos .= ' IDJ=' . $row['IDJ'];
        if ($i < mysqli_num_rows($result)) :
            $verdatos .= ' or ';
            $i++;
        endif;
    }

    $add = " and  (" . $verdatos . " ) ";

    echo '<div><table  border="0" >';
    echo '  <tr>';
    echo '  <th><input name="" type="button" value="Imprimir" onclick="print();"/><input name="" type="button" value="Cerrar" onclick="window.close();"/></th>';
    echo '  </tr>';
    echo '</table></div>';

    //echo '<samp>';
    //echo ("SELECT * FROM _Escritu_Ani where Publicar=1 ".$add. " order by IDJ,ID");
    $data = array();
    $show = array();

    foreach ($arraF as $idj => $value) {

        echo "<p>Fecha :" . _ConverFechaT2($arraF[$idj]) . "</p>";

        $result2n1 = mysqli_query($link, "SELECT * FROM _Loterias Where Activa=1 Order by IDL");
        while ($row2n1 = mysqli_fetch_array($result2n1)) {
            $col = '1';
            echo "<br><h3>" . $row2n1['Nombre'] . "</h3>";
            echo '<table  border="1" cellspacing="0" cellpadding="2"><tr>';
            $IDL = $row2n1['IDL'];
            $aID = array();
            $result2n = mysqli_query($link, "SELECT * FROM _JornadaStandar,_Jornada WHERE _JornadaStandar.Hora=_Jornada.HoraCierre  and _Jornada.IDL=" . $IDL . " and IDJ=" . $idj . " Group by _Jornada.id ORDER BY _JornadaStandar.Hora ASC ");
            //echo ("SELECT * FROM _JornadaStandar,_Jornada WHERE _JornadaStandar.Hora=_Jornada.HoraCierre  and _Jornada.IDL=".$IDL." and IDJ=".$idj." Group by _Jornada.id ORDER BY _JornadaStandar.Hora ASC ");

            while ($row2n = mysqli_fetch_array($result2n)) {
                $aID[] = $row2n['ID'];
                switch ($col) {
                    case '1':
                        $color = '#CCC';
                        $col = '2';
                        break;

                    case '2':
                        $color = '#FFF';
                        $col = '1';
                        break;
                }
                echo '<td  width="120" align="center" style="border-bottom:none;border-right:thin; border-left:thin; border-top:thin; background:' . $color . '">' . $row2n['Descripcion'] . '</td>';
            }
            $col = '1';
            echo '</tr>';
            echo '<tr>';
            $EnLetrayNum = array();
            $i = 0;
            $result = mysqli_query($link, "SELECT _Escritu_Ani . * FROM _Escritu_Ani, _Jornada   WHERE  _Escritu_Ani.ID = _Jornada.ID AND _Escritu_Ani.IDJ = " . $idj . " and  _Escritu_Ani.ID  in (" . implode(',', $aID) . ")   ORDER BY _Escritu_Ani.IDJ, _Jornada.HoraCierre");
            //  echo ("SELECT * FROM _Escritu_Ani where Publicar=1 and IDJ=".$idj." order by IDJ,ID");
            while ($row = mysqli_fetch_array($result)) {
                switch ($col) {
                    case '1':
                        $color = '#CCC';
                        $col = '2';
                        break;

                    case '2':
                        $color = '#FFF';
                        $col = '1';
                        break;
                }

                // echo ("Select * from _NumeroAnimatios where num='".$numgana."' and  Activo=1  and IDL=".$IDL);

                if ($row['G1'] == '-1') :

                    $EnLetrayNum[$i] = '()';
                else :

                    $EnLetrayNum[$i] = $row['G1'];
                endif;
                $i++;
            }
            echo '</tr>';
            echo '<tr>';
            $col = '1';
            for ($i = 0; $i <= count($EnLetrayNum) - 1; $i++) {
                switch ($col) {
                    case '1':
                        $color = '#CCC';
                        $col = '2';
                        break;

                    case '2':
                        $color = '#FFF';
                        $col = '1';
                        break;
                }
            }
            echo '</tr>';



            echo '</table>';
            echo '<br>';
        }
    }
endif;

function showWinner($row, $IDL, $color)
{

    $data1 = getNumber($row['G1'], $IDL);
    $data2 = getNumber($row['G2'], $IDL);
    $data3 = getNumber($row['G3'], $IDL);

    echo '<table  border="1" cellspacing="0" cellpadding="2"><tr>';
    if ($data1[0] == '-1') :
        echo '<td align="center" style="border-bottom:none; border-top:none; border-right:thin; border-left:thin; background:' . $color . '"></td>';
    else :
        echo '<td align="center" style="border-bottom:none; border-top:none; border-right:thin; border-left:thin; background:' . $color . '"><h3>' . $data1[1] . '</h3></td>';
        echo ' <td align="center" style="border-right:thin; border-left:thin; border-bottom:thin;border-top:none; background:' . $color . '"> <h2 >' . $data1[0] . '</h2></td>';
    endif;
    echo '</table>';
}

function getNumber($numwin, $IDL)
{
    global $link;

    if ($numwin == '-1') {
        return array('-1');
    }

    if ($numwin <= 9 && $numwin >= 0) :
        if ($numwin == '0') :
            $numgana = $numwin;
        else :
            if ($numwin == '00') :
                $numgana = $numwin;
            else :
                $a = str_split($numwin);
                if (count($a) == 2) :
                    $numgana = $numwin;
                else :
                    $numgana = '0' . $numwin;
                endif;
            endif;
        endif;
    else :
        $numgana = $numwin;
    endif;
    $resultj3n = mysqli_query($link, "Select * from _NumeroAnimatios where num='" . $numgana . "' and  Activo=1  and IDL=" . $IDL);
    $row3n = mysqli_fetch_array($resultj3n);
    return array($numgana, $row3n['nombre']);
}
  //echo '</samp>';