<?php
require_once "scripts/gm_access.php";
// pricesh_kod обязательно должна присутствовать на этой странице (>0)
$pricesh_kod=$_GET["pricesh"]*1;
if ($user_group<3) {
	//print "Доступ запрещен!";
	//include "_autentication.php";
} else if ($pricesh_kod<=0) {
	print "Неверный прайс!";
} else {
?>
	<?php
		//сохраняем изменения сделанные в этой странице, и переносим темп - в реальный прайс
		if (isset($_POST["price_save"])) {
			$save_pr_name=$_POST["price_name"]."";
            $save_pr_srok_min=$_POST["price_srok_min"]."";
            $save_pr_srok_max=$_POST["price_srok_max"]."";
			$save_pr_valyuta_kod=$_POST["price_valyuta_kod"]*1;
			$save_pr_nacenka=$_POST["price_nacenka"]*1;
			$save_pr_moy_sklad=$_POST["price_moy_sklad"]*1;
			$save_pr_hide=$_POST["price_hide"]*1;
			$save_pr_source=$_POST["price_source"]*1;

            $save_pr_tel=$_POST["price_tel"]."";
            $save_pr_email=$_POST["price_email"]."";
            $save_pr_skype=$_POST["price_skype"]."";
            $save_pr_icq=$_POST["price_icq"]."";
            $save_pr_view_status=$_POST["price_view_status"]-0;
            $save_pr_city_count=$_POST["price_city_count"]-0;
            
            $save_pr_search_url=$_POST["price_search_url"]."";
            $save_pr_search_url_login=$_POST["price_search_url_login"]."";
            $save_pr_search_url_pass=$_POST["price_search_url_pass"]."";
            $save_pr_manager=$_POST["price_manager"]."";
            $save_pr_city_id1=$_POST["city_id1"]-0;
            $save_pr_city_id2=$_POST["city_id2"]-0;
            $save_pr_city_id3=$_POST["city_id3"]-0;
            $save_pr_city_id4=$_POST["city_id4"]-0;
            $save_pr_city_id5=$_POST["city_id5"]-0;
            $save_pr_temp=$_POST["price_temp"]-0;

			$sql="update p_pricesh 
                     set name_='$save_pr_name', 
                         srok_min='$save_pr_srok_min', 
                         srok_max='$save_pr_srok_max', 
                         valyuta_kod=$save_pr_valyuta_kod, 
                         nacenka_=$save_pr_nacenka, 
                         hide_=$save_pr_hide, 
                         moy_sklad=$save_pr_moy_sklad, 
                         user_id=$user_id, 
                         tel_='$save_pr_tel', 
                         email_='$save_pr_email', 
                         skype_='$save_pr_skype', 
                         icq_='$save_pr_icq', 
                         view_status=$save_pr_view_status, 
                         city_count=$save_pr_city_count,
                         search_url='$save_pr_search_url',
                         search_url_login='$save_pr_search_url_login',
                         search_url_pass='$save_pr_search_url_pass',
                         manager_='$save_pr_manager', 
                         city_id1=$save_pr_city_id1, 
                         city_id2=$save_pr_city_id2, 
                         city_id3=$save_pr_city_id3, 
                         city_id4=$save_pr_city_id4, 
                         city_id5=$save_pr_city_id5, 
                         temp_=0 
                   where pricesh_kod=$pricesh_kod";
			mysql_query($sql);
			// если сохраняли временный прайс, то очищаем реальный и переносим туда новые из временного
			if ($save_pr_temp<>0) {
				// убираем из временного прайса номер реального прайса, чтобы повторно не нажимали "обновление страницы" и затерли сам прайс
				//mysql_query("update p_pricesh set destination_=0 where pricesh_kod=$save_pr_source");
				// удаляем старые детали и переносим новые
				mysql_query("delete from p_prices where pricesh_kod=$pricesh_kod");
                //mysql_query("update p_prices set pricesh_kod=$pricesh_kod where pricesh_kod=$save_pr_source");
                $ssql="insert into p_prices(tov_make_kod,tov_kod,tov_name,cena_,pricesh_kod,action_,count_,count2_,count3_,count4_,count5_,group_kod,tov_kod2,hide_) ".
                            "select               tm.tov_make_kod,t.tov_kod,t.tov_name,t.cena_,$pricesh_kod,t.action_,t.count_,t.count2_,t.count3_,t.count4_,t.count5_,t.group_kod,t.tov_kod2,t.hide_  ".
                            "  from tmp_prices t left join p_tov_make tm on t.tov_make=tm.tov_make ".
                            " where (tm.tov_make_kod is not null) and pricesh_kod=$save_pr_source";
                //print $ssql;
                mysql_query($ssql);
                mysql_query("delete from tmp_prices where pricesh_kod=$pricesh_kod");
                
                //обновляю дату прайса
                mysql_query("update p_pricesh set update_date=current_date where pricesh_kod=$pricesh_kod");
			}
			echo "Данные благополучно сохранены!"; 
		}

		if (isset($_GET["delete"])) {
			if ($_GET["delete"]==1){
				$sql="delete from p_pricesh where pricesh_kod=$pricesh_kod";
				//print $sql;
				mysql_query($sql);
			}
		}
	?> 
<?php
}
?>
<script type="text/javascript"> location.replace('prices.php'); </script>
