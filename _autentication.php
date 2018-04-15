		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<div id="noro_inner">
	<div id="authentication">
		<div id="center_column" class="center_column">
		<?php if ($user_id==0) { ?>            
				<!-- Breadcrumb -->
				<div class="breadcrumb bordercolor"><div class="breadcrumb_inner">
					<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><span class="navigation_page">Вход</span>
				</div></div>
				<!-- /Breadcrumb -->
				<h1>Вход</h1>
				<ul id="order_steps" class="step2">
					<li class="step_done"><a href="my-account.php">Итого</a></li>
					<li class="step_current"><span>Вход</span></li>
					<li class="step_todo"><span>Адрес</span></li>
					<li class="step_todo"><span>Доставка</span></li>
					<li id="step_end" class="step_todo"><span>Оплата</span></li>
				</ul>
				<span>
					<div class="error" id="error_text" <?php if (($login_error==false)&&($login_ok==false)) print "hidden"; ?> style="font-size:12px; border-color:#FF0000; border-style:solid; border:1 1 1 1"><?php print $login_error.$login_ok; ?></div>
				</span>	
			<?php if (!isset($_POST["SubmitCreate"]) && !isset($_POST["SubmitAccount"])) { ?>
				<form action="authentication.php" method="post" id="create-account_form" class="std">
					<fieldset>
						<h3>Регистрация</h3>
						<h4>Для создания учетной записи укажите Ваш контактный e-mail.</h4>
						<p class="text">
							<label for="email_create">E-mail</label>
							<input type="text" id="email_create" name="email_create" value class="account_input" onkeyup="javascript: emailStatus2();" onchange="javascript: emailStatus2();">
							<sup style="font-size:12px" id="email_status2" ></sup><br>
							<sup style="font-size:12px" id="email_error2" ></sup>
							<script type="text/javascript">
								function emailStatus2(){
									$("#email_status2").load("scripts/gm_check_email_status.php?kod_=<?php print $kod_; ?>&email="+$("#email_create").val());
								}
								emailStatus2();
							</script>
						</p>
						<p class="submit">
	                        <script type="text/javascript">
								function check_registration2(){
									emailStatus2();
									$("#email_error2").contents().remove();
									s='';
									if ($('#email_create').val()=='') s=s+"Укажите email для регистрации!";
									else if (($('#email_create').val().indexOf('@')<=0)||
											($('#email_create').val().indexOf('@')>=($('#email_create').val().length-3))||
											($('#email_create').val().indexOf('.')==-1)) s=s+"Некорректный email!"; 
									else if ($('#email_is_free').val()==0) s=s+"Этот email уже использован для авторизации, попробуйте зарегистрировать другой!";
									if (s!='') {
										$("#email_error2").append(s);
										return false;
									}else return true;
								}
							</script>
							<input type="submit" id="SubmitCreate" name="SubmitCreate" class="button_large" value="Создать учетную запись" onclick="javascript:return check_registration2();">
						</p>
					</fieldset>
				</form>
				<form action="#" method="post" id="login_form" class="std">
					<fieldset>
						<h3>Уже зарегистрированы?</h3>
						<p class="text">
							<label for="email">E-mail</label>
							<input type="text" id="email" name="email" value="<?php print $_POST["email"] ?>" class="account_input">
						</p>
						<p class="text">
							<label for="passwd">Пароль</label>
							<input type="password" id="passwd" name="passwd" value class="account_input"><br><sup style="font-size:12px"> <?php print $login_error ?></sup>
						</p>
					<?php if (isset($login_activated)&&($login_activated!=1)) { ?>
						<p class="text">
							<label for="email_activation">Код активации</label>
							<input type="text" id="email_activation" name="email_activation" value class="account_input">
							<sup style="font-size:11px">Отправить еще раз <a href="<?php print "scripts/gm_send_activation_kod.php?kod_=$kod_&email=$login_email&act=$login_activated"; ?>"><sup style="font-size:11px; ">код активации</sup></a></sup>
						</p>
					<?php } ?>
						<p class="submit">
                			<input type="submit" id="SubmitLogin" name="SubmitLogin" class="button" value="Вход">
						</p>
						<p class="lost_password"><a href="password.php">Восстановить пароль!</a></p>
					</fieldset>
				</form>
			<? } else { ?>
            	<?php if ($login_ok==false) { ?>
				<form action="authentication.php" method="post" id="account-creation_form" class="std">
					<?php include "_registration_user.php"; ?>
					<?php include "_registration_address.php"; ?>
					<style type="text/css">
						.account_creation #p_postcode sup,.account_creation #p_company sup {
							display:none;
						}
						.account_creation #p_deliv_strahovka {
							display: none;
						}
					</style>
					<?php include "_registration_avto.php"; ?>
					<p class="required required_desc"><span><sup>*</sup>Обязательные поля</span></p>
					<script type="text/javascript">
						function check_registration(){
							$("#error_text").contents().remove();
							s='';
							if ($('#customer_firstname').val()=='') s=s+"<li>Имя</li>"; 
							if ($('#customer_lastname').val()=='') s=s+"<li>Фамилия</li>";
							if ($('#email').val()=='') s=s+"<li>email</li>";
							else if (($('#email').val().indexOf('@')<=0)||
								($('#email').val().indexOf('@')>=($('#email').val().length-3))||
								($('#email').val().indexOf('.')==-1)) s=s+"<li>Некорректный email</li>"; 
							else if ($('#email_is_free').val()==0) s=s+"<li>email занят</li>";
							if ($('#passwd').val()=='') s=s+"<li>Пароль</li>";
							if ($('#firstname').val()=='') s=s+"<li>Имя получателя</li>";
							if ($('#lastname').val()=='') s=s+"<li>Фамилия получателя</li>";
							if ($('#middlename').val()=='') s=s+"<li>Отчество получателя</li>";
							//if ($('#postcode').val()=='') s=s+"<li>Почтовый индекс</li>";
							if ($('#id_country').val()=='') s=s+"<li>Страна</li>";
							if ($('#id_state').val()=='') s=s+"<li>Область</li>";
							if ($('#id_city').val()=='') s=s+"<li>Город</li>";
							if ($('#address').val()=='') s=s+"<li>Адрес</li>";
							if (($('#phone').val()=='')&&($('#phone_mobile').val()=='')) s=s+"<li>Номер телефона</li>";
							if (s!='') {
								$("#error_text").append("<p>Вы не заполнили следующие поля:</p><ol>"+s+"</ol>");
								$("#error_text").show();
								return false;
							}else{
								$("#error_text").hide();
								return true;
							}
						}
					</script>
					<p class="submit">	
        				<input name="SubmitAccount" id="SubmitAccount" value="Зарегистрировать" class="exclusive" type="submit" 1onclick="javascript:return check_registration();" >
					</p>
				</form>
				<?php } ?>
			<?php } ?>
				<div class="clearblock"></div>
		<?php }else{ ?>
				<!-- Breadcrumb -->
				<div class="breadcrumb bordercolor"><div class="breadcrumb_inner">
					<a href="index.php" title="На главную">Главная</a>
					<span class="navigation-pipe">&gt;</span>
					<span class="navigation_page">Учетная запись</span>
				</div></div>
				<!-- /Breadcrumb -->
				<h1>Учетная запись</h1>
				<h4>Добро пожаловать в Вашу учетную запись. </h4>
				<h4>Здесь Вы можете контролировать Ваши заказы и личные данные.</h4>
				<ul id="my_account_links">
                    <li><a href="cart.php" title="Моя корзина"><img src="images/shopping-basket.png" alt="Моя корзина" class="icon"></a><a href="order.php" title="Моя корзина">Моя корзина</a></li>
                    <li><a href="rashodh.php" title="Мои заказы"><img src="images/order.png" alt="Мои заказы" class="icon"></a><a href="rashodh.php" title="Мои заказы">Мои заказы</a></li>
                    <li><a href="zaprosh.php" title="Мои запросы"><img src="images/order.png" alt="Мои запросы" class="icon"></a><a href="zaprosh.php" title="Мои запросы">Мои запросы</a></li>
					<li class="hidden"><a href="order-slip.php" title="Банковские реквизиты"><img src="images/slip.png" alt="Банковские реквизиты" class="icon"></a><a href="order-slip.php" title="Банковские реквизиты">Банковские реквизиты</a></li>
                    <?php $url_="user.php?user_id=$user_id&ts=$user_ts&nextpage=authentication.php"; ?>
                    <li><a href="<?php print $url_; ?>" title="Настройки пользователя"><img src="images/userinfo.png" alt="Настройки пользователя" class="icon"></a><a href="<?php print $url_; ?>" title="Настройки пользователя">Настройки пользователя</a></li>
                    <?php $url_="avto_list.php?user_id=$user_id&ts=$user_ts&nextpage=authentication.php"; ?>
                    <li><a href="<?php print $url_; ?>" title="Транспортные средства"><img src="images/car.png" alt="Транспортные средства" class="icon"></a><a href="<?php print $url_; ?>" title="Транспортные средства">Транспортные средства</a></li>
                <?php
                $sql_="select * from gm_faces f where f.user_id=$user_id";
                $tb=mysql_query($sql_);
                $tb_n=mysql_numrows($tb);
                $i_=0;
                while ($i_<$tb_n) {
                    $url_="face.php?faces_id=".mysql_result($tb,0,"faces_id")."&ts=".mysql_result($tb,0,"ts_")."&nextpage=authentication.php";
                ?>
					<li><a href="<?php print $url_; ?>" title="Контакты"><img src="images/addrbook.png" alt="Контакты" class="icon"></a><a href="<?php print $url_; ?>" title="Контакты">Контакты</a></li>
                <?php
                    $i_+=1;
                }
                ?>
					<li class="hidden"><a href="discount.php" title="Скидки"><img src="images/voucher.png" alt="Скидки" class="icon"></a><a href="discount.php" title="Скидки">Скидки</a></li>		
				</ul>

<?php 
	if ($user_group==3) {
?>
				<h1>Администрирование</h1>
            <table><tr><td width="500px">
				<ul id="my_account_links">
                    <li><a href="prices.php" title="Управление прайсами"><img src="images/shopping-basket.png" alt="Управление прайсами" class="icon"></a><a href="prices.php" title="Управление прайсами">Управление прайсами</a></li>
                    <li><a href="croses.php" title="Управление кросами"><img src="images/shopping-basket.png" alt="Управление кросами" class="icon"></a><a href="croses.php" title="Управление кросами">Управление кросами</a></li>
                    <li><a href="makes.php" title="Бренды"><img src="images/shopping-basket.png" alt="Бренды" class="icon"></a><a href="makes.php" title="Бренды">Бренды</a></li>
                    <li><a href="makes_zam.php" title="Замена брендов"><img src="images/shopping-basket.png" alt="Замена брендов" class="icon"></a><a href="makes_zam.php" title="Бренды">Замена брендов</a></li>
					<li><a href="reklama_all.php" title="Реклама"><img src="images/order.png" alt="Реклама" class="icon"></a><a href="reklama_all.php" title="Реклама">Реклама</a></li>
					<li class="hidden"><a href="history.php" title="Заказы"><img src="images/order.png" alt="Заказы" class="icon"></a><a href="history.php" title="Заказы">Заказы</a></li>
					<li><a href="searchs.php" title="У нас искали"><img src="images/order.png" alt="У нас искали" class="icon"></a><a href="searchs.php" title="У нас искали">У нас искали</a></li>
					<li><a href="klients.php" title="Пользователи"><img src="images/userinfo.png" alt="Пользователи" class="icon"></a><a href="klients.php" title="Пользователи">Пользователи</a></li>
					<li class="hidden"><a href="discount.php" title="Скидки"><img src="images/voucher.png" alt="Скидки" class="icon"></a><a href="discount.php" title="Скидки">Скидки</a></li>
                    <li><a href="deliv.php" title="Перевозчики"><img src="images/order.png" alt="Перевозчики" class="icon"></a><a href="deliv.php" title="Перевозчики">Перевозчики</a></li>        
                    <li><a href="download/avto-polit-price.csv" title="Наш прайс"><img src="images/order.png" alt="Наш прайс" class="icon"></a><a href="download/avto-polit-price.csv" title="Наш прайс">Наш прайс</a></li>        
				</ul>
            </td><td>
                <table><tr><td width=100px><p>Курсы валют:</p></td><td></td></tr>
                    <tr><td width=130px><div id="vl_840" name="vl_840"></div></td></tr>
                    <tr><td width=130px><div id="vl_978" name="vl_978"></div></td></tr>
                </table>
                <script type="text/javascript">
                    $("#vl_840").load("valyuta.php?kod_=<?php print $kod_; ?>&vl_kod=840&vl_basic_kod=980");
                    $("#vl_978").load("valyuta.php?kod_=<?php print $kod_; ?>&vl_kod=978&vl_basic_kod=980");
                    function chcourse(vl_kod,basic_vl_kod,vl_cours){
                        txt='Укажите новый курс';
                        if (vl_kod==840) txt=txt+' $';
                        else if (vl_kod==978) txt=txt+' €';
                        vl_cours=prompt(txt,vl_cours);
                        if (vl_cours!=null) {
                            new_cours=parseFloat(vl_cours);
                            if (isNaN(new_cours)) { alert('Вы не указали числовое значение!'); }
                                             else {        
                                                 $("#vl_"+vl_kod).load("valyuta.php?kod_=<?php print $kod_; ?>&vl_kod="+vl_kod+"&vl_basic_kod="+basic_vl_kod+"&vl_ch&vl_cours="+vl_cours);
                                             }
                        }  
                    }
                </script>
            </td></tr></table>    
<?php 
	}
?>
				<ul class="footer_links">
					<li><a href="index.php" title="На главную"><img src="images/home.png" alt="На главную" class="icon"></a><a href="index.php" title="На главную">На главную</a></li>
				</ul>
		<?php } ?>
		</div>
	</div>
</div>
