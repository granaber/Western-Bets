<?
session_start();
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<style type="text/css">
	.imgclass {
		-webkit-filter: drop-shadow(0 0 0 black);
		filter: drop-shadow(0 0 0 black);
	}
</style>
<div id="TabbedPanels1" class="TabbedPanels" style="display:none; margin-left:35px;">
	<ul class="TabbedPanelsTabGroup">
		<?php
		require_once('prc_php.php');
		require_once('prc_skynet.php');
		require_once('graphql.php');
		global $server1;
		global $user1;
		global $clv1;
		global $server;
		global $user;
		global $clv;

		$skynet2 = mysqli_connect($server1, $user1, $clv1);
		mysqli_select_db($skynet2, $db1);
		$GLOBALS['link'] = Connection::getInstance();

		$idusu = $_REQUEST['idt'];
		$fc = $_REQUEST['fc'];
		$IDC = $_REQUEST['idc'];
		$IDG = 0;
		$versionTQ = false;
		$iSecury = explode('/', getenv("HTTP_REFERER"));

		if (($iSecury[count($iSecury) - 2] === "parlayenlinea.ml"  || $iSecury[count($iSecury) - 2] === "www.parlayenlinea.ml")) :
			$versionTQ = true;
		endif;
		if ($IDC == -4 || $IDC == -1 || $IDC == -2) :
			if ($IDC == -4) :
				$IDB = WhatBancaByUsuario($idusu);
			else :
				$IDB = 1;
			endif;
		else :
			$IDB = WhatBanca($IDC);
			$IDG = WhatGrupo($IDC);
		endif;
		// CREDITO
		$tcredito = 0;
		$tbalance = 0;
		$tpendiente = 0;
		$Disponible = 0;
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM `_tbcrdcredito`  where IDC='$IDC'");
		if (mysqli_num_rows($result) != 0) :
			$row3 = mysqli_fetch_array($result);
			if ($row3['credito'] != 0) :
				$tcredito = $row3['credito'];
				$tbalance = $row3['saldo'] - $row3['credito'];
				$tpendiente = $row3['CreditoDiario'];
				$Disponible = $tbalance + $row3['credito'];
			endif;
		endif;

		$tb = 0;
		$result = mysqli_query($GLOBALS['link'], "SELECT _tconsecionario.*,sbmonedas.moneda  FROM _tconsecionario,sbmonedas where _tconsecionario.idm=sbmonedas.id and IDC='$IDC'");
		if (mysqli_num_rows($result) != 0) :
			$row3 = mysqli_fetch_array($result);
			$tb = $row3['tb'];
			$mnd = "'" . $row3['moneda'] . "'";
		endif;
		$_SESSION['tb_session'] = $tb;

		////// Hacer Busqueda de tipo de logros ///
		// $result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconsecionariodd where IDC='$IDC' " );
		//  $row = mysqli_fetch_array($result);
		$idCnv = $_SESSION['idCnv'];
		//echo '**'.$idCnv.'**';
		// = $idCnv;
		//////////////////////////////////////////
		$ldg = '';
		$idj = 0;
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "' and IDB=$IDB");
		// echo "SELECT * FROM _jornadabb where Fecha='".$fc."' and IDB=$IDB";
		// echo "SELECT * FROM _tconfjornada where Fecha='".$fc."'";
		if (mysqli_num_rows($result) != 0) :
			$row3 = mysqli_fetch_array($result);
			$idj = $row3['IDJ'];
		endif;
		$listapubli = '(0';
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where Estatus=1 Order by grupo");
		if (mysqli_num_rows($result) != 0) :
			$epd = 0;
			while ($row3 = mysqli_fetch_array($result)) {
				$resultx = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpublicaciones where IDJ=" . $idj . " and Grupo=" . $row3['Grupo'] . " and IDB=$IDB");
				if (mysqli_num_rows($resultx) != 0) :
					/// Verificacion de Equipos cerrado
					//SELECT *  FROM  `_cierrebb`  WHERE  `IDJ` =879 AND grupo =28
					$resulCierr = mysqli_query($GLOBALS['link'], "SELECT  COUNT( idp ) AS x FROM _cierrebb where IDJ=" . $idj . " and Grupo=" . $row3['Grupo']);
					$xrow = mysqli_fetch_array($resulCierr);
					$xcant = $xrow['x'];
					//SELECT *  FROM _jornadabb WHERE IDJ =879 AND grupo =28
					$resulCierr = mysqli_query($GLOBALS['link'], "SELECT  Partidos FROM _jornadabb where IDJ=" . $idj . " and Grupo=" . $row3['Grupo'] . " and IDB=$IDB");
					$xrow = mysqli_fetch_array($resulCierr);
					$xcantJ = $xrow['Partidos'];
					///
					if ($xcant != $xcantJ) :
						$op = "'ticketbb-3.php?idg=" . $row3['Grupo'] . "'";
						if ($epd == 0) :
							$epd = $row3['Grupo'];
						endif;
						$marcar = ' background:#FF0';
						$listapubli .= ',' . $row3['Grupo'];
						$ldg = $ldg . '|' . $row3['Grupo'];
						$Lgot = searhcLG($row3['Grupo'], $GLOBALS['link'], $skynet2);
						// echo $Lgot . '-' . $row3['Grupo'];
						if ($Lgot != null) {
							$imagen = '<img src="' . $Lgot . '" width="54" height="35" class="imgclass" />';
							$default[$row3['Grupo']] = $Lgot;
							$aplDefa[$row3['Grupo']] = true;
						} else {
							if (!file_exists('media/' . $row3['imagen'])) {
								$imagen = '<img src="media/undefine.png" width="54" height="35" />';
								$default[$row3['Grupo']] = "media/undefine.png";
								$aplDefa[$row3['Grupo']] = false;
							} else {
								$imagen = '<img src="media/' . $row3['imagen'] . '" width="54" height="35" />';
								$default[$row3['Grupo']] = "media/" . $row3['imagen'];
								$aplDefa[$row3['Grupo']] = false;
							}
						}
						echo '<li class="TabbedPanelsTab" tabindex="0"   style="color:#000;' . $marcar . '" onclick="activarcc(' . $row3['Grupo'] . ',' . $idj . ',' . $IDB . ')">' . $imagen . $row3['Descripcion'] . '</li>';
					else :
						$marcar = '';
						$imagen = '';
					endif;
				else :
					$marcar = '';
					$imagen = '';
				endif;
			}
		endif;
		$listapubli .= ')';
		?>

	</ul>
	<div class="TabbedPanelsContentGroup">
		<?php
		$tdl = 1;
		$result_bg = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where Estatus=1 and grupo in " . $listapubli . " Order by grupo");
		if (mysqli_num_rows($result) != 0) :
			while ($row_bg = mysqli_fetch_array($result_bg)) {
				//'ticketbb-3.php?idg='.$row3['Grupo'].'&idj=30'
				$idg = $row_bg['Grupo'];
				$resultchk = mysqli_query($GLOBALS['link'], "Insert listactualiza (IDJ,Grupo,IDusu,IDB) values ($idj,$idg,$idusu,$IDB)");
				/// logros automaticos ///
				$lisAUTO = array();
				$resultnk = mysqli_query($GLOBALS['link'], "Select * from _agendaNT where Grupo=$idg and IDB=$IDB and idj=$idj");
				if (mysqli_num_rows($resultnk) != 0) :
					$rownk = mysqli_fetch_array($resultnk);
					$lisAUTO = explode(',', $rownk['IDDDs']);
					if ($rownk['apptbls'] != null)
						$appIDDD = explode(',', $rownk['apptbls']);
					else
						$appIDDD = array();
				endif;
				/////////////////////////
				echo '<div class="TabbedPanelsContent" >';
				echo '<div id="forttD_' . $idg . '" lang="' . $tdl . '">';
				include('ticketbb-3.php');
				//<a href="javascript:tick('.$op.','.$row3['Grupo'].');" title="'.$row3['Descripcion'].'"><img src="media/'.$row3['imagen'].'" width="54" height="35" /><span>'.$row3['Descripcion'].'
				echo '</div></div>';
			}
		endif;

		foreach ($ncom3 as $vector => $index)
			$_SESSION["'" . $vector . "'"]  = $ncom3[$vector];

		?>
	</div>
</div>
<samp id='timeact' lang="<?= time(); ?>"></samp>
<samp id='totaldefilar' lang="<?= $tdl; ?>"></samp>
<samp id='tti' lang=""></samp>
<samp id='ldegrup' lang="<?= $ldg; ?>"></samp>
<samp id='idj_x' lang="<?= $idj; ?>"></samp>
<samp id='camposmarcados' lang=""></samp>

<a id="lgrunico" lang="<?= $logrounico; ?>"></a>


<script type="text/javascript">
	<?php if ($tcredito != 0) : ?>
		$('stCredito').style.display = '';
		$('crd').innerHTML = "CREDITO:" + <?= $tcredito;  ?>;
		$('bln').innerHTML = "BALANCE:" + <?= $tbalance; ?>;
		$('pnd').innerHTML = "PENDIENTE:" + <?= $tpendiente; ?>;
		$('dip').innerHTML = "DISPONIBLE:" + <?= $Disponible; ?>;
	<?php endif; ?>
	var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
	$('TabbedPanels1').style.display = '';
	activarcc(<?= $epd; ?>, <?= $idj; ?>);
</script>