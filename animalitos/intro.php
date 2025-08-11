<?
session_start();
date_default_timezone_set('America/Caracas');



//$op=$_REQUEST['op'];

// $usu=$_REQUEST['usu'];

require_once('prc_php.php');
require_once('escruteshi.php');

$link = ConnectionAnimalitos::getInstance();
global $minutosa;


if (true) :
	$usu = trim($_COOKIE['usukk']);
	$pw = trim($_COOKIE['-okwilh']);
	setcookie("usukk", null, -1, '/');
	setcookie("-okwilh", null, -1, '/');


	$ck = '*';



	$result = mysqli_query($link, "SELECT * FROM _tusu where MD5(UPPER(Usuario))='" . trim($usu) . "'");
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$nusu = $row['Usuario'];
		$resultNS = mysqli_query($link, "SELECT * FROM _tconsecionario where IDC='" . $row["Asociado"] . "'");
		$rowNS = mysqli_fetch_array($resultNS);
		if ($rowNS['ins'] == 1) :
			$serial = $rowNS['se'];
		else :
			$serial = -1;
		endif;
		if ($row['Tipo'] == 2 || $row['Tipo'] == 4) :	$serial = -1;
		endif;

		$permitirgrabar = false;
		$valK = time();
		if (($valK - $row['lastactivity']) > 15) :
			$permitirgrabar = true;
		endif;


		if ($ck != '*' && $ck != 0) :
			if ($ck == $row['bloqueado']) :
				$ck = $row['bloqueado'];
			else :
				if ($row['bloqueado'] == 0) :
					$ck = $row['bloqueado'];
				endif;
			endif;
		endif;

		$ck = $row['bloqueado'];


		if ($serial == -1) :
			$libre = true;
		else :
			$iud = $_COOKIE['uid'];
			if ($iud === $serial) :
				$libre = true;
			else :
				$libre = false;
			endif;
		endif;
		if ($permitirgrabar) :
			if ($libre) :

				if ($row['bloqueado'] == 0 && $ck == '*') :
					if (md5($row['clave']) === $pw) :
						$result2 = mysqli_query($link, "SELECT * FROM _tconfjornada where Estatus=1 and fecha='" . FecharealAnimalitos($minutosa, "d/n/Y") . "' order by IDCN");
						$row2 = mysqli_fetch_array($result2);
						if (mysqli_num_rows($result2) != 0) :
							$jor = $row2["IDCN"];
						else :
							$jor = "Cerrada";
						endif; //  if (mysqli_num_rows($result2)!=0):
						if ($row['Estatus'] == 1) :
							$rnd = rand(1, 32560);
							$result2 = mysqli_query($link, "Update _tusu Set bloqueado=" . $rnd . " where IDusu=" . $row['IDusu']); //setcookie("iusbl", $rnd);
							if ($row["Tipo"] == 3) :
								$_SESSION['iInSeccu2'] = true;
								$_SESSION['referrer'] = $_SERVER['REQUEST_URI'];
								$_SESSION['Agrupo'] = $row["AGrupo"];
								$_SESSION['count'] = $row["IDusu"];
								$valordeaa =  "true||" . $row["Asociado"] . "||" . $row["Estacion"] . "||" . $row["Descripcion"] . "||" . FecharealAnimalitos($minutosa, "d/n/Y") . "||" . $jor . "||" . $rnd . "||" . $row["IDusu"] . "||" . $row["Acceso"] . "||" . $row["AccesoP"];
								///////  Chequeo de Credito ///
								cRdCreditoAnt($row["Asociado"]);
							///////////////////////////////
							else :
								$valor = intval($row["Tipo"]) * (-1);
								$_SESSION['iInSeccu2'] = true;
								$_SESSION['referrer'] = $_SERVER['REQUEST_URI'];
								$_SESSION['Agrupo'] = $row["AGrupo"];
								$_SESSION['count'] = $row["IDusu"];
								$valordeaa =  "true||" . $valor . "||" . $row["Estacion"] . "||" . $row["Descripcion"] . "||" . FecharealAnimalitos($minutosa, "d/n/Y") . "||" . $jor . "||" . $rnd . "||" . $row["IDusu"] . "||" . $row["Acceso"] . "||" . $row["AccesoP"];
							endif; //if ($row["Tipo"]==3):
						else :
							echo  "false||1";
						endif; // if ($row['Estatus']==1):
					else :
						echo  "false||0";
					endif; //if ($row['clave']===$pw):
				else : // if ($row['bloqueado']==0 && $ck=='*' ):
					if ($row['bloqueado'] == $ck) :
						if (md5($row['clave']) === $pw) :
							$result2 = mysqli_query($link, "SELECT * FROM _tconfjornadahi where Estatus=1 and fecha='" . FecharealAnimalitos($minutosa, "d/n/Y") . "' order by IDCN");
							$row2 = mysqli_fetch_array($result2);
							if (mysqli_num_rows($result2) != 0) :
								$jor = $row2["IDCN"];
							else :
								$jor = "Cerrada";
							endif; //if (mysqli_num_rows($result2)!=0):

							if ($row['Estatus'] == 1) :
								$rnd = rand(1, 32560);
								$result2 = mysqli_query($link, "Update _tusu Set bloqueado=" . $rnd . " where IDusu=" . $row['IDusu']);
								//setcookie("iusbl", $rnd);

								if ($row["Tipo"] == 3) :
									$_SESSION['iInSeccu2'] = true;
									$_SESSION['referrer'] = $_SERVER['REQUEST_URI'];
									$_SESSION['Agrupo'] = $row["AGrupo"];
									$_SESSION['count'] = $row["IDusu"];
									$valordeaa =  "true||" . $row["Asociado"] . "||" . $row["Estacion"] . "||" . $row["Descripcion"] . "||" . FecharealAnimalitos($minutosa, "d/n/Y") . "||" . $jor . "||" . $rnd . "||" . $row["IDusu"] . "||" . $row["Acceso"] . "||" . $row["AccesoP"];
									///////  Chequeo de Credito ///
									cRdCreditoAnt($row["Asociado"]);
								///////////////////////////////
								else :
									$valor = intval($row["Tipo"]) * (-1);
									$_SESSION['iInSeccu2'] = true;
									$_SESSION['referrer'] = $_SERVER['REQUEST_URI'];
									$_SESSION['Agrupo'] = $row["AGrupo"];
									$_SESSION['count'] = $row["IDusu"];
									$valordeaa =  "true||" . $valor . "||" . $row["Estacion"] . "||" . $row["Descripcion"] . "||" . FecharealAnimalitos($minutosa, "d/n/Y") . "||" . $jor . "||" . $rnd . "||" . $row["IDusu"] . "||" . $row["Acceso"] . "||" . $row["AccesoP"];
								endif; //if ($row["Tipo"]==3):
							else :
								$valordeaa =  "false||1";
							endif; // if ($row['Estatus']==1):

						else :
							$valordeaa =  "false||0";
						endif; // if ($row['clave']===$pw):

					else :
						$valordeaa =  "false||1";
					endif; //    if ($row['bloqueado']==$ck):

				endif; // if ($row['bloqueado']==0 && $ck=='*' ):

			else :
				$valordeaa =  "false||2";
			endif; // if ($libre):

		else :
			$valordeaa =  "false||3";
		endif; // if ($libre):

	else :
		$valordeaa =  "false||0";
	endif; // if (mysqli_num_rows($result)!=0):

else :
	$result2 = mysqli_query($link, "Update _tusu Set bloqueado=0 where IDusu=" . $usu); //setcookie("iusbl", 0);
	$valordeaa =  "true||0";
endif; //if ($op==1):



$veracceso = explode('||', $valordeaa);
//print_r($veracceso);
if ($veracceso[0] === 'true') :
	$_SESSION['_xmenu'] = $veracceso[8];
	$namef = namerand();
	setcookie('fx', ecoBaseAnimalitos('xmln-' . $namef . '.xml'), 0, '/');
	$_SESSION['flx'] = $namef . '.xml';
	setcookie("sessionhash", $row["IDusu"], 0, '/');
?>
	<link rel="shortcut icon" type="image/x-icon" href="media/sph.gif" />

	<style type="text/css">
		<!--
		.Estilo13 {
			color: #FFCC00
		}
		-->

	</style>

	<head>

		<title>..:: AMERICANAS ::..</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<meta http-equiv="Content-Style-Type" content="text/css" />
		<script src="md5.js"></script>


	</head>

	<!--CARGA DE SCRIPT JAVA!-->
	<link type="text/css" rel="stylesheet" media="all" href="cometchat/css/cometchat.css" />
	<script type="text/javascript" src="cometchat/js/jquery.js"></script>
	<script src="md5.js"></script>
	<style type="text/css">
		#loading-mask {
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			z-index: 20000
		}

		#loading {
			position: absolute;
			background: #000;
			left: 45%;
			top: 40%;
			padding: 2px;
			z-index: 20001;
			height: auto
		}

		#loading a {
			color: #225588;
			background: #000
		}

		#loading .loading-indicator {
			background: black;
			color: #FC0;
			font: bold 13px tahoma, arial, helvetica;
			padding: 10px;
			margin: 0;
			height: auto;
		}

		#loading-msg {
			font: normal 10px arial, tahoma, sans-serif;
			color: #FFF
		}
	</style>


	<!--FIN DE CARGA DE SCRIPT JAVA!-->

	<link href="prin_pcss.css" rel="stylesheet" type="text/css" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="menu_style.css" />

	<body id="page">


		<samp id="repuesta"></samp>
		<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="50%" height="100%" style=" background-color:#000000 ;background-repeat:repeat-y;background-position:right"></td>
				<td align="right">
					<table id="body_program" border="0" cellpadding="-1" cellspacing="-1">
						<tr>
							<td id="logo" lang="" colspan="2" style="padding-bottom:1px " align="center" bgcolor="#336699">
								<span><img align="middle" src="media/logop.png"></span>
								<div id="Cinti" style="background: #FC0; color: #000" align="center">
									<marquee><span id="MensajeTXT" style="font-size:25px"><?


																							$link = ConnectionAnimalitos::getInstance();

																							$result = mysqli_query($link, " Select * From _tbmensaje");
																							$row = mysqli_fetch_array($result);
																							echo   $row['mensaje'];
																							?></span><br></marquee>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" bgcolor="#336699">
								<table>
									<tr>
										<td colspan="2" class="Estilo6"><span id="con" title="<? echo $veracceso[1]; ?>">Concesionario:<? echo $veracceso[1]; ?></span></td>
									</tr>
									<tr>
										<td class="Estilo6"><span id="fch" title="<? echo $veracceso[4]; ?>">Fecha:<? echo $veracceso[4]; ?></span></td>
										<td class="Estilo6"><span id="jnd" title="<? echo $veracceso[5]; ?>">Jornada:<? echo $veracceso[5]; ?></span></td>
									</tr>
									<tr>
										<td class="Estilo6"><span id="usu" title="<? echo $veracceso[7]; ?>" lang="<? echo $nusu; ?>">Usuario:<? echo $nusu; ?></span></td>
										<td class="Estilo6"><span id="est" title="<? echo $veracceso[2]; ?>">Estacion:<? echo $veracceso[2]; ?></span></td>
									</tr>
								</table>

							</td>
						</tr>
						<tr align="center">
							<td colspan="2">
								<div id="MenuTool">
									<div id="contextArea"></div>
								</div>
								<div id="topmenu" align="center"></div>
							</td>
						</tr>
						<tr align="center">
							<td colspan="2">
								<div id="tablemenu" style=" height:1000px"></div>
							</td>
						</tr>
					</table>
				</td>
				<td width="50%" height="100%" style=" background-color:#000000 ;background-repeat:repeat-y;background-position:left"></td>
			</tr>
		</table></span>
		<div id="tablemenuANI" style="color:#FFF"></div>
		<samp id="printer"></samp>

		<!----------------------------->



	</body>

	</html>
	<link type="text/css" rel="stylesheet" media="all" href="cometchat/css/cometchat.css" />
	<script type="text/javascript" src="cometchat/js/jquery.js"></script>

	<script type='text/javascript' src='x/lib/x_core.js'></script>
	<script type='text/javascript' src='x/lib/xtabpanelgroup.js'></script>
	<script type='text/javascript' src='x/lib/xevent.js'></script>

	<script type="text/javascript" src="Scripts/calendar.js"></script>
	<script type="text/javascript" src="lang/calendar-es.js"></script>
	<script type="text/javascript" src="Scripts/calendar-setup.js"></script>
	<script type="text/javascript" src="niftycube.js"></script>
	<script type="text/javascript" src="prototype.js"></script>
	<script type="text/javascript" src="prc.js"></script>
	<script type="text/javascript" src="prcjuegos.js"></script>
	<script type="text/javascript" src="prchi3x4k.js"></script>
	<script type="text/javascript" src="base64dc.js"></script>
	<!--Animalitos-->
	<script type="text/javascript" src="animalitos/prcJsX3v1.js"></script>
	<!--Animalitos-->


	<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
	<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
	<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
	<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
	<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
	<script src="SpryAssets/SpryEffects.js" type="text/javascript"></script>
	<script src="color_functions.js"></script>
	<script type="text/javascript" src="js_color_picker_v2.js"></script>

	<script src="codebase/dhtmlxcommon.js"></script>
	<script src="codebase/dhtmlxmenu.js"></script>
	<script src="codebase/dhtmlxwindows.js"></script>
	<script src="codebase/dhtmlxtabbar.js"></script>
	<script src="codebase/dhtmlxgrid.js"></script>
	<!--    <script  src="codebase/dhtmlxdataprocessor.js"></script>		Extension de Grid-->
	<script src="codebase/php/connector.js"></script><!--	Extension de Grid-->
	<script src="codebase/ext/dhtmlxgrid_filter.js"></script> <!--	Extension de Grid-->
	<script src="codebase/ext/dhtmlxgrid_srnd.js"></script><!--	Extension de Grid-->

	<script src="codebase/dhtmlxgridcell.js"></script>
	<script src="codebase/dhtmlxtoolbar.js"></script>
	<script src="codebase/dhtmlxcombo.js"></script>
	<script src="codebase/dhtmlxcalendar.js"></script>
	<script src="codebase/ext/dhtmlxwindows_wtb.js"></script>

	<script src="codebase/dhtmlxlayout.js"></script>
	<script src="codebase/dhtmlxtree.js"></script>
	<script src="codebase/dhtmlxcontainer.js"></script>

	<script src="codebase/dhtmlxcombo.js"></script>
	<script src="codebase/ext/dhtmlxcombo_extra.js"></script>


	<link rel="stylesheet" type="text/css" href="resources/css/ext-all.css" />
	<script type="text/javascript" src="adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="ext-all-debug.js"></script>
	<script type="text/javascript" src="ux/Spinner.js"></script>
	<script type="text/javascript" src="ux/SpinnerField.js"></script>
	<script type="text/javascript" src="spinner.js"></script>
	<script type="text/javascript" src="examples.js"></script>



	<link rel="stylesheet" type="text/css" href="css/Spinner.css" />

	<link rel="stylesheet" href="js_color_picker_v2.css" media="screen">
	<link rel="stylesheet" type="text/css" media="all" href="css/calendar-win2k-cold-1.css" title="win2k-cold-1" />

	<link href="css/menuhi.css" rel="stylesheet" type="text/css" />
	<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
	<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
	<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
	<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
	<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
	<link rel='stylesheet' type='text/css' href='x/lib/v3.css'>
	<link rel='stylesheet' type='text/css' href='x/lib/tpg_dyn.css'>


	<link href="prin_pcss.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="codebase/dhtmlxtree.css">
	<link rel="stylesheet" type="text/css" href="codebase/dhtmlxlayout.css">
	<link rel="stylesheet" type="text/css" href="codebase/dhtmlxwindows.css">
	<link rel="stylesheet" type="text/css" href="codebase/dhtmlxgrid.css">
	<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxcombo.css">
	<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxtabbar.css">
	<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxcalendar.css">

	<link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_blue.css">
	<link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_black.css">

	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxlayout_dhx_skyblue.css">
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxlayout_dhx_black.css">

	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_skyblue.css">
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_black.css">

	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxtoolbar_dhx_skyblue.css">
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxtoolbar_dhx_black.css">

	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxmenu_modern_blue.css">
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxgrid_dhx_skyblue.css">
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxgrid_dhx_black.css">

	<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxcombo.css">
	<LINK HREF="style.css" TYPE="text/css" REL="stylesheet">
	<script>
		//document.cookie = "sessionhash=0; max-age=" + (60*60*24*4) ;
		timerID2z = setInterval("console.clear()", 10);

		setCookie('rndusr', <? echo $veracceso[6]; ?>);
		new Ajax.Request('chatactivo.php', {
			method: 'get',
			onSuccess: function(transport) {
				var response = transport.responseText;

				response.evalScripts();
			},
			onFailure: function() {
				alert('No tengo respuesta Comuniquese con el Administrador!');
			}
		});



		new Ajax.Request('kp903.php', {
			method: 'post',
			asynchronous: false,
			onComplete: function(transport) {
				var response = transport.responseText;
			},
			onFailure: function() {
				alert('No tengo respuesta Comuniquese con el Administrador!');
			}
		});

		menu = new dhtmlXMenuObject("contextArea", "modern_blue");
		menu.setImagePath("codebase/imgs/");
		menu.setIconsPath("images/");
		menu.setOpenMode("win");
		archivo = dbna(getCookie2('fx'), this);
		setCookie2('fx', '', '/');
		res = archivo.replace("-", "/");
		menu.loadXML(res);
		menu.attachEvent("onClick", "execMenu");
	</script>
	<!--FIN DE CARGA DE SCRIPT JAVA!-->

	<!--CARGA DE CSS!-->

<?
else :

	switch ($veracceso[1]) {

		case 1:
			$leyenda = 'Usuario Bloqueado';
			break;
		case 2:
			$leyenda = 'ESTA FUERA DEL HORARIO PARA LA VENTA!';
			break;
		default:
			$leyenda = 'El Usuario No Existe o Clave Errada';
	}
?>
	<script>
		alert('<? echo $leyenda; ?>');
		window.close();
	</script>
<?
endif;

?>