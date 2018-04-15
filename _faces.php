		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
	if ($user_group<3) {
		include "_autentication.php";
		exit;
	}
?>
	<!-- Breadcrumb -->
	<div class="breadcrumb bordercolor">
	<div class="breadcrumb_inner">
		<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><a href="authentication.php">Учетная запись</a><span class="navigation-pipe">&gt;</span>Перевозчики</div>
	</div>
	<!-- /Breadcrumb -->
<div id="noro_inner">

<?php 
	$faces_id=$_GET["faces"]-0;
	$ts_=$_GET["ts"]-0;
	//удаление перевозчика
	if (isset($_GET["delete"])) { 
		$sql_="delete from gm_faces where (faces_id=$faces_id)and(ts_=$ts_)";
		unset($faces_id);
		unset($ts_);
		mysql_query($sql_);
		print $sql_;
	}
?>

<?php if (isset($_GET["createDeliv"])) { ?>
	<div id="identity" class="identity">
		<h1>Добавление перевозчиков</h1>
		<form action="deliv.php" method="post" class="std identity">
    		<?php include "_registration_address.php"; ?>
			<style type="text/css">
				.account_creation #p_postcode sup {
					display:none;
				}
				.account_creation #p_firstname, .account_creation #p_lastname, .account_creation #p_middlename  {
					display: none;
				}
			</style>
            <input type="hidden" value="<?php print $_POST["deliv_id"]; ?>" >
			<p class="required required_desc"><sup>*</sup>Объязательные поля</p>
			<p class="submit">
				<input class="button_red" name="submitDeliv" value="Сохранить" type="submit">
				<a class="button" href="deliv.php">Назад к перевозчикам</a>
			</p>
		</form>
		<ul class="footer_links">
			<li><a href="authentication.php"><img src="images/my-account.png" alt="" class="icon"></a><a href="authentication.php">Вернуться в учетную запись</a></li>
			<li><a href="index.php"><img src="images/home.png" alt="" class="icon"></a><a href="index.php">На главную</a></li>
		</ul>
	</div>
<?php }else{ ?>
	<div id="identity" class="identity">
		<h1>Управление прайсами</h1>
		<h4>Добавление, изменение и удаление прайсов.</h4>
		<ul id="my_account_links">
		<?php
			$sql_="select * from gm_faces f where f.typ_=3";
			$tb=mysql_query($sql_);
			@$tb_n=mysql_numrows($tb);
			$i=0;
			while ($i<$tb_n){
				$deliv_faces_id			=mysql_result($tb,$i,"faces_id");
				$deliv_user_id			=mysql_result($tb,$i,"user_id");
				$deliv_typ				=mysql_result($tb,$i,"typ_");
				$deliv_name_first		=mysql_result($tb,$i,"name_first");
				$deliv_name_last		=mysql_result($tb,$i,"name_last");
				$deliv_name_middle		=mysql_result($tb,$i,"name_middle");
				$deliv_date_create		=mysql_result($tb,$i,"date_create");
				$deliv_date_modify		=mysql_result($tb,$i,"date_modify");
				$deliv_email			=mysql_result($tb,$i,"email_");
				$deliv_skype			=mysql_result($tb,$i,"skype_");
				$deliv_icq				=mysql_result($tb,$i,"icq_");
				$deliv_country			=mysql_result($tb,$i,"country_");
				$deliv_region			=mysql_result($tb,$i,"region_");
				$deliv_city				=mysql_result($tb,$i,"city_");
				$deliv_zip				=mysql_result($tb,$i,"zip_");
				$deliv_adr				=mysql_result($tb,$i,"adr_");
				$deliv_name_organization=mysql_result($tb,$i,"name_organization");
				$deliv_name_full		=mysql_result($tb,$i,"name_full");
				$deliv_info				=mysql_result($tb,$i,"info_");
				$deliv_tel				=mysql_result($tb,$i,"tel_");
				$deliv_tel_mob			=mysql_result($tb,$i,"tel_mob");
				$deliv_strahovka		=mysql_result($tb,$i,"deliv_strahovka");
				$deliv_ts				=mysql_result($tb,$i,"ts_");
		?>
				<li class="cat_desc bordercolor bgcolor">
					<div style="color: #999; position: relative; left: 10px; top: 0px; width: 250px; height: 30px; ">
						<a href="faces.php?faces_id=<?php print $deliv_faces_id; ?>" title="<?php print $deliv_name_organization; ?>"><img src="images/order.png" alt="<?php print $deliv_name_organization; ?>" class="icon"> <?php print $deliv_name_organization; ?></a>&nbsp;
						<a href="<?php print "deliv.php?createDeliv&faces=$deliv_faces_id&ts=$deliv_ts"; ?>" class="button">Изменить</a>&nbsp;
						<a href="<?php print "deliv.php?delete&faces=$deliv_faces_id&ts=$deliv_ts"; ?>" onclick="javascript: return confirm('Удалить перевозчика?');" class="button_delete">x</a>
					</div>
					<div style="color: #999; position:relative; left: 300px; top: -30px; width: 300px; height: 30px; ">
						<?php print "Телефон: $deliv_tel; $deliv_tel_mob"; ?><br />
                        <?php print " Адрес: $deliv_adr"; ?><br/>
						<?php if ($deliv_strahovka==1) print " Можно страховать"; ?>
					</div>
				</li>
		<?php 
				$i+=1;
			} 
		?>
		</ul>
		<br />
		<div>
			<a href="deliv.php?createDeliv" class="button">Добавить перевозчика</a>
		</div>
	</div>
<?php } ?>
</div>