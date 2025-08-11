<?php

require_once 'prc_skynet.php';
require 'prc_phpN.php';

$GLOBALS['link'] = mysqli_connect($server, $user, $clv);
mysql_select_db($db, $GLOBALS['link']);
$skynet = mysqli_connect($server1, $user1, $clv1);
mysql_select_db($db1, $skynet);
/* $fechaSR=date('Ymd');
$fecha=date('d/n/Y');
$fechaSR='20140501';
$fecha='01/5/2014';*/

$hora = date('G');
echo '***' . $hora;
if ($hora <= 12) :
    $fechaSR = date('Ymd', mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
    $fecha = date('d/n/Y', mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
else :
    $fechaSR = date('Ymd');
    $fecha = date('d/n/Y');
endif;
/* $fechaSR='20140825';
$fecha='25/8/2014';*/
//  echo "SELECT * FROM _tbjornadaNT where fecha='$fechaSR'";
//  exit;
echo $fechaSR . '-' . $fecha;
$resultSK1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjornadaNT where fecha='$fechaSR'", $skynet);
if (mysqli_num_rows($resultSK1) == 0) : exit;
else : $row = mysqli_fetch_array($resultSK1);
    $nidj = $row['idj'];
endif;

$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where fecha='$fecha'", $GLOBALS['link']);
if (mysqli_num_rows($resultj) == 0) {
    exit;
}

$row = mysqli_fetch_array($resultj);
$idj = $row["IDJ"];
$escrute = '';
$juegocompleto = -1;
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbescrute Order by Ides Desc", $GLOBALS['link']);
if (mysqli_num_rows($resultj) != 0) :
    $rowj = mysqli_fetch_array($resultj);
    $ides = $rowj["Ides"] + 1;
else :
    $ides = 1;
endif;

$pasopor = true;

$valores = explode('|', $escrute);
$idg = 0;
$jc = 0;
$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDJ=$idj ORDER BY IDP ASC ", $GLOBALS['link']);
while ($row2 = mysqli_fetch_array($result2)) {
    if ($idg != $row2['Grupo']) :
        $idg = $row2['Grupo'];
        $lisde = array();
        $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute order by posicion", $GLOBALS['link']);
        while ($Row = mysqli_fetch_array($resultj)) {
            $IDDD = explode('|', $Row['IDDD_AESC']);
            for ($l = 0; $l <= count($IDDD) - 1; $l++) {
                $resultj2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where IDDD=" . $IDDD[$l] . " and Grupo=" . $idg, $GLOBALS['link']);
                if (mysqli_num_rows($resultj2) != 0) :
                    $key = array_search($Row['IDCNGE'], $lisde);

                    if (($key === false)) {
                        $lisde[] = $Row['IDCNGE'];
                    }

                endif;
            }
            if ($Row['Formato'] == 3) {
                $jc = 1;
            }
        }
        $lisdeN = $lisde;

    endif;
    $lisde = $lisdeN;
    $siHayValores = false;
    $equi1 = $row2['CodEq1'];
    $equi2 = $row2['CodEq2'];

    // echo ("select * from _agendaNT where idj=$idj and grupo=$idg");
    $result3 = mysqli_query($GLOBALS['link'], "select * from _agendaNT where idj=$idj and grupo=$idg", $GLOBALS['link']);
    if (mysqli_num_rows($result3) != 0) {
        $row3 = mysqli_fetch_array($result3);

        $valoreParam = explode('|', $row3['param']); //390-1470|3,5,9,44,16,20,65
        $varlE = explode('-', $valoreParam[0]);
        $idepKronos = $varlE[0];
        $idjKronos = $varlE[1];
        // echo "select * from _tbequiposNTnwForEscrute where idep=$idepKronos and idj=$idjKronos  and idequi=$equi1";
        $result4 = mysqli_query($GLOBALS['link'], "select * from _tbequiposNTnwForEscrute where idep=$idepKronos and idj=$idjKronos  and idequi=$equi1", $skynet);
        if (mysqli_num_rows($result4) != 0) {
            $row4 = mysqli_fetch_array($result4);
            $idep = $row4['idep'];
            $equiKr1 = $row4['idequi'];
            $eid = $row4['eid'];
            // echo "select * from _tbequiposNTnwForEscrute where idep=$idepKronos and idj=$idjKronos  and idequi=$equi2";
            $result4 = mysqli_query($GLOBALS['link'], "select * from _tbequiposNTnwForEscrute where idep=$idepKronos and idj=$idjKronos  and idequi=$equi2", $skynet);
            $row4 = mysqli_fetch_array($result4);
            $equiKr2 = $row4['idequi'];

            $resultSp = mysqli_query($GLOBALS['link'], "select * from _tbligasNTnw where idep=$idepKronos and idj=$idjKronos ", $skynet);
            $rowSp = mysqli_fetch_array($resultSp);
            $spid = $rowSp['spid'];
            echo '** spid=' . $spid . '***';
            echo '\n';
            // _tbligasNTnw
            //  echo "SELECT * FROM _tbEscruteNT where     (idequi=$equi1 or idequiNW=$equi1 )  and idj=$nidj"; echo '\n';
            // "SELECT * FROM _tbEscruteNT where eid=$eid and idequiNW=$equiKr1"
            $hayResultados = false;
            // echo "SELECT * FROM _tbEscruteNT where eid=$eid and idequiNW=$equiKr1 and idj=$idjKronos";
            $resultSK1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbEscruteNT where eid=$eid and idequiNW=$equiKr1 and idj=$idjKronos", $skynet);
            if (mysqli_num_rows($resultSK1) != 0) {
                $rowSK1 = mysqli_fetch_array($resultSK1);
                $resultSK1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbEscruteNT where eid=$eid and idequiNW=$equiKr2 and idj=$idjKronos", $skynet);
                if (mysqli_num_rows($resultSK1) != 0) {
                    $rowSK2 = mysqli_fetch_array($resultSK1);
                    $hayResultados = true;
                }
            } else {
                $resultSK1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbEscruteNT where eid=$eid and idj=$idjKronos", $skynet);
                if (mysqli_num_rows($resultSK1) != 0) {
                    $level = 0;
                    while ($rowSK1_Temp = mysqli_fetch_array($resultSK1)) {
                        if ($level == 0)
                            $rowSK1 = $rowSK1_Temp;
                        else
                            $rowSK2 = $rowSK1_Temp;

                        $level++;
                    }
                    $hayResultados = true;
                }
            }

            if ($hayResultados) :
                echo 'hay resutados <br>';

                // echo "SELECT * FROM _tbEscruteNT where     idequi=$equi1 and idj=$nidj"; echo '<br>';
                // $rowSK1 = mysqli_fetch_array($resultSK1);

                //  echo "SELECT * FROM _tbEscruteNT where (idequi=$equi2 or idequiNW=$equi2 )     and idj=$nidj"; echo '<br>';



                for ($l = 0; $l <= count($lisde) - 1; $l++) {
                    $siHayValores = true;
                    $valor = '';
                    switch (intval($lisde[$l])) {
                        case 1:
                        case 6:
                            /// TOMA TODOS LOS RESULTADOS DE JUEGO COMPLETO
                            $resulttado1 = unserialize($rowSK1['resul']);
                            print_r($resulttado1);
                            if ($spid == 2) {
                                $pn = unserialize($rowSK1['pn']);
                                $valor = sumaFO($pn, $resulttado1);
                                // $valor = $resulttado1[0]+$resulttado1[1];
                                $resulttado1 = unserialize($rowSK2['resul']);
                                $pn = unserialize($rowSK2['pn']);
                                $valor2 = sumaFO($pn, $resulttado1);
                                print_r($resulttado1);
                                $valor .= '-' . $valor2 . '-';
                            } else {
                                if ($idep == 7) {
                                    /// NHL por el extra tiempo!
                                    if (count($resulttado1) > 4) {
                                        $valor = sumarr($resulttado1, 0, count($resulttado1) - 2); //$resulttado1[4];
                                        $resulttado1 = unserialize($rowSK2['resul']);
                                        $valor .= '-' . sumarr($resulttado1, 0, count($resulttado1) - 2) . '-';
                                    } else {
                                        $valor = $resulttado1[count($resulttado1) - 1];
                                        $resulttado1 = unserialize($rowSK2['resul']);
                                        print_r($resulttado1);
                                        $valor .= '-' . $resulttado1[count($resulttado1) - 1] . '-';
                                    }
                                } else {
                                    $valor = $resulttado1[count($resulttado1) - 1];
                                    $resulttado1 = unserialize($rowSK2['resul']);
                                    print_r($resulttado1);
                                    $valor .= '-' . $resulttado1[count($resulttado1) - 1] . '-';
                                }
                            }
                            break;
                        case 2:
                            /// TOMA SOLO LOS RESULTADOS DE PRIMERA MITAD

                            $resulttado1 = unserialize($rowSK1['resul']);
                            //if ($resulttado1[0]=='-'): $valor=''; break; endif;

                            print_r($resulttado1);
                            switch ($idep) {
                                case 5:
                                    $mitad = 1;
                                    $valor = sumarr($resulttado1, 0, $mitad);
                                    $resulttado1 = unserialize($rowSK2['resul']);
                                    $valor .= '-' . sumarr($resulttado1, 0, $mitad) . '-';
                                    break;
                                case 14:
                                    $valor = $resulttado1[0];
                                    $resulttado1 = unserialize($rowSK2['resul']);
                                    $valor .= '-' .  $resulttado1[0] . '-';
                                    break;
                                default:
                                    $mitad = intval((count($resulttado1) - 2) / 2);
                                    $valor = sumarr($resulttado1, 0, $mitad);
                                    $resulttado1 = unserialize($rowSK2['resul']);
                                    $valor .= '-' . sumarr($resulttado1, 0, $mitad) . '-';
                            }



                            break;
                        case 10:
                            /// TOMA SOLO LOS RESULTADOS DE SEGUNDA MITAD

                            $resulttado1 = unserialize($rowSK1['resul']);
                            //if ($resulttado1[0]=='-'): $valor=''; break; endif;
                            print_r($resulttado1);
                            $mitad = intval((count($resulttado1) - 2) / 2) + 1;
                            $valor = sumarr($resulttado1, $mitad, count($resulttado1) - 2);
                            $resulttado1 = unserialize($rowSK2['resul']);
                            $valor .= '-' . sumarr($resulttado1, $mitad, count($resulttado1) - 2) . '-';

                            break;
                        case 3:
                            /// PRIMER INNIG ES SOLO UN SI O NO
                            $valor = '0-1-';
                            $resulttado1 = unserialize($rowSK1['resul']);
                            print_r($resulttado1);
                            //if ($resulttado1[0]=='-'): $valor=''; break; endif;
                            if ($resulttado1[0] != 0) :
                                $valor = '1-0-';
                            else :
                                $resulttado1 = unserialize($rowSK2['resul']);
                                if ($resulttado1[0] != 0) {
                                    $valor = '1-0-';
                                }

                            endif;

                            break;
                        case 11:
                            /// PRIMER INNIG ES SOLO UN SI O NO
                            $valor = '0-1-';
                            $resulttado1 = unserialize($rowSK1['resul']);
                            print_r($resulttado1);
                            //if ($resulttado1[0]=='-'): $valor=''; break; endif;
                            if ($resulttado1[5] != 0) :
                                $valor = '1-0-';
                            else :
                                $resulttado1 = unserialize($rowSK2['resul']);
                                if ($resulttado1[5] != 0) {
                                    $valor = '1-0-';
                                }

                            endif;

                            break;
                        case 8:
                            /// PRIMER INNIG ES SOLO UN SI O NO
                            $valor = '0-0-';
                            $resulttado1 = unserialize($rowSK1['resul']);
                            print_r($resulttado1);
                            //if ($resulttado1[0]=='-'): $valor=''; break; endif;
                            $c1 = 0;
                            for ($r = 0; $r <= count($resulttado1) - 1; $r++)
                                if ($resulttado1[$r] != 0) : $c1 = $r + 1;
                                    break;
                                endif;

                            $resulttado1 = unserialize($rowSK2['resul']);
                            $c2 = 0;
                            for ($r = 0; $r <= count($resulttado1) - 1; $r++)
                                if ($resulttado1[$r] != 0) : $c2 = $r + 1;
                                    break;
                                endif;

                            if ($c1 != $c2) :
                                if ($c1 != 0 && $c2 != 0) :
                                    if ($c1 < $c2) : $valor = '1-0-';
                                    endif;
                                    if ($c2 < $c1) : $valor = '0-1-';
                                    endif;
                                else :
                                    if ($c1 != 0) $valor = '1-0-';
                                    if ($c2 != 0) $valor = '0-1-';
                                endif;
                            else :
                                $valor = '1-0-';
                            endif;
                            break;
                        case 9:
                            /// SOLO HRE
                            $resulttado1 = unserialize($rowSK1['resulExt']);
                            print_r($resulttado1);
                            //if ($resulttado1[0]=='-'): $valor='0-0-'; break; endif;

                            $valor = sumarr($resulttado1, 0, count($resulttado1));
                            $resulttado1 = unserialize($rowSK2['resulExt']);
                            $valor .= '-' . sumarr($resulttado1, 0, count($resulttado1)) . '-';
                            //if ($valor=='0-0-')  $valor='';
                            break;
                        case 5:
                            // Los empates
                            if ($spid == 2) {
                                $resulttado1 = unserialize($rowSK1['resul']);
                                $pn = unserialize($rowSK1['pn']);
                                $valor1 = sumaFO($pn, $resulttado1);
                                // $valor1 = $resulttado1[0]+$resulttado1[1];
                                $resulttado1 = unserialize($rowSK2['resul']);
                                $pn = unserialize($rowSK2['pn']);
                                $valor2 = sumaFO($pn, $resulttado1);
                                // $valor2 = $resulttado1[0]+$resulttado1[1];
                            } else {
                                $resulttado1 = unserialize($rowSK1['resul']);
                                print_r($resulttado1);
                                $valor1 = $resulttado1[count($resulttado1) - 1];
                                $resulttado1 = unserialize($rowSK2['resul']);
                                $valor2 = $resulttado1[count($resulttado1) - 1];
                            }
                            if ($valor1 != $valor2) :
                                $valor = '0-1-';
                            else :
                                $valor = '1-0-';
                            endif;
                            break;
                        case 4:
                            // Primer Cuarto
                            $resulttado1 = unserialize($rowSK1['resul']);
                            print_r($resulttado1);
                            //if ($resulttado1[0]=='-'): $valor=''; break; endif;
                            $valor = $resulttado1[0];
                            $resulttado1 = unserialize($rowSK2['resul']);
                            $valor .= '-' . $resulttado1[0] . '-';
                            break;
                    }
                    $nohr = 0;
                    $lisde[$l] = $lisde[$l] . '|' . $valor;
                    if ($valor == '') : $nohr = 1;
                    endif;
                }
            else :
            //$equi1=0;$equi2=0;
            endif;
            if ($equi1 == 0 || $equi2 == 0) {
                $nohr = 1;
            }

            if ($siHayValores) :
                if ($nohr == 0) :
                    $Avalor = implode('|', $lisde) . '|';
                    $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpubliresultados where IDJ=" . $idj . " and Grupo=" . $idg, $GLOBALS['link']);
                    echo "0:SELECT * FROM _tbpubliresultados where IDJ=" . $idj . " and Grupo=" . $idg;
                    echo '<br>';
                    if (mysqli_num_rows($resultj) != 0) :
                        $rowSK3 = mysqli_fetch_array($resultj);
                        if ($rowSK3['Publicar'] != 1) :
                            // Update de los Resultados
                            $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbescrute where IDJ=" . $idj . " and IDP=" . $row2['IDP'], $GLOBALS['link']);
                            if (mysqli_num_rows($resultj) != 0) :
                                echo "0:Update _tbescrute set Escrute='$Avalor' where IDJ=" . $idj . " and IDP=" . $row2['IDP'];
                                echo '<br>';
                                $resultj = mysqli_query($GLOBALS['link'], "Update _tbescrute set Escrute='$Avalor' where IDJ=" . $idj . " and IDP=" . $row2['IDP'], $GLOBALS['link']);
                            else :
                                $resultj = mysqli_query($GLOBALS['link'], "Insert _tbescrute values ($ides," . $row2['IDP'] . ",$idg,'" . date("d/m/y") . "','" . date("h_i_s A") . "','" . $Avalor . "',$idj,$jc)", $GLOBALS['link']);
                                $ides++;
                            endif;
                        else :
                            echo 'NO UPDATE';
                            echo '<br>';
                            echo "0-1:Update _tbescrute set Escrute='$Avalor' where IDJ=" . $idj . " and IDP=" . $row2['IDP'];
                            echo '<br>';

                        //    $resultj = mysqli_query($GLOBALS['link'],"Update _tbescrute set Escrute='$Avalor' where IDJ=".$idj." and IDP=".$row2['IDP'],$GLOBALS['link']);
                        endif;

                    else :
                        $aceptarPB = true;
                        $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpubliresultados where IDJ=" . $idj . " and Grupo=" . $idg, $GLOBALS['link']);
                        if (mysqli_num_rows($resultj) != 0) :
                            $rowSK3 = mysqli_fetch_array($resultj);
                            if ($rowSK3['Publicar'] == 1) {
                                $aceptarPB = false;
                            }

                        endif;

                        $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbescrute where IDJ=" . $idj . " and IDP=" . $row2['IDP'], $GLOBALS['link']);
                        if (mysqli_num_rows($resultj) != 0) :
                            if ($aceptarPB) :
                                $resultj = mysqli_query($GLOBALS['link'], "Update _tbescrute set Escrute='$Avalor' where IDJ=" . $idj . " and IDP=" . $row2['IDP'], $GLOBALS['link']);
                                echo "1:Update _tbescrute set Escrute='$Avalor' where IDJ=" . $idj . " and IDP=" . $row2['IDP'];
                            else :
                                echo 'No publique';
                            endif;
                        else :
                            mysqli_query($GLOBALS['link'], "Insert _tbescrute values ($ides," . $row2['IDP'] . ",$idg,'" . date("d/m/y") . "','" . date("h_i_s A") . "','" . $Avalor . "',$idj,$jc)", $GLOBALS['link']);
                            echo "1:Insert _tbescrute values ($ides," . $row2['IDP'] . ",$idg,'" . date("d/m/y") . "','" . date("h_i_s A") . "','" . $Avalor . "',$idj,$jc)";
                            $ides++;
                        endif;

                    endif;

                endif; //echo '    '.$idg.' '.$equi1.'-'.$equi2; print_r($lisde);echo '<br>';
            endif;
        }
    }
}
function sumaFO($pn, $resul)
{
    $suma = 0;
    foreach ($pn as $clave => $valor) {
        if ($valor == 1 || $valor == 2) $suma += $resul[$clave];
    }
    return $suma;
}

function sumarr($arr, $des, $has)
{
    $nsu = 0;
    for ($j = $des; $j <= count($arr) - 1; $j++) {
        if ($j <= $has) {
            $nsu += $arr[$j];
        }
    }

    return $nsu;
}
