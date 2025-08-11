<?
header("Content-type:text/xml");
require_once('prc_phpDUK.php');
global $serverD;
global $userD;
global $clvD;
global $dbD;
$link = mysqli_connect($serverD, $userD, $clvD, $dbD);

$iGrupo = $_REQUEST['IDG'];

echo '<?xml version="1.0"?>';
echo '<toolbar>';
echo '
    <item id="Cerrar_" type="button" img="animalitos/icons/noun_1042920_cc.png"
        imgdis="animalitos/icons/noun_1042920_cc.png" text="Cerrar" />';
echo '
    <item id="Anular_" type="button" img="animalitos/icons/noun_145187_cc.png"
        imgdis="animalitos/icons/noun_145187_cc.png" text="Anular Ticket" />';
echo '
    <item id="ImpCopy_" type="button" img="animalitos/icons/noun_926248_cc.png"
        imgdis="animalitos/icons/noun_926248_cc.png" text="Imprimir Copia" />';
echo '
    <item id="" type="separator" />';
echo ' <item id="Grupo_" type="buttonSelect" img="animalitos/icons/noun_737661_cc.png"
        imgdis="animalitos/icons/noun_737661_cc.png" text="Grupo:">';
if ($iGrupo == 0) :
    echo '
        <item type="button" id="All" text="Todos" img="animalitos/icons/csh_vista/noun_737678_cc.png" />';
    $resultj = mysqli_query($link, "SELECT * FROM _tgrupo Where Estatus=1");
else :
    $resultj = mysqli_query($link, "SELECT * FROM _tgrupo Where Estatus=1 and IDG in (" . $iGrupo . ")");
endif;
while ($row = mysqli_fetch_array($resultj)) {
    echo '
        <item type="button" id="G-' . $row['IDG'] . '-' . $row['Descrip'] . '"
            text="' . $row['IDG'] . '-' . $row['Descrip'] . '" img="animalitos/icons/csh_vista/noun_737678_cc.png" />';
}
echo '
    </item>';
echo '
    <item id="IDse" type="text" text="Todos" />';
echo ' <item id="Loterias_" type="buttonSelect" img="animalitos/icons/csh_vista/noun_28078_cc.png"
        imgdis="animalitos/icons/csh_vista/noun_28078_cc.png" text="Loterias:">';

echo '
        <item type="button" id="AllLot" text="Todos" img="animalitos/icons/csh_vista/noun_28078_cc.png" />';
$link = ConnectionAnimalitos::getInstance();
$resultj2 = mysqli_query($link, "SELECT * FROM _Loterias ");
while ($row2 = mysqli_fetch_array($resultj2)) {
    echo '
        <item type="button" id="L-' . $row2['IDL'] . '-' . str_replace(" -", "|", $row2['Nombre']) . '" text="' .
        $row2['IDL'] . '-' . $row2['Nombre'] . '"
            img="animalitos/icons/csh_vista/noun_28078_cc.png" />';
}
echo '
    </item>';
echo '
    <item id="IDlot" type="text" text="Todos" />';
echo '
</toolbar>';
