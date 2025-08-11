
<div id="box1" style="background: #4179E0;">
  <table width="200" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        <table align="center" class="ta_encab">
          <tbody>
            <tr class="ta_encab_tr">
              <td align="center" ><div align="center" style="color:#FC0; font-size:16px">Configuracion</div></td>
            </tr>
          </tbody>
        </table><div id='busq' >
        <p style="color:#FFF; font-size:12px">Buscar Configuracion</p>
        <table border="0" cellpadding="0" cellspacing="0" width="750">
          <tbody>
            <tr>
              <td width="9%" valign="middle" ><span style="color:#FFF; font-size:10px">Fecha:</span></td>
              <td width="20%" valign="middle"><label>
                <input type="text" name="fc" id="fc"   onFocus="cargarcampos();" />
              </label>
                </td>
              <td width="5%" valign="middle" > </td>

   
              <td width="14%"><label>
                <input type="submit" name="button" id="button" value="Buscar" onClick="makeResEsp('jornada-1-1.php','parametrodeconfigu')"/>
              </label></td>
              <td width="52%"><input type="submit" name="button2" id="button2" value="Agregar" onClick="makeResEsp('jornada-1.php','parametrodeconfigu')" /></td>
            </tr>
          </tbody>
        </table></div>

       
        <div id='parametrodeconfigu'></div></td> 
    </tr>
  </table>
</div>  
 <div id='tabladeconfiguracion'></div>


<script> 
  Nifty('div#box1'); 
</script>