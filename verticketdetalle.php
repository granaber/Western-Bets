<div id="box16" style="width:300px; background: #036;    border-radius: 6px;margin-bottom:10px">
  <section>
    <h2 style="    
      color: #fff;
      font-size: 16px;
      text-align: center;">
      Verificación de Ticket
    </h2>
    <div style="    
        margin-top: 16px;
        display: flex;
        gap: 10px;
        flex-wrap: nowrap;
        align-items: center">
      <h3 style="color:yellow;font-size:14px">Serial</h3>
      <input id='ticket_buscr' type="text" class="input-pv-standard" style="width:118px" />
      <input placeholder="SERIAL" class="button-pv-standard" name="input" type="button" value="Buscar" onclick="if ($('ticket_buscr').value!='') {OpcionVerificarPublica($('ticket_buscr').value);}else{alert('Disculpe debe colocar el Numero de Ticket!');}" />
    </div>
  </section>


</div>
<div align="center">
  <table width="200" border="0" align="center">
    <tr>
      <td align="center">
        <div id="resultados" align="center" style="font-size:14px; background:#fbf9f9;width:300px;padding: 12px 5px;border-radius: 6px;">



        </div>
      </td>
    </tr>
  </table>
  <div>
    <script>
      ENTER = 13
      ESCAPE = 27
      e = $('ticket_buscr')
      e.addEventListener('keyup', function(e) {
        const t = e.keyCode
        if (t === ENTER) {
          OpcionVerificarPublica($('ticket_buscr').value)
        }
        if (t === ESCAPE) {
          $('ticket_buscr').value = ''
          $('resultados').innerHTML = ''
        }
      })
    </script>