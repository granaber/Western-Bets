 <?php

	function Chaespc($sg)
	{
		$ce = explode('*', $sg);
		$tc = '';
		for ($i = 0; $i <= count($ce) - 1; $i++) {
			$tc = $tc . chr($ce[$i]);
		}
		return trim($tc);
	}

	$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
	mysql_select_db("sphonlin_sphonline", $GLOBALS['link']);



	$tp = $_REQUEST['tp'];
	if ($tp == 1) :

		$IDCN = $_REQUEST['idcn'];
		$idjug = $_REQUEST['idjug'];
		$ne = $_REQUEST['ne'];
		$e = $_REQUEST['e'];
		$es = Chaespc($_REQUEST['es']);
		$ac = Chaespc($_REQUEST['ac']);
		$fac = Chaespc($_REQUEST['fac']);
		$dv = Chaespc($_REQUEST['dv']);



		$vne = explode('*', $ne);
		$ve = explode('*', $e);

		for ($i = 0; $i <= count($vne) - 1; $i++) {
			if ($vne[$i] != '') :
				$result = mysqli_query($GLOBALS['link'], "select * from  _relacion where IDCN=" . $IDCN . " and IDJug=" . $idjug . " and Posi=" . ($i + 1),  $GLOBALS['link']);
				if (mysqli_num_rows($result) == 0) :
					$result = mysqli_query($GLOBALS['link'], "Insert  _relacion values (" . $IDCN . "," . $idjug . "," . ($i + 1) . ",'" . $vne[$i] . "','" . $ve[$i] . "',0)",  $GLOBALS['link']);
				else :
					$result = mysqli_query($GLOBALS['link'], "Update  _relacion set NomEjem='" . $vne[$i] . "', Ejem='" . $ve[$i] . "' where IDCN=" . $IDCN . " and IDJug=" . $idjug . " and Posi=" . ($i + 1),  $GLOBALS['link']);
				endif;
			endif;
		}

		$result = mysqli_query($GLOBALS['link'], "select * from  _relacion12 where IDCN=" . $IDCN . " and IDJug=" . $idjug,  $GLOBALS['link']);
		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "Insert  _relacion12 values (" . $IDCN . "," . $idjug . ",0,'" . $es . "','" . $ac . "','" . $fac . "','" . $dv . "')",  $GLOBALS['link']);
		else :
			$result = mysqli_query($GLOBALS['link'], "Update  _relacion12  set es='" . ($es) . "',ac='" . $ac . "',fac='" . $fac . "',diven='" . $dv . "' where IDCN=" . $IDCN . " and IDJug=" . $idjug,  $GLOBALS['link']);
		endif;

	endif;
	if ($tp == 2) :
		$IDCN = $_REQUEST['idcn'];
		$idjug = $_REQUEST['idjug'];
		$carr = $_REQUEST['carr'];
		$ne = $_REQUEST['ne'];
		$e = $_REQUEST['e'];
		$dv = Chaespc($_REQUEST['dv']);

		$vne = explode('*', $ne);
		$ve = explode('*', $e);

		for ($i = 0; $i <= count($vne) - 2; $i++) {
			$result = mysqli_query($GLOBALS['link'], "select * from  _relacion where IDCN=" . $IDCN . " and IDJug=" . $idjug . " and Posi=" . ($i + 1) . " and carr=" . $carr,  $GLOBALS['link']);
			if (mysqli_num_rows($result) == 0) :
				$result = mysqli_query($GLOBALS['link'], "Insert  _relacion values (" . $IDCN . "," . $idjug . "," . ($i + 1) . ",'" . $vne[$i] . "','" . $ve[$i] . "'," . $carr . ")",  $GLOBALS['link']);
			else :
				$result = mysqli_query($GLOBALS['link'], "Update  _relacion set NomEjem='" . $vne[$i] . "', Ejem='" . $ve[$i] . "' where IDCN=" . $IDCN . " and IDJug=" . $idjug . " and Posi=" . ($i + 1) . " and carr=" . $carr,  $GLOBALS['link']);
			endif;
		}

		$result = mysqli_query($GLOBALS['link'], "select * from  _relacion12 where IDCN=" . $IDCN . " and IDJug=" . $idjug . " and carr=" . $carr,  $GLOBALS['link']);
		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "Insert  _relacion12 values (" . $IDCN . "," . $idjug . "," . $carr . ",'','','','" . $dv . "')",  $GLOBALS['link']);
		else :
			$result = mysqli_query($GLOBALS['link'], "Update  _relacion12  set diven='" . $dv . "' where IDCN=" . $IDCN . " and IDJug=" . $idjug . " and carr=" . $carr,  $GLOBALS['link']);
		endif;
	endif;

	if ($tp == 3) :
		$IDCN = $_REQUEST['idcn'];
		$idjug = $_REQUEST['idjug'];
		$car = $_REQUEST['carr'];
		$e = $_REQUEST['e'];

		$carr = explode('-', $car);

		$ve = explode('*', $e);
		$j = 0;
		$dill = count($ve) / count($carr);
		for ($i = 0; $i <= count($ve) - 1; $i++) {
			if ($i == 2) :
				$j++;
			endif;

			$result = mysqli_query($GLOBALS['link'], "select * from  _relacion where IDCN=" . $IDCN . " and IDJug=" . $idjug . " and Posi=" . ($i + 1) . " and carr=" . $carr[$j],  $GLOBALS['link']);
			if (mysqli_num_rows($result) == 0) :
				$result = mysqli_query($GLOBALS['link'], "Insert  _relacion values (" . $IDCN . "," . $idjug . "," . ($i + 1) . ",'','" . $ve[$i] . "'," . $carr[$j] . ")",  $GLOBALS['link']);
			else :
				$result = mysqli_query($GLOBALS['link'], "Update  _relacion set  Ejem='" . $ve[$i] . "' where IDCN=" . $IDCN . " and IDJug=" . $idjug . " and Posi=" . ($i + 1) . " and carr=" . $carr[$j],  $GLOBALS['link']);
			endif;
		}


	endif;
	if ($tp == 0) :
		$IDCN = $_REQUEST['idcn'];
		$obs = $_REQUEST['obs'];

		$result = mysqli_query($GLOBALS['link'], "select * from  _relacion13 where IDCN=" . $IDCN,  $GLOBALS['link']);
		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "Insert  _relacion13 values (" . $IDCN . ",'" . $obs . "')",  $GLOBALS['link']);
		else :
			$result = mysqli_query($GLOBALS['link'], "Update  _relacion13  set Observa='" . $obs . "' where IDCN=" . $IDCN,  $GLOBALS['link']);
		endif;
	endif;
	?>
