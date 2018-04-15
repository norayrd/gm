<?php
require_once "scripts/gm_access.php";
require_once "Excel/reader.php";
require_once "scripts/gm_tools_avto.php";
		
if(isset($_POST['upload'])){
    $sql_="select * from p_crosesh where (user_id=$user_id)and(temp_=1)";
	$tb=mysql_query($sql_);
    $sql_="insert into p_crosesh (name_,hide_,user_id, temp_)values('*temp*',1,$user_id,1)";
	if (mysql_numrows($tb)==0) mysql_query($sql_); //если нет, то создаем временный склад
    $sql_="select crosesh_kod from p_crosesh where (user_id=$user_id)and(temp_=1)";
	$tb=mysql_query($sql_);
	@$tb_n=mysql_numrows($tb);
	if ($tb_n>0) $crosesh_kod=mysql_result($tb,0,"crosesh_kod");

	if ($crosesh_kod>0){
		$folder = 'upload/';
		$uploadedFile = $folder.time().".xls"; //basename( basename($_FILES['cros_file']['name']);
		if(is_uploaded_file($_FILES['cros_file']['tmp_name'])){
			if(move_uploaded_file($_FILES['cros_file']['tmp_name'],$uploadedFile)) {
				echo "Файл загружен<br>";
				xls2mysql($uploadedFile);
				unlink($uploadedFile);
				echo "<script> location.replace('cros.php?crosesh=$crosesh_kod'); </script>"; 
				exit; 
			} else echo "Во время загрузки файла произошла ошибка";
		}else {
            echo "Файл не загружен";
        }
	}else echo "Ошибка: не удалось создать временный крос!";
}

	function xls2mysql($xls_file_name){
		global $crosesh_kod;
		//print $xls_file_name;
		//$xls_file_name=$_GET["filename"];
		if (isset($xls_file_name)&&($xls_file_name!="")) {
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('cp-1251');
			$data->setUTFEncoder('mb');
			$data->read($xls_file_name);
			error_reporting(E_ALL);
			$crosesh_name=$_POST["cros_name"]."";
			if (isset($_POST["cros_hide"])) {
				if ($_POST["cros_hide"]=="1") $crosesh_hide=1; else $crosesh_hide=0;
			} else $crosesh_hide=0;
			if (isset($_POST["cros_destination"])) 	$crosesh_destination=$_POST["cros_destination"]-0; 		else $crosesh_destination=0;
			
			$sql="update p_crosesh ph set ph.name_='$crosesh_name', ph.update_date=current_date, ph.hide_=$crosesh_hide, ph.destination_=$crosesh_destination where ph.crosesh_kod=$crosesh_kod";
			// print $sql;
			mysql_query($sql);
			//удаляем старые записи
			$sql="delete from p_croses where crosesh_kod=$crosesh_kod";
			mysql_query($sql);
			for($j=2; $j<=$data->sheets[0]['numRows']; $j++) { // Начинаем выводить данные со второй строки
				if (!empty($data->sheets[0]['cells'][$j][1]) && !empty($data->sheets[0]['cells'][$j][2])) {
					$tov_kod1=tov_kod_clear(trim($data->sheets[0]['cells'][$j][1]));
					$tov_kod2=tov_kod_clear(trim($data->sheets[0]['cells'][$j][2]));
					if (($tov_kod1!='')&&($tov_kod2!='')) {
						$sql = "insert into p_croses (tov_kod1, tov_kod2,crosesh_kod) values( '$tov_kod1', '$tov_kod2', $crosesh_kod)"; // Создаём запрос mysql
						mysql_query($sql);
					}
				}
			}
		}else echo "Ошибка: файл не указан или не найден!";
	}
?>