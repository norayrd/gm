<?php 
	require_once "gm_access.php";
	if (($_GET['kod_']=$kod_)&& isset($_GET['email'])&& isset($_GET['act'])) {
		$email_=$_GET['email'];
		$message_="<p>��������� ������������, ���������� ��� �� ����������� �� ����� www.avto-polit.ru</p><p>��� ���������� ����������� ���������� ������������ ���� ������� ������ ����� �� ����������������� ��������:</p>
 <ul><li>��������� �� ������ <a href='http://www.avto-polit.ru?activation=".$_GET['act']."&activation_email=$email_'>���������</a>;</li><li>������� �� ���� http://avto-polit.ru/authentication.php � ���������� ����� ��� ����� �������������, �� ������ ���� ��������� ������� ".$_GET['act'].".</li></ul>";
		mail($email_, "���� ��������� ������� ������ �� ����� www.avto-polit.ru", $message_,"Content-type: text/html; charset=windows-1251; \r\nFrom:=?windows-1251?B?".base64_encode("�������� ������� AvtoPolit")."?="."<info@avto-polit.ru>");
		//print $message_;
	}
?>
<p>������� �� �����������.<br> � ������� 10 ����� �� ��� e-mail ����� ���������� ��������� ���������� ��� ���������.<br> ��������� �� ��������� � ��� ������ ��� ���������� �������� �����������!</p>