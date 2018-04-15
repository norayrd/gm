		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><span class="navigation_page">Адреса</span></div>
</div>
<!-- /Breadcrumb -->
<div id="address">
<script type="text/javascript">
// <![CDATA[
idSelectedCountry = false;
countries = new Array();
countriesNeedIDNumber = new Array();
countriesNeedZipCode = new Array();
			countries[21] = new Array();
					countries[21].push({'id' : '1', 'name' : 'Alabama'});
					countries[21].push({'id' : '2', 'name' : 'Alaska'});
					countries[21].push({'id' : '3', 'name' : 'Arizona'});
					countries[21].push({'id' : '4', 'name' : 'Arkansas'});
					countries[21].push({'id' : '5', 'name' : 'California'});
					countries[21].push({'id' : '6', 'name' : 'Colorado'});
					countries[21].push({'id' : '7', 'name' : 'Connecticut'});
					countries[21].push({'id' : '8', 'name' : 'Delaware'});
					countries[21].push({'id' : '53', 'name' : 'District of Columbia'});
					countries[21].push({'id' : '9', 'name' : 'Florida'});
					countries[21].push({'id' : '10', 'name' : 'Georgia'});
					countries[21].push({'id' : '11', 'name' : 'Hawaii'});
					countries[21].push({'id' : '12', 'name' : 'Idaho'});
					countries[21].push({'id' : '13', 'name' : 'Illinois'});
					countries[21].push({'id' : '14', 'name' : 'Indiana'});
					countries[21].push({'id' : '15', 'name' : 'Iowa'});
					countries[21].push({'id' : '16', 'name' : 'Kansas'});
					countries[21].push({'id' : '17', 'name' : 'Kentucky'});
					countries[21].push({'id' : '18', 'name' : 'Louisiana'});
					countries[21].push({'id' : '19', 'name' : 'Maine'});
					countries[21].push({'id' : '20', 'name' : 'Maryland'});
					countries[21].push({'id' : '21', 'name' : 'Massachusetts'});
					countries[21].push({'id' : '22', 'name' : 'Michigan'});
					countries[21].push({'id' : '23', 'name' : 'Minnesota'});
					countries[21].push({'id' : '24', 'name' : 'Mississippi'});
					countries[21].push({'id' : '25', 'name' : 'Missouri'});
					countries[21].push({'id' : '26', 'name' : 'Montana'});
					countries[21].push({'id' : '27', 'name' : 'Nebraska'});
					countries[21].push({'id' : '28', 'name' : 'Nevada'});
					countries[21].push({'id' : '29', 'name' : 'New Hampshire'});
					countries[21].push({'id' : '30', 'name' : 'New Jersey'});
					countries[21].push({'id' : '31', 'name' : 'New Mexico'});
					countries[21].push({'id' : '32', 'name' : 'New York'});
					countries[21].push({'id' : '33', 'name' : 'North Carolina'});
					countries[21].push({'id' : '34', 'name' : 'North Dakota'});
					countries[21].push({'id' : '35', 'name' : 'Ohio'});
					countries[21].push({'id' : '36', 'name' : 'Oklahoma'});
					countries[21].push({'id' : '37', 'name' : 'Oregon'});
					countries[21].push({'id' : '38', 'name' : 'Pennsylvania'});
					countries[21].push({'id' : '51', 'name' : 'Puerto Rico'});
					countries[21].push({'id' : '39', 'name' : 'Rhode Island'});
					countries[21].push({'id' : '40', 'name' : 'South Carolina'});
					countries[21].push({'id' : '41', 'name' : 'South Dakota'});
					countries[21].push({'id' : '42', 'name' : 'Tennessee'});
					countries[21].push({'id' : '43', 'name' : 'Texas'});
					countries[21].push({'id' : '52', 'name' : 'US Virgin Islands'});
					countries[21].push({'id' : '44', 'name' : 'Utah'});
					countries[21].push({'id' : '45', 'name' : 'Vermont'});
					countries[21].push({'id' : '46', 'name' : 'Virginia'});
					countries[21].push({'id' : '47', 'name' : 'Washington'});
					countries[21].push({'id' : '48', 'name' : 'West Virginia'});
					countries[21].push({'id' : '49', 'name' : 'Wisconsin'});
					countries[21].push({'id' : '50', 'name' : 'Wyoming'});
					
			countriesNeedZipCode[21] = 1;
	$(function(){
	$('.id_state option[value=]').attr('selected', 'selected');
});
//]]>
</script>
<h1>Ваши адреса</h1>
<h3>Для ввода нового адреса заполните нижеследующие поля.</h3>
<form action="address.php" method="post" class="std">
	<fieldset>
		<h3>Новый адрес</h3>
		<p style="display: none;" class="required text dni">
			<label for="dni">Identification number</label>
			<input class="text" name="dni" id="dni" type="text">
			<sup>*</sup>
			<span class="form_info">DNI / NIF / NIE</span>
		</p>
			<div style="display: none;">
			<div id="vat_number">
			<p class="text">
				<label for="vat_number">VAT number</label>
				<input class="text" name="vat_number" type="text">
			</p>
		</div>
		</div>
								<p class="required text">
			<label for="firstname">Имя</label>
			<input class="text" name="firstname" id="firstname" type="text">
			<sup>*</sup>
		</p>
																										<p class="required text">
			<label for="lastname">Фамилия</label>
			<input class="text" id="lastname" name="lastname" type="text">
			<sup>*</sup>
		</p>
																					<p class="text">
			<label for="company">Организация</label>
			<input id="company" name="company" type="text">
		</p>
																														<p class="required text">
			<label for="address1">Адрес</label>
			<input class="text" id="address1" name="address1" type="text">
			<sup>*</sup>
		</p>
																										<p class="required text">
			<label for="address2">Адрес 2</label>
			<input class="text" id="address2" name="address2" type="text">
		</p>
																												<p class="required text">
			<label for="city">Город</label>
			<input class="text" name="city" id="city" maxlength="64" type="text">
			<sup>*</sup>
		</p>
																														<p style="display: block;" class="required id_state select">
			<label for="id_state">Штат</label>
			<select name="id_state" id="id_state">
				<option selected="selected" value="">-</option>
			<option value="1">Alabama</option><option value="2">Alaska</option><option value="3">Arizona</option><option value="4">Arkansas</option><option value="5">California</option><option value="6">Colorado</option><option value="7">Connecticut</option><option value="8">Delaware</option><option value="53">District of Columbia</option><option value="9">Florida</option><option value="10">Georgia</option><option value="11">Hawaii</option><option value="12">Idaho</option><option value="13">Illinois</option><option value="14">Indiana</option><option value="15">Iowa</option><option value="16">Kansas</option><option value="17">Kentucky</option><option value="18">Louisiana</option><option value="19">Maine</option><option value="20">Maryland</option><option value="21">Massachusetts</option><option value="22">Michigan</option><option value="23">Minnesota</option><option value="24">Mississippi</option><option value="25">Missouri</option><option value="26">Montana</option><option value="27">Nebraska</option><option value="28">Nevada</option><option value="29">New Hampshire</option><option value="30">New Jersey</option><option value="31">New Mexico</option><option value="32">New York</option><option value="33">North Carolina</option><option value="34">North Dakota</option><option value="35">Ohio</option><option value="36">Oklahoma</option><option value="37">Oregon</option><option value="38">Pennsylvania</option><option value="51">Puerto Rico</option><option value="39">Rhode Island</option><option value="40">South Carolina</option><option value="41">South Dakota</option><option value="42">Tennessee</option><option value="43">Texas</option><option value="52">US Virgin Islands</option><option value="44">Utah</option><option value="45">Vermont</option><option value="46">Virginia</option><option value="47">Washington</option><option value="48">West Virginia</option><option value="49">Wisconsin</option><option value="50">Wyoming</option></select>
			<sup>*</sup>
		</p>
																		<p class="required postcode text">
			<label for="postcode">Индекс</label>
			<input class="text" id="postcode" name="postcode" onkeyup="$('#postcode').val($('#postcode').val().toUpperCase());" type="text">
			<sup>*</sup>
		</p>
																												<p class="required select">
			<label for="id_country">Страна</label>
			<select id="id_country" name="id_country"><option selected="selected" value="21">United States</option></select>
			<sup>*</sup>
		</p>
				<script type="text/javascript">
		var ajaxurl = '/prestashop_40832/modules/';
		
				$(document).ready(function(){
					$('#id_country').change(function() {
						$.ajax({
							type: "GET",
							url: ajaxurl+"vatnumber/ajax.php?id_country="+$('#id_country').val(),
							success: function(isApplicable){
								if(isApplicable == "1")
								{
									$('#vat_area').show();
									$('#vat_number').show();
								}
								else
								{
									$('#vat_area').hide();
								}
							}
						});
					});
					
				});
		
		</script>
																														<input name="token" value="54a4765def43b1773245dd9b647b2762" type="hidden">
				<p class="textarea">
			<label for="other">Дополнительная информация</label>
			<textarea id="other" name="other" cols="26" rows="3" style="width:210px"></textarea>
		</p>
		<p class="required">Вы должны оставить хотябы один контактный телефонный номер<sup style="color:red;">*</sup></p>
		<p class="text">
			<label for="phone">Домашний телефон</label>
			<input class="text" id="phone" name="phone" type="text">
		</p>
		<p class="text">
			<label for="phone_mobile">Мобильный телефон</label>
			<input class="text" id="phone_mobile" name="phone_mobile" type="text">
		</p>
		<p class="required text" id="adress_alias">
			<label for="alias">Назовите данный адрес для будущих действий</label>
			<input class="text" id="alias" name="alias" type="text">
			<sup>*</sup>
		</p>
	</fieldset>
	<p class="required required_desc"><sup>*</sup>Объязательные поля</p>
	<p class="submit submit2">
								<input name="select_address" value="0" type="hidden">		<input name="submitAddress" id="submitAddress" value="Сохранить" class="exclusive" type="submit">
		<br>
		<br>
		<a class="button" href="addresses.php" title="Previous">« Назад</a>
	</p>
</form>		</div>