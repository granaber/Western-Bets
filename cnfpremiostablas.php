<div id="box2" style="background: #385B96; width:445px">


<table border="0">
  <tr>
    <th scope="row">
            <span style="color: #0099CC">Cantidad de Ejemplares:</span>
            <input  id="CantidaEje" type="text" size="4" maxlength="10"  />
            <span style="color: #0099CC">%:</span>
            <input id="Porcentaje" type="text" size="4" maxlength="10"/>
            <span style="color: #0099CC">Premio:</span>
            <input  id="Premio" type="text" size="3" maxlength="10"/>
            <img src="media/edit_icon.gif" alt=""  onclick="grabar_cnf1(6,'CantidaEje.value|Porcentaje.value|Premio.value','_tcnftablaspor',true);makeResultwin2('cnfpremiostablas-1.php?op=2','esckk');$('CantidaEje').value='';$('Porcentaje').value='';$('Premio').value='';"/><br />
            <div id="esckk">
              <? include('cnfpremiostablas-1.php'); ?>
    </div></th>
  </tr>
</table>
</div>
