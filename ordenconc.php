<table class="ta_borde" border="0" cellpadding="3" cellspacing="0" width="505">
	<tbody>
		<?php
		/* if (isset($_REQUEST['opc'])):
 require('prc_php.php');  
 $GLOBALS['link'] = Connection::getInstance();  

 $opc = $_REQUEST["opc"];
 $busq = $_REQUEST["bq"];
 $ord = $_REQUEST["ord"];
            if ($opc == 1):
            $result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconsecionario Order By IDC Asc" );
			elseif ($opc == 2):
			$result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconsecionario Order By IDC Desc" );
			elseif ($opc == 3):
				if ($busq == 0):
					$result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconsecionario " );
				else:
					$result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconsecionario Where IDG=".$busq );
				endif;
			elseif ($opc==4):
				if ($ord == 1):
					if ($busq == 0):
						$result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconsecionario Order By IDC Asc" );
					else:
						$result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconsecionario Where IDG=".$busq." Order By IDC Asc" );
					endif;
				else:
					if ($busq == 0):
						$result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconsecionario Order By IDC Desc" );
					else:
						$result = mysqli_query($GLOBALS['link'],"SELECT * FROM _tconsecionario Where IDG=".$busq." Order By IDC Desc" );
					endif;
				endif;
			endif;	
  
endif;           
 */ $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where IDG=" . $row_g['IDG']);
		$un = 1;
		while ($row = mysqli_fetch_array($result)) {
			if ($un == 1) :
				echo "<tr class='ta_tr_left' bgcolor='white'>";
				$un = 0;
			else :
				echo "<tr class='ta_tr_left' >";
				$un = 1;
			endif;
			if ($row["Estatus"] == 1) :
				echo "<td  width='300' style='color:#000'> <img src='media/users.png' />";
			endif;
			if ($row["Estatus"] == 2) :
				echo "<td  width='350' style='color:#000'> <img src='media/delete.png' />";
			endif;
			echo "  Consecionario: <u><strong>" . $row["IDC"] . "</strong></u> Nombre " . $row["Nombre"];

			echo "</td>";
			$vc = "'consecionario.php?fc=" . $row["IDRow"] . "'";
			echo '<td > <input type="button" value="ver" title="' . $vc . '" onclick="javascript:makeRequest(' . $vc . ');"></td>';
		}

		?>
	</tbody>
</table>