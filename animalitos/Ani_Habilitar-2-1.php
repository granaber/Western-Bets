    <?
    for ($x = 0; $x <= $CantiPremios - 1; $x++) { ?>
        <tr>
            <td>
                <p style="font-weight: bold;">
                    <? echo $x + 1; ?>.-Premio(<?= $x + 1 ?>) 1x :
                </p>
            </td>
            <td><input id="iPremio<?= $IDL ?>_<? echo $x + 1; ?>" class="input-habilitar" value="<? echo $iPremio[$x]; ?>" type="text" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iMinimo<?= $IDL ?>') " onkeypress=' return permitebbDUK(event,"num");' /></td>
        </tr>
    <? }
    if ($isActiveTripleta) {
    ?>
        <tr style="background:yellow">
            <td>
                <p style="font-weight: bold;">E1.-Premio(TRP) 1x:</p>
            </td>
            <td><input id="iPremioTripleta<?= $IDL ?>" class=" input-habilitar" value="<? echo $iPremioTripleta; ?>" type="text" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iMaximo<?= $IDL ?>') " onkeypress=' return permitebbDUK(event,"real");' /></td>
        </tr>
        <tr style="background:yellow">
            <td>
                <p style="font-weight: bold;">E2.-Maximo por Jornada(TRP):</p>
            </td>
            <td><input id="iMontMaxTripleta<?= $IDL ?>" class=" input-habilitar" value="<? echo $iMontMaxTripleta; ?>" type="text" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iMaximo<?= $IDL ?>') " onkeypress=' return permitebbDUK(event,"real");' /></td>
        </tr>
    <? } ?>
    <tr>
        <td>
            <p style="font-weight: bold;">2.-Monto Minimo por Numero:</p>
        </td>
        <td><input id="iMinimo<?= $IDL ?>" class="input-habilitar" value="<? echo $iMinimo; ?>" type="text" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iMaximo<?= $IDL ?>') " onkeypress=' return permitebbDUK(event,"real");' /></td>
    </tr>
    <tr>
        <td>
            <p style="font-weight: bold;">3.-Monto Maximo por Numero:</p>
        </td>
        <td><input id="iMaximo<?= $IDL ?>" class="input-habilitar" value="<? echo $iMaximo; ?>" type="text" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iMontSort<?= $IDL ?>') " onkeypress=' return permitebbDUK(event,"real");' /></td>
    </tr>
    <tr>
        <td>
            <p style="font-weight: bold;">4.-Monto Maximo por Sorteo:</p>
        </td>
        <td><input id="iMontSort<?= $IDL ?>" class="input-habilitar" value="<? echo $iMontSort; ?>" type="text" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iAceptoPorcentaje<?= $IDL ?>') " onkeypress=' return permitebbDUK(event,"num");' /></td>
    </tr>
    <tr>
        <td>
            <p style="font-weight: bold;">5.-% de # permitidos vender:</p>
        </td>
        <td><input id="iAceptoPorcentaje<?= $IDL ?>" class="input-habilitar" value="<? echo $iAceptoPorcentaje; ?>" type="number" min="0" max="100" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iPVentas<?= $IDL ?>') " onkeypress=' return permitebbDUK(event,"num");' />
        </td>
    </tr>
    <tr>
        <td>
            <p style="font-weight: bold;">6.-% de Ventas:</p>
        </td>
        <td><input id="iPVentas<?= $IDL ?>" class="input-habilitar" value="<? echo $iPVentas; ?>" type="number" min="0" max="100" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iPremioProx<? echo $row2['IDL']; ?>') " onkeypress=' return permitebbDUK(event,"num");' />
        </td>
    </tr>
    <tr style="display:<?= ($iPremioProx != -1) ? 'contents' : 'none' ?>">
        <td>
            <p style="font-weight: bold;">7.-Premio Aproximación 1x:</p>
        </td>
        <td><input id="iPremioProx<? echo $row2['IDL']; ?>" value="<? echo $iPremioProx; ?>" type="text" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iTkElim') " onkeypress=' return permitebbDUK(event,"num");' /></td>
    </tr>