<?
require_once('prc_phpDUK.php');
require_once('send_ws.php');
require_once('base_credit.php');


global $serverD;
global $userD;
global $clvD;
global $dbD;
$conexion = mysqli_connect($serverD, $userD, $clvD, $dbD);
$TYPE_NORMAL = 0;


function saveTicket($IDC, $data, $vf, $usu, $deb)
{
    global $conexion, $minutosh;
    global $creditDat;


    $fechaactual = FecharealAnimalitos($minutosh, "d/n/Y");
    $horaticket = HorarealAnimalitos($minutosh, "h:i:s A");
    $idcram = rand(1, 2);
    $Fecha = FecharealAnimalitos($minutosh, 'Y-m-d');
    $hora = HorarealAnimalitos($minutosh, "H:i:s");
    $dataR = array(); // Data devuelta por Cierre de Sorteos
    $dataT = array(); // Data devuelta por Tope maximos permitidos
    $dataT2 = array(); // Data devuelta por Tope maximos permitidos
    $reslval = [];
    $IDG = 0;
    $idm = 0;
    $MND = "?";

    $resultj = mysqli_query($conexion, "SELECT * FROM _tconsecionario  Where IDC='" . $IDC . "'");
    if (mysqli_num_rows($resultj) != 0) :
        $rowj = mysqli_fetch_array($resultj);
        $IDG = $rowj['IDG'];
        $idm = $rowj['idm'];
        $MND = ""; // getMoneda($IDC, $conexion);
    endif;

    $link = ConnectionAnimalitos::getInstance();


    $q = mysqli_query($link, "SELECT * FROM _Concesionario_Ani  Where IDC='" . $IDC . "'");
    if (mysqli_num_rows($q) == 0) :
        $reslval["info"] = false;
        $reslval["ticket"] = '7';
        $reslval["dataR"] = 'NO ACTIVO - Disculpe su usuario no esta activo para vender este tipo de Jugada';
        $reslval["dataT"] = "";
        $reslval = array_merge($reslval, $creditDat);
        return json_encode($reslval);
    endif;


    if (!VerifHoySor($data, $Fecha)) :
        $reslval["info"] = false;
        $reslval["ticket"] = '7';
        $reslval["dataR"] = 'JORNADA - Los Sorteos en el ticket estan Cerrados!';
        $reslval["dataT"] = "";
        $reslval = array_merge($reslval, $creditDat);
        return json_encode($reslval);

    endif;

    $resultj = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha='" . $Fecha . "'");
    if (mysqli_num_rows($resultj) != 0) :
        $rowj = mysqli_fetch_array($resultj);
        $IDJ = $rowj["IDJ"];
        $cierre = _check_cierre_sorteo($usu);
        if (count($cierre) != 0) :
            $dataR = _Verficacion_Sorteo($cierre, $data);
            $dataTemp = getInfoDatar($dataR);

            // foreach ($dataR as $key => $value) {
            //     //"modo":0,"monto":1,"sorteo":169049,"numero":"10"}
            //     $dataTemp[] = ["modo" => $value->modo, "monto" => strval($value->monto), "sorteo" => $value->sorteo, "numero" => $value->numero];
            // }
            $dataR = json_decode(json_encode($dataTemp));
        else :
            if ($cierre[0] == false   &&  isset($cierre[0])) :
                $reslval["info"] = false;
                $reslval["ticket"] = '7';
                $reslval["dataR"] = 'JORNADA - No hay jornada habilitada para esta fecha!';
                $reslval["dataT"] = "";
                $reslval = array_merge($reslval, $creditDat);

                return json_encode($reslval);

            endif;
        endif;

        $dataT = TopesxSorteo($IDC, $data, $IDJ, $IDG);
        $dataT2 = TopesxNumero($IDC, $data, $IDJ, $IDG);
        $dataT3 = TopesxNumeroxSorteo($IDC, $data, $IDJ, $IDG);


        if (count($data) == 0) :
            if (count($dataT) == 0) :
                if (count($dataT2) == 0) :
                    if (count($dataT3) == 0) :
                        $reslval["info"] = false;
                        $reslval["ticket"] = '7';
                        $reslval["dataR"] = 'CIERRE - Todas los Sorteos seleccionados estan cerrados!';
                        $reslval["dataT"] = "";

                    else :
                        $reslval["info"] = false;
                        $reslval["ticket"] = '7';
                        $reslval["dataR"] = 'TOPES/NUMERO/SORTEO - No puedo imprimir el ticket porque todos los sorteo sobrepasa el cupo limite!';
                        $reslval["dataT"] = "";

                    endif;
                else :
                    $reslval["info"] = false;
                    $reslval["ticket"] = '7';
                    $reslval["dataR"] = 'TOPES/NUMERO - No puedo imprimir el ticket porque todos los sorteo sobrepasa el cupo limite!';
                    $reslval["dataT"] = "";

                endif;
            else :
                $reslval["info"] = false;
                $reslval["ticket"] = '7';
                $reslval["dataR"] = 'TOPES/SORTEO - No puedo imprimir el ticket porque todos los Animalitos sobrepasa el cupo limite!';
                $reslval["dataT"] = "";

            endif;
            $reslval = array_merge($reslval, $creditDat);

            return json_encode($reslval);

        endif;

        $dataT = array_merge($dataT, $dataT2, $dataT3);


        if (!verificCountTrackAnimalitos($IDC, $data, $IDJ)) :
            $reslval["info"] = false;
            $reslval["ticket"] = '7';
            $reslval["dataR"] = 'TOPES - Supero los topes de sus Ventas en este Ticket!';
            $reslval["dataT"] = "";
            $reslval = array_merge($reslval, $creditDat);
            return json_encode($reslval);
        endif;


        $data = handler_empac_especial($data);

        $dataTESP = ToperxJornadaOnlyTRP($IDC, $data, $IDJ);
        if (count($data) == 0) :
            $reslval["info"] = false;
            $reslval["ticket"] = '7';
            $reslval["dataR"] = 'TOPES TRIPETA - No puedo imprimir el ticket porque todos los Animalitos sobrepasa el cupo limite!';
            $reslval["dataT"] = "";
            $reslval = array_merge($reslval, $creditDat);
            return json_encode($reslval);
        endif;
        $dataT = array_merge($dataT, $dataTESP);


        $TopeGrupalNum = Topes_ByGrupalByxNumero($data, $IDG);
        if (count($data) == 0) :

            $reslval["info"] = false;
            $reslval["ticket"] = '7';
            $reslval["dataR"] = 'TOPES GRUPAL - No puedo imprimir el ticket porque todos los Animalitos sobrepasa el cupo limite!';
            $reslval["dataT"] = "";
            $reslval = array_merge($reslval, $creditDat);
            return json_encode($reslval);

        endif;
        $dataT = array_merge($dataT, $TopeGrupalNum);

        $serial = bticketAnimalitos();
        if ($idcram == 1) :
            $se = rand(1, 9) . rand(1, $serial) . '-' . rand(1, 9) . rand(1, $IDJ) . '-' . substr($serial, 2, 1);
        else :
            $se = rand(1, $serial) . '-' . rand(1, 9) . rand(1, $IDJ) . '-' . substr($serial, 2, 1) . rand(1, 9) . '-' . rand(1, 9);
        endif;

        $ip = getipAnimalitos();
        if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) : $ip = $_SERVER["REMOTE_ADDR"];
        endif;
        $jugada = ecoBaseAnimalitos(serialize($data));
        $ap = _MontoDUK($data);


        $credit = BackendCredito($IDC, $serial, $ap, TYPE_VENTA, $deb);

        if ($credit["err"]) {

            $reslval["info"] = false;
            $reslval["ticket"] = '7';
            $reslval["dataR"] = $credit["mensaje"];
            $reslval["dataT"] = "";
            $reslval = array_merge($reslval, $creditDat);

            return json_encode($reslval);
        }

        $creditDat = ["consume" => strval($credit["monto"]), "saldo" => strval($credit['saldo']), "bono" => strval(0), "lastactivity" => strval($credit['transacc'])];

        $result2 = mysqli_query($link, "INSERT INTO _Jugada_ani2  VALUES (" . $serial . ",'" . $IDC . "','" . $hora . "'," . $IDJ . ",1,'" . $jugada . "'," . $ap . ",'" . $ip . "','" . $se . "'," . $usu . ",$idm)");
        $result = false;
        $result = mysqli_query($link, "INSERT INTO _Jugada_ani  VALUES (" . $serial . ",'" . $IDC . "','" . $hora . "'," . $IDJ . ",1,'" . $jugada . "'," . $ap . ",'" . $ip . "','" . $se . "'," . $usu . ",0,'','',0,0,$idm)");
        /// Si fue Aceptado en la Tabla Error:2
        if ($result) :
            if ($vf == '-1') :
                $reslval["info"] = $result;
                $reslval["ticket"] = ticketDUK($serial, $fechaactual, $horaticket, $IDC, $se, $data, $ap, $IDJ, 1, 1, $MND);
                $reslval["dataR"] = $dataR;
                $reslval["dataT"] = $dataT;

            else :
                $reslval["info"] = $result;
                $tkrecibo = reciboDUK($serial, $fechaactual, $horaticket, $IDC, $se, $data, $ap, $IDJ, 1, 1);
                $reslval["ticket"] = $tkrecibo["recibo"];

                $msgWs = MakeTicketVirtualAnimalitos($serial, $IDC, $horaticket, $fechaactual, $se, $tkrecibo["dataws"]);
                if ($msgWs['err']) {
                    $Resp['status'] = false;
                    $Resp['info'] = $msgWs['errText'];
                    $dataT = array_merge($Resp, $dataT);
                }
                $reslval["dataR"] = json_encode($dataR);
                $reslval["dataT"] = json_encode($dataT);

            // if ($repGP[0]) :
            //     $reslval["info"] = true;
            //     $reslval["ticket"] = $repGP[2];
            //     $reslval["dataR"] = $dataR;
            //     $reslval[3] = $dataT;
            // else :
            //     $reslval["info"] = false;
            //     $reslval["ticket"] = '7';
            //     $reslval["dataR"] = 'VerFacil-No pude enviar los datos a VERFACIL!';
            // endif;
            endif;
        else :
            $reslval["info"] = false;
            $reslval["ticket"] = '7';
            $reslval["dataR"] = 'ERROR - Disculpe no puedo almacenar el ticket!';
            $reslval["dataT"] = "";

        endif;

    else :
        $reslval["info"] = false;
        $reslval["ticket"] = '7';
        $reslval["dataR"] = 'JORNADA - No hay jornada habilitada para este fecha!';
        $reslval["dataT"] = "";

    endif;
    $reslval = array_merge($reslval, $creditDat);

    return json_encode($reslval);
}


function _Verficacion_Sorteo($cierre, &$data)
{
    $numeroEl = array();
    foreach ($data as $i => $value) {
        $IDa = $data[$i]->sorteo;
        if (in_array($IDa, $cierre)) :
            $numeroEl[] = $data[$i];
            unset($data[$i]);
        endif;
    }

    return $numeroEl;
}

function TopesxSorteo($IDC, &$data, $IDJ, $IDG)
{
    global $link, $TYPE_NORMAL;
    mysqli_begin_transaction($link);
    //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
    //// Buscar los Topes N1 Por Punto de Venta
    $Resp = array();
    $dataT = array();
    $Resp['status'] = true;
    $arrayTOPE = array();

    $DatIDS = viewIDJND($IDJ);
    //print_r($DatIDS);

    $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani  Where IDC='" . $IDC . "'");
    if (mysqli_num_rows($resultj) != 0) :
        $row = mysqli_fetch_array($resultj);
        //if ($row['iMontSort']!=0):
        $arrayTOPE[1] = $row['iMontSort'];
        $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani_2  Where IDC='" . $IDC . "'");
        while ($row = mysqli_fetch_array($resultj)) {
            $arrayTOPE[$row['IDL']] = $row['iMontSort'];
        }
        $sumaSor = array();
        foreach ($data as $i => $value) {
            $d_esp = $data[$i]->esp ?? 0;
            if ($d_esp == $TYPE_NORMAL) {
                if (isset($sumaSor[$data[$i]->sorteo])):
                    $sumaSor[$data[$i]->sorteo] += isset($data[$i]->monto) ? $data[$i]->monto : 0;
                else:
                    $sumaSor[$data[$i]->sorteo] =  $data[$i]->monto;
                endif;
            }
        }
        // print_r($sumaSor);
        foreach ($sumaSor as $i => $value) {
            $resultjSN1 = mysqli_query($link, "SELECT * FROM _Jornada  Where ID=" . $i);
            $rowN1 = mysqli_fetch_array($resultjSN1);
            $IDL =  $rowN1['IDL'];
            if ($arrayTOPE[$IDL] != 0) :
                $resultjS = mysqli_query($link, "SELECT * FROM _Tope_Suma_PV  Where IDC='" . $IDC . "' and ID=" . $i);
                if (mysqli_num_rows($resultjS) != 0) :
                    $rowS = mysqli_fetch_array($resultjS);
                    $Total = $rowS['suma'] + $sumaSor[$i];
                    if ($Total > $arrayTOPE[$IDL]) :
                        $Resp['status'] = false;
                        $verS = _verSorteo($i, $IDJ, $IDC);
                        $Resp['info'] = '1.El tope de venta por el Sorteo ' . $verS[0] . ' solo tiene cupo de ' . ($arrayTOPE[$IDL] - $rowS['suma']) . ' y lo esta pasando con este ticket';
                        $dataT[] = $Resp;
                        foreach ($data as $x => $y) {
                            $d_esp = $data[$x]->esp ?? 0;

                            if ($data[$x]->sorteo == $i && $d_esp == $TYPE_NORMAL) :
                                unset($data[$x]);
                            endif;
                        }
                    else :
                        $resultjS = mysqli_query($link, "UPDATE  _Tope_Suma_PV  set suma=$Total where  IDC='$IDC' and ID=$i");
                    endif;
                else :
                    if ($sumaSor[$i] > $arrayTOPE[$IDL]) :
                        $Resp['status'] = false;
                        $verS = _verSorteo($i, $IDJ, $IDC);
                        $Resp['info'] = '2.El tope de venta por el Sorteo ' . $verS[0] . ' solo tiene cupo de ' . ($arrayTOPE[$IDL]) . ' y lo esta pasando con este ticket';
                        $dataT[] = $Resp;
                        foreach ($data as $x => $y) {
                            $d_esp = $data[$x]->esp ?? 0;
                            if ($data[$x]->sorteo == $i && $d_esp == $TYPE_NORMAL) :
                                unset($data[$x]);
                            endif;
                        }
                    else :
                        $resultjS = mysqli_query($link, "INSERT INTO  _Tope_Suma_PV  (IDC,ID,suma) VALUES ('" . $IDC . "'," . $i . "," . $sumaSor[$i] . ")");
                    //  echo ("INSERT INTO  _Tope_Suma_PV  (IDC,ID,suma) VALUES ('".$IDC."',".$i.",".$sumaSor[$i].")");
                    endif;
                endif;
            endif;
        }
    //endif;
    endif;
    //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
    //// Buscar los Topes N2 Por Grupo
    $resultj = mysqli_query($link, "SELECT * FROM _Grupo_Tope_S  Where Tope!=0 and IDG=" . $IDG);
    if (mysqli_num_rows($resultj) != 0) :

        $sumaSor = array();
        foreach ($data as $i => $value) {
            $d_esp = $data[$i]->esp ?? 0;
            if ($d_esp == $TYPE_NORMAL)
                $sumaSor[$data[$i]->sorteo] +=  isset($data[$i]->monto) ? $data[$i]->monto : 0;
            //  print_r($sumaSor);
        }

        foreach ($sumaSor as $i => $value) {
            $id = $DatIDS[$i];
            $resultj = mysqli_query($link, "SELECT * FROM _Grupo_Tope_S  Where Tope!=0 and IDS=" . $id . " and IDG=" . $IDG);
            //  echo ("SELECT * FROM _Grupo_Tope_S  Where Tope!=0 and IDS=".$id." and IDG=".$IDG);
            if (mysqli_num_rows($resultj) != 0) :
                $row = mysqli_fetch_array($resultj);
                $TopeN2 = $row['Tope']; //500
                $Total = $row['Suma'] + $sumaSor[$i]; //30
                if ($Total > $TopeN2) :
                    $Resp['status'] = false;
                    $verS = _verSorteo($i, $IDJ, $IDC);
                    $Resp['info'] = '3.El tope de venta por el Sorteo ' . $verS[0] . ' solo tiene cupo por GRUPO (' . $IDG . ') de ' . ($TopeN2 - $row['suma']) . ' y lo esta pasando con este ticket';
                    $dataT[] = $Resp;
                    foreach ($data as $x => $y) if ($data[$x]->sorteo == $i && $data[$x]->esp == $TYPE_NORMAL) : unset($data[$x]);
                    endif;
                else :
                    $resultjS = mysqli_query($link, "UPDATE  _Grupo_Tope_S  set suma=$Total where  IDS=" . $id . " and IDG=" . $IDG);
                //echo ("UPDATE  _Grupo_Tope_S  setSsuma=$Total where  IDS=".$id." and IDG=".$IDG);
                endif;
            endif;
        }

    endif;
    //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
    //// Buscar los Topes N3 Por Banca
    $resultj = mysqli_query($link, "SELECT * FROM _Banca_Tope_S  Where Tope!=0");
    if (mysqli_num_rows($resultj) != 0) :

        $sumaSor = array();
        foreach ($data as $i => $value)
            if (isset($sumaSor[$data[$i]->sorteo])) {
                $d_esp = $data[$i]->esp ?? 0;
                if ($d_esp == $TYPE_NORMAL) $sumaSor[$data[$i]->sorteo] += isset($data[$i]->monto) ? $data[$i]->monto : 0;
            }
        foreach ($sumaSor as $i => $value) {
            $id = $DatIDS[$i];
            $resultj = mysqli_query($link, "SELECT * FROM _Banca_Tope_S  Where Tope!=0 and IDS=" . $id);
            if (mysqli_num_rows($resultj) != 0) :
                $row = mysqli_fetch_array($resultj);
                $TopeN3 = $row['Tope']; //500
                $Total = $row['Suma'] + $sumaSor[$i]; //30
                if ($Total > $TopeN3) :
                    $Resp['status'] = false;
                    $verS = _verSorteo($i, $IDJ, $IDC);
                    $Resp['info'] = '4.El tope de venta por el Sorteo ' . $verS[0] . ' solo tiene cupo por BANCA de ' . ($TopeN3 - $row['suma']) . ' y lo esta pasando con este ticket';
                    $dataT[] = $Resp;
                    foreach ($data as $x => $y) if ($data[$x]->sorteo == $i && $data[$x]->esp == $TYPE_NORMAL) : unset($data[$x]);
                    endif;
                else :
                    $resultjS = mysqli_query($link, "UPDATE  _Banca_Tope_S  set suma=$Total where  IDS=" . $id);
                //echo ("UPDATE  _Grupo_Tope_S  setSsuma=$Total where  IDS=".$id." and IDG=".$IDG);
                endif;
            endif;
        }

    endif;


    if (count($dataT) == 0) :
        mysqli_commit($link);
    else :
        mysqli_rollback($link);
    endif;
    return $dataT;
}

///////////////////////////////// Tope por numero //////////////////////////////////
function TopesxNumero($IDC, &$data, $IDJ, $IDG)
{
    global $link;

    mysqli_query($link, "begin");

    $Resp = array();
    $dataT = array();
    $Resp[0] = true;


    $DatIDS = viewIDJND($IDJ);
    //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
    //// Buscar los Topes N2 Por Grupo
    $resultj = mysqli_query($link, "SELECT * FROM _Grupo_Tope_N  Where Tope!=0 and IDG=" . $IDG);
    if (mysqli_num_rows($resultj) != 0) :
        foreach ($data as $i => $value) {
            $id = $DatIDS[$data[$i]->sorteo];
            $resultj = mysqli_query($link, "SELECT * FROM _Grupo_Tope_N  Where  IDS=" . $id . " and numero='" . $data[$i]->numero . "' and Tope!=0 and IDG=" . $IDG);
            if (mysqli_num_rows($resultj) != 0) :
                $row = mysqli_fetch_array($resultj);
                $TopeN2 = $row['Tope']; //500
                $Total = $row['Suma'] + $data[$i]->monto; //30
                if ($Total > $TopeN2) :
                    $Resp[0] = false;
                    $verS = _verSorteo($data[$i]->sorteo, $IDJ, $IDC);
                    $Resp[1] = 'El tope de venta por el Sorteo ' . $verS[0] . ' y Animalito ' . $data[$i]->numero . ' del Grupo ' . $IDG . ' solo tiene cupo por ' . ($TopeN2 - $row['Suma']) . ' y lo esta pasando con este ticket';
                    $dataT[] = $Resp;
                    unset($data[$i]);
                else :
                    $resultjS = mysqli_query($link, "UPDATE  _Grupo_Tope_N  set suma=$Total  Where numero='" . $data[$i]->numero . "' and Tope!=0 and IDG=" . $IDG);
                endif;
            endif;
        }
    endif;

    //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
    //// Buscar los Topes N3 Por Banca
    $resultj = mysqli_query($link, "SELECT * FROM _Banca_Tope_N  Where Tope!=0");
    if (mysqli_num_rows($resultj) != 0) :
        foreach ($data as $i => $value) {
            $id = $DatIDS[$data[$i]->sorteo];
            $resultj = mysqli_query($link, "SELECT * FROM _Banca_Tope_N  Where IDS=" . $id . " and numero='" . $data[$i]->numero . "' and Tope!=0");
            if (mysqli_num_rows($resultj) != 0) :
                $row = mysqli_fetch_array($resultj);
                $TopeN3 = $row['Tope']; //500
                $Total = $row['Suma'] + $data[$i]->monto; //30
                if ($Total > $TopeN3) :
                    $Resp[0] = false;
                    $verS = _verSorteo($data[$i]->sorteo, $IDJ, $IDC);
                    $Resp[1] = 'El tope de venta por el Sorteo ' . $verS[0] . ' y Animalito ' . $data[$i]->numero . '  solo tiene cupo por ' . ($TopeN3 - $row['Suma']) . ' y lo esta pasando con este ticket';
                    $dataT[] = $Resp;
                    unset($data[$i]);
                else :
                    $resultjS = mysqli_query($link, "UPDATE  _Grupo_Tope_N  set suma=$Total  Where numero='" . $data[$i]->numero . "' and Tope!=0 and IDG=" . $IDG);
                endif;
            endif;
        }
    endif;


    if (count($dataT) == 0) :
        mysqli_query($link, "commit");
    else :
        mysqli_query($link, "rollback");
    endif;
    return $dataT;
}
function VerifHoySor($data, $Fecha)
{
    global $link;

    $resultj = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha='" . $Fecha . "'");
    if (mysqli_num_rows($resultj) != 0) :
        $rowj = mysqli_fetch_array($resultj);
        $IDJ = $rowj["IDJ"];
        $aSorteosAct = array();
        $result = mysqli_query($link, "SELECT * FROM  _Jornada WHERE IDJ =" . $IDJ);
        while ($row = mysqli_fetch_array($result)) {
            $aSorteosAct[] = $row['ID'];
        }
        // Los Sorteos DE HOY y Solo hoy

        $cerrar = true;
        foreach ($data as $i => $value) {
            $ide = array_search($data[$i]->sorteo, $aSorteosAct);
            //  echo $data[$i]->sorteo;echo '*';
            if ($ide === false) :
                $cerrar = false;
                break;
            endif;
        }

        //
        return $cerrar;
    else :
        return false;
    endif;
}


function TopesxNumeroxSorteo($IDC, &$data, $IDJ, $IDG)
{
    global
        $link, $TYPE_NORMAL;

    mysqli_query($link, "begin");

    $Resp = array();
    $dataT = array();
    $Resp[0] = true;
    $arrayTOPE = array();

    $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani  Where IDC='$IDC'");
    if (mysqli_num_rows($resultj) != 0) :
        $row = mysqli_fetch_array($resultj);
        $arrayTOPE[1] = $row['iMontMax']; //1000

        $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani_2  Where IDC='" . $IDC . "'");
        while ($row = mysqli_fetch_array($resultj)) {
            $arrayTOPE[$row['IDL']] = $row['iMontMax'];
        }


        foreach ($data as $i => $value) {
            $d_esp = $data[$i]->esp ?? 0;
            if ($d_esp  != $TYPE_NORMAL) {
                continue;
            }


            $id = $data[$i]->sorteo;

            $resultjSN1 = mysqli_query($link, "SELECT * FROM _Jornada  Where ID=" . $id);
            $rowN1 = mysqli_fetch_array($resultjSN1);
            $IDL =  $rowN1['IDL'];
            if (isset($arrayTOPE[$IDL])) :
                if ($arrayTOPE[$IDL] != 0) :
                    $num = $data[$i]->numero;
                    $monto = $data[$i]->monto; //1000
                    //ln 	IDC 	num 	ID 	total
                    //echo ("SELECT * FROM _Tope_Suma_PV_Xnum  Where  IDC='$IDC' and ID=$id and num='$num' ");
                    $resultj = mysqli_query($link, "SELECT * FROM _Tope_Suma_PV_Xnum  Where  IDC='$IDC' and ID=$id and num='$num' ");
                    if (mysqli_num_rows($resultj) != 0) :
                        $row = mysqli_fetch_array($resultj);
                        $TopeN4 = $row['total'] + $monto; // $row['total']=50  $monto=1000
                        if ($TopeN4 <= $arrayTOPE[$IDL]) :
                            $resultjS = mysqli_query($link, "Update   _Tope_Suma_PV_Xnum  Set total=$TopeN4 Where  IDC='$IDC' and ID=$id and num='$num' ");

                        else :
                            $Resp[0] = false;
                            $verS = _verSorteo($data[$i]->sorteo, $IDJ, $IDC);
                            $Resp[1] = 'El tope de venta por el Sorteo ' . $verS[0] . ' y Animalito ' . $data[$i]->numero . '  solo tiene cupo por ' . ($arrayTOPE[$IDL] - $row['total']) . ' y lo esta pasando con este ticket';
                            $dataT[] = $Resp;
                            unset($data[$i]);
                        endif;
                    else :
                        if ($monto <= $arrayTOPE[$IDL]) :
                            $resultjS = mysqli_query($link, "Insert  _Tope_Suma_PV_Xnum  (IDC,num,ID,total) values ('$IDC','$num',$id,$monto) ");
                        //      echo ("Insert  _Tope_Suma_PV_Xnum  (IDC,num,ID,total) values ('$IDC','$num',$id,$monto) ");//
                        else :
                            $Resp[0] = false;
                            $verS = _verSorteo($data[$i]->sorteo, $IDJ, $IDC);
                            $Resp[1] = 'El tope de venta por el Sorteo ' . $verS[0] . ' y Animalito ' . $data[$i]->numero . '  solo tiene cupo por ' . ($arrayTOPE[$IDL] - $monto) . ' y lo esta pasando con este ticket';
                            $dataT[] = $Resp;
                            unset($data[$i]);
                        endif;
                    endif;

                endif;
            else :
                $Resp[0] = false;
                $verS = _verSorteo($data[$i]->sorteo, $IDJ, $IDC);
                $Resp[1] = 'El tope de venta por el Sorteo ' . $verS[0] . ' y Animalito ' . $data[$i]->numero . '  solo tiene cupo por ' . ($arrayTOPE[$IDL]) . ' y lo esta pasando con este ticket';
                $dataT[] = $Resp;
                unset($data[$i]);
            endif;
        }

    endif;

    if (count($dataT) == 0) :
        mysqli_query($link, "commit");
    else :
        mysqli_query($link, "rollback");
    endif;
    return $dataT;
}

function getInfoDatar($dataR)
{
    global $link;

    $infoDataR = [];

    foreach ($dataR as $key => $value) {
        $s = $value->sorteo;
        $idAnimalito = $value->numero;

        $s = "SELECT _Jornada.*,_JornadaStandar.`Descripcion`,_Loterias.`Nombre` from _Jornada,_JornadaStandar,_Loterias where _Loterias.IDL=_Jornada.IDL and _JornadaStandar.`Hora`=_Jornada.`HoraCierre` and _Jornada.id=$s group by _Jornada.id";

        $q = mysqli_query($link, $s);
        $d = mysqli_fetch_array($q);

        $r = $d;



        $dLoteria = $r['Nombre'];
        $dHoraCierre = $r['Descripcion'];
        $IDL = $r['IDL'];
        $Animalito = implode(",", _verAnimalito($idAnimalito, $IDL));
        $infoDataR[] = ["modo" => $value->modo, "monto" => strval($value->monto), "sorteo" => $value->sorteo, "numero" => $value->numero, "info1" => "$dHoraCierre($dLoteria)", "info2" => "$Animalito ($idAnimalito)"]; //, , 
    }

    return json_decode(json_encode($infoDataR));
}

function handler_empac_especial($data)
{

    function specialdata($tempnum, $tempSorteo, $tempMonto)
    {
        $keys = [];
        for ($x = 0; $x < count($tempnum); $x++) {
            $keys[] = "numero" . ($x + 1);
        }
        $bodyNumber = array_combine($keys, $tempnum);
        $rest = ["sorteo" => $tempSorteo, "monto" => $tempMonto, "modo" => 0, "esp" => 1];

        return
            array_merge($bodyNumber, $rest);
    }

    function handlerDataSpc(&$data)
    {
        foreach ($data as $i => $value) {
            $esp = $data[$i]->esp ?? 0;
            switch ($esp) {
                case 1:
                    $n1 = $data[$i]->numero1 ?? '-1';
                    $n2 = $data[$i]->numero2 ?? '-1';
                    $n3 = $data[$i]->numero3 ?? '-1';
                    if ($n1 == '-1' || $n2 == '-1'  || $n3 == '-1') {
                        array_splice($data, $i, 1);
                    }
            }
        }
    }


    $especial = array_column($data, 'esp');
    if (array_search(1, $especial) === false)
        return $data;

    $dataespe = getDataSpecial(1);

    $maxnumber = $dataespe[1];

    $newData = [];
    $tempnum = [];
    $tempMonto = 0;
    $tempSorteo = 0;
    $inic = 0;
    foreach ($data as $i => $value) {
        $esp = $data[$i]->esp ?? 0;

        switch ($esp) {
            case 0:
                if ($inic != 0) {
                    $newData[] = specialdata($tempnum, $tempSorteo, $tempMonto);
                    $tempnum = [];
                    $tempMonto = 0;
                    $tempSorteo = 0;
                    $inic = 0;
                }
                $newData[] = $data[$i];
                break;
            case 1:
                if ($inic == 0) {
                    $tempMonto = $data[$i]->monto;
                    $tempSorteo = $data[$i]->sorteo;
                }
                $tempnum[$inic] = $data[$i]->numero;
                $inic++;
                if ($inic >= $maxnumber) {
                    $newData[] = specialdata($tempnum, $tempSorteo, $tempMonto);
                    $tempnum = [];
                    $tempMonto = 0;
                    $tempSorteo = 0;
                    $inic = 0;
                }
        }
    }

    if ($inic != 0) {
        $newData[] = specialdata($tempnum, $tempSorteo, $tempMonto);
    }


    $newData = json_decode(json_encode($newData));
    handlerDataSpc($newData);
    return $newData;
}

function ToperxJornadaOnlyTRP($IDC, &$data, $IDJ)
{
    global $link, $TYPE_NORMAL;

    function updateTopes($resultjS, $newTotal, $IDC, $IDL, $IDJ)
    {
        global $link;
        if (mysqli_num_rows($resultjS) != 0) {
            mysqli_query($link, "UPDATE _Tope_Suma_TRP set total=$newTotal  Where IDC='" . $IDC . "' and IDL=$IDL and IDJ=" . $IDJ);
        } else {
            mysqli_query($link, "INSERT _Tope_Suma_TRP  (IDC,IDL,IDJ,total) values ('$IDC',$IDL,$IDJ,$newTotal)");
        }
    }
    $Resp = array();
    $dataT = array();
    $Resp[0] = true;
    $sumaTK = array();
    $IDSorteosporIDL = [];

    foreach ($data as $i => $value) {
        $d_esp  = $data[$i]->esp ?? 0;
        if ($d_esp != $TYPE_NORMAL) {
            $resultjSN1 = mysqli_query($link, "SELECT * FROM _Jornada  Where ID=" . $data[$i]->sorteo);
            $rowN1 = mysqli_fetch_array($resultjSN1);
            $IDL =  $rowN1['IDL'];
            if (isset($sumaTK[$IDL])) {
                $sumaTK[$IDL] += $data[$i]->monto ?? 0;
            } else {
                $sumaTK[$IDL]
                    = $data[$i]->monto ?? 0;
            }
            $IDSorteosporIDL[$IDL] = $data[$i]->sorteo;
        }
    }
    foreach ($sumaTK as $IDL => $value) {
        $maximo = -1;
        $tb = '_Concesionario_Ani_2';
        $add = " and IDL=$IDL";
        if ($IDL == 1) {
            $tb = '_Concesionario_Ani';
            $add = "";
        }
        $resultj = mysqli_query($link, "SELECT * FROM $tb  Where IDC='" . $IDC . "' $add");
        if (mysqli_num_rows($resultj) != 0) {
            $row = mysqli_fetch_array($resultj);
            $maximo = $row['iMontMaxTripleta'] == 0 ? -1 : $row['iMontMaxTripleta'];
        }
        $total = 0;
        $resultjS = mysqli_query($link, "SELECT * FROM _Tope_Suma_TRP  Where IDC='" . $IDC . "' and IDL=$IDL and IDJ=" . $IDJ);
        if (mysqli_num_rows($resultjS) != 0) {
            $row = mysqli_fetch_array($resultjS);
            $total = $row['total'];
        }
        $disponible =  $maximo == -1 ? -1 : $maximo - $total;
        if ($sumaTK[$IDL] <= $disponible) {
            $newTotal = $total + $sumaTK[$IDL];
            updateTopes($resultjS, $newTotal, $IDC, $IDL, $IDJ);
        } else {
            $Resp[0] = false;
            $verltt = getLottery($IDL);
            $Resp[1] = 'En los Animalitos de ' . $verltt . ' para la TRIPLETA (el cupo disponible es ' . ($disponible) . ' y se ajusto el ticket a ese monto)';
            $dataT[] = $Resp;
            $IDSorteo =     $IDSorteosporIDL[$IDL];
            foreach ($data as $x => $y)
                if ($data[$x]->sorteo == $IDSorteo && $data[$x]->esp != $TYPE_NORMAL) :
                    if ($disponible == 0)
                        unset($data[$x]);
                    else {
                        if ($data[$x]->monto != 0) {
                            $data[$x]->monto = $disponible;
                            $newTotal = $total + $disponible;
                            updateTopes($resultjS, $newTotal, $IDC, $IDL, $IDJ);
                        }
                    }
                endif;
        }
    }
    return $dataT;
}


function Topes_ByGrupalByxNumero(&$data, $IDG)
{
    global $link, $TYPE_NORMAL;
    mysqli_begin_transaction($link);

    $FIELD_IDL = 4;
    $FIELD_iMontMaxNum = 3;
    $FIELD_iMontSort = 2;

    $Resp = array();
    $dataT = array();
    $Resp[0] = true;
    $SumaxSorteo = [];
    $cacheIDLxIDs = [];

    $resultjSN1 = mysqli_query($link, "SELECT * FROM _Grupos_topes  Where IDG=$IDG ");
    $alldata = mysqli_fetch_all($resultjSN1);

    foreach ($data as $i => $value) {
        $d_esp = $data[$i]->esp ?? 0;
        if ($d_esp == $TYPE_NORMAL) {
            $IDs = $data[$i]->sorteo;
            if (isset($SumaxSorteo[$IDs]))
                $SumaxSorteo[$IDs] += $data[$i]->monto;
            else
                $SumaxSorteo[$IDs] = 0;

            $resultjSN1 = mysqli_query($link, "SELECT * FROM _Jornada  Where ID=" . $IDs);
            $rowN1 = mysqli_fetch_array($resultjSN1);
            $IDL = $rowN1['IDL'];
            $cacheIDLxIDs[$IDs] = $IDL;
            $topeMx = -1;

            foreach ($alldata as $x => $val2) {
                if ($alldata[$x][$FIELD_IDL] == $IDL) {
                    $topeMx = $alldata[$x][$FIELD_iMontMaxNum];
                    break;
                }
            }
            if ($topeMx != -1) {
                $num = $data[$i]->numero;
                $total = 0;
                $resultjSN1 = mysqli_query($link, "SELECT * FROM Topes_xNumero  Where IDG=$IDG and num='$num' and IDs=$IDs");
                if (mysqli_num_rows($resultjSN1) != 0) {
                    $rowN1 = mysqli_fetch_array($resultjSN1);
                    $total = $rowN1['total'];
                }
                $totalv = $data[$i]->monto  + $total;
                if ($totalv > $topeMx) {
                    $dif = $topeMx - $total;
                    if ($dif <= 0) {
                        $Resp[0] = false;
                        $verltt = _verSorteoEsp($IDs);
                        $Resp[1] = 'El Animalito Numero ' . $num . ' del Sorteo de ' . $verltt[0] . ' de ' .  $verltt[1] . '  ya no tiene Cupo disponible';
                        $dataT[] = $Resp;
                        unset($data[$i]);
                        continue;
                    }
                    $data[$i]->monto = $dif;
                    $totalv = $topeMx;
                }
                // echo "Insert Topes_xNumero (IDs,IDG,num,total) values ($IDs,$IDG,'$num',$totalv) ON DUPLICATE KEY UPDATE total=$totalv";
                $resultjSN1 = mysqli_query($link, "Insert Topes_xNumero (IDs,IDG,num,total) values ($IDs,$IDG,'$num',$totalv) ON DUPLICATE KEY UPDATE total=$totalv");
            }
        }
    }
    $tempLengData = count($data);
    foreach ($SumaxSorteo as $IDs => $value) {
        $topeMxSor = -1;

        foreach ($alldata as $x => $val2) {
            if ($alldata[$x][$FIELD_IDL] == $cacheIDLxIDs[$IDs]) {
                $topeMxSor = $alldata[$x][$FIELD_iMontSort];
                break;
            }
        }

        if ($topeMxSor != -1) {
            $total = 0;
            $resultjSN1 = mysqli_query($link, "SELECT * FROM Topes_xSorteo  Where IDG=$IDG and IDs=$IDs");
            if (mysqli_num_rows($resultjSN1) != 0) {
                $rowN1 = mysqli_fetch_array($resultjSN1);
                $total = $rowN1['total'];
            }
            $totalv = $SumaxSorteo[$IDs] + $total;


            if ($totalv > $topeMxSor) {
                $dif = $topeMxSor - $totalv;
                if ($dif <= 0) {
                    $Resp[0] = false;
                    $verltt = _verSorteoEsp($IDs);
                    $Resp[1] = 'Los Animalitos del Sorteo de ' . $verltt[0] . ' de ' .  $verltt[1] . '  ya no tiene Cupo Suficiente para este ticket';
                    $dataT[] = $Resp;
                    foreach ($data as $x => $y)
                        if ($data[$x]->sorteo == $IDs && $data[$x]->esp == $TYPE_NORMAL) :
                            unset($data[$x]);
                        endif;
                    continue;
                }
                $data[$i]->monto = $dif;
                $totalv = $topeMxSor;
            }
            $resultjSN1 = mysqli_query($link, "Insert Topes_xSorteo (IDs,IDG,total) values ($IDs,$IDG,$totalv) ON DUPLICATE KEY UPDATE total=$totalv");
        }
    }
    if (count($data) == $tempLengData) :
        mysqli_commit($link);
    else :
        mysqli_rollback($link);
    endif;

    return $dataT;
}


function verificCountTrackAnimalitos($IDC, $data, $IDJ)
{
    global $link, $TYPE_NORMAL;
    $json = [];
    $sorteos = [];
    $NoGrabar = true;
    $exits = false;
    foreach ($data as $i => $value) {
        $sorteos[] = $data[$i]->sorteo;
    }
    $resultj = mysqli_query($link, "SELECT * FROM _Count_Track  Where IDJ=$IDJ and IDC='$IDC' and IDL in (" . join(',', $sorteos) . ")");
    if (mysqli_num_rows($resultj) != 0) :
        $exits = true;
        while ($row = mysqli_fetch_array($resultj)) {
            $json[$row['IDL']] = unserialize($row['iJson']);
        }
    endif;
    foreach ($data as $i => $value) {
        $d_esp = $data[$i]->esp ?? 0;
        if ($d_esp  != $TYPE_NORMAL) {
            continue;
        }
        $numero = $data[$i]->numero;
        $sorteo = $data[$i]->sorteo;

        if (isset($json[$sorteo])) {

            $vnum = $json[$sorteo];
            if (isset($vnum[$numero])) {
                $vnum[$numero]++;
            } else {
                $vnum[$numero] = 1;
            }
            $json[$sorteo] = $vnum;
            $jData = $json[$sorteo];

            $resultj = mysqli_query($link, "SELECT * FROM _Jornada  Where ID=$sorteo");
            $row = mysqli_fetch_array($resultj);
            $IDL = $row['IDL'];
            $pJgd = 100;
            if ($IDL == 1) :
                $tbl = '_Concesionario_Ani';
                $add = "";
            else :
                $tbl = '_Concesionario_Ani_2';
                $add = " and IDL=" . $IDL;
            endif;
            $resultj = mysqli_query($link, "SELECT * FROM $tbl  Where  IDC='$IDC' $add");
            if (mysqli_num_rows($resultj) != 0) :
                $row = mysqli_fetch_array($resultj);
                $pJgd = $row['iAceptoPorcentaje'];
            endif;
            $resultj = mysqli_query($link, "SELECT * FROM _NumeroAnimatios  Where  activo=1 and IDL=$IDL ");
            $CountData = count($jData) * 100 / mysqli_num_rows($resultj);
            if ($CountData > $pJgd) {
                $NoGrabar = false;
                break;
            }
        } else {
            $vnum = [];
            $vnum[$numero] = 1;
            $json[$sorteo] =  $vnum;
        }

        if (!$NoGrabar) break;
    }
    if ($NoGrabar) {
        // print_r($json);
        foreach ($json as $i => $value) {
            $sorteo = $i;
            $jData = $json[$i];
            if ($exits) {
                $resultj = mysqli_query($link, "Update   _Count_Track  set iJson='" . serialize($jData) . "' Where IDJ=$IDJ and IDC='$IDC' and IDL=$sorteo");
            } else {
                $resultj = mysqli_query($link, "Insert  _Count_Track  values ($sorteo,$IDJ,'$IDC','" . serialize($jData) . "')");
            }
        }
    }

    return $NoGrabar;
}
