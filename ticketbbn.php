<?
session_start();
?>
<div align="left" style=" margin-left:35px;">
	<!--  "
--> <?php
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();
	$idusu = $_REQUEST['idt'];
	$fc = $_REQUEST['fc'];
	$IDC = $_REQUEST['idc'];
	$IDG = 0;
	if ($IDC == -4 || $IDC == -1 || $IDC == -2) :
		if ($IDC == -4) :
			$IDB = WhatBancaByUsuario($idusu);
		else :
			$IDB = 1;
		endif;
	// echo '<samp id="nDatos" lang="nAn"></samp><samp id="oDatos" lang=""></samp>';
	else :
		$IDB = WhatBanca($IDC);
		$IDG = WhatGrupo($IDC);
	/* $result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconsecionariodd where idc='".$IDC."'");
	  $row = mysqli_fetch_array($result);
	  echo '<samp id="nDatos" lang="'.$row['mmdp'].'-'.$row['chkTop'].'"></samp>';*/
	endif;

	$idCnv = 1;

	$ldg = '';
	$idj = 0;
	$hay = 0;
	$auto = 0;
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "' and IDB=$IDB");
	// echo "SELECT * FROM _tconfjornada where Fecha='".$fc."'";
	if (mysqli_num_rows($result) != 0) :
		$row3 = mysqli_fetch_array($result);
		$idj = $row3['IDJ'];
		$auto = $row3['auto'];
	endif;
	$listapubli = '(0';
	$nombreGrup = array();
	$result = mysqli_query($GLOBALS['link'], "SELECT _gruposdd.*,deportes.IDD,deportes.Prior FROM _gruposdd,deportes where Estatus=1 and  _gruposdd.IDD=deportes.IDD  Order by deportes.Prior,_gruposdd.grupo");
	// echo ("SELECT _gruposdd.*,deportes.IDD,deportes.Prior FROM _gruposdd,deportes where Estatus=1 and  _gruposdd.IDD=deportes.IDD  Order by deportes.Prior");
	if (mysqli_num_rows($result) != 0) :
		$epd = 0;
		while ($row3 = mysqli_fetch_array($result)) {
			$resultx = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpublicaciones where IDJ=" . $idj . " and Grupo=" . $row3['Grupo'] . " and IDB=$IDB");
			if (mysql_errno() == 0) :
				if (mysqli_num_rows($resultx) != 0) :
					$op = "'ticketbb-3n.php?idg=" . $row3['Grupo'] . "'";
					$hay = 1;
					if ($epd == 0) :
						$epd = $row3['Grupo'];
					endif;
					$nombreGrup[$row3['Grupo']] = $row3['Descripcion'];
					$listapubli .= ',' . $row3['Grupo'];
					$ldg = $ldg . '|' . $row3['Grupo'];
					$default[$row3['Grupo']] = 'media/' . $row3['imagen'];
				else :
					$marcar = '';
					$imagen = '';
				endif;
			endif;
		}
	endif;
	$listapubli .= ')';
	?>
	<div id="contextArea2p"></div>

	<div id='verJugadasfrm' style=" height: 800px; overflow: auto; width:100% ">
		<div id='verJug2'>
			<?php
			$tdl = 1;
			$gruInx = 0;
			$in = 1;
			$result_bg = mysqli_query($GLOBALS['link'], "SELECT _gruposdd.*,deportes.IDD,deportes.Prior FROM _gruposdd,deportes where Estatus=1 and  _gruposdd.IDD=deportes.IDD and  grupo in " . $listapubli . " Order by deportes.Prior,_gruposdd.grupo");
			//echo ("SELECT _gruposdd.*,deportes.IDD,deportes.Prior FROM _gruposdd,deportes where Estatus=1 and  _gruposdd.IDD=deportes.IDD and  grupo in ".$listapubli." Order by deportes.Prior,_gruposdd.grupo");
			if (mysqli_num_rows($result) != 0) :
				while ($row_bg = mysqli_fetch_array($result_bg)) {
					$idg = $row_bg['Grupo'];
					$resultchk = mysqli_query($GLOBALS['link'], "Insert listactualiza (IDJ,Grupo,IDusu,IDB) values ($idj,$idg,$idusu,$IDB)");
					echo '<br><div id="Liga_' . $idg . '" style="color:#FC0; font-size:18px;background:#999;height:30px;">';
					echo '<img id="mas' . $idg . '" src="images/elbow-minus-nl.gif"  onclick="displayOnOff(' . $idg . ',1);"/><img id="menos' . $idg . '" src="images/elbow-plus-nl.gif" style="display:none"  onclick="displayOnOff(' . $idg . ',2);"/>';
					echo '<span style="color:#FC0; font-size:18px;background:#999"> Liga: ' . $nombreGrup[$idg] . '</span>';
					$gruInx++;
					$irC = "'contextArea2p'";
					echo '<img id="ira_' . $idg . '" src="images/ir_A.gif"  onclick="document.getElementById(' . $irC . ').scrollIntoView(true);" title="Ir al Menu"/></div>';
					echo '<div id="forttD_' . $idg . '" lang="' . $tdl . '">';
					include('ticketbb-3n.php');
					echo '</div>';
				}
			endif;
			?>
		</div>
	</div>
</div>
<samp id='totaldefilar' lang="<?php echo $tdl; ?>"></samp>
<samp id='tti' lang=""></samp>
<samp id='ldegrup' lang="<?php echo $ldg; ?>"></samp>
<samp id='idj_x' lang="<?php echo $idj; ?>"></samp>
<samp id='camposmarcados' lang=""></samp>

<a id="lgrunico" lang="<?php echo $logrounico; ?>"></a>
<? if ($hay == 1) : ?>
	<script type="text/javascript">
		activarcc(<?php echo $epd; ?>, <?php echo $idj; ?>);

		new Ajax.Request('xmlticketbbn.php', {
			parameters: {
				file: 'xmenu.xml',
				idj: <?php echo $idj; ?>,
				IDB: <?php echo $IDB; ?>
			},
			method: 'post',
			asynchronous: false,
			onComplete: function(transport) {
				var response = transport.responseText;
			},
			onFailure: function() {
				alert('No tengo respuesta Comuniquese con el Administrador!');
			}
		});



		menu2p = new dhtmlXMenuObject("contextArea2p", "dhx_terrace");
		menu2p.setImagePath("codebase/imgs/");
		menu2p.setIconsPath("images/");
		menu2p.loadXML("xmenu.xml");
		menu2p.attachEvent("onClick", "execMenuVentas");

		/*dhxWinsVe = new dhtmlXWindows();
    dhxWinsVe.setImagePath("codebase/imgs/");
    w1ve = dhxWinsVe.createWindow("w1ve", 600, 350, 1000, 640);*/
		//
		openpV = false;
		Ext.MessageBox.hide();
		/* w1ve.setText("");
    w1ve.button("close").hide();//,stick,sticked,park,minmax1,minmax2
	w1ve.button("park").hide();
	w1ve.button("minmax1").hide();
	w1ve.button("minmax1").hide();
	dhxWinsVe.window("w1ve").hideHeader();
	dhxWinsVe.window("w1ve").denyMove();
	w1ve.attachObject('verJugadasfrm');
	dhxWinsVe.setSkin( "dhx_terrace");*/


		//-->
	</script>
<? else : ?>
	<script>
		openpV = false;
		Ext.MessageBox.hide();
		alert('No hay ventas disponibles');
		Ext.MessageBox.hide();
	</script>
<? endif; ?>