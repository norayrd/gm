		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><a href="my-account.php">Учетная запись</a><span class="navigation-pipe">&gt;</span>Адреса</div>
</div>
<!-- /Breadcrumb -->
<div id="addresses" class="center_column">

<script type="text/javascript">
//<![CDATA[
	
	$(document).ready(function()
	{
			resizeAddressesBox();
	});
	
//]]>
</script>
<h1>Адреса</h1>
<p>Введите желаемые адреса для составления заказов и доставки. При желании Вы можете добавить дополнительные адреса и подписать их для простоты понимания(например Домашний, Рабочий и т.д.).</p>
<div class="addresses">
	<h3>Ваши адреса.</h3>
	<p>Пожалуйста, следите за актуальностью Ваших адресов.</p>
			<ul style="height: 176px;" class="address bordercolor last_item item">
		<li class="address_title">Мой адрес</li>
								<li>
							<span class="address_name">
					asdasd
				</span>
							<span class="address_name">
					asdasd
				</span>
						</li>
								<li>
							<span class="address_company">
					
				</span>
						</li>
								<li>
							<span class="address_address1">
					SAASDASDA
				</span>
							<span class="address_address2">
					
				</span>
						</li>
								<li>
							<span class="address_city">
					LA,
				</span>
							<span class="">
					Alabama
				</span>
							<span class="">
					10000
				</span>
						</li>
								<li>
							<span class="">
					United States
				</span>
						</li>
								<li>
							<span class="address_phone">
					111-111-11
				</span>
						</li>
				<li class="address_update"><a href="address.php?id_address=6" title="Изменить">Изменить</a></li>
		<li class="address_delete"><a href="address.php?id_address=6&amp;delete" onclick="return confirm('Вы уверены?');" title="Удалить">Удалить</a></li>
	</ul>
		<div class="clearblock"></div>
</div>
<div class="address_add"><a href="address.php" title="Добавить новый адрес" class="button_large">Добавить новый адрес</a></div>
<ul class="footer_links">
	<li><a href="my-account.php"><img src="images/my-account.png" alt="" class="icon"></a><a href="my-account.php">Вернуться в учетную запись</a></li>
	<li><a href="index.php"><img src="images/home.png" alt="" class="icon"></a><a href="index.php">На главную</a></li>
</ul>
</div>