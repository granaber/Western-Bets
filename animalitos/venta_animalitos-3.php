<table border="0" cellspacing="0" style="background:#34495e " width='300px' height='50px'>
  <tr>
    <td ><strong><span  id="TxtNumero" style="font-size:14px;color:#FFFFFF" lang="1">Numero:</span></strong></td>
    <td  ><strong><span  id="TxtPago" style="font-size:14px;color:#FFFFFF" lang="1">Monto:</span></strong></td>
  </tr>
  <tr>
    <td><input id='ImpNumero' value='' onkeypress=' return permitebbDUK(event,"num");' onkeyup=" pressSpecialDUK(event,'ImpMonto',0) "></td>
    <td><input id='ImpMonto' value='' onkeypress=' return permitebbDUK(event,"real");' onkeyup="pressSpecialDUK(event,'Imprimir',1)"></td>
  </tr>
 </table>
