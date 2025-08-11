<?
include "prc_php.php";
$GLOBALS['link'] = Connection::getInstance();

$serial = array(5506077, 5506078, 5506115, 5506119, 5506123, 5506125, 5506143, 5506156, 5506169, 5506174, 5506194, 5506197, 5506207, 5506217, 5506226, 5506233, 5506250, 5506255, 5506261, 5506264, 5506265, 5506267, 5506270, 5506274, 5506278, 5506288, 5506307, 5506308, 5506310, 5506314, 5505923, 5505928, 5505932, 5505937, 5505938, 5505940, 5505953, 5505954, 5505959, 5505968, 5505971, 5505984, 5505996, 5506001, 5506008, 5506012, 5506014, 5506017, 5506044, 5506064, 5506066, 5506068, 5506073, 5505918, 5505921);

//10-3%|-160*9-3%|-120*28-5%-1.5|-145*2-5%-1.5|+115*30-5%-1.5|-0*18-5%-1.5|+115*25-5%-1.5|-175*


for ($i = 0; $i <= count($serial) - 1; $i++) {
    $resultjj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb where serial=" . $serial[$i]);
    if (mysqli_num_rows($resultjj) != 0) :
        $row2 = mysqli_fetch_array($resultjj);
        $jud = $row2['Jugada'];
        $jgdad = explode('*', $jud);
        for ($j = 0; $j <= count($jgdad) - 2; $j++) {

            $opcion = explode('|', $jgdad[$j]);
            $logro = $opcion[1];
            $opcion1 = explode('%', $opcion[0]);
            $carr = $opcion1[1];
            $opcion2 = explode('-', $opcion1[0]);
            $equi = $opcion2[0];
            $iddd = $opcion2[1];
            // echo   $serial[$i].' '.$equi.'-'.   $iddd.'<br>' ;
            if ($equi == 30 && $iddd == 5) :
                $jgdad[$j] = '30-5%+1.5|-0';
                break;
            endif;
        }
        $vlr = join('*', $jgdad);
    //echo $serial[$i].' '. $vlr.'<br>' ;

    endif;
    echo ("Update  _tjugadabb set Jugada='" . $vlr . "',recalculo=1 where serial=" . $serial[$i] . ';');
    $resultjj2 = mysqli_query($GLOBALS['link'], "Update  _tjugadabb set Jugada='" . $vlr . "',recalculo=1 where serial=" . $serial[$i]);
}
//8-5%-1.5|+125*28-5%-1.5|-145*2-5%-1.5|+115*30-5%1.5|-130*25-5%-1.5|-175*
//8-5%-1.5|+125*28-5%-1.5|-145*2-5%-1.5|+115*30-5%1.5|-130*25-5%-1.5|-175*
//8-5%-1.5|+125*28-5%-1.5|-145*2-5%-1.5|+115*30-5%-1.5|-0*25-5%-1.5|-175*
