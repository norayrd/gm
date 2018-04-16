		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<!-- script type="text/javascript" src="images/product0.js"></script -->
<?php
$reklama_kod=$_GET["reklama"]-0;
$prices_kod=$_GET["prices"]-0;
if (($reklama_kod>0)||($prices_kod>0)) {
        if ($reklama_kod>0) 
            $sql="select rk.*, tm.tov_make, vl.pref_, vc.cours_, cena_ * cours_ cena_uah, cena_old * cours_ cena_old_uah 
                    from gm_reklama rk left join p_tov_make tm on rk.tov_make_kod=tm.tov_make_kod 
                         left join gm_valyuta_list vl on rk.valyuta_kod=vl.ISO_ 
                         left join gm_valyuta_cours vc on rk.valyuta_kod=vc.valyuta_kod 
                   where (rk.reklama_kod=$reklama_kod)";
        else if ($prices_kod>0)
            $sql="select 0 typ_, p.tov_kod, p.tov_name, p.pricesh_kod, tm.tov_make, vl.pref_, vc.cours_, cena_ * cours_ cena_uah, 0 cena_old_uah,
                         '' text_short, '' text_full, '' char_, ps.pic_max image1_,'' image2_, '' image3_
                    from p_prices p left join p_pricesh ph on p.pricesh_kod=ph.pricesh_kod
                         left join p_prices_dop pd on pd.prices_kod=p.prices_kod
                         left join p_pic_shini ps on pd.image1_=ps.id_name2
                         left join p_tov_make tm on p.tov_make_kod=tm.tov_make_kod 
                         left join gm_valyuta_list vl on ph.valyuta_kod=vl.ISO_ 
                         left join gm_valyuta_cours vc on ph.valyuta_kod=vc.valyuta_kod 
                   where (p.prices_kod=$prices_kod)";
            
			$tb=mysql_query($sql) or die(mysql_error());
			@$tb_n=mysql_numrows($tb);
			if ($tb_n>0) {
				$reklama_typ=mysql_result($tb,0,"typ_");
				$reklama_tov_make=mysql_result($tb,0,"tov_make");
				$reklama_tov_kod=mysql_result($tb,0,"tov_kod");
				$reklama_tov_name=mysql_result($tb,0,"tov_name");
				$reklama_cena=number_format(mysql_result($tb,0,"cena_uah"),2,'.','');
				$reklama_valyuta_pref="руб."; //mysql_result($tb,0,"pref_");
				$reklama_pricesh_kod=mysql_result($tb,0,"pricesh_kod");
				$reklama_text_short=str_replace(chr(13), "<br>",mysql_result($tb,0,"text_short"));
				$reklama_text_full=str_replace(chr(13), "<br>",mysql_result($tb,0,"text_full"));
				$reklama_cena_old=number_format(mysql_result($tb,0,"cena_old_uah"),2,'.','');
				$reklama_char=str_replace(chr(13), "<br>",mysql_result($tb,0,"char_"));
                $reklama_image1=mysql_result($tb,0,"image1_");
                if (($prices_kod>0)&&(($reklama_image1.'')!='')) $reklama_image1="shini/images/".$reklama_image1;
				$reklama_image2=mysql_result($tb,0,"image2_");
				$reklama_image3=mysql_result($tb,0,"image3_");
				$page_title="$reklama_tov_kod $reklama_tov_make $reklama_tov_name";
		?>
        <script type="text/javascript">
			document.title="<?php print $page_title; ?>";
		</script>

<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><span class="navigation_end"><?php print $reklama_tov_name; ?></span></div>
</div>
<!-- /Breadcrumb -->
<div id="noro_inner">
<div id="center_column" class="center_column">
<div id="primary_block" class="clearfix">
	<div id="pb-right-column">
		<div id="image-block" class="bordercolor">
			<img src="<?php print $reklama_image1; ?>" name="bigpic" class="jqzoom" id="bigpic">
		</div>
		<div id="views_block">
			<a href="javascript:{}" name="view_scroll_left" title="Other views" class="hidden" id="view_scroll_left">Previous</a>
			<div id="thumbs_list">
				<ul id="thumbs_list_frame">
                <?php if ($reklama_image1.""<>"") { ?>
					<li id="thumbnail_1">
						<a onclick="javascript: bigpic.src='<?php print $reklama_image1; ?>';" rel="other-views" class="thickbox bordercolor shown" title="<?php print $reklama_tov_name; ?>">
							<img id="thumb_1" src="<?php print $reklama_image1; ?>" alt="<?php print $reklama_tov_name; ?>" height="75" width="75">
						</a>
					</li>
				<?php } 
				if ($reklama_image2.""<>"") { ?>
					<li id="thumbnail_2">
						<a onclick="javascript: bigpic.src='<?php print $reklama_image2; ?>'; " rel="other-views" class="thickbox bordercolor " title="<?php print $reklama_tov_name; ?>">
							<img id="thumb_2" src="<?php print $reklama_image2; ?>" alt="<?php print $reklama_tov_name; ?>" height="75" width="75">
						</a>
					</li>
				<?php } 
				if ($reklama_image3.""<>"") { ?>
					<li id="thumbnail_3">
						<a onclick="javascript: bigpic.src='<?php print $reklama_image3; ?>'; " rel="other-views" class="thickbox bordercolor " title="<?php print $reklama_tov_name; ?>">
							<img id="thumb_3" src="<?php print $reklama_image3; ?>" alt="<?php print $reklama_tov_name; ?>" height="75" width="75">
						</a>
					</li>
				<?php } ?>
				</ul>
			</div>
			<a id="view_scroll_right" title="Other views" href="javascript:{}">Next</a>	
		</div>
		<span id="wrapResetImages" style="display:none;">
			<div>
				<a id="resetImages" href="product.php?id_product=1" onclick="$('span#wrapResetImages').hide('slow');return (false);">Display all pictures</a>
			</div>
		</span>
	</div>
	<div id="pb-left-column">
		<h1><?php print "$reklama_tov_kod $reklama_tov_make"; ?></h1>
		<h1><?php print $reklama_tov_name; ?></h1>
				<form id="buy_block" class="bordercolor" action="cart.php" method="post">
			<p class="hidden">
				<input type="hidden" name="token" value="bd530dd7b6039ab183fb25cb9fdb4abf">
				<input type="hidden" name="id_product" value="1" id="product_page_product_id">
				<input type="hidden" name="add" value="1">
				<input type="hidden" name="id_product_attribute" id="idCombination" value>
			</p>
							<div class="price bordercolor">
										<span class="our_price_display">
												<span id="our_price_display" class="price"><?php print $reklama_cena." ".$reklama_valyuta_pref; ?></span>
																	</span>
										<p id="add_to_cart">
                        <?php if ($reklama_kod>0) { ?>                
						    <a class="exclusive" onclick="$('#cart_macro').load('_cart_makro.php?kod_=<?php print $kod_; ?>&add&reklama_kod=<?php print $reklama_kod; ?>&count='+$('#quantity_wanted').val());">В корзину</a>
                        <?php } else if ($prices_kod>0) {?>
                            <a class="exclusive" onclick="$('#cart_macro').load('_cart_makro.php?kod_=<?php print $kod_; ?>&add&prices_kod=<?php print $prices_kod; ?>&count='+$('#quantity_wanted').val());">В корзину</a>                        
                        <?php } ?>
						<input id="add2cartbtn" type="submit" name="Submit" value="Add to cart">
					</p>
					<p id="quantity_wanted_p">
						<input type="text" name="qty" id="quantity_wanted" class="text" value="1" size="2" maxlength="3">
						<label>Количество :</label>
					</p>
				</div>
                <?php if ($reklama_cena_old>0) { ?>
                <p id="old_price"> Преждняя цена
					<span id="old_price_display"><?php print $reklama_cena_old." ".$reklama_valyuta_pref; ?></span></p>
				<?php } ?>
				<p id="minimal_quantity_wanted_p" class="bordercolor" style="display:none;">You must add <b id="minimal_quantity_label">1</b> a a minimum quantity to buy this product.</p>
				<div id="short_description_block" class="bordercolor">
							<div id="short_description_content" class="rte align_justify"><p><?php print $reklama_text_short; ?></p></div>
					</div>
								<p id="oosHook" style="display: none;"></p>
						<div class="clearblock"></div>
		</form>
					</div>
</div>
		<div id="quantityDiscount" class="bgcolor bordercolor" style="display:none; visibility:hidden;">
		<h3>Sliding scale pricing</h3>
		<table>
			<tr>
									<th class="bordercolor">20
											quantities
										</th>
							</tr>
			<tr>
									<td>
											-10%
										</td>
							</tr>
		</table>
	</div>
	<div id="more_info_block" class="clear" style="width:700px">
		<ul id="more_info_tabs" class="idTabs idTabsShort">
			<li class="<?php if (!$reklama_text_full) print "hidden"; ?>"><a id="idTabb1" onclick="javascript: showTab('1');" class="selected">Подробная информация</a></li>			
            <li class="<?php if (!$reklama_char) print "hidden"; ?>"><a id="idTabb2" onclick="javascript: showTab('2');">Характеристики</a></li>			<li class="hidden"><a id="idTabb9" onclick="javascript: showTab('9');">Закачки</a></li>			<li class="hidden"><a id="idTabb4" onclick="javascript: showTab('4');">Аксессуары</a></li>
<li class="hidden"><a id="idTabb5" onclick="javascript: showTab('5'); " class="idTabHrefShort">Комментарии (0)</a></li>
		</ul>
        <script type="text/javascript">
			function showTab(tab_){
				if (tab_=='1') {
					$('#idTab1').show();
					$('#idTabb1').addClass('selected');
				}else{
					$('#idTab1').hide();
					$('#idTabb1').removeClass('selected');
				}
				if (tab_=='2') {
					$('#idTab2').show();
					$('#idTabb2').addClass('selected');
				}else{
					$('#idTab2').hide();
					$('#idTabb2').removeClass('selected');
				}
				if (tab_=='3') {
					$('#idTab3').show();
					$('#idTabb3').addClass('selected');
				}else{
					$('#idTab3').hide();
					$('#idTabb3').removeClass('selected');
				}
				if (tab_=='4') {
					$('#idTab4').show();
					$('#idTabb4').addClass('selected');
				}else{
					$('#idTab4').hide();
					$('#idTabb4').removeClass('selected');
				}
				if (tab_=='5') {
					$('#idTab5').show();
					$('#idTabb5').addClass('selected');
				}else{
					$('#idTab5').hide();
					$('#idTabb5').removeClass('selected');
				}
				if (tab_=='6') {
					$('#idTab6').show();
					$('#idTabb6').addClass('selected');
				}else{
					$('#idTab6').hide();
					$('#idTabb6').removeClass('selected');
				}
				if (tab_=='7') {
					$('#idTab7').show();
					$('#idTabb7').addClass('selected');
				}else{
					$('#idTab7').hide();
					$('#idTabb7').removeClass('selected');
				}
				if (tab_=='8') {
					$('#idTab8').show();
					$('#idTabb8').addClass('selected');
				}else{
					$('#idTab8').hide();
					$('#idTabb8').removeClass('selected');
				}
				if (tab_=='9') {
					$('#idTab9').show();
					$('#idTabb9').addClass('selected');
				}else{
					$('#idTab9').hide();
					$('#idTabb9').removeClass('selected');
				}
			}
		</script>
		<div id="more_info_sheets" class="bgcolor bordercolor">
			<div id="idTab1" class="bullet <?php if (!$reklama_text_full) print "hidden"; ?>"><div><p><?php print $reklama_text_full; ?></p></div></div>
			<div id="idTab2" class="bullet <?php if (!(!$reklama_text_full && $reklama_char)) print "hidden"; ?>">
				<?php print $reklama_char; ?>
			</div>
			<ul id="idTab9" class="bullet hidden">
				<li><a >Test Attachment</a><br>Lorem ipsum</li>
			</ul>
			<ul id="idTab4" class="hidden">
				<li class="bordercolor ajax_block_product first_item product_accessories_description">
					<div class="accessories_desc">
						<a class="accessory_image product_img_link bordercolor" href="view.php?id_product=2" title="A-Tng"><img src="img/2-4-medi.jpg" alt="A-Tng"></a>
						<h5><a class="product_link" href="product.php?id_product=2">A-T Steeler Front S...</a></h5>
						<a class="product_descr" href="view.php?id_product=2" title="More">Even ff,...</a>
					</div>
					<div class="accessories_price bordercolor">
						<span class="price">$215.00</span>
						<a class="exclusive button ajax_add_to_cart_button" href="cart.php?qty=1&amp;id_product=2&amp;token=bd530dd7b6039ab183fb25cb9fdb4abf&amp;add" rel="ajax_id_product_2" title="Add to cart">Add to cart</a>
					</div>
				</li>
				<li class="bordercolor ajax_block_product item product_accessories_description">
					<div class="accessories_desc">
						<a class="accessory_image product_img_link bordercolor" href="view.php?id_product=5" title="Evo Kit"><img src="img/5-13-med.jpg" alt="Evo Kit"></a>
						<h5><a class="product_link" href="view.php?id_product=5">Evo  ...</a></h5>
						<a class="product_descr" href="view.php?id_product=5" title="More">We spend,...</a>
					</div>
					<div class="accessories_price bordercolor">
						<span class="price">$270.00</span>
						<a class="exclusive button ajax_add_to_cart_button" href="cart.php?qty=1&amp;id_product=5&amp;token=bd530dd7b6039ab183fb25cb9fdb4abf&amp;add" rel="ajax_id_product_5" title="Add to cart">Add to cart</a>
					</div>
				</li>
				<li class="bordercolor ajax_block_product item product_accessories_description">
					<div class="accessories_desc">
						<a class="accessory_image product_img_link bordercolor" href="view.php?id_product=6" title="Bre Kit"><img src="ima/6-16-med.jpg" alt="Brembo GT Big Brake Kit"></a>
						<h5><a class="product_link" href="product.php?id_product=6">Brembo GT Big Brake...</a></h5>
						<a class="product_descr" href="product.php?id_product=6" title="More">Our a...</a>
					</div>
					<div class="accessories_price bordercolor">
						<span class="price">$620.00</span>
						<a class="exclusive button ajax_add_to_cart_button" href="cart.php?qty=1&amp;id_product=6&amp;token=bd530dd7b6039ab183fb25cb9fdb4abf&amp;add" rel="ajax_id_product_6" title="Add to cart">Add to cart</a>
					</div>
				</li>
				<li class="bordercolor ajax_block_product last_item product_accessories_description">
					<div class="accessories_desc">
						<a class="accessory_image product_img_link bordercolor" href="view.php?id_product=10" title="Acura"><img src="img/10-28-me.jpg" alt="Acura"></a>
						<h5><a class="product_link" href="view.php?id_product=10">Acura RSX Type-S HK...</a></h5>
						<a class="product_descr" href="view.php?id_product=10" title="More">Have it...</a>
					</div>
					<div class="accessories_price bordercolor">
						<span class="price">$49.00</span>
						<a class="exclusive button ajax_add_to_cart_button" href="cart.php?qty=1&amp;id_product=10&amp;token=bd530dd7b6039ab183fb25cb9fdb4abf&amp;add" rel="ajax_id_product_10" title="Add to cart">Add to cart</a>
					</div>
				</li>
			</ul>
			<div id="idTab5" class="hidden">
				<script type="text/javascript" src="images/jquery07.js"></script>
				<script type="text/javascript">
					$(function(){ $('input[@type=radio].star').rating(); });
					$(function(){
						$('.auto-submit-star').rating({
							callback: function(value, link){
							}
						});
					});
					//close  comment form
					function closeCommentForm(){
						$('#sendComment').slideUp('fast');
						$('input#addCommentButton').fadeIn('slow');
					}
				</script>
				<p class="comment_none">No customer comments for the moment.</p>
				<p class="comment_add"><input class="button_large" type="button" id="addCommentButton" value="Добавить коментарий" onclick="$('#sendComment').slideDown('slow');$(this).slideUp('slow');"></p>
				<form action method="post" id="sendComment" style="display:none;">
					<fieldset>
						<p class="align_right"><a href="javascript:closeCommentForm()">X</a></p>
						<p class="bold">Добавить коментарий</p>
						<table class="comment_rating"></table>
						<p><label for="customer_name">Ваше имя:</label><input type="text" name="customer_name" id="customer_name"></p>
						<p><label for="comment_title">Заголовок:</label><input type="text" name="title" id="comment_title"></p>
						<p><label for="content">Ваш комментарий:</label><textarea style="width:650px" cols="46" rows="5" name="content" id="content"></textarea></p>
						<p class="submit"><input class="button" name="submitMessage" value="Отправить" type="submit"></p>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<ul class="idTabs" style="display:none; visibility:hidden;">
		<li><a class="selected">Product customization</a></li>
	</ul>
	<div class="customization_block bgcolor bordercolor" style="display:none; visibility:hidden;">
		<form method="post" action="product.php?id_product=1" enctype="multipart/form-data" id="customizationForm">
			<p>
				<img src="Castrol%20Edge%200W30%205%20Litre%20Synthetic%20Engine%20Oil%20-%20SPARE%20PARTS_files/infos000.png" alt="Informations">
				After saving your customized product, remember to add it to your cart.
			</p>
			<h2>Texts</h2>
			<ul id="text_fields">
			</ul>
			<p style="clear: left;" id="customizedDatas">
				<input type="hidden" name="ipa_customization" id="ipa_customization" value>
				<input type="hidden" name="quantityBackup" id="quantityBackup" value>
				<input type="hidden" name="submitCustomizedDatas" value="1">
				<input type="button" class="button" value="Save" onclick="javascript:saveCustomization()">
				<span id="ajax-loader" style="display:none"><img src="images/loader00.gif" alt="loader"></span>
			</p>
		</form>
		<p class="clear required"><sup>*</sup> required fields</p>
	</div>
</div>
<?php 
	}
}
?>
</div>