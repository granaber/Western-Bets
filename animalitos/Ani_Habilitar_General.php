<table border="0" style="
    width: 100%;
    margin: 8px 2px;
    background: #ccc;
">
    <tr>
        <td>
            <p style="font-weight: bold;;padding-top: 3px">
                Para los Grupos:
            </p>
        </td>
        <td>
            <div name="idgrupo" id="idgrupo"></div>
            <?
            include "./prc_phpDUK.php";
            $link = ConnectionAnimalitos::getInstance();
            global $serverD;
            global $userD;
            global $clvD;
            global $dbD;
            $linkMain = mysqli_connect($serverD, $userD, $clvD, $dbD);

            $result = mysqli_query($linkMain, "SELECT * FROM _tgrupo where Estatus=1;  ");
            $list = [];
            $ids = [];
            while ($row = mysqli_fetch_array($result)) {
                $list[] = $row["IDG"] . '-' . $row["Descrip"];
                $ids[] = $row["IDG"];
            ?>

            <? } ?>
        </td>
    </tr>
    <tr>
        <td>
            <p style="font-weight: bold;;padding-top: 3px">
                Aplicar a:
            </p>
        </td>
        <td>
            <select class="select-habilitar" id="aplicar-to-lotter">
                <?

                $result = mysqli_query($link, "SELECT * FROM _Loterias where Activa=1   ");

                while ($row = mysqli_fetch_array($result)) {

                ?>
                    <option value="<?= $row['IDL'] ?>"><?= $row['Nombre'] ?></option>
                <? } ?>
            </select>
        </td>
    </tr>
    <?
    $iPremioTripleta = "";
    $iMontMaxTripleta = "";
    $iPremioProx = "";
    $iMinimo = "";
    $iMaximo = "";
    $iPremioProx = "";
    $iMontSort = "";
    $isActiveTripleta = true;
    $IDL = 'G';
    $CantiPremios = 3;
    $iPremio = ['', '', ''];
    include './Ani_Habilitar-2-1.php';

    ?>

    <tr>
        <td colspan="2" style="height: 55px;padding-top: 10px;">
            <label style="font-weight: bold;color:red">*</label>
            <h4 style="display:inline;">Si deja el espacio en BLANCO en el casilla, no se actualizara en la
                configuración de ningún punto
                de
                venta
            </h4>
        </td>
    </tr>
</table>
<script>
    var lg = "<?= join(",", $list) ?>";
    var idst = '<?= join(",", $ids); ?>';
    var pvalores = lg.split(',');
    var pids = idst.split(',');

    z2 = new dhtmlXCombo("idgrupo", "alfa3", 200, 'checkbox');
    valor = '';
    var valores = [];
    for (i = 0; i <= pvalores.length - 1; i++) {
        var valor = [];
        valor[0] = pids[i];
        valor[1] = pvalores[i];
        valores[i] = valor;
    }
    z2.addOption(valores);
</script>