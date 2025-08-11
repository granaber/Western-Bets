<?
$add = "";
if (isset($_REQUEST['idb'])) {
    require_once("prc_php.php");
    $GLOBALS['link'] = Connection::getInstance();
    $idb = $_REQUEST['idb'];
    $accesogp = $_REQUEST['accesogp'];
    $add =  $idb == 0 ? "" : " and IDB=$idb";
}


if ($accesogp == 0) : ?>
<samp> Indique el Grupo:</samp>
<select class="select-pv-standard" name="select" id="grupos">
    <option value="0">Todos</option>
    <?php

        $result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where 1  $add ");
        while ($row3 = mysqli_fetch_array($result3))
            echo "<option  value='" . $row3["IDG"] . "'>" . $row3["IDG"] . '-' . $row3['Descrip'] . "-" . $row3['IDB'] . "</option>";

        ?>
</select>
<? else : ?>
<input id="grupos" size="10" value="0" style="display:none" />
<? endif; ?>