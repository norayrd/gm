<?php
include "scripts/gm_access.php"; 
// !заголовок
 
/*
// раскомментируйте строки ниже, если файл не будет загружаться
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
*/
//стандартный заголовок, которого обычно хватает
    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header("Content-Disposition: attachment;filename=".date("d-m-Y")."-export.xls");
    header("Content-Transfer-Encoding: binary ");
 
// !! Шапка хтмл
 
echo '
   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=windows-1251" />
        <meta name="author" content="zabey" />
        <title>Demo</title>
    </head>
    <body>
';
 
// !!! Таблица с данными
 
// заголовок таблицы
echo '<table border="1"> <tr> <th>бренд</th> <th>код</th><th>наименование</th><th>цена</th><th>количество</th><th>прайс</th> </tr>';

        $sql_="select tm.tov_make, p.tov_kod, p.tov_name, p.cena_*vc.cours_ * ph.nacenka_ cena_, p.count_, ph.pricesh_kod
                 from p_pricesh ph left join p_prices p on ph.pricesh_kod=p.pricesh_kod
                      left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod
                      left join gm_valyuta_cours vc on vc.valyuta_kod=ph.valyuta_kod
                where ph.city_id1=2653 and ph.hide_<>1 and ph.temp_<>1
                order by tm.tov_make, p.tov_kod
                limit 100 ";
        $tb=mysql_query($sql_);
        @$tb_n=mysql_numrows($tb);
        $i_=0;
        while ($i_<$tb_n) {
            $tov_make=mysql_result($tb,$i_,"tov_make");
            $tov_kod=mysql_result($tb,$i_,"tov_kod");
            $tov_name=mysql_result($tb,$i_,"tov_name");
            $cena_=mysql_result($tb,$i_,"cena_");
            $count_=mysql_result($tb,$i_,"count_");
            $pricesh_kod=mysql_result($tb,$i_,"pricesh_kod");

            echo "<tr> <td>$tov_make</td> <td>$tov_kod</td> <td>$tov_name</td> <td>$cena_</td> <td>$count_</td> <td>$pricesh_kod</td> </tr>";

            $i_+=1;
        }

/*while($row = $STH->fetch()){ // формирование тела таблицы. Выберете ваш метод самостоятельно.
    echo '<tr>
        <td>'.$row['col1'].'</td>
        <td>'.$row['col2'].'</td>
          </tr>';
} */

echo '</table>';
echo '</body></html>';
// не забываем закрывать таблицу, боди и сам хтмл документ
?>