<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$result = mysqli_query($GLOBALS['link'], "SELECT _hipodromoshi .* FROM _tconfjornadahi , _hipodromoshi  WHERE _tconfjornadahi.IDhipo = _hipodromoshi._idhipo AND (STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $_REQUEST['fecha'] . "','%d/%m/%Y') and STR_TO_DATE('" . $_REQUEST['fecha'] . "','%d/%m/%Y')) group by _idhipo order by _idhipo");


?>

<div id="box6" style="background: #036; color: #FC0">


	<table border="0">
		<tr style="color:#FC0">
			<td align="center"><span style="color:#FC0; font-size:14px"">Hipodromo</span></td>
    <td align=" center"><span style="color:#FC0; font-size:14px"">Past Performan</span></td>
    <td align=" center"><span style="color:#FC0; font-size:14px"">Winners</span></td>
    <td align=" center"><span style="color:#FC0; font-size:14px"">Resultados</span></td>
     <td align=" center"><input name="" type="button" value="Subir Archivo" onclick="cambiofile('<? echo $_REQUEST['fecha']; ?>')" /></td>
		</tr>
		<?
		$lisvalores = '';
		$i = 0;
		while ($row = mysqli_fetch_array($result)) {
			echo '<tr>';
			echo ' <td><span style="color:#FFF; font-size:14px"">' . $row["Descripcion"] . '</span></td>';
			echo ' <td><form id="fromiut_1_' . $row["_idhipo"] . '" method="post" enctype="multipart/form-data"    action="controlUpload3.php?id=1&pr=' . $row["_idhipo"] . '" target="iframeUpload" >  <input name="fileUpload_1_' . $row["_idhipo"] . '" type="file" id="imagen_1_' . $row["_idhipo"] . '"  lang="0" onchange="uploadFile2(this.id,1,' . $row["_idhipo"] . ');" ></form></td>';
			echo ' <td><form id="fromiut_2_' . $row["_idhipo"] . '" method="post" enctype="multipart/form-data"    action="controlUpload3.php?id=2&pr=' . $row["_idhipo"] . '" target="iframeUpload" ><input name="fileUpload_2_' . $row["_idhipo"] . '" type="file" id="imagen_2_' . $row["_idhipo"] . '" lang="0" onchange="uploadFile2(this.id,2,' . $row["_idhipo"] . ');" ></form></td>';
			echo ' <td><form id="fromiut_3_' . $row["_idhipo"] . '" method="post" enctype="multipart/form-data"    action="controlUpload3.php?id=3&pr=' . $row["_idhipo"] . '" target="iframeUpload" ><input name="fileUpload_3_' . $row["_idhipo"] . '" type="file" id="imagen_3_' . $row["_idhipo"] . '" lang="0" onchange="uploadFile2(this.id,3,' . $row["_idhipo"] . ');" ></form></td>';
			echo ' <td></td>';
			echo '</tr>';
			$i++;
			$lisvalores = $lisvalores . 'imagen_1_' . $row["_idhipo"] . ',imagen_2_' . $row["_idhipo"] . ',imagen_3_' . $row["_idhipo"] . ',';
		}
		?>



	</table>
	<iframe name="iframeUpload" style="display:none"></iframe>
</div>
<span id='lvr' lang="<? echo  $lisvalores; ?>"></span>
<span id='cant' lang="<? echo  $i; ?>"></span>
<span id='fch' lang="<? echo $_REQUEST['fecha']; ?>"></span>
<script>
	Nifty('div#box6', 'big');
</script>