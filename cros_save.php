<?php
require_once "scripts/gm_access.php";
// crosesh_kod ����������� ������ �������������� �� ���� �������� (>0)
$crosesh_kod=$_GET["crosesh"]-0;
if ($user_group<3) {
	//print "������ ��������!";
	//include "_autentication.php";
} else if ($crosesh_kod<=0) {
	print "�������� id �����!";
} else {
?>
	<?php
		//��������� ��������� ��������� � ���� ��������, � ��������� ���� - � �������� �����
		if (isset($_POST["cros_save"])) {
			$save_cr_name=$_POST["cros_name"]."";
			$save_cr_hide=$_POST["cros_hide"]*1;
			$save_cr_source=$_POST["cros_source"]*1;
			$sql="update 1p_crosesh set name_='$save_cr_name', update_date=current_date, hide_=$save_cr_hide, user_id=$user_id, temp_=0 where crosesh_kod=$crosesh_kod";
			mysql_query($sql);
			// ���� ��������� ��������� �����, �� ������� �������� � ��������� ���� ����� �� ����������
			if (($crosesh_kod<>$save_cr_source) && ($save_cr_source>0)) {
				// ������� �� ���������� ������ ����� ��������� ������, ����� �������� �� �������� "���������� ��������" � ������� ��� �����
				mysql_query("update 1p_crosesh set destination_=0 where crosesh_kod=$save_cr_source");
				// ������� ������ ������ � ��������� �����
				mysql_query("delete from 1p_croses where crosesh_kod=$crosesh_kod");
				mysql_query("update 1p_croses set crosesh_kod=$crosesh_kod where crosesh_kod=$save_cr_source");
			}
			echo "������ ������������ ���������!"; 
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
