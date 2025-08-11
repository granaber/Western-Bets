<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$ArrMon = _NowMonitor($_REQUEST['IDJ'], $_REQUEST['IDS']);
//print_r($ArrMon);
//echo $_REQUEST['IDS']; echo '<br>';
//echo $_REQUEST['IDJ'];
$NewMon = $ArrMon[$_REQUEST['IDS']];
$Suma = 0;
$Tk = 0;
if (count($NewMon) != 0):
  foreach ($NewMon as $i => $value) {
    $Suma += $NewMon[$i]['monto'];
  }
  foreach ($NewMon as $i => $value) {
    $Tk += $NewMon[$i]['tk'];
    $ArrMon[$_REQUEST['IDS']][$i]['monto'] = number_format($NewMon[$i]['monto'], 2, ',', '.');
    $sup = $NewMon[$i]['monto'];
    if ($sup != 0): $porc = ($sup / $Suma) * 100;
      $porc = number_format($porc, 2, ',', '.') . '%';
    else: $porc = '';
    endif;
    $ArrMon[$_REQUEST['IDS']][$i]['porce'] = $porc;
  }
endif;
$ArrMon[$_REQUEST['IDS']]['Total']['monto'] = number_format($Suma, 2, ',', '.');
$ArrMon[$_REQUEST['IDS']]['Total']['tk'] = $Tk;
echo json_encode($ArrMon);
