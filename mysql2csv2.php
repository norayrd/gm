 <?php
  include "scripts/gm_access.php"; 
  $query = "select tm.tov_make, p.tov_kod, p.tov_name, p.cena_*vc.cours_ * ph.nacenka_ cena_, p.count_, ph.pricesh_kod
              from p_pricesh ph left join p_prices p on ph.pricesh_kod=p.pricesh_kod
                      left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod
                      left join gm_valyuta_cours vc on vc.valyuta_kod=ph.valyuta_kod
                where ph.city_id1=2653 and ph.hide_<>1 and ph.temp_<>1
                order by tm.tov_make, p.tov_kod";

  $kar = mysql_query($query);
  if(!$kar) exit("Ошибка ".mysql_error());
  if(mysql_num_rows($kar))
  {
    unlink("download/"."avto-polit-price.csv");
    $filename="download/avto-polit-price.csv";
    $fd = fopen($filename, "w");
      $order = "tov_make;tov_kod;tov_name;cena_;count_;pricesh_kod;обновлен ".date("d-m-Y")."\r\n";
      fwrite($fd, $order);

    while($kart = mysql_fetch_array($kar))
    {
      $order = '"'.$kart['tov_make'].'";'.
               '"'.$kart['tov_kod'].'";'.
               '"'.$kart['tov_name'].'";'.
               $kart['cena_'].';'.
               '"'.$kart['count_'].'";'.
               $kart['pricesh_kod']."\r\n";
      fwrite($fd, $order);
    }
    fclose($fd);
  }
?>