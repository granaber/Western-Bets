<?php

$tp = $_REQUEST['tp'];

if ($tp == 1) :
    require_once('prc_php.php');
    $GLOBALS['link'] = Connection::getInstance();

    $result2 = mysqli_query($GLOBALS['link'], "START TRANSACTION");
    $result2 = mysqli_query($GLOBALS['link'], "SELECT N_x  FROM _conteo Where Modulo='Ticket' FOR UPDATE");
    $result2 = mysqli_query($GLOBALS['link'], "UPDATE _conteo SET N_x = LAST_INSERT_ID(N_x + 1) Where Modulo='Ticket'");
    $result2 = mysqli_query($GLOBALS['link'], "SELECT LAST_INSERT_ID() as N_x;");
    $row2 = mysqli_fetch_array($result2);
    $result2 = mysqli_query($GLOBALS['link'], "COMMIT");

    $tik = $row2["N_x"];
    echo json_encode($tik);
endif;

if ($tp == 2) :
    echo date("d/m/y") . '||' . date("H:i:s");
endif;
