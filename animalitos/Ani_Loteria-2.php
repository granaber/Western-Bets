<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();
$IDL = $_REQUEST['IDL'];
$Nombre = '';
$Icono = '';
$activo = 0;
$AutoSorteo = '-1';
$Code = '';
$minimalNumber = 0;
$procentajeSplit = 0;
if ($IDL == 0) :
    $resultj = mysqli_query($link, "SELECT * FROM _Loterias  ORDER BY IDL DESC ");
    if (mysqli_num_rows($resultj) == 0) :
        $IDL = 1;
    else :
        $row = mysqli_fetch_array($resultj);
        $IDL = $row['IDL'] + 1;
    endif;
else :
    $resultj = mysqli_query($link, "SELECT * FROM _Loterias  Where IDL=$IDL");
    //echo ("SELECT * FROM _Concesionario_Ani  Where IDC='$IDC'");;
    if (mysqli_num_rows($resultj) != 0) :
        $row = mysqli_fetch_array($resultj);
        $Nombre = $row['Nombre'];
        $Icono = $row['logo'];
        $activo = $row['Activa'];
        $AutoSorteo = $row['xFun'];
        $Code = $row['Code'];
        $minimalNumber = $row['minimalNumber'];
        $procentajeSplit = $row['procentajeSplit'];
    endif;
endif;
?>
<table border="0">
    <tr>
        <td align="right">
            <p style="font-weight: bold;font-size:12px;color:red">Numero:</p>
        </td>
        <td>
            <p id="IDL" lang="<? echo $IDL; ?>" style="font-weight: bold;font-size:12px;color:red">00000
                <? echo $IDL; ?>
            </p>
        </td>
    </tr>
    <tr>
        <td align="right">
            <p style="font-size:12px"><input id="activo" type="checkbox" value="" <? echo ($activo == 1 ? 'checked' : ''); ?> />&nbsp;Habilitar</p>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <p style="font-weight: bold;">Nombre:</p>
        </td>
        <td><input id="Nombre" value="<? echo $Nombre; ?>" type="text" size="30" maxlength="30" onkeyup=" pressSpecialNMDUK(event,'AutoSorteo') " onkeypress=' return permitebbDUK(event,"car");' />
        </td>
    </tr>
    <tr>
        <td>
            <p style="font-weight: bold;">Forma de Sorteo:</p>
        </td>
        <td>
            <select id="AutoSorteo">
                <option value="0" <? echo ($AutoSorteo == '0' ? "selected='selected'" : ''); ?>>Automatico</option>
                <option value="1" <? echo ($AutoSorteo == '1' ? "selected='selected'" : ''); ?>>Captura Skynet</option>
                <option value="-1" <? echo ($AutoSorteo == '-1' ? "selected='selected'" : ''); ?>>Manual</option>
                <option value="2" <? echo ($AutoSorteo == '2' ? "selected='selected'" : ''); ?>>Interno</option>
                <option value="3" <? echo ($AutoSorteo == '3' ? "selected='selected'" : ''); ?>>Calculado</option>
            </select>
            Configuracion: <input id="Code" value="<?= $Code ?>" type="text" size="8" maxlength="8" />
        </td>
    </tr>
    <tr>
        <td colspan=" 2">
            <div id="forAutoSorteo" style="<?= $AutoSorteo == '3' ? "" : " display: none;" ?>">
                <div style=" margin-top:5px">
                    <label for="minimalNumber" style="font-weight: bold;">Cantidad de Numeros para activar el
                        escrute</label>
                    <input id="minimalNumber" value="<? echo $minimalNumber; ?>" type="text" size="3" maxlength="3" />
                </div>
                <div style=" margin-top:5px">
                    <label for="procentajeSplit" style="font-weight: bold;">% a Repartir</label>
                    <input id="procentajeSplit" value="<? echo $procentajeSplit; ?>" type="text" size="3" maxlength="3" />
                </div>
            </div>
        </td>
    </tr>
</table>

<script>
    $('AutoSorteo').addEventListener("change", function(e) {

        const x = Number(e.target.value);
        if (x == 3) {
            $('forAutoSorteo').style.display = 'block';
        } else {
            $('forAutoSorteo').style.display = 'none';
        }
    });
</script>