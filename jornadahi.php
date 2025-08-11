
<div id="box8" align="left" style="background:#333333"; style="width:1900px; height:1900px;">
  <table  border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td>
        <table align="center" >
          <tbody>
            <tr >
              <td align="center" ><div align="center" style="color:#FFFFFF; font-size:16px"><strong>Configuracion</strong></div></td>
            </tr>
          </tbody>
        </table>
        <div id='busq' >
        <p  style="color:#FFCC00">Buscar Configuracion</p>
        <table  border="0" cellpadding="0" cellspacing="0" width="750">
          <tbody>
            <tr >
              <td  valign="middle" ><span  style="color:#FFFFFF; font-size:14px">Fecha:</span></td>
              <td  valign="middle"><label>
                <input type="text" name="fc" id="fc"   onFocus="cargarcampos();" />
              </label>
                <span class="Estilo35"><span class="Estilo36"><span class="Estilo39"></span></span></span></td>
           

   
              <td  ><label>
                <input type="submit" name="button" id="button" value="Buscar" onClick="makeResEsphi('jornada-1-1hi.php','parametrodeconfigu')"/>
              </label></td>
              <td ><input type="submit" name="button2" id="button2" value="Agregar" onClick="makeResEsphi('jornada-1hi.php','parametrodeconfigu')" /></td>
            </tr>
          </tbody>
        </table></div>
        <p>
          <legend ></legend>
        <div id='parametrodeconfigu'></div></td> 
    </tr>
  </table>
</div>  
  <div id='tabladeconfiguracion'></div>

<script type="text/javascript">
Nifty('div#box8');
</script>