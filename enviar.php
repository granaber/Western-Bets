<?php 
$dato=$_GET["fecha"];
$xpos=$_GET["pos"];
?>

<script language='javascript'>
if (<?php echo $xpos; ?> == 1)
{
window.opener.document.getElementById("fc").value='<?php echo $dato; ?>';
window.opener.document.getElementById("fc").focus();
}
if (<?php echo $xpos; ?> == 2)
{
window.opener.document.getElementById("fecha_2").value='<?php echo $dato; ?>';
window.opener.document.getElementById("fecha_2").focus();
}
 window.close();
</script>