		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
	if (isset($_POST['from'])) {
		$sql_="select count(*) count_ from gm_capcha where capcha_='".$_POST["id_capcha"]."'";
		$tb=mysql_query($sql_);
		@$tb_n=mysql_numrows($tb);
		if ($tb_n>0) $capcha_count=mysql_result($tb,0,"count_");
		if ($capcha_count>0) {				
			if (isset($_POST['message'])) $message_=$_POST['message']; else $message_="";
			if (isset($_POST['id_order'])) $message_="Заказ № ".$_POST['id_order']."<br>\r\n".$message_;
			if ($_POST['id_contact']==1) {
                mail("info@tandem-auto.com.ua", "Сообщение вебмастеру (из сайта)", $message_, "Content-type: text/html; charset=windows-1251 \r\nFrom:".$_POST['from']);
			}else if ($_POST['id_contact']==2) {
                mail("zakaz@tandem-auto.com.ua", "Сообщение в отдел заказов (из сайта)", $message_,"Content-type: text/html; charset=windows-1251 \r\nFrom:".$_POST['from']);
			}
?>
			<div ><p>Ваше сообщение отправлено!</p></div>

<?php			
		}else{
?>
		<div ><p>Неверный код защиты! Вернитесь и попробуйте ввести еще раз!</p></div>
<?php
		}
	}else{ 
	//XMail( $from, $to, $subj, $text, $filename)
	//XMail( "norayrd@rambler.ru", "info@tandem-auto.com.ua", "письмо с отправкой", "проверка", "statusy.xlsx")
?>
<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><span class="navigation_page">Контакты</span></div>
</div>
<!-- /Breadcrumb -->

<div id="noro_inner">
<div id="contact-form" class="center_column">
<h1>Наши контакты</h1>
	<p class="bold">Если у Вас есть вопросы по заказам, или нужна более подробная информация о продукции, то Вы можете задавать их заполнив форму ниже, или по телефону +38(066) 970-12-48.</p>
    <table width="100%">
    <tr>
    <td width="25%"><h3>Киев</h3><p>ул.Березняковская, 13</p></td>
    <td width="25%"><h3>Днепропетровск</h3><p>ул.Чечерина, 31</p></td>
    <td width="25%"><h3>Мариуполь</h3><p>ул.Мерзляка, 4</p></td>
    <td width="25%"><h3>Львов</h3><p>ул.Раховская, 13</p></td>
    </tr>
    <tr><td colspan=4>&nbsp;</td></tr>
    </table>
		<form action="contact-form.php" method="post" class="std bordercolor" enctype="multipart/form-data" id="contact_form">
		<fieldset>
			<h3>Отправка сообщения</h3>
			<p class="select">
				<label for="id_contact">Тип сообщения *</label>
							<select id="id_contact" name="id_contact" onchange="showElemFromSelect('id_contact', 'desc_contact')">
					<option selected="selected" value="0">-- Выберите --</option>
									<option value="2">Отдел заказов</option>
									<option value="1">Вебмастеру</option>
								</select>
			</p>
			<p id="desc_contact0" class="desc_contact">&nbsp;</p>
									<p id="desc_contact2" class="desc_contact" style="display:none;">
						Для решения возникших вопросов по заказам или продукции
					</p>
									<p id="desc_contact1" class="desc_contact" style="display:none;">
						Для решения технических вопросов при работе на сайте.
					</p>
										<p class="text">
				<label for="email">E-mail *</label>
									<input id="email" name="from" type="text">
							</p>
								<p class="text">
				<label for="id_order">Номер заказа</label>
									<input name="id_order" id="id_order" type="text">
							</p>
													<p class="text file_input" hidden>
			<label for="fileUpload">Вложить файл</label>
				<input name="MAX_FILE_SIZE" value="200000000" type="hidden">
				<input name="fileUpload" id="fileUpload" type="file">
			</p>
				<p class="textarea">
			<label for="message">Сообщение *</label>
			 <textarea id="message" name="message" rows="15" cols="20"></textarea>
		</p>
		<p class="text">
        	<img style=" position:absolute; left:300px" src="capcha.php"><br>
			<label for="id_capcha">Код защиты</label>
            
			<input name="id_capcha" id="id_capcha" type="text" style=" width:70px">
		</p>

		<p class="submit">        
			<input name="submitMessage" id="submitMessage" value="Отправить" class="button_large" type="submit">
		</p>
	</fieldset>
</form>
		</div>
        </div>
<?php 
	}
?>