<?php require_once "scripts/gm_access.php"; 
	if (isset($_GET["kod_"])) {
		if ($_GET["kod_"]==$kod_) {
			//если удаление 
			if (isset($_GET["delete"]) && isset($_GET["rashod_kod"])) {
				$sql_="delete from gm_rashod where (rashod_kod=".($_GET["rashod_kod"]-0).")and((user_id=$user_id)or(kod_=$kod_))";
				mysql_query($sql_);
			} else
			//если добавление 
			if (isset($_GET["add"]) && isset($_GET["prices_kod"])) {
				$sql_="call gm_recicle_add($kod_,".($_GET["prices_kod"]-0).",".($_GET["count"]-0).")";
				mysql_query($sql_);
			} else if (isset($_GET["add"]) && isset($_GET["reklama_kod"])) {
				$sql_="call gm_recicle_add_from_reklama($kod_,".($_GET["reklama_kod"]-0).",".($_GET["count"]-0).")";
				mysql_query($sql_);
			}
		} else exit;
	} else exit;
?>
<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<div id="cart_block" class="block exclusive">                                                                        
	<h4><a href="order.php">Корзина</a><span id="block_cart_expand" class="hidden">&nbsp;</span><span id="block_cart_collapse">&nbsp;</span></h4>
	<div class="block_content">
	<div id="cart_block_list" class="expanded">
		<dl class="products">
<?php
		$sql_="select r.*, tm.tov_make, ifnull(r.cena_ * r.valyuta_cours * r.count_,0) summa_ from gm_rashod r left join gm_kod k on k.kod_=$kod_ left join p_tov_make tm on tm.tov_make_kod=r.tov_make_kod where ((r.kod_='$kod_')or((r.user_id=k.user_id)and(k.user_id>0)))and(r.rashodh_kod is null)";
		$tb=mysql_query($sql_);
		@$tb_n=mysql_numrows($tb);
		$i=0;
		$pozicii_=0;
		$vsego_=0;
		while ($i<$tb_n){
            $count_=number_format(mysql_result($tb,$i,"count_"),0,".","");
            $summa_=number_format(mysql_result($tb,$i,"summa_"),2,".","");
			$vsego_=$vsego_ + $summa_;
			$pozicii_+=1;
			$tov_name=substr(mysql_result($tb,$i,"tov_name"),0,12);
			$tov_kod=mysql_result($tb,$i,"tov_kod");
			$tov_make=mysql_result($tb,$i,"tov_make");
			$rashod_kod=mysql_result($tb,$i,"rashod_kod");
			$rashod_reklama_kod=mysql_result($tb,$i,"reklama_kod")-0;
?>
        	<dt style="display: block;" class="1first_item" id="cart_block_product">
            	<span class="quantity-formated"><span class="quantity"><?php print $count_; ?></span>x</span>
                <a <?php if ($rashod_reklama_kod>0) print "href='view.php?reklama=$rashod_reklama_kod'"; ?>" title="<?php print $tov_name; ?>..."><?php print $tov_name; ?> ...</a>
                <span class="remove_link">
                	<a class="ajax_cart_block_remove_link" rel="nofollow" onclick=" if (confirm('Удалить из корзины?')) { $('#cart_macro').load('_cart_makro.php?kod_=<?php print $kod_; ?>&delete&rashod_kod=<?php print $rashod_kod; ?>'); } " title="Удалить из карзины"> </a></span>
                    <span class="price"><?php print $summa_; ?></span>
			</dt>
            <dd style="display: block;" id="cart_block_combination_of_111" class="">
				<a <?php if ($rashod_reklama_kod>0) print "href='view.php?reklama=$rashod_reklama_kod'"; ?>" title="<?php print $tov_name; ?> ..."><?php print substr($tov_kod." " .$tov_make,0,20)."..."; ?></a>
            </dd>
            
<?php 
		$i+=1;
	}
?>
            
        </dl>
		<?php if (!($pozicii_>0)) { ?>
			<p id="cart_block_no_products">Пусто</p>
		<?php } ?>
			<div class="cart-prices">
				<div class="cart-prices-block" style=" display:none; visibility:hidden; ">
					<span>Доставка</span>
					<span id="cart_block_shipping_cost" class="price ajax_cart_shipping_cost">$0.00</span>
				</div>
				<div class="cart-prices-block">
					<span>Всего</span>
					<span id="cart_block_total" class="price ajax_block_cart_total"><?php print number_format($vsego_,2,".",""); ?> грн.</span>
				</div>
			</div>
		<p id="cart-buttons">
			<a href="order.php" class="btn_cart" title="Корзина">Корзина</a>
		</p>
	  </div>
	</div>
</div>
<script type="text/javascript">
	$('#header_cart').load('_cart_mini.php?kod_=<?php print $kod_; ?>');
</script>
