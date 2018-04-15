		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><a href="my-account.php">Учетная запись</a><span class="navigation-pipe">&gt;</span>Обо мне</div>
</div>
<!-- /Breadcrumb -->
<div id="identity" class="identity">
<h1>Данные о Вашей личности</h1>
	<h3>Пожалуйста исправьте данные, если они у Вас изменились.</h3>
	<form action="identity.php" method="post" class="std identity">
		<fieldset>
			<p class="radio">
				<span>Пол</span>
				<input id="id_gender1" name="id_gender" value="1" checked="checked" type="radio">
				<label for="id_gender1">мужской</label>
				<input id="id_gender2" name="id_gender" value="2" type="radio">
				<label for="id_gender2">женский</label>
			</p>
			<p class="required text">
				<label for="firstname">Имя</label>
				<input id="firstname" name="firstname" type="text"> <sup>*</sup>
			</p>
			<p class="required text">&nbsp;</p>
		  <p class="required text">&nbsp;</p>
			<p class="required text">
			  <label for="lastname">Фамилия</label>
			  <input name="lastname" id="lastname" type="text"> <sup>*</sup>
		  </p>
			<p class="required text">
			  <label for="middlename">Отчество</label>
				<input name="middlename" id="middlename" type="text">
			</p>
			<p class="required text">
				<label for="email">E-mail</label>
				<input name="email" id="email" type="text"> <sup>*</sup>
			</p>
			<p class="required text">
				<label for="old_passwd">Текущий пароль</label>
				<input name="old_passwd" id="old_passwd" type="password"> <sup>*</sup>
			</p>
			<p class="password">
				<label for="passwd">Новый пароль</label>
				<input name="passwd" id="passwd" type="password">
			</p>
			<p class="password">
				<label for="confirmation">Подтверждение</label>
				<input name="confirmation" id="confirmation" type="password">
			</p>
			<p class="select">
				<label>Дата рождения</label>
				<select name="days" id="days">
					<option selected="selected" value="">-</option>
											<option value="1">1&nbsp;&nbsp;</option>
											<option value="2">2&nbsp;&nbsp;</option>
											<option value="3">3&nbsp;&nbsp;</option>
											<option value="4">4&nbsp;&nbsp;</option>
											<option value="5">5&nbsp;&nbsp;</option>
											<option value="6">6&nbsp;&nbsp;</option>
											<option value="7">7&nbsp;&nbsp;</option>
											<option value="8">8&nbsp;&nbsp;</option>
											<option value="9">9&nbsp;&nbsp;</option>
											<option value="10">10&nbsp;&nbsp;</option>
											<option value="11">11&nbsp;&nbsp;</option>
											<option value="12">12&nbsp;&nbsp;</option>
											<option value="13">13&nbsp;&nbsp;</option>
											<option value="14">14&nbsp;&nbsp;</option>
											<option value="15">15&nbsp;&nbsp;</option>
											<option value="16">16&nbsp;&nbsp;</option>
											<option value="17">17&nbsp;&nbsp;</option>
											<option value="18">18&nbsp;&nbsp;</option>
											<option value="19">19&nbsp;&nbsp;</option>
											<option value="20">20&nbsp;&nbsp;</option>
											<option value="21">21&nbsp;&nbsp;</option>
											<option value="22">22&nbsp;&nbsp;</option>
											<option value="23">23&nbsp;&nbsp;</option>
											<option value="24">24&nbsp;&nbsp;</option>
											<option value="25">25&nbsp;&nbsp;</option>
											<option value="26">26&nbsp;&nbsp;</option>
											<option value="27">27&nbsp;&nbsp;</option>
											<option value="28">28&nbsp;&nbsp;</option>
											<option value="29">29&nbsp;&nbsp;</option>
											<option value="30">30&nbsp;&nbsp;</option>
											<option value="31">31&nbsp;&nbsp;</option>
									</select>
				<select id="months" name="months">
					<option selected="selected" value="">-</option>
											<option value="1">Январь&nbsp;</option>
											<option value="2">Февраль&nbsp;</option>
											<option value="3">Март&nbsp;</option>
											<option value="4">Апрель&nbsp;</option>
											<option value="5">Май&nbsp;</option>
											<option value="6">Июнь&nbsp;</option>
											<option value="7">Июль&nbsp;</option>
											<option value="8">Август&nbsp;</option>
											<option value="9">Сентябрь&nbsp;</option>
											<option value="10">Октябрь&nbsp;</option>
											<option value="11">Ноябрь&nbsp;</option>
											<option value="12">Декабрь&nbsp;</option>
									</select>
				<select id="years" name="years">
					<option selected="selected" value="">-</option>
											<option value="2002">2002&nbsp;&nbsp;</option>
											<option value="2001">2001&nbsp;&nbsp;</option>
											<option value="2000">2000&nbsp;&nbsp;</option>
											<option value="1999">1999&nbsp;&nbsp;</option>
											<option value="1998">1998&nbsp;&nbsp;</option>
											<option value="1997">1997&nbsp;&nbsp;</option>
											<option value="1996">1996&nbsp;&nbsp;</option>
											<option value="1995">1995&nbsp;&nbsp;</option>
											<option value="1994">1994&nbsp;&nbsp;</option>
											<option value="1993">1993&nbsp;&nbsp;</option>
											<option value="1992">1992&nbsp;&nbsp;</option>
											<option value="1991">1991&nbsp;&nbsp;</option>
											<option value="1990">1990&nbsp;&nbsp;</option>
											<option value="1989">1989&nbsp;&nbsp;</option>
											<option value="1988">1988&nbsp;&nbsp;</option>
											<option value="1987">1987&nbsp;&nbsp;</option>
											<option value="1986">1986&nbsp;&nbsp;</option>
											<option value="1985">1985&nbsp;&nbsp;</option>
											<option value="1984">1984&nbsp;&nbsp;</option>
											<option value="1983">1983&nbsp;&nbsp;</option>
											<option value="1982">1982&nbsp;&nbsp;</option>
											<option value="1981">1981&nbsp;&nbsp;</option>
											<option value="1980">1980&nbsp;&nbsp;</option>
											<option value="1979">1979&nbsp;&nbsp;</option>
											<option value="1978">1978&nbsp;&nbsp;</option>
											<option value="1977">1977&nbsp;&nbsp;</option>
											<option value="1976">1976&nbsp;&nbsp;</option>
											<option value="1975">1975&nbsp;&nbsp;</option>
											<option value="1974">1974&nbsp;&nbsp;</option>
											<option value="1973">1973&nbsp;&nbsp;</option>
											<option value="1972">1972&nbsp;&nbsp;</option>
											<option value="1971">1971&nbsp;&nbsp;</option>
											<option value="1970">1970&nbsp;&nbsp;</option>
											<option value="1969">1969&nbsp;&nbsp;</option>
											<option value="1968">1968&nbsp;&nbsp;</option>
											<option value="1967">1967&nbsp;&nbsp;</option>
											<option value="1966">1966&nbsp;&nbsp;</option>
											<option value="1965">1965&nbsp;&nbsp;</option>
											<option value="1964">1964&nbsp;&nbsp;</option>
											<option value="1963">1963&nbsp;&nbsp;</option>
											<option value="1962">1962&nbsp;&nbsp;</option>
											<option value="1961">1961&nbsp;&nbsp;</option>
											<option value="1960">1960&nbsp;&nbsp;</option>
											<option value="1959">1959&nbsp;&nbsp;</option>
											<option value="1958">1958&nbsp;&nbsp;</option>
											<option value="1957">1957&nbsp;&nbsp;</option>
											<option value="1956">1956&nbsp;&nbsp;</option>
											<option value="1955">1955&nbsp;&nbsp;</option>
											<option value="1954">1954&nbsp;&nbsp;</option>
											<option value="1953">1953&nbsp;&nbsp;</option>
											<option value="1952">1952&nbsp;&nbsp;</option>
											<option value="1951">1951&nbsp;&nbsp;</option>
											<option value="1950">1950&nbsp;&nbsp;</option>
											<option value="1949">1949&nbsp;&nbsp;</option>
											<option value="1948">1948&nbsp;&nbsp;</option>
											<option value="1947">1947&nbsp;&nbsp;</option>
											<option value="1946">1946&nbsp;&nbsp;</option>
											<option value="1945">1945&nbsp;&nbsp;</option>
											<option value="1944">1944&nbsp;&nbsp;</option>
											<option value="1943">1943&nbsp;&nbsp;</option>
											<option value="1942">1942&nbsp;&nbsp;</option>
											<option value="1941">1941&nbsp;&nbsp;</option>
											<option value="1940">1940&nbsp;&nbsp;</option>
											<option value="1939">1939&nbsp;&nbsp;</option>
											<option value="1938">1938&nbsp;&nbsp;</option>
											<option value="1937">1937&nbsp;&nbsp;</option>
											<option value="1936">1936&nbsp;&nbsp;</option>
											<option value="1935">1935&nbsp;&nbsp;</option>
											<option value="1934">1934&nbsp;&nbsp;</option>
											<option value="1933">1933&nbsp;&nbsp;</option>
											<option value="1932">1932&nbsp;&nbsp;</option>
											<option value="1931">1931&nbsp;&nbsp;</option>
											<option value="1930">1930&nbsp;&nbsp;</option>
											<option value="1929">1929&nbsp;&nbsp;</option>
											<option value="1928">1928&nbsp;&nbsp;</option>
											<option value="1927">1927&nbsp;&nbsp;</option>
											<option value="1926">1926&nbsp;&nbsp;</option>
											<option value="1925">1925&nbsp;&nbsp;</option>
											<option value="1924">1924&nbsp;&nbsp;</option>
											<option value="1923">1923&nbsp;&nbsp;</option>
											<option value="1922">1922&nbsp;&nbsp;</option>
											<option value="1921">1921&nbsp;&nbsp;</option>
											<option value="1920">1920&nbsp;&nbsp;</option>
											<option value="1919">1919&nbsp;&nbsp;</option>
											<option value="1918">1918&nbsp;&nbsp;</option>
											<option value="1917">1917&nbsp;&nbsp;</option>
											<option value="1916">1916&nbsp;&nbsp;</option>
											<option value="1915">1915&nbsp;&nbsp;</option>
											<option value="1914">1914&nbsp;&nbsp;</option>
											<option value="1913">1913&nbsp;&nbsp;</option>
											<option value="1912">1912&nbsp;&nbsp;</option>
											<option value="1911">1911&nbsp;&nbsp;</option>
											<option value="1910">1910&nbsp;&nbsp;</option>
											<option value="1909">1909&nbsp;&nbsp;</option>
											<option value="1908">1908&nbsp;&nbsp;</option>
											<option value="1907">1907&nbsp;&nbsp;</option>
											<option value="1906">1906&nbsp;&nbsp;</option>
											<option value="1905">1905&nbsp;&nbsp;</option>
											<option value="1904">1904&nbsp;&nbsp;</option>
											<option value="1903">1903&nbsp;&nbsp;</option>
											<option value="1902">1902&nbsp;&nbsp;</option>
											<option value="1901">1901&nbsp;&nbsp;</option>
											<option value="1900">1900&nbsp;&nbsp;</option>
									</select>
			</p>
						<p class="required required_desc"><sup>*</sup>Объязательные поля</p>
			<p class="submit">
				<input class="button" name="submitIdentity" value="Сохранить" type="submit">
			</p>
		</fieldset>
	</form>
<ul class="footer_links">
	<li><a href="my-account.php"><img src="images/my-account.png" alt="" class="icon"></a><a href="my-account.php">Вернуться в учетную запись</a></li>
	<li><a href="index.php"><img src="images/home.png" alt="" class="icon"></a><a href="index.php">На главную</a></li>
</ul>
</div>