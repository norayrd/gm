<?php
include "scripts/gm_access.php"; 
    function export_csv(
        $filename, 	 	// Имя CSV файла для сохранения информации
                    // (путь от корня web-сервера)
        $delim=',', 		// Разделитель полей в CSV файле
        $enclosed='"', 	 	// Кавычки для содержимого полей
        $escaped='\\', 	 	// Ставится перед специальными символами
        $lineend='\\r\\n'){  	// Чем заканчивать строку в файле CSV

        $sql_="select tm.tov_make, p.tov_kod, p.tov_name, p.cena_*vc.cours_ * ph.nacenka_ cena_, p.count_, ph.pricesh_kod
               into outfile '".$filename."' FIELDS TERMINATED BY '$delim' ENCLOSED BY '$enclosed' ESCAPED BY '$escaped' LINES TERMINATED BY '$lineend' 
                 from p_pricesh ph left join p_prices p on ph.pricesh_kod=p.pricesh_kod
                      left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod
                      left join gm_valyuta_cours vc on vc.valyuta_kod=ph.valyuta_kod
                where ph.city_id1=2653 and ph.hide_<>1 and ph.temp_<>1
                order by tm.tov_make, p.tov_kod limit 100 ";

//        $sql_="select tm.tov_make, p.tov_kod, p.tov_name, p.cena_*vc.cours_ * ph.nacenka_ cena_, p.count_, ph.pricesh_kod
//               into outfile '".$_SERVER['DOCUMENT_ROOT'].$filename."' FIELDS TERMINATED BY '$delim' ENCLOSED BY '$enclosed' ESCAPED BY '$escaped' LINES TERMINATED BY '$lineend' 
//                 from p_pricesh ph left join p_prices p on ph.pricesh_kod=p.pricesh_kod
//                      left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod
//                      left join gm_valyuta_cours vc on vc.valyuta_kod=ph.valyuta_kod
//                where ph.city_id1=2653 and ph.hide_<>1 and ph.temp_<>1
//                order by tm.tov_make, p.tov_kod limit 100 ";

        // Если файл существует, при экспорте будет выдана ошибка
        if(file_exists($filename)) unlink($filename);
        return mysql_query($sql_);
    }

    export_csv("upload/".date("d-m-Y")."-export.csv",',','"','\\','\\r\\n');

?>