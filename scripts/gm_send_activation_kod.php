<?php 
	require_once "gm_access.php";
	if (($_GET['kod_']=$kod_)&& isset($_GET['email'])&& isset($_GET['act'])) {
		$email_=$_GET['email'];
		$message_="<p>Уважаемый пользователь, благодарим Вас за регистрацию на сайте www.tandem-auto.com.ua</p><p>Для завершения регистрации необходимо активировать Вашу учетную запись одним из нижеперечисленных способов:</p>
 <ul><li>перейдите по ссылке <a href='http://www.tandem-auto.com.ua?activation=".$_GET['act']."&activation_email=$email_'>активация</a>;</li><li>зайдите на сайт http://tandem-auto.com.ua/authentication.php и попробуйте войти под Вашим пользователем, на запрос кода активации введите ".$_GET['act'].".</li></ul>";
		mail($email_, "Ключ активации учетной записи на сайте www.tandem-auto.com.ua", $message_,"Content-type: text/html; charset=windows-1251; \r\nFrom:=?windows-1251?B?".base64_encode("Интернет магазин www.tandem-auto.com.ua")."?="."<info@tandem-auto.com.ua>");
		//print $message_;
	}
?>
<p>Спасибо за регистрацию.<br> В течении 10 минут на Ваш e-mail будет отправлено сообщение содержащее код активации.<br> Перейдите по указанной в ней ссылке для завершения процесса регистрации!</p>