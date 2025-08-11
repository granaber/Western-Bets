<?



$MonitorArr = array();
$tik = 0;
$serial = 0;
$result = mysqli_query($link, "Select * From  _Jugada_ani  Where Activo=1  and  IDJ=" . $IDJ);
while ($Row = mysqli_fetch_array($result)) {
  $data = unserialize(decoBaseK($Row['Jugada']));

  $tik++;
  foreach ($data as $i => $value) {
    if ($data[$i]->sorteo == $IDS) :
      $numero = $data[$i]->numero;
      $sorteo = $data[$i]->sorteo;
      $monto = $data[$i]->monto;

      if (isset($MonitorArr[$sorteo][$numero])) :
        $MonitorArr[$sorteo][$numero]['monto'] += $monto;
        $MonitorArr[$sorteo][$numero]['tk'] += $tik;
      else :
        $MonitorArr[$sorteo][$numero] = array('monto' => $monto, 'tk' => $tik);

      endif;
    endif;
  }
  $serial = $Row['serial'];
}

echo '<table  border="1" style="border-color:#000">';
$result = mysqli_query($link, "Select * From  _NumeroAnimatios  Where Activo=1");
$nl = 0;
$alt = 0;
while ($Row = mysqli_fetch_array($result)) {
  if ($nl == 6) :
    echo '</tr>';
    $nl = 0;
  endif;
  if ($nl == 0) echo '<tr>';
  switch ($alt) {
    case '0':
      $sty = 'style="background:#39C; color:#FFFFFF"';
      $pp = 'style="color:#FF3; font-size:18px"';
      $alt = 1;
      break;

    case '1':
      $sty = 'style="background:#FFF; color:#000000"';
      $pp = 'style="color:#000; font-size:18px"';
      $alt = 0;
      break;
  }
  $Mnt = '';
  $Ntk = '0';
  if (isset($MonitorArr[$IDS][$numero])) :
    if ($MonitorArr[$IDS][$Row['num']]['monto'] != 0) :
      $Mnt = number_format($MonitorArr[$IDS][$Row['num']]['monto'], 2, ',', '.');
      $Ntk = $MonitorArr[$IDS][$Row['num']]['tk'];
    endif;
  endif;
  $idM = $IDS . '_' . $Row['num'];

  echo '<td ' . $sty . '  width="150px"><img src="animalitos/imag/' . $Row['figura'] . '" /><spam id="' . $idM . '" ' . $pp . '>' . $Mnt . '</spam><br>' . $Row['nombre'] . '(<spam id="' . $idM . '_N" >' . $Ntk . '</spam>)</td>';
  $nl++;
}
echo '</tr>';
echo '</table>';
