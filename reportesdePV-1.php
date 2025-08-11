<style type="text/css">
<!--
.Estilo2d1 {color: #000000}
.Estilo3d1 {
	color: #FFFF66;
	font-size: 10px;
}
.Estilo5d1 {
	color: #FFFFFF;
	font-size: 10px;
}
.Estilo4d1 { color:#FFFFFF; font-size:14px}
-->

</style>

 <?php
	     
				
				$titulo=$_REQUEST['titulo'];
				$box=$_REQUEST['box'];
				$reporte=$_REQUEST['reporte'];
				
		?>



<div id="<?php echo $box; ?>" style="width:442px; background:#4682CA "  >

  
 <table   width="440" border="0" cellspacing="0" >
        <tr >
          <th   ></th>
          <th colspan="4"  ><div align="center" class="Estilo4d1"><?php echo $titulo;?></div>            <div align="right"></div></th>
        </tr>
        <tr >
          <th  ></th>
          <th >&nbsp;</th>
          <th colspan="2"  >&nbsp;</th>
          <th  ><div align="right"></div></th>
        </tr>
        
        <tr  >
          <th ></th>
          <th  class="Estilo3d1" ><div align="right">Desde:</div></th>
          <th width="144"  ><input name="fc" type="text" id="fc1"  size="10"  value="<?php echo date("d/n/Y");?>" /></th>
          <th width="137"  ><div align="right" class="Estilo3d1">Hasta:</div></th>
          <th  ><input name="fc" type="text" id="fc2"  size="10"  value="<?php echo date("d/n/Y");?>"/></th>
        </tr>
        
        <tr >
          <th  ></th>
          <th  >&nbsp;</th>
          <th colspan="2"  >&nbsp;</th>
          <th  >&nbsp;</th>
        </tr>
        <tr  >
          <th width="1"   ></th>
          <th width="80"  >&nbsp;</th>
          <th colspan="2"  >&nbsp;</th>
          <th width="68"  ><input name="" type="button" value="Ver por Pantalla" onclick="imprimi_reporte('<?php echo $reporte;?>');"/></th>
    </tr>
      </table>
</div> 

<script>
Nifty('<?php echo $box; ?>','big');
cargarcampos_ddes1();cargarcampos_ddes2();

</script>
