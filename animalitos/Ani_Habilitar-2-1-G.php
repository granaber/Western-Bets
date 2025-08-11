<tr>
    <td>
        <p style="font-weight: bold;">1.-Monto Maximo por Numero:</p>
    </td>
    <td><input id="iMontMaxNum<?= $IDL ?>" class="input-habilitar" value="<? echo $iMontMaxNum; ?>" type="text" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iMaximo<?= $IDL ?>') " onkeypress=' return permitebbDUK(event,"real");' /></td>
</tr>
<tr>
    <td>
        <p style="font-weight: bold;">2.-Monto Maximo por Sorteo:</p>
    </td>
    <td><input id="iMontSort<?= $IDL ?>" class="input-habilitar" value="<? echo $iMontSort; ?>" type="text" size="10" maxlength="10" onkeyup=" pressSpecialNMDUK(event,'iAceptoPorcentaje') " onkeypress=' return permitebbDUK(event,"num");' /></td>
</tr>