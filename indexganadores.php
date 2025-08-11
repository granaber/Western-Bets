<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>Página principal</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="mm_training.css" type="text/css" />
<link rel="stylesheet" media="all" type="text/css" href="../css/css_play.css" />
<link rel="stylesheet" media="all" type="text/css" href="../css/menus.css" />
<style type="text/css">
<!--

/*Credits: By Santosh Setty (http://webdesigninfo.wordpress.com) */
/*Posted to: Dynamic Drive CSS Library (http://www.dynamicdrive.com/style/) */

.glossymenu{
	position: relative;
	padding: 0 0 0 34px;
	margin: 0 auto 0 auto;
	background: url(media/menub_bg.gif) repeat-x; /*tab background image path*/
	height: 46px;
	list-style: none;
}

.glossymenu li{
	float:left;
}

.glossymenu li a{
	float: left;
	display: block;
	color:#000;
	text-decoration: none;
	font-family: sans-serif;
	font-size: 13px;
	font-weight: bold;
	padding:0 0 0 16px; /*Padding to accomodate left tab image. Do not change*/
	height: 46px;
	line-height: 46px;
	text-align: center;
	cursor: pointer;	
}

.glossymenu li a b{
	float: left;
	display: block;
	padding: 0 24px 0 8px; /*Padding of menu items*/
}

.glossymenu li.current a, .glossymenu li a:hover{
	color: #fff;
	background: url(media/menub_hover_left.gif) no-repeat; /*left tab image path*/
	background-position: left;
}

.glossymenu li.current a b, .glossymenu li a:hover b{
	color: #fff;
	background: url(media/menub_hover_right.gif) no-repeat right top; /*right tab image path*/
}

#info {height:500px; position:relative;}
#adsie {position:absolute; bottom:0;}
/*Menu vertival*/

.arrowlistmenu{
width: 180px; /*width of menu*/
}

.arrowlistmenu .headerbar{
font: bold 14px Arial;
color: white;
background: black url(media/titlebar.png) repeat-x center left;
margin-bottom: 10px; /*bottom spacing between header and rest of content*/
text-transform: uppercase;
padding: 4px 0 4px 10px; /*header text is indented 10px*/
}

.arrowlistmenu ul{
list-style-type: none;
margin: 0;
padding: 0;
margin-bottom: 8px; /*bottom spacing between each UL and rest of content*/
}

.arrowlistmenu ul li{
padding-bottom: 2px; /*bottom spacing between menu items*/
}

.arrowlistmenu ul li a{
color: #A70303;
background: url(media/arrowbullet.png) no-repeat center left; /*custom bullet list image*/
display: block;
padding: 2px 0;
padding-left: 19px; /*link text is indented 19px*/
text-decoration: none;
font-weight: bold;
border-bottom: 1px solid #dadada;
font-size: 90%;
}

.arrowlistmenu ul li a:visited{
color: #A70303;
}

.arrowlistmenu ul li a:hover{ /*hover state CSS*/
color: #A70303;
background-color: #F3F3F3;
}
.Estilo4 {
	font-size: 12pt;
	font-family: "Times New Roman", Times, serif;
}
.Estilo6 {color: #FFFFFF}
.Estilo7 {font-size: 16px}

/*Hoja estilo*/

.curlycontainer{
border: 1px solid #b8b8b8;
margin-bottom: 1em;
width: 300px;
}

.curlycontainer .innerdiv{
background: transparent url(media/brcorner.gif) bottom right no-repeat;
position: relative;
left: 2px;
top: 2px;
padding: 1px 4px 15px 5px;
}

/*con sombra*/

<![if !IE 6]>



.shiftcontainer{
position: relative;
left: 5px; /*Number should match -left shadow depth below*/
top: 5px; /*Number should match -top shadow depth below*/
}

.shadowcontainer{
width: 220px; /* container width*/
background-color: #d1cfd0;
}

.shadowcontainer .innerdiv{
/* Add container height here if desired */
background-color: white;
border: 1px solid gray;
padding: 6px;
position: relative;
left: -5px; /*shadow depth*/
top: -5px; /*shadow depth*/
}

<![endif]>
.Estilo11 {color: #000000}

table {
  border: -1px solid #03476F;
  font: normal 11px verdana, arial, helvetica, sans-serif;

  }
caption {
  text-align: center;
  font: bold 18px arial, helvetica, sans-serif;
  background: transparent;
  padding:6px 4px 8px 0px;
  color: #03476F;
  text-transform: uppercase;
  }
td, th {
  border: -1px dotted #03476F;
  padding: .4em;
  color: #363636;
  }

thead th, tfoot th {
  font: bold 11px verdana, arial, helvetica, sans-serif;
  border: -1px solid #03476F;;
  text-align: left;
  background: #4591AD;
  color: #FFFFFF;
  padding-top:3px;
  }
tbody td a {
  background: transparent;
  text-decoration: none;
  color: #363636;
  }
tbody td a:hover {
  background: #C2F64D;
  color: #363636;
  }
tbody th a {
  font: normal 11px verdana, arial, helvetica, sans-serif;
  background: transparent;
  text-decoration: none;
  font-weight:normal;
  color: #363636;
  }
tbody th a:hover {
  background: transparent;
  color: #363636;
  }
tbody th, tbody td {
  vertical-align: top;
  text-align: left;
  }
tfoot td {
  border: -1px solid #03476F;
  background: #4591AD;
  padding-top:3px;
  color: #FFFFFF;
  }
.odd {
  background: #AEE239;
  }
.Estilo12 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
/*tbody tr:hover {
  background: #FFD800;
  border: 1px solid #03476F;
  color: #FFFFFF;
  }
tbody tr:hover th,
tbody tr.odd:hover th {
  background: #FFD800;
  color: #FFFFFF;
  }*/
-->
</style>
<script language="javascript">

function abrir(direccion,nombreventana, pantallacompleta, herramientas, direcciones, estado, barramenu, barrascroll, cambiatamano, ancho, alto, izquierda, arriba, sustituir){
    var opciones = "fullscreen=" + pantallacompleta +
                 ",toolbar=" + herramientas +
                 ",location=" + direcciones +
                 ",status=" + estado +
                 ",menubar=" + barramenu +
                 ",scrollbars=" + barrascroll +
                 ",resizable=" + cambiatamano +
                 ",width=" + ancho +
                 ",height=" + alto +
                 ",left=" + izquierda +
                 ",top=" + arriba;
    var ventana = window.open(direccion,nombreventana,opciones,sustituir);

}  
</script>
</head>
<body bgcolor="#64748B">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr bgcolor="#26354A">
	<td height="70" colspan="2" class="logo" nowrap="nowrap">Super Pool Hipico<span class="tagline">Web</span></td>
	</tr>
	<tr bgcolor="#FFCC00">
	<td height="24" colspan="2" bgcolor="#FFFFFF">
	<table id="navigation">
        <tr>
          <ul class="glossymenu">
	<li><a href="index.php"><b>Super Pool Hipico</b></a></li>
	<li class="current"><a href="indexganadores.php"><b>Ganadores</b></a></li>
	<li><a href="indexbeisball.php"><b>Beisball</b></a></li>	
	<li><a href="indexinformacion.php"><b>Informacion</b></a></li>	
	<li><a href="indexayuda.php"><b>Ayuda</b></a></li>	
</ul>
        </tr>
      </table>	</td>
  </tr>
	<tr bgcolor="#D3DCE6">
	<td valign="top" bgcolor="#FFFFFF"><table width="160" height="450" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	<p>&nbsp;</p>
	  <p>&nbsp;</p>
	  </td>
	<td width="908" valign="top" bgcolor="#D3DCE6"><table width="700" height="500" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
	</tr>

	<tr bgcolor="#D3DCE6">
	<td colspan="2"><img src="mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
	</tr>

	<tr>
	<td width="196">&nbsp;</td>
	<td width="908">&nbsp;</td>
	</tr>
</table>
</body>
</html>
