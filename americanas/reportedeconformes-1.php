<div class="badge badge-secondary text-wrap" style="width: 10rem;font-size:12px">
    <?= $descrip; ?>
</div>
<?


$DiviExoticaEspecial = array();
$sql = 'select * from _tdividendohi where IDCN=' .   $IDCN . ' group by carrera order by carrera';
$result4 = mysqli_query($linkAme, $sql);

?>
<table class="table  table-hover cursoHand" style="font-size: 10px;">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Carr</th>
            <th scope="col" class="min-col-table">1ª</th>
            <th scope="col" class="min-col-table">2ª</th>
            <th scope="col" class="min-col-table">3ª</th>
            <th scope="col" class="min-col-table">4ª</th>
            <?
            for ($gam = 1; $gam <= count($games); $gam++) {
                $DiviExoticaEspecial[$gam] = '-';
                echo '<th scope="col">' . $games[$gam] . '</th>';
            }

            ?>
        </tr>
    </thead>
    <tbody>
        <?
        while ($row4 = mysqli_fetch_array($result4)) {
            $listaCap[] = $row4['carrera'];
            $inSqlDivi = "Select _tdividendohi_exo.*,_tdjuegoshi.IDJug from _tdividendohi_exo,_tdjuegoshi where _tdividendohi_exo.Code=_tdjuegoshi.Code and  IDCN=" . $row4['IDCN'] . " and DivIn=" . $row4['carrera'] . " order by _tdjuegoshi.IDJug ";
            // echo   $inSqlDivi;
            // echo '<br>';
            $resulExotica = mysqli_query($linkAme, $inSqlDivi);
            while ($rowEspecial = mysqli_fetch_array($resulExotica)) {
                $DiviExoticaEspecial[$rowEspecial['IDJug']] = $rowEspecial['dividendo'] . '(' . $rowEspecial['win'] . ')';
            }
            // print_r($DiviExoticaEspecial);
            //17.8,9.4,3.6,
            //4.6,3.4,,
            //2.8,,,40.7,135,88.82
            $dividendos = explode(',', $row4['Dividendos']);

            $divll = [];
            $sub = 0;
            $x = 0;
            // print_r($dividendos);
            for ($j = 0; $j <= count($dividendos) - 1; $j++) {
                if ($sub <= 2) {
                    $sub++;
                } else {
                    $sub = 0;
                    $x++;
                }

                if (!isset($divll[$x])) {
                    $divll[$x] = "";
                }

                if (trim($dividendos[$j]) != '') {
                    $divll[$x] .= '<span class="d-inline-block mb-1" tabindex="0"  data-toggle="tooltip" data-placement="bottom" title="' . $dividendos[$j] . '"><a class="badge badge-dark mb-1" >' . $dividendos[$j] . '</a></span>';
                } else {
                    $sub = 0;
                    $x++;
                    if (!isset($divll[$x])) {
                        $divll[$x] = "";
                    }
                    $divll[$x] .= '<span class="d-inline-block mb-1" tabindex="0"  data-toggle="tooltip" data-placement="bottom" title=""><a class="badge badge-dark" ></a></span>';
                }
            }

        ?>
        <tr>
            <th scope="col">
                <? echo $row4['carrera']; ?>
            </th>
            <th scope="col"><span class="badge badge-primary mb-1" data-toggle="tooltip" data-placement="bottom"
                    title="<? echo $row4['Primero']; ?>">
                    <? echo $row4['Primero'] . '</span> ' . $divll[0]; ?>
            </th>
            <th scope="col"><span class="badge badge-warning mb-1" data-toggle="tooltip" data-placement="bottom"
                    title="<? echo $row4['Segundo']; ?>">
                    <? echo $row4['Segundo'] . '</span> ' . $divll[1]; ?>
            </th>
            <th scope="col"><span class="badge badge-info mb-1" data-toggle="tooltip" data-placement="bottom"
                    title="<? echo $row4['Tercero']; ?>">
                    <? echo $row4['Tercero'] . '</span> ' . $divll[2]; ?>
            </th>
            <th scope="col"><span class="badge badge-secondary mb-1" data-toggle="tooltip" data-placement="bottom"
                    title="<? echo $row4['cuarto']; ?>">
                    <? echo $row4['cuarto']; ?>
                </span>
            </th>
            <? for ($gam = 0; $gam < 3; $gam++) {
                    $posic = $PosiDividendo[($gam + 1)];
                ?>
            <th scope="col"><span class="badge badge-dark" data-toggle="tooltip" data-placement="bottom"
                    title="<?= $dividendos[$posic]; ?>">
                    <?= $dividendos[$posic]; ?>
                </span>
            </th>
            <? } ?>


            <? for ($gam2 = $gam + 1; $gam2 < count($DiviExoticaEspecial); $gam2++) {
                    if ($DiviExoticaEspecial[$gam2] != '-') {
                ?>
            <th scope="col"><span class="badge badge-dark" data-toggle="tooltip" data-placement="bottom"
                    title="<?= $DiviExoticaEspecial[$gam2]; ?>">
                    <?= $DiviExoticaEspecial[$gam2]; ?>
                </span>
            </th>
            <? } else { ?>

            <th scope="col">
            </th>
            <? }
                }
                $DiviExoticaEspecial = array_fill(0, count($DiviExoticaEspecial), '-');
                ?>
        </tr>

        <?   } ?>
    </tbody>
</table>