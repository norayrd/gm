<fieldset class="account_creation">
		<h3>Личная информация</h3>
		<p class="radio required">
			<span>Пол</span>
			<input name="id_gender" id="id_gender1" value="1" type="radio" <?php if (isset($_POST["id_gender"])) { if ($_POST["id_gender"]==1) print "checked"; } else { if ($cuser_sex==1) print "checked"; }  ?>>
			<label for="id_gender1" class="top">мужской</label>
			<input name="id_gender" id="id_gender2" value="2" type="radio" <?php if (isset($_POST["id_gender"])) { if ($_POST["id_gender"]==2) print "checked"; } else { if ($cuser_sex==2) print "checked"; } ?>>
			<label for="id_gender2" class="top">женский</label>
		</p>
		<p class="required text">
			<label for="customer_firstname">Имя</label>
			<input onkeyup="$('#firstname').val(this.value);" id="customer_firstname" name="customer_firstname" type="text" value="<?php if (isset($_POST["customer_firstname"])) print $_POST["customer_firstname"]; else print $cuser_name_first; ?>">
			<sup>*</sup>
		</p>
		<p class="required text">
			<label for="customer_lastname">Фамилия</label>
			<input onkeyup="$('#lastname').val(this.value);" id="customer_lastname" name="customer_lastname" type="text" value="<?php if (isset($_POST["customer_lastname"])) print $_POST["customer_lastname"]; else print $cuser_name_last; ?>">
			<sup>*</sup>
		</p>
		<p class="required text">
			<label for="customer_middlename">Отчество</label>
			<input onkeyup="$('#middlename').val(this.value);" id="customer_middlename" name="customer_middlename" type="text" value="<?php if (isset($_POST["customer_middlename"])) print $_POST["customer_middlename"]; else print $cuser_name_middle; ?>">
		</p>
		<p class="required text">
			<label for="email">E-mail</label>
			<input id="email" name="email" type="text" value="<?php if (isset($_POST["email_create"]) || isset($_POST["email"])) print $_POST["email_create"].$_POST["email"]; else print $cuser_email; ?>" onkeyup="javascript: emailStatus();" onchange="javascript: emailStatus();">
			<sup>*</sup><sup style="font-size:12px" id="email_status" ></sup>
		</p>
        <script type="text/javascript">
			function emailStatus(){
				$("#email_status").load("scripts/gm_check_email_status.php?kod_=<?php print $kod_; ?>&email="+$("#email").val());
			}
			emailStatus();
		</script>
        
        <?php if ($cuser_id==0) { ?>
		<p class="required password">
			<label for="passwd">Пароль для входа на сайт</label>
			<input name="passwd" id="passwd" type="password">
			<sup>*</sup>
			<span class="form_info">(минимум 5 символов)</span>
		</p>
        <?php } ?>
		<p class="select">
			<span>Дата рождения</span>
			<select id="days" name="days" >
				<?php
					$selected=0;
					for ($i=1; $i<=31; $i=$i+1){ ?>
						<option <?php if (($_POST["days"]==$i)||($cuser_birth_day==$i)) { print "selected"; $selected=1; } ?> value="<?php print $i; ?>"><?php print $i; ?></option>
				<?php
					}
				?>
				<option <?php if ($selected==0) print "selected"; ?> value="">-</option>
							</select>
			<select id="months" name="months" >
				<?php
					$selected=0;
					$months=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
					for ($i=1; $i<=12; $i=$i+1){ ?>
						<option <?php if (($_POST["months"]==$i)||($cuser_birth_month==$i)) { print "selected"; $selected=1; } ?> value="<?php print $i; ?>"><?php print $months[$i-1]; ?></option>
				<?php
					}
				?>
				<option <?php if ($selected==0) print "selected"; ?> value="">-</option>
			</select>
			<select id="years" name="years">
				<?php
					$selected=0;
					for ($i=2002; $i>=1950; $i=$i-1){ ?>
						<option <?php if (($_POST["years"]==$i)||($cuser_birth_year==$i)) { print "selected"; $selected=1; } ?> value="<?php print $i; ?>"><?php print $i; ?></option>
				<?php
					}
				?>
				<option <?php if ($selected==0) print "selected"; ?> value="">-</option>
			</select>
		</p>
			</fieldset>