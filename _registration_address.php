<fieldset class="account_creation">
		<h3>Адрес доставки и получатель</h3>
		<p class="required text" id="p_firstname">
			<label for="firstname">Имя</label>
			<input id="firstname" name="firstname" type="text" value="<?php if (isset($_POST['firstname'])) print $_POST['firstname']; else print $faces_name_first; ?>">
			<sup>*</sup>
		</p>
		<p class="required text" id="p_lastname">
			<label for="lastname">Фамилия</label>
			<input id="lastname" name="lastname" type="text" value="<?php if (isset($_POST['lastname'])) print $_POST['lastname']; else print $faces_name_last; ?>">
			<sup>*</sup>
		</p>
		<p class="required text" id="p_middlename">
			<label for="middlename">Отчество</label>
			<input id="middlename" name="middlename" type="text" value="<?php if (isset($_POST['middlename'])) print $_POST['middlename']; else print $faces_name_middle; ?>">
            <sup>*</sup>
		</p>
		<p class="text" id="p_company">
			<label for="company">Организация</label>
			<input id="company" name="company" type="text" value="<?php if (isset($_POST['company'])) print $_POST['company']; else print $faces_name_organization; ?>">
			<sup>*</sup>
		</p>
		<p class="required postcode text" id="p_postcode">
			<label for="postcode">Почтовый индекс</label>
			<input name="postcode" id="postcode" onkeyup="$('#postcode').val($('#postcode').val().toUpperCase());" type="text" value="<?php if (isset($_POST['postcode'])) print $_POST['postcode']; else print $faces_zip; ?>">
            <sup>*</sup>
		</p>
		<p class="required select" id="p_id_country">
			<label for="id_country">Страна</label>
			<select name="id_country" id="id_country" onChange="loadRegions(); ">
<?php
$sql="select country_id, name_ru from gm_country order by order_, name_ru;";
$tb=mysql_query($sql) or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$selected=0;
$i=0;
while($i<$tb_n){
    $tb_country_id=mysql_result($tb,$i,"country_id");	
    $tb_country_name=mysql_result($tb,$i,"name_ru");	
?>
<option <?php if (isset($_POST["id_country"])&& ($_POST["id_country"]==$tb_country_id)) { print "selected"; $selected=1; } else if ($faces_country==$tb_country_id) { print "selected"; $selected=1; } ?> value="<?php print $tb_country_id; ?>"><?php print $tb_country_name; ?></option>
<?php
	$i++;
}
?>
				<option value="" <? if ($selected==0) print "selected"; ?> >-</option>
							</select>
			<sup>*</sup>
		</p>
        <script type="text/javascript">
			//по умолчанию подставляем Украину
			if ($('#id_country').val()==0) $("#id_country").val(2);
		</script>
		<p id="select_regions" style="display: block;" class="required id_state select">
			<label for="id_region">Область</label>
			<select name="id_region" id="id_region">
				<option selected value="">-</option>
			</select>
			<sup>*</sup>
		</p>
        <script type="text/javascript">
			function loadRegions(idRegion){
				url_="./scripts/gm_list_region.php?country_id="+$('#id_country').val();
				if (idRegion>=0) url_=url_+"&region_id="+idRegion;
				$('#select_regions').load(url_);
			}
			loadRegions(<?php if (isset($_POST["id_region"])) print $_POST["id_region"]; else print $faces_region; ?>);
		</script>
		<p id="select_city" class="required text">
			<label for="id_city">Город</label>
			<input name="id_city" id="id_city" type="text" title="Город" value="<?php if (isset($_POST["id_city"])) print $_POST["id_city"]; else print $faces_city; ?>">
			<sup>*</sup>
		</p>
        <!-- script type="text/javascript">
			function loadCity(){
				          $('#select_city').load("./scripts/gm_list_city.php?region_id="+document.getElementById('id_region').value);
			}
			loadCity();
			          </script -->
		<p class="required textarea" id="p_address">
			<label for="address">Адрес</label>
            <textarea name="address" id="address" cols="26" rows="3"><?php if (isset($_POST["address"])) print $_POST["address"]; else print $faces_adr; ?></textarea>
		  <sup>*</sup>
		  <span class="inline-infos">Улица, дом, квартира</span>
		</p>
		<p class="textarea" id="p_other">
			<label for="other">Дополнительная информация</label>
			<textarea name="other" id="other" cols="26" rows="3"><?php if (isset($_POST["other"])) print $_POST["other"]; print $faces_info; ?></textarea>
		</p>
		<p class="required" id="p_phone_title">Вы должны указать хотябы один контактный номер телефона <sup>*</sup></p>
		<p class="text" id="p_phone">
			<label for="phone">Домашний</label>
			<input name="phone" id="phone" type="text" value="<?php if (isset($_POST["phone"])) print $_POST["phone"]; else print $faces_tel; ?>">
		</p>
        <p class="text" id="p_phone_mobile">
            <label for="phone_mobile">Мобильный</label>
            <input name="phone_mobile" id="phone_mobile" type="text" value="<?php if (isset($_POST["phone_mobile"])) print $_POST["phone_mobile"]; else print $faces_tel_mob; ?>">
        </p>
        <p class="text" id="p_email">
            <label for="p_email">E-mail</label>
            <input name="p_email" id="p_email" type="text" value="<?php if (isset($_POST["p_email"])) print $_POST["p_email"]; else print $faces_email; ?>">
        </p>
        <p class="text" id="p_skype">
            <label for="p_skype">Skype</label>
            <input name="p_skype" id="p_skype" type="text" value="<?php if (isset($_POST["p_skype"])) print $_POST["p_skype"]; else print $faces_skype; ?>">
        </p>
        <p class="text" id="p_icq">
            <label for="p_icq">ICQ</label>
            <input name="p_icq" id="p_icq" type="text" value="<?php if (isset($_POST["p_icq"])) print $_POST["p_icq"]; else print $faces_icq; ?>">
        </p>
		<p class="required text" id="p_deliv_strahovka">
			<label for="deliv_strahovka">Страховка</label>
			<input name="deliv_strahovka" id="deliv_strahovka" type="checkbox" value="1" <?php if (isset($_POST['deliv_strahovka'])) print checked; else if ($faces_deliv_strahovka==1) print checked; ?> > <sup>*</sup>
		</p>
		<p class="required text" id="p_deliv_strahovka">
			<label for="deliv_need_adr">Требуется вводить адрес доставки</label>
			<input name="deliv_need_adr" id="deliv_need_adr" type="checkbox" value="1" <?php if (isset($_POST['deliv_need_adr'])) print checked; else if ($faces_deliv_need_adr==1) print checked; ?> > <sup>*</sup>
		</p>

	</fieldset>