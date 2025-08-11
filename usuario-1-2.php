<?php

require 'prc_php.php';
$GLOBALS['link'] = Connection::getInstance();
$pr = $_REQUEST['pr'];

$autorizadoparaAdmin = true;
// $nivel = $_COOKIE['rndusr'];
// echo ("Select * from _tusu where bloqueado=" . $nivel);
// $result = mysqli_query($GLOBALS['link'],"Select * from _tusu where bloqueado=" . $nivel);
// if (mysqli_num_rows($result) != 0) :
//     $row = mysqli_fetch_array($result);
//     if ($row['IDusu'] == 2) {
//         $autorizadoparaAdmin = true;
//     }

// endif;

if ($pr == 1) :
    $nm = $_REQUEST['nm'];
    $us = $_REQUEST['us'];
    $est = $_REQUEST['est'];
    $clv = $_REQUEST['clv'];
    $tp = $_REQUEST['tp'];
    $as = $_REQUEST['as'];
    $es = $_REQUEST['es'];
    $idu = $_REQUEST['idu'];
    $ta = $_REQUEST['ta'];
    $v = $_REQUEST['v'];
    $v2 = $_REQUEST['v2'];
    $agrupo = $_REQUEST['agrupo'];
    $abanca = $_REQUEST['abanca']; //mysql_real_escape_string()

    if ($as == '') {
        $as = '-2';
    }

    settype($idu, 'integer');
    $result = mysqli_query($GLOBALS['link'], "Select * from _tusu where IDusu=" . $idu);
    if (mysqli_num_rows($result) == 0) :
        $error = 0;
        if ($clv == '') :
            $error = 1; // Clave Vacia CLAVE NO GENERADA
        endif;
        if ($error == 0) :
            $result = mysqli_query($GLOBALS['link'], "Select * from _tusu where Usuario='$us'");

            if (mysqli_num_rows($result) == 0) :
                if ($tp != 3) {
                    if ($autorizadoparaAdmin) {
                        $result = mysqli_query($GLOBALS['link'], "INSERT INTO _tusu (IDusu,Estacion,Descripcion,clave,Usuario,Asociado,Estatus,Nombre,Acceso,Tipo,AccesoP,AGrupo,lastactivity,ABanca)  VALUES (" . $idu . "," . $est . ",'','" . $clv . "','" . $us . "','" . $as . "'," . $es . ",'" . $nm . "','" . $v . "'," . $tp . ",'" . $v2 . "','" . $agrupo . "',0,$abanca)");
                    } else {
                        $result = false;
                    }
                } else {
                    $result = mysqli_query($GLOBALS['link'], "INSERT INTO _tusu (IDusu,Estacion,Descripcion,clave,Usuario,Asociado,Estatus,Nombre,Acceso,Tipo,AccesoP,AGrupo,lastactivity,ABanca)  VALUES (" . $idu . "," . $est . ",'','" . $clv . "','" . $us . "','" . $as . "'," . $es . ",'" . $nm . "','" . $v . "'," . $tp . ",'" . $v2 . "','" . $agrupo . "',0,$abanca)");
                }

                Logs($_REQUEST['idt'], -1, 'Creacion de Usuarios ' . $nm, 1);
                if (!$result) :
                    $error = 2; // Error al Grabar en la Base de Datos
                endif;

            else :
                $error = 3; //El USUARIO EXISTE
            endif;
        endif;

    else :
        $error = 0;
        $row = mysqli_fetch_array($result);
        if ($ta == 1) :
            $cf = 0;
        else :
            $cf = $row['bloqueado'];
        endif;

        if ($clv == '') :
            if ($tp != 3) {
                if ($autorizadoparaAdmin) {
                    $result = mysqli_query($GLOBALS['link'], "Update _tusu  Set ABanca=$abanca, Agrupo='" . $agrupo . "',Nombre='" . $nm . "',Usuario='" . $us . "',Estatus=" . $es . ",Estacion=" . $est . ",Asociado='" . $as . "',Tipo=" . $tp . ",Acceso='" . $v . "',AccesoP='" . $v2 . "' where IDusu=" . $idu);
                } else {
                    $result = false;
                }
            } else {
                $result = mysqli_query($GLOBALS['link'], "Update _tusu  Set ABanca=$abanca, Agrupo='" . $agrupo . "',Nombre='" . $nm . "',Usuario='" . $us . "',Estatus=" . $es . ",Estacion=" . $est . ",Asociado='" . $as . "',Tipo=" . $tp . ",Acceso='" . $v . "',AccesoP='" . $v2 . "' where IDusu=" . $idu);
            }
        else :
            if ($tp != 3) {
                if ($autorizadoparaAdmin) {
                    $result = mysqli_query($GLOBALS['link'], "Update _tusu  Set ABanca=$abanca,Agrupo='" . $agrupo . "',Nombre='" . $nm . "',Usuario='" . $us . "',Estatus=" . $es . ",clave='" . $clv . "',Estacion=" . $est . ",Asociado='" . $as . "',Tipo=" . $tp . ",Acceso='" . $v . "',AccesoP='" . $v2 . "' where IDusu=" . $idu);
                } else {
                    $result = false;
                }
            } else {
                $result = mysqli_query($GLOBALS['link'], "Update _tusu  Set ABanca=$abanca,Agrupo='" . $agrupo . "',Nombre='" . $nm . "',Usuario='" . $us . "',Estatus=" . $es . ",clave='" . $clv . "',Estacion=" . $est . ",Asociado='" . $as . "',Tipo=" . $tp . ",Acceso='" . $v . "',AccesoP='" . $v2 . "' where IDusu=" . $idu);
            }
        endif;

        Logs($_REQUEST['idt'], -1, 'Modificacion de Usuarios ' . $nm, 1);
        if (!$result) :
            $error = 2; // Error al Grabar en la Base de Datos
        endif;

    endif;

    if ($error == 0) :
        switch ($tp) {
            case 1:
                $sql = "Select * from _tusu where Tipo=2 and IDusu!=" . $idu;
                break;
            case 2:
                $sql = "Select * from _tusu where  IDusu!=" . $idu;
                break;
            case 3:
                $sql = "Select * from _tusu where Tipo=2 and IDusu!=" . $idu; /// Debo hacer Doble Consulta
                break;
            case 4:
                $sql = "Select _tusu.* from _tusu where  IDusu!=" . $idu . " and Asociado in (Select IDC From _tconsecionario Where IDG in (" . $agrupo . "))";

                break;
            case 5:
                $sql = "Select * from _tusu where  IDusu!=" . $idu;
                break;
        }
        // echo $sql;
        $result = mysqli_query($GLOBALS['link'], $sql);
        while ($rowg = mysqli_fetch_array($result)) {
            $result1 = mysqli_query($GLOBALS['link'], "Select * from userlist where userid=" . $idu . " and relationid=" . $rowg['IDusu']);
            if (mysqli_num_rows($result1) == 0) :
                $result2 = mysqli_query($GLOBALS['link'], "INSERT userlist VALUES (" . $idu . "," . $rowg['IDusu'] . ",'yes')");
                $result2 = mysqli_query($GLOBALS['link'], "INSERT userlist VALUES (" . $rowg['IDusu'] . "," . $idu . ",'yes')");
            endif;
        }
        if ($tp == 3) :
            $result = mysqli_query($GLOBALS['link'], "Select * from _tusu where  Asociado in (Select IDC From _tconsecionario Where IDG=" . $agrupo . ")");

            while ($rowg = mysqli_fetch_array($result)) {
                $result1 = mysqli_query($GLOBALS['link'], "Select * from userlist where userid=" . $idu . " and relationid=" . $rowg['IDusu']);
                if (mysqli_num_rows($result1) == 0) :
                    $result2 = mysqli_query($GLOBALS['link'], "INSERT userlist VALUES (" . $idu . "," . $rowg['IDusu'] . ",'yes')");
                    $result2 = mysqli_query($GLOBALS['link'], "INSERT userlist VALUES (" . $rowg['IDusu'] . "," . $idu . ",'yes')");
                endif;
            }
        endif;
    endif;
    if ($error == 0) :
        $resultado[] = true;
    else :
        $resultado[] = false;
        $resultado[] = $error;
    endif;
    echo json_encode($resultado);

else :

    $idu = $_REQUEST['idu'];
    $result = mysqli_query($GLOBALS['link'], 'Delete from _tusu  where IDusu=' . $idu);
    Logs($_REQUEST['idt'], -1, 'Borrado de Usuarios ' . $idu, 1);
    $resultado[] = $result;
    echo json_encode($resultado);

endif;

//echo "$result = mysqli_query($GLOBALS['link'],'Delete from _tcusu  where IDusu='.$idu);