<?php
require_once "scripts/gm_access.php";
require_once "scripts/gm_tools_avto.php";
		
if(isset($_POST['upload'])){
    $sql_="select * from 1p_crosesh where (user_id=$user_id)and(temp_=1)";
	$tb=mysql_query($sql_);
    $sql_="insert into 1p_crosesh (name_,hide_,user_id, temp_)values('*temp*',1,$user_id,1)";
	if (mysql_numrows($tb)==0) mysql_query($sql_); //если нет, то создаем временный склад
    $sql_="select crosesh_kod from 1p_crosesh where (user_id=$user_id)and(temp_=1)";
	$tb=mysql_query($sql_);
	@$tb_n=mysql_numrows($tb);
	if ($tb_n>0) $crosesh_kod=mysql_result($tb,0,"crosesh_kod");

	if ($crosesh_kod>0){
		$folder = 'upload/';
		$uploadedFile = $folder.time().".csv"; //basename( basename($_FILES['cros_file']['name']);
		if(is_uploaded_file($_FILES['cros_file']['tmp_name'])){
			if(move_uploaded_file($_FILES['cros_file']['tmp_name'],$uploadedFile)) {
				echo "Файл загружен<br>";
				csv2mysql($uploadedFile);
				unlink($uploadedFile);
				echo "<script> location.replace('cros.php?crosesh=$crosesh_kod'); </script>"; 
				exit; 
			} else echo "Во время загрузки файла произошла ошибка";
		}else {
            echo "Файл не загружен";
        }
	}else echo "Ошибка: не удалось создать временный крос!";
}

	function csv2mysql($csv_file_name){
		global $crosesh_kod;
		//print $csv_file_name;
		//$csv_file_name=$_GET["filename"];
		if (isset($csv_file_name)&&($csv_file_name!="")) {
			$crosesh_name=$_POST["cros_name"]."";
			if (isset($_POST["cros_hide"])) {
				if ($_POST["cros_hide"]=="1") $crosesh_hide=1; else $crosesh_hide=0;
			} else $crosesh_hide=0;
			if (isset($_POST["cros_destination"])) 	$crosesh_destination=$_POST["cros_destination"]-0; 		else $crosesh_destination=0;
			
			$sql="update 1p_crosesh ph set ph.name_='$crosesh_name', ph.update_date=current_date, ph.hide_=$crosesh_hide, ph.destination_=$crosesh_destination where ph.crosesh_kod=$crosesh_kod";
			// print $sql;
			mysql_query($sql);
			//удаляем старые записи
			$sql="delete from 1p_croses where crosesh_kod=$crosesh_kod";
			mysql_query($sql);

            $fh = fopen($csv_file_name, "r");
            //бренд;код;наименование;цена;количество;группа
            //пропускаем заголовок
            $line = fgetcsv($fh, 1000, ";");
            while($line = fgetcsv($fh, 1000, ";")) {
                if (!empty($line[0]) && !empty($line[1]) && !empty($line[2]) && !empty($line[3])) {
                    $tov_make1=trim($line[0]);
                    $tov_kod1=tov_kod_clear(trim($line[1]));
                    $tov_make2=trim($line[2]);
                    $tov_kod2=tov_kod_clear(trim($line[3]));
                    if (($tov_make1!='')&&($tov_kod1!='')&&($tov_make2!='')&&($tov_kod2!='')) {
                        $sql = "insert into 1p_croses (tov_make1, tov_kod1, tov_make2, tov_kod2,crosesh_kod) values( get_tov_make_kod('$tov_make1'), '$tov_kod1', get_tov_make_kod('$tov_make2'), '$tov_kod2', $crosesh_kod)"; // Создаём запрос mysql
                        mysql_query($sql);
                    }
                }
            }            
		}else echo "Ошибка: файл не указан или не найден!";
	}
?>