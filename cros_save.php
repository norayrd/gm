<?php
require_once "scripts/gm_access.php";
// crosesh_kod обязательно должна присутствовать на этой странице (>0)
$crosesh_kod=$_GET["crosesh"]-0;
if ($user_group<3) {
	//print "Доступ запрещен!";
	//include "_autentication.php";
} else if ($crosesh_kod<=0) {
	print "Неверный id кроса!";
} else {
?>
	<?php
		//сохраняем изменения сделанные в этой странице, и переносим темп - в реальный прайс
		if (isset($_POST["cros_save"])) {
			$save_cr_name=$_POST["cros_name"]."";
			$save_cr_hide=$_POST["cros_hide"]*1;
			$save_cr_source=$_POST["cros_source"]*1;
			$sql="update 1p_crosesh set name_='$save_cr_name', update_date=current_date, hide_=$save_cr_hide, user_id=$user_id, temp_=0 where crosesh_kod=$crosesh_kod";
			mysql_query($sql);
			// если сохраняли временный прайс, то очищаем реальный и переносим туда новые из временного
			if (($crosesh_kod<>$save_cr_source) && ($save_cr_source>0)) {
				// убираем из временного прайса номер реального прайса, чтобы повторно не нажимали "обновление страницы" и затерли сам прайс
				mysql_query("update 1p_crosesh set destination_=0 where crosesh_kod=$save_cr_source");
				// удаляем старые детали и переносим новые
				mysql_query("delete from 1p_croses where crosesh_kod=$crosesh_kod");
				mysql_query("update 1p_croses set crosesh_kod=$crosesh_kod where crosesh_kod=$save_cr_source");
			}
			echo "Данные благополучно сохранены!"; 
		}

		if (isset($_GET["delete"])) {
			if ($_GET["delete"]==1){
				$sql="delete from 1p_crosesh where crosesh_kod=$crosesh_kod";
				//print $sql;
				mysql_query($sql);
			}
		}
	?> 
<?php
}
?>
<script> location.replace('croses.php'); </script>
