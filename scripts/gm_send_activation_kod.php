<?php 
	require_once "gm_access.php";
	if (($_GET['kod_']=$kod_)&& isset($_GET['email'])&& isset($_GET['act'])) {
		$email_=$_GET['email'];
		$message_="<p>��������� ������������, ���������� ��� �� ����������� �� ����� www.tandem-auto.com.ua</p><p>��� ���������� ����������� ���������� ������������ ���� ������� ������ ����� �� ����������������� ��������:</p>
 <ul><li>��������� �� ������ <a href='http://www.tandem-auto.com.ua?activation=".$_GET['act']."&activation_email=$email_'>���������</a>;</li><li>������� �� ���� http://tandem-auto.com.ua/authentication.php � ���������� ����� ��� ����� �������������, �� ������ ���� ��������� ������� ".$_GET['act'].".</li></ul>";
		mail($email_, "���� ��������� ������� ������ �� ����� www.tandem-auto.com.ua", $message_,"Content-type: text/html; charset=windows-1251; \r\nFrom:=?windows-1251?B?".base64_encode("�������� ������� www.tandem-auto.com.ua")."?="."<info@tandem-auto.com.ua>");
		//print $message_;
	}
?>
<p>������� �� �����������.<br> � ������� 10 ����� �� ��� e-mail ����� ���������� ��������� ���������� ��� ���������.<br> ��������� �� ��������� � ��� ������ ��� ���������� �������� �����������!</p>