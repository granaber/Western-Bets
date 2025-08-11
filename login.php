<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Nifty Corners: Javascript and CSS rounded corners</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="generator" content="HAPedit 3.1">
<style type="text/css">


div#box{width: 18em;padding:0;margin:0 auto;
    background:#B5BBCB ;color:#111}
h1{font: lighter 200% "Trebuchet MS",Arial sans-serif;color: #208BE1}
h1,p{margin:0;padding:10px 20px}
.Estilo1 {
	font-size: 12px
}
body {
	background-color: transparent; border:none;
	  
	
	
}
ul.postnav,ul.postnav li{margin:0;padding:0;list-style-type:none}
ul.postnav li{float:left;font-size:50%;}
ul.postnav a{
	display:block;
	width:36em;
	padding:10px 0;
	font: bold 100% Verdana,Arial,sans-serif;
	text-transform:uppercase;
	background: #26354A;
	color: #FFFFFF;
	text-decoration:none;
	text-align:center
}
ul.postnav a:hover{background: #111;color:#FFF}

.boton1{
        font-size:10px;
        font-family:Verdana,Helvetica;
        font-weight:bold;
        color:white;
        background:#638cb5;
        border:0px;
        width:80px;
        height:19px;
       }
</style>
<script type="text/javascript" src="NiftyCube/niftycube.js"></script>
<script type="text/javascript">
NiftyLoad=function(){
Nifty("div#box","small");
Nifty("ul.postnav a","transparent");
conteo=0;
}
</script>
</head>
<body>
<div id="box">
<ul class="postnav"> 
<li><a href="#">Acceso al Sistema</a></li>
</ul> <p class="Estilo1">&nbsp;</p>
<h1 align="center" class="Estilo1">Usuario:   
  <input  id="user_x" type="text"  size="20" maxlength="10"  >
</h1>
<h1 align="center" class="Estilo1"> Clave :   
  <input id="pwd" type="password" size="20" maxlength="10" >
</h1 >
&nbsp;
  <div align="center">
    <input type="submit" class="boton1" name="button" id="button" value="Entrar" onClick="void(top.pop1.acced(document.getElementById('user_x').value,document.getElementById('pwd').value));document.getElementById('user_x').value='';document.getElementById('pwd').value='';"> &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" class="boton1" name="button2" id="button2" value="Cancelar" onClick="document.getElementById('user_x').value='';document.getElementById('pwd').value='';void(top.pop1.hide());">
  </div>
  &nbsp;
</div>
&nbsp;
</body>
</html>


