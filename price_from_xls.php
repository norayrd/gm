<?php
require_once "scripts/gm_access.php";
require_once "Excel/reader.php";
require_once "scripts/gm_tools_avto.php";
		
if(isset($_POST['upload'])){
	$tb=mysql_query("select * from p_pricesh where (user_id='$user_id')and(temp_=1)");
	if (mysql_numrows($tb)==0) mysql_query("insert into p_pricesh (name_,hide_,user_id, temp_)values('*temp*',1,'$user_id',1)"); //если нет, то создаем временный склад
	$tb=mysql_query("select pricesh_kod from p_pricesh where (user_id='$user_id')and(temp_=1)");
	@$tb_n=mysql_numrows($tb);
	if ($tb_n>0) $pricesh_kod=mysql_result($tb,0,"pricesh_kod");

	if ($pricesh_kod>0){
		$folder = 'upload/';
		$uploadedFile = $folder.time().".xls"; //basename( basename($_FILES['price_file']['name']);
		if(is_uploaded_file($_FILES['price_file']['tmp_name'])){
			if(move_uploaded_file($_FILES['price_file']['tmp_name'],$uploadedFile)) {
				echo "Файл загружен<br>";
				xls2mysql($uploadedFile);
				unlink($uploadedFile);
				echo "<script> location.replace('price.php?pricesh=$pricesh_kod'); </script>"; 
				exit; 
			} else echo "Во время загрузки файла произошла ошибка";
		}else echo "Файл не  загружен";
	}else echo "Ошибка: не удалось создать временный прайс!";
}

	function xls2mysql($xls_file_name){
		global $pricesh_kod;
		//print $xls_file_name;
		//$xls_file_name=$_GET["filename"];
		if (isset($xls_file_name)&&($xls_file_name!="")) {
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('cp-1251');
			$data->setUTFEncoder('mb');
			$data->read($xls_file_name);
			error_reporting(E_ALL);
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
			// print $sql;
			mysql_query($sql);
			//удаляем старые записи
			$sql="delete from p_prices where pricesh_kod=$pricesh_kod";
			mysql_query($sql);
			for($j=2; $j<=$data->sheets[0]['numRows']; $j++) { // Начинаем выводить данные со второй строки
				if (!empty($data->sheets[0]['cells'][$j][1]) && !empty($data->sheets[0]['cells'][$j][2]) && !empty($data->sheets[0]['cells'][$j][3]) && !empty($data->sheets[0]['cells'][$j][4])) {
					$tov_make=trim($data->sheets[0]['cells'][$j][1]);
					$tov_kod=tov_kod_clear(trim($data->sheets[0]['cells'][$j][2]));
					$tov_name=$data->sheets[0]['cells'][$j][3];
					if (strlen($tov_name)>50) $tov_name=substr($tov_name,0,50);
					$tov_cena=$data->sheets[0]['cells'][$j][4];
                    $tov_cena=str_replace(",",".",$tov_cena);
					if (!empty($data->sheets[0]['cells'][$j][5])) $tov_count=$data->sheets[0]['cells'][$j][5]; else $tov_count="";
					if (!empty($data->sheets[0]['cells'][$j][6])) $tov_group_kod=$data->sheets[0]['cells'][$j][6]; else $tov_group_kod="null";
					if ($tov_cena>=0) {
						$sql = "insert into p_prices (tov_make_kod, tov_kod, tov_name, cena_,count_,pricesh_kod, group_kod) values(get_tov_make_kod('$tov_make'), '$tov_kod', '$tov_name', $tov_cena, '$tov_count', $pricesh_kod, $tov_group_kod)"; // Создаём запрос mysql
						mysql_query($sql);
					}
				}
			}
		}else echo "Ошибка: файл не указан или не найден!";
	}
?>