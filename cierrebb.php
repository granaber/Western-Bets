<style type="text/css">
.shadowcontainerx {
    width: 380px;
    /* container width*/
    background-color: #d1cfd0;
}

.shadowcontainerx .innerdivx {
    /* Add container height here if desired */
    background-color: white;
    border: 1px solid gray;
    padding: 6px;
    position: relative;
    left: -5px;
    /*shadow depth*/
    top: -5px;
    /*shadow depth*/
}
</style>
<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$idj = $_REQUEST["idj"];
$dp = $_REQUEST['dp'] ?? 0;



?>
<div id="box5">
    <div id="n_idc" align="center" title="<?php echo $idj; ?>" style="font-size:16px; background:#FFCC00"><strong>
            Jornada Numero: </strong><?php echo $idj; ?>&nbsp;|&nbsp;&nbsp;Hora Actual:<span id='horaser'
            style="font-size:16px; background:#FFCC00"></span><img id="dbj"
            src="media/proceso.gif" />&nbsp;|&nbsp;&nbsp;<input id="btn" type="button" lang="1" value="Parar Cierre"
            onclick="btnstop();" /></div>
    <table border="0" cellpadding="0" cellspacing="5">

        <tr>
            <?
            set_time_limit(5000);
            $n = 1;
            $jnd = mysqli_query($GLOBALS['link'], "SELECT Grupo From _jornadabb where  IDJ=$idj  ");

            while ($jndMain = mysqli_fetch_array($jnd)) {
                $resultgrupo = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where Grupo=" . $jndMain['Grupo']);
                $rowgrupo = mysqli_fetch_array($resultgrupo);
                $resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDJ=" . $idj . " and Grupo=" . $jndMain['Grupo'] . " Order by IDP");
                $i = 1;
                if (mysqli_num_rows($resultp) != 0) :
                    $cant = mysqli_num_rows($resultp);
                    while ($rowp = mysqli_fetch_array($resultp)) {
                        $eq1[$i] = $rowp["IDE1"];
                        $eq2[$i] = $rowp["IDE2"];
                        $hrx[$i] = $rowp["Hora"];
                        $idp[$i] = $rowp["IDP"];
                        $i++;
                    }
                endif;
                if ($i != 1) :

            ?>

            <td>
                <div id="boxc<? echo $n; ?>" style="background: #333333">
                    <div align="center" style="background: #68A0E6; color:#FFFFFF; font-size:14px"><strong>
                            <? echo $rowgrupo['Descripcion']; ?>
                        </strong></div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td bgcolor="#FFFFFF">
                                <div align="center"><strong>Est.</strong></div>
                            </td>
                            <td bgcolor="#FFFFFF">
                                <div align="center"><strong>N.P</strong></div>
                            </td>
                            <td bgcolor="#FFFFFF">
                                <div align="center"><strong>Hora<br />(HH:MM) </strong></div>
                            </td>
                            <td bgcolor="#FFFFFF">
                                <div align="center"><strong>Equipo(1)</strong></div>
                            </td>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                            <td valign="bottom" bgcolor="#FFFFFF">
                                <div align="center"><strong>Equipo(2)</strong></div>
                            </td>
                            <td bgcolor="#FFFFFF">
                                <div align="center"><strong>Cierre</strong></div>
                            </td>
                            <?php
                                    /*  */
                                    $n++;
                                    for ($i = 1; $i <= $cant; $i++) {
                                        if (($i % 2) == 0) :
                                            $bkcolor = "#999999";
                                        else :
                                            $bkcolor = "#333333";
                                        endif;

                                        echo  '<tr bgcolor="' . $bkcolor . '"><td ><img id="img2_' . $idp[$i] . '" src="media/estrella.png"  lang="0" height="16" width="16"/>  </div></td> ';

                                        echo '<td > <div id="cuatro_' . $idp[$i] . '" align="left" style="color:#FFFFFF">&nbsp;' . $idp[$i] . '&nbsp;</div><td align="left">';
                                        $fho = explode(':', $hrx[$i]);
                                        if (count($fho) != 1) :
                                            if ($fho[0] < 12) :
                                                $ann = 'a';
                                            endif;
                                            if ($fho[0] == 12) :
                                                $ann = 'm';
                                            endif;
                                            if ($fho[0] > 12) :
                                                $ann = 'p';
                                                $horr = $fho[0] - 12;
                                            else :
                                                $horr = $fho[0];
                                            endif;
                                            $aa = $horr . ':' . $fho[1] . $ann;
                                        else :
                                            $aa = '';
                                        endif;
                                        echo '<div id="uno_' . $idp[$i] . '"  style="font-size:12px; color:#FFCC00"><strong>' . $aa . '</strong></div>';
                                        echo '<td ><div  id="dos_' . $idp[$i] . '"  align="left" style="color:#FFFFFF"><strong>';
                                        $thisEqui = array();
                                        $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb  where IDE in (" . $eq1[$i] . "," . $eq2[$i] . ") order by IDE");
                                        while ($row = mysqli_fetch_array($result)) {
                                            $thisEqui[$row["IDE"]] = $row["Descripcion"];
                                        }
                                        echo $thisEqui[$eq1[$i]];
                                        $n = $i + $cant;
                                        echo ' </strong></div></td> <td><div align="left" style="color:#FFFFFF"><strong>&nbsp;&nbsp;</strong></div></td>          <td ><div id="tres_' . $idp[$i] . '"  align="left" style="color:#FFFFFF"><strong>';
                                        echo $thisEqui[$eq2[$i]];

                                        // $result = mysqli_query($GLOBALS['link'],"SELECT * FROM _equiposbb order by IDE");

                                        // while ($row = mysqli_fetch_array($result)) {
                                        //     if ($eq2[$i] == $row["IDE"]) {
                                        //         echo $row["Descripcion"];
                                        //     }
                                        // }
                                        echo '</strong></div></td>';
                                        $resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrebb where IDJ=" . $idj . " and IDP=" . $idp[$i] . " and Grupo=" . $jndMain['Grupo']);
                                        if (mysqli_num_rows($resultp) != 0) :
                                            echo '<td ><div align="center"><img id="img_' . $idp[$i] . '" src="media/lock.png" lang="0" onclick="cierrebb(event,' . $idp[$i] . ',' . $rowgrupo['Grupo'] . ')" />  </div></td>';
                                        else :
                                            echo '<td ><div align="center"><img id="img_' . $idp[$i] . '" src="media/unlock.png" lang="1" onclick="cierrebb(event,' . $idp[$i] . ',' . $rowgrupo['Grupo'] . ')" /> </div></td>';
                                        endif;
                                    }
                                    ?>
                    </table>
                </div>
                <p></p>
            </td>
            <?
                endif;
            } ?>
        </tr>
    </table>
</div>
<script>
Nifty('div#box5', 'big');
cierreauto(1, <?= $idj; ?>);
for (i = 1; i <= <?= ($n - 1); ?>; i++) {
    Nifty('div#boxc' + i, 'big');
}
</script>