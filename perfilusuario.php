 <?php

	$cmp = $_REQUEST['cmp'];

	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();

	$i = 1;
	$en[0] = false;
	$resultMENU = mysqli_query($GLOBALS['link'], " SELECT *  FROM _tmenu where  " . $cmp . "=1");

	if (mysqli_num_rows($resultMENU) != 0) :
		$en[0] = true;
		while ($row = mysqli_fetch_array($resultMENU)) {
			$en[$i] = $row['variable'];
			$i++;
		}
	endif;
	echo json_encode($en);

	?>