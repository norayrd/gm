<?php
	require_once "scripts/gm_access.php";
	if (isset($_GET["kod_"])) if ($_GET["kod_"]==$kod_){
		if (isset($_GET["prices_kod"])){
			$sql_="call gm_recicle_add('$kod_', ".$_GET["prices_kod"].");";
			mysql_query($sql_) or trigger_error(mysql_error().$sql);
		}
		$sql_="select count(*) pozicii_, ifnull(sum(r.cena_ * r.valyuta_cours * r.count_),0) summa_ from gm_rashod r left join gm_kod k on k.kod_=$kod_ where ((r.kod_='$kod_') or ((r.user_id=k.user_id)and(k.user_id>0)))and(r.rashodh_kod is null)";
		$tb=mysql_query($sql_);
		@$tb_n=mysql_numrows($tb);
		if ($tb_n>0){
			$pozicii_=mysql_result($tb,0,"pozicii_");
			$summa_=number_format(mysql_result($tb,0,"summa_"),2,'.','');
		}else{
			$pozicii_=0;
			$summa_=0;
		}
	}
?>
		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

		
        <!-- 
        <a href="order.php" title="Ваша корзина">КОРЗИНА:</a>
        
        <?php if ($pozicii_>0) { ?>
			<span id="cart_quantity" class="ajax_cart_quantity "><?php print $pozicii_; ?></span>
		<?php }else{ ?>
			<span id="cart_no_product" class="ajax_cart_no_product">(пусто)</span>
		<?php } ?>

		<?php if ($pozicii_==1) { ?>
			<span id="cart_product_txt" class="ajax_cart_product_txt">позиция</span>
		<?php } else if (($pozicii_>=2)&&($pozicii_<5)) { ?>
			<span id="cart_product_txt_234" class="ajax_cart_product_txt_234">позиции</span>
		<?php } else if ($pozicii_>=5) { ?>
			<span id="cart_product_txt_s" class="ajax_cart_product_txt_s">позиций</span>
		<?php } ?>
        -->
        
        <a href="vin.php">ЗАПРОС ПО VIN</a>