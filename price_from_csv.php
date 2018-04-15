<?php
require_once "scripts/gm_access.php";
require_once "scripts/gm_tools_avto.php";
		
if(isset($_POST['upload'])){
	$tb=mysql_query("select * from p_pricesh where (user_id='$user_id')and(temp_=1)");
	if (mysql_numrows($tb)==0) mysql_query("insert into p_pricesh (name_,hide_,user_id, temp_,city_id1)values('*temp*',1,'$user_id',1,0)"); //если нет, то создаем временный склад
	$tb=mysql_query("select pricesh_kod from p_pricesh where (user_id='$user_id')and(temp_=1)");
	@$tb_n=mysql_numrows($tb);
	if ($tb_n>0) $pricesh_kod=mysql_result($tb,0,"pricesh_kod");

	if ($pricesh_kod>0){
		$folder = 'upload/';
		$uploadedFile = $folder.time().".csv"; //basename( basename($_FILES['price_file']['name']);
		if(is_uploaded_file($_FILES['price_file']['tmp_name'])){
			if(move_uploaded_file($_FILES['price_file']['tmp_name'],$uploadedFile)) {
				echo "Файл загружен<br>";
				csv2mysql($uploadedFile);
				unlink($uploadedFile);
				echo "<script> location.replace('price.php?pricesh=$pricesh_kod'); </script>"; 
				exit; 
			} else echo "Во время загрузки файла произошла ошибка";
		}else echo "Файл не  загружен";
	}else echo "Ошибка: не удалось создать временный прайс!";
}

	function csv2mysql($csv_file_name){
		global $pricesh_kod;
		//print $csv_file_name;
		//$csv_file_name=$_GET["filename"];
		if (isset($csv_file_name)&&($csv_file_name!="")) {
			$pricesh_name=$_POST["price_name"]."";
            $pricesh_srok_min=$_POST["price_srok_min"]-0;
            $pricesh_srok_max=$_POST["price_srok_max"]-0;
			if (isset($_POST["price_valyuta_kod"])) 	$pricesh_valyuta_kod=$_POST["price_valyuta_kod"]; 		else $pricesh_valyuta_kod=980;
			if (isset($_POST["price_nacenka"])) 		$pricesh_nacenka=$_POST["price_nacenka"]; 				else $pricesh_nacenka=1.5;
			if (isset($_POST["price_moy_sklad"])) {
				if ($_POST["price_moy_sklad"]=="1") $pricesh_moy_sklad=1; else $pricesh_moy_sklad=0;
			} else $pricesh_moy_sklad=0;
			if (isset($_POST["price_hide"])) {
				if ($_POST["price_hide"]=="1") $pricesh_hide=1; else $pricesh_hide=0;
			} else $pricesh_hide=0;
			if (isset($_POST["price_destination"])) 	$pricesh_destination=$_POST["price_destination"]*1; 		else $pricesh_destination=0;
            
            $pricesh_pr_city_id1=0;
            $pricesh_pr_city_id2=0;
            $pricesh_pr_city_id3=0;
            $pricesh_pr_city_id4=0;
            $pricesh_pr_city_id5=0;
            $pricesh_pr_view_status=0;
            $pricesh_pr_city_count=1;
            
            if ($pricesh_destination>0) {
                $tb=mysql_query("select * from p_pricesh ph where ph.pricesh_kod=$pricesh_destination");
                @$tb_n=mysql_numrows($tb);
                if ($tb_n>0) $pricesh_kod;
                    $pricesh_pr_tel=mysql_result($tb,0,"tel_")."";
                    $pricesh_pr_email=mysql_result($tb,0,"email_")."";
                    $pricesh_pr_skype=mysql_result($tb,0,"skype_")."";
                    $pricesh_pr_icq=mysql_result($tb,0,"icq_")."";
                    $pricesh_pr_view_status=mysql_result($tb,0,"view_status")-0;
                    $pricesh_pr_city_count=mysql_result($tb,0,"city_count")-0;
                    $pricesh_pr_search_url=mysql_result($tb,0,"search_url")."";
                    $pricesh_pr_search_url_login=mysql_result($tb,0,"search_url_login")."";
                    $pricesh_pr_search_url_pass=mysql_result($tb,0,"search_url_pass")."";
                    $pricesh_pr_manager=mysql_result($tb,0,"manager_")."";
                    $pricesh_pr_city_id1=mysql_result($tb,0,"city_id1")-0;
                    $pricesh_pr_city_id2=mysql_result($tb,0,"city_id2")-0;
                    $pricesh_pr_city_id3=mysql_result($tb,0,"city_id3")-0;
                    $pricesh_pr_city_id4=mysql_result($tb,0,"city_id4")-0;
                    $pricesh_pr_city_id5=mysql_result($tb,0,"city_id5")-0;
            }
                                        
			$sql="update p_pricesh ph 
                     set ph.name_='$pricesh_name', 
                         ph.update_date=current_date, 
                         ph.srok_min=$pricesh_srok_min, 
                         ph.srok_max=$pricesh_srok_max, 
                         ph.valyuta_kod=$pricesh_valyuta_kod, 
                         ph.nacenka_=$pricesh_nacenka, 
                         ph.hide_=$pricesh_hide, 
                         ph.moy_sklad=$pricesh_moy_sklad, 
                         ph.destination_=$pricesh_destination,
                         tel_='$pricesh_pr_tel', 
                         email_='$pricesh_pr_email', 
                         skype_='$pricesh_pr_skype', 
                         icq_='$pricesh_pr_icq', 
                         view_status=$pricesh_pr_view_status, 
                         city_count=$pricesh_pr_city_count,
                         search_url='$pricesh_pr_search_url',
                         search_url_login='$pricesh_pr_search_url_login',
                         search_url_pass='$pricesh_pr_search_url_pass',
                         manager_='$pricesh_pr_manager', 
                         city_id1=$pricesh_pr_city_id1, 
                         city_id2=$pricesh_pr_city_id2, 
                         city_id3=$pricesh_pr_city_id3, 
                         city_id4=$pricesh_pr_city_id4, 
                         city_id5=$pricesh_pr_city_id5
                   where ph.pricesh_kod=$pricesh_kod";
			// print $sql; exit;
			mysql_query($sql);
			//удаляем старые записи
			$sql="delete from tmp_prices where pricesh_kod=$pricesh_kod";
			mysql_query($sql);
            
            $fh = fopen($csv_file_name, "r");
            //бренд;код;наименование;цена;количество;группа
            //пропускаем заголовок
            $line = fgetcsv($fh, 1000, ";");
            while($line = fgetcsv($fh, 1000, ";")) {
                if (!empty($line[0]) && !empty($line[1]) && !empty($line[2]) && !empty($line[3])) {
                    $tov_make=trim($line[0]);
                    $tov_kod=tov_kod_clear(trim($line[1]));
                    $tov_kod2=tov_kod_clear(trim($line[6]));
                    $tov_name=$line[2];
                    if (strlen($tov_name)>50) $tov_name=substr($tov_name,0,50);
                    $tov_cena=floatval(str_replace(",",".",$line[3]));
                    if (!empty($line[4])) $tov_count=$line[4]; else $tov_count="";
                    if (!empty($line[5])) $tov_group_kod=$line[5]; else $tov_group_kod="null";
                    if ($tov_cena>=0) {
                        //$sql = "insert into tmp_prices (tov_make, tov_kod, tov_name, cena_,count_,pricesh_kod, group_kod,tov_kod2,tov_make_kod) values('$tov_make', '$tov_kod', '$tov_name', $tov_cena, '$tov_count', $pricesh_kod, $tov_group_kod, '$tov_kod2',get_tov_make_kod('$tov_make'))"; // Создаём запрос mysql
                        $sql = "insert into tmp_prices (tov_make, tov_kod, tov_name, cena_,count_,pricesh_kod, group_kod,tov_kod2,tov_make_kod) values(upper('$tov_make'), '$tov_kod', '$tov_name', $tov_cena, '$tov_count', $pricesh_kod, $tov_group_kod, '$tov_kod2',null)"; // Создаём запрос mysql
                        mysql_query($sql);
                        /*if ((mysql_affected_rows()>0) && ( !empty($line[7]) || !empty($line[8]) || !empty($line[9]) || !empty($line[10]) || !empty($line[11]) || !empty($line[12]) || !empty($line[13]) ) ) {
                            if (!empty($line[7])) $tov_width=trim($line[7]); else $tov_width="null";
                            if (!empty($line[8])) $tov_height=trim($line[8]); else $tov_height="null";
                            if (!empty($line[9])) $tov_radius="'".trim($line[9])."'"; else $tov_radius="null";
                            if (!empty($line[10])) $tov_season=trim($line[10]); else $tov_season="0";
                            if (!empty($line[11])) $tov_typ=trim($line[11]); else $tov_typ="0";
                            if (!empty($line[12])) $tov_country_name="'".trim($line[12])."'"; else $tov_country_name="null";
                            if (!empty($line[13])) $tov_indexsn="'".trim($line[13])."'"; else $tov_indexsn="null";
                            $sql = "insert into p_prices_dop (prices_kod,width_,height_,radius_,season_,typ_,country_id,index_sn) 
                                    select AUTO_INCREMENT-1,$tov_width,$tov_height,$tov_radius,$tov_season,$tov_typ,(select country_id from gm_country where name_ru=$tov_country_name),$tov_indexsn
                                      from information_schema.TABLES 
                                     where (table_schema=DATABASE()) and (table_name='p_prices')";
                            mysql_query($sql);
                        }*/
                        mysql_query("COMMIT");
                    }
                }
            }
		}else echo "Ошибка: файл не указан или не найден!";
	}
?>