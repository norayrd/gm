		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<div id="header">
		<a id="header_logo" href="http://www.avto-polit.ru" title="avto-polit.ru">
			<img src="images/logotip.png" alt="avto-polit.ru" height="80" class="logo">
		</a>
		<div id="header_right">
		<div class="clearblock"></div>
<ul id="tmheaderlinks">
	<li><a href="index.php" class="active">ГЛАВНАЯ</a></li>
	<li><a href="prices-drop.php">АКЦИИ</a></li>
	<li><a href="delivery.php">ДОСТАВКА</a></li>
	<li><a href="contact-form.php">КОНТАКТЫ</a></li>
    <li><a href="map.php">КАРТА САЙТА</a></li>
</ul><!-- Block currencies module -->
<div id="currencies_block_top" hidden style="visibility: hidden">
	<form id="setCurrency" action="#" method="post">
		<label>Валюта:</label>
		<select onchange="setCurrency(this.value);" >
							<option value="1">$</option>
							<option value="2">&euro;</option>
							<option value="3" selected="selected">гривна</option>
					</select>
		<input type="hidden" name="id_currency" id="id_currency" value>
		<input type="hidden" name="SubmitCurrency" value>
	</form>
</div>
<!-- /Block currencies module --><!-- Block user information module HEADER -->
<ul id="header_user">
	<li id="header_user_info">
		Добро пожаловать <?php print $user_name_first; ?>,
        	<?php if ($user_id>0) { ?>
				(&nbsp;<a href="?logout=1">Выход</a>&nbsp;)
            <?php }else{ ?>
				(&nbsp;<a href="authentication.php">Вход</a>&nbsp;)            
            <?php } ?>
			</li>
	<li id="your_account"><a href="authentication.php" title="Учетная запись">Учетная запись</a></li>
</ul>
<div id="header_cart">
<!--?php //include "_cart_mini.php"; ?--></div>
<script type="text/javascript">
	$("#header_cart").load("_cart_mini.php?kod_=<?php print $kod_; ?>");
</script>
<!-- /Block user information module HEADER --><!-- Block search module TOP -->
<div id="search_block_top">
	<?php
        $search_query=tov_kod_clear($_GET["search_query"]); 
        $search_query_make=tov_kod_clear($_GET["search_query_make"]); 
	?>
	<form method="get" action="search.php" id="searchbox">                                                
        <input class="search_query" type="text" id="search_query_top" name="search_query" value="<?php print $search_query; ?>" >
        <script type="text/javascript">
			searchtext='поиск по коду товара';
			if (document.getElementById("search_query_top").value=="") document.getElementById("search_query_top").value=searchtext;
document.getElementById("search_query_top").onfocus=new Function("if (this.value == searchtext) {this.value = '';}");
document.getElementById("search_query_top").onblur=new Function("if (this.value == '') {this.value = searchtext;}");
		</script>
		<a href="javascript: if (document.getElementById('search_query_top').value!=searchtext) {document.getElementById('search_query_make').value=''; document.getElementById('searchbox').submit();}">Поиск</a>
        <input type="hidden" id="search_query_make" name="search_query_make" value="<?php print $search_query_make; ?>" >
		<input type="hidden" name="sortby" value="1">
	</form>
</div>
	
<!-- /Block search module TOP -->
<!-- TM Categories -->
<script type="text/javascript" src="images/superfish.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('ul.sf-menu').superfish({
			delay: 1000,
			animation: {opacity:'show',height:'show'},
			speed: 'fast',
			autoArrows: false,
			dropShadows: false
		});
	});
</script>
<div id="tmcategories">
	<ul id="cat" class="sf-menu sf-js-enabled">
		<?php
		if (isset($_GET["prices_kod"])){
            $sql_="call gm_recicle_add('$kod_', ".$_GET["prices_kod"].");";
			mysql_query($sql_) or trigger_error(mysql_error().$sql);
		}
		$sql_="select * from gm_menu m where (m.hide_=0) order by m.order_";
		$tb=mysql_query($sql_);
		@$tb_n=mysql_numrows($tb);
		$i=0;
		while ($i<$tb_n){
            $menu_id=mysql_result($tb,$i,"menu_id");
            $menu_name=substr(mysql_result($tb,$i,"menu_name"),0,50);
            $menu_url=mysql_result($tb,$i,"url_");
			if ($i==0) {
		?>
				<li class="sub"><a href="<?php print $menu_url; ?>"><?php print $menu_name; ?></a></li>        
        <?php
			}else if (($i<>5)&&($i<$tb_n-1)) {
		?>
				<li class=""><a href="<?php print $menu_url; ?>"><?php print $menu_name; ?></a></li>
			<?php 
			}else if ($i==$tb_n-1) {
			?>
					<li class="last"><a href="<?php print $menu_url; ?>"><?php print $menu_name; ?></a></li>
				</ul>
       		</li>
			<?php 
			}else if ($i==5) { ?>
				<li class="last"><a href="#">Другие &raquo;</a>
					<ul style="display: none; visibility: hidden;" class="subcat">
						<li class=""><a href="<?php print $menu_url; ?>"><?php print $menu_name; ?></a></li>
			<?php 
			}
			$i+=1;
        }
		?>
	</ul>
</div>
<!-- /TM Categories -->
		</div>
	</div>
    <?php if (isset($page_baner)) include $page_baner;
	  else { ?>
<div style="height:57px"></div>      
      <?php } ?>

