		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
        <?php
			if (!isset($_POST["step"])) $step_=1;
			else $step_=$_POST["step"]-0;
			
			if (($step_<1)||($step_>5)) $step_=1;
			//print "$step_, ".$_POST['deliv_id'].", ".$_POST['deliv_strahovka'].", ". $_POST['deliv_need_adr'];
            if (($user_id==0)&&($step_>1)){
                include "_autentication.php";
                exit;
            }
			if (($user_id>0)&&($step_==1)) $step_=2;
        ?>
<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><span class="navigation_page">Корзина</span></div>
</div>
<!-- /Breadcrumb -->
<div id="noro_inner">
    <h1 id="cart_title">Содержание корзины</h1>
	<ul id="order_steps" class="step<?php print $step_; ?> hidden">
		<li class="step_done"><a href="order.php">Корзина</a></li>
		<li class="step_current"><span>Вход</span></li>
		<li class="step_todo"><span>Доставка</span></li>
		<li class="step_todo"><span>Оплата</span></li>
		<li id="step_end" class="step_todo"><span>Всего</span></li>
	</ul>
<?php
//step=1 или 2 - это значит, что на этом этапе клиент осматривает корзину, и может войти или зарегистрироваться
if (($step_==1)||($step_==2)) {
?>
	<div id="order-detail-content" class="table_block">
            <script type="text/javascript">
                function cart(id,ts,todo){
                    $('#product_'+id).hide(100);
                    $('#product_'+id).load('<?php print "_cart.php?kod=$kod_&rashod="; ?>'+id+'&ts='+ts+'&'+todo);
                    $('#product_'+id).show(100);
                }
            </script>
		<table id="cart_summary" class="std">
			<thead>
				<tr>
					<th class="cart_product first_item"><!-- input type="checkbox" value="1" checked="checked" onclick="productCheck(this.checked)" -->
					<script type="text/javascript">
						function productCheck(val_){
							prod_check=document.getElementsByName('product_check');
							for (var i in prod_check){
								prod_check[i].checked=val_;
                                //prod_check[i].click(val_);
							} 
						}
					</script>
        	        </th>
					<th class="cart_product">Артикул</th>
					<th class="cart_description item">Наименование</th>
					<!-- th class="cart_ref item">Примечание</th -->
					<th class="cart_availability item">Сроки</th>
					<th class="cart_quantity item">Кол.</th>
					<th class="cart_unit item">Цена (грн)</th>
					<th class="cart_total last_item">Сумма (грн)</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$sql_="select r.rashod_kod, r.ts_ from gm_rashod r left join p_tov_make tm on tm.tov_make_kod=r.tov_make_kod where (r.rashodh_kod is null)and((r.kod_='$kod_')or((r.user_id=$user_id)and($user_id>0)) )";
			$tb=mysql_query($sql_);
			@$tb_n=mysql_numrows($tb);
			$i=0;
			$pozicii_=0;
			$vsego_=0;
			$total_summa=0;      
			while ($i<$tb_n){
				$pozicii_+=1;
                $rashod_kod=mysql_result($tb,$i,"rashod_kod");
                $rashod_ts=mysql_result($tb,$i,"ts_");
			?>
				<tr id="product_<?php print $rashod_kod; ?>" class=" cart_item">
                    <td><script type="text/javascript">
                        cart(<?php print $rashod_kod; ?>,<?php print $rashod_ts; ?>,'check');
                    </script></td>
                </tr>    
			<?php
				$i+=1; 
			} 
			?>
			</tbody>
			<tfoot id="cart_total">
			</tfoot>
		</table>
        <script type="text/javascript">
            function cart_total_refresh(){
                $('#cart_total').load('_cart_total.php?kod=<?php print $kod_; ?>');
            }
            cart_total_refresh();
        </script>
	</div>
    <div align="right">
	<p class="cart_navigation">
    <form method="post" action="order.php" id="form_tostep2">
    	<input type="hidden" name="step" id="step" value="<?php print ($step_+1); ?>">
    	<input type="hidden" name="kod" id="kod" value="<?php print $kod_; ?>">
        <?php if ($user_id==0) { ?><label>ВНИМАНИЕ! Для оформления заказа требуется войти или зарегистрироваться. </label><?php } ?>
    	<input type="submit" class=" button_red exclusive" alt="Далее / Заказать »" value="Далее / Заказать »" >
    </form></p>
    </div>
<?php
	//step=1 или 2 - это значит, что на этом этапе клиент осматривает корзину, и может войти или зарегистрироваться
} else if ($step_==3) {
	//на этом этапе мы уточняем адрес доставки заказа, и при переходе на step_=4 создаем временный заголовок заказа (temp в gm_rashodh).
?>


<form method="post" action="order.php" id="form_tostep32">
<div id="cart_block">
	<div id="perevozchik">
		<h2>Способ доставки</h2><br />
        <p>
        	<?php
			$sql="select f.faces_id,f.name_full,f.deliv_strahovka,f.deliv_need_adr,f.deliv_have_office,f.typ_ from gm_faces f where f.typ_ in (3,4) order by typ_, f.order_";
			$tb=mysql_query($sql);
			@$tb_n=mysql_numrows($tb);
			$i_=0;
			$mas_deliv="[0,0,0,0]";
			$deliv_id_options="";
            $tb_perevozchik_typ=3;
            $tb_perevozchik_typ_old=3;
			while ($i_<$tb_n) {
				$tb_perevozchik_faces_id=mysql_result($tb,$i_,"faces_id");	
				$tb_perevozchik_name_full=mysql_result($tb,$i_,"name_full");
                $tb_perevozchik_deliv_strahovka=mysql_result($tb,$i_,"deliv_strahovka");
                $tb_perevozchik_deliv_have_office=mysql_result($tb,$i_,"deliv_have_office");
                $tb_perevozchik_deliv_need_adr=mysql_result($tb,$i_,"deliv_need_adr");
                $tb_perevozchik_typ=mysql_result($tb,$i_,"typ_");
				$mas_deliv="$mas_deliv,[$tb_perevozchik_faces_id,$tb_perevozchik_deliv_strahovka,$tb_perevozchik_deliv_need_adr,$tb_perevozchik_deliv_have_office]";
                if ($tb_perevozchik_typ_old!=$tb_perevozchik_typ) $deliv_id_options=$deliv_id_options."<optgroup label='перевозчики'>";
				$deliv_id_options=$deliv_id_options."<option value='".$tb_perevozchik_faces_id."'>$tb_perevozchik_name_full</option>";
				$i_+=1;
                $tb_perevozchik_typ_old=$tb_perevozchik_typ;
			}
        	?>
        <select name="deliv_id" id="deliv_id" style="left:50px; position:relative;" onchange="javascript: loadDelivInfo($('#deliv_id').val()); " >
        	<option selected="selected" value="0">-</option>
            <?php print $deliv_id_options; ?>
        </select>
        </p>
        
	</div>
        <div id="deliv_info"></div>
	    <script type="text/javascript">
            function loadDelivInfo(deliv_id){
                $('#deliv_info').load('_order_deliv.php?kod=<?php print $kod_; ?>&deliv='+deliv_id);
            }
    	    loadDelivInfo($('#deliv_id').val());
	    </script>
</div>
        <h2>Условия доставки</h2><br />
        <div style="left:50px; position:relative; width: 600px;">
            <table class=" noro_table" style=" border-style: solid; border-color: #CCCCCC;"><tr><td width="10"></td><td align="justify">
            <p>Доставка по Украине</p>
            <p>
                1. Выбирая способ доставки того или иного перевозчика, вы соглашаетесь с условиями перевозки, упаковки и возмещения ущерба данной транспортной компании. С момента передачи вашего заказа перевозчику, всю ответственность за вверенный товар несёт транспортная компания. 
            </p>
            <p>
                2. Компания Автотим к отправке готовит исключительно новые товары в заводской не нарушенной упаковке без следов установки и явных дефектов. Поэтому при получении своего товара у перевозчика проверяйте целостность вверяемых вам ваших заказов. Все претензии незамедлительно предоставляйте перевозчику. 
            </p>
            <p>
                Все заказы принимаются: 
            </p>
            <p>
                • до 12.30 для отправки перевозчиком «Новая Почта»; 
            </p>
            <p>
                • до 16.30 для отправки перевозчиком «Гюнсел»; 
            </p>
            <p>
                • до 15.00 для отправки перевозчиком «Ночной экспресс». 
            </p>
            <p></p>
            </td><td width="10"></td></tr></table>
            <p>
                <input type="checkbox" value="1" name="deliv_rules" id="deliv_rules"> <label for="deliv_rules" style="font-weight: bold;">* С условиями доставки согласен.</label>
            </p>
        </div> 
    	<input type="hidden" name="deliv_need_adr" id="deliv_need_adr" value="0">
    	<input type="hidden" name="step" id="step" value="4">
    	<input type="hidden" name="kod" id="kod" value="<?php print $kod_; ?>">
        <textarea name="deliv_adr" id="deliv_adr" class="hidden"></textarea>
    <p></p>    
    <script type="text/javascript">
        function totalSubmit2(){
            res=totalSubmit();
            if (res && !$('#deliv_rules')[0].checked) {
                    res=false;
                    alert('Без соглашения с условиями доставки заказ не принимается в работу!');
            }
            return res;    
        }
    </script>
    <div align="right">
    <table width="100%">
    <tr><td height="10"></td>
    </tr>
    <tr>
    <td align="left">
    	<input type="button" class=" button exclusive" alt="&laquo; Назад" value="&laquo; Назад" onclick="javascript: window.history.back(); " >
    </td>
    <td align="right">
    	<input type="submit" class=" button_red exclusive" alt="Далее / Оплата »" value="Далее / Оплата »" onclick="javascript: return totalSubmit2(); ">
    </td>
    </tr>
    </table>
    </div>
</form>
<?php
	//на этом этапе мы уточняем адрес доставки заказа, и при переходе на step_=4 создаем временный заголовок заказа (temp в gm_rashodh).
} else if ($step_==4) {
	//на этом этапе варианты оплаты
?>


<div id="order-detail-content" class="table_block">
    <?php
        //заказчик
        $sql_="select * from gm_faces f where (f.user_id=$user_id) order by f.typ_ limit 1";
        $tb=mysql_query($sql_);
        @$tb_n=mysql_numrows($tb);
        if ($tb_n>0){
            $faces_id=mysql_result($tb,0,"faces_id");
            $faces_name_full=mysql_result($tb,0,"name_full");
            $faces_email=mysql_result($tb,0,"email_");
        }
        //перевозчик
        if ($_POST["deliv_id"]-0!=0) {
            $sql_="select * from gm_faces f where f.faces_id=".$_POST["deliv_id"];
            $tb=mysql_query($sql_);
            @$tb_n=mysql_numrows($tb);
            if ($tb_n>0){
                $deliv_id=mysql_result($tb,0,"faces_id");
                $deliv_name_full=mysql_result($tb,0,"name_full");
                $deliv_email=mysql_result($tb,0,"email_");
            }
        }
        if ($_POST['deliv_office']-0!=0) {
            $sql_="select * from gm_deliv_office do where do.deliv_office_id=".$_POST['deliv_office'];
            $tb=mysql_query($sql_);
            @$tb_n=mysql_numrows($tb);
            if ($tb_n>0){
                $deliv_office_city=mysql_result($tb,0,"city_");
                $deliv_office_adr=mysql_result($tb,0,"adr_");
                $deliv_office_tel=mysql_result($tb,0,"tel_");
            }
        }
    ?>
        <table border="0" width="100%" cellspacing="10">
				<tr>
					<td colspan="2">
                    <p align="center"><label style="font-weight:bold">ЗАКАЗ №______ ОТ <?php print date('d.m.Y', time()); ?></label></p>
                    </td>
                </tr>
				<tr>
					<td width="100%">
                        <p >ЗАКАЗЧИК: <label style="font-weight:bold"><?php print $faces_name_full; ?></label></p>
                        <p >E-MAIL: <label style="font-weight:bold"><?php print $faces_email; ?></label></p>
                        <p style="font-weight:bold">ДОСТАВКА: <label style="font-weight:bold"><?php print $deliv_name_full; ?> <?php if ($_POST['deliv_strahovka']==1) { ?> <span style="color: red;">(застраховать)</span><?php } else { ?><span style="color: red;">(не страховать)</span><?php } ?></label></p>
                        <p style="font-weight:bold">ПОЛУЧАТЕЛЬ: <label style="font-weight:bold"><?php print $_POST['deliv_poluchatel']; ?></label></p>
                        <p style="font-weight:bold">АДРЕС:</p>
                        <div style=" position:relative; left:100px; top:-10px;">
                            <table class=" noro_table" style=" border-style: solid; border-color: #EEEEEE;" width="250px"><tr><td>
                                <pre style=" color:#666666; "><?php print $_POST['deliv_adr']; ?></pre>
                                <pre style=" color:#666666; "><?php if ($deliv_office_tel) print $deliv_office_tel; if ($deliv_office_city) print '<br>(город/село) '.$deliv_office_city; if ($deliv_office_adr) print '<br>адрес: '.$deliv_office_adr; ?></pre>
                            </td></tr></table>
                        </div>
                    </td>
				    <!--td width="50%">
                        <p style="font-weight:bold">ПОСТАВЩИК</p>
                    </td-->
				</tr>
                <tr><td height="20"></td></tr>
        </table>
		<table id="cart_summary" class="std">
			<thead>
				<tr>
					<th class="cart_product first_item">№</th>
					<th class="cart_product">Артикул</th>
					<th class="cart_description item">Наименование</th>
                    <th class="cart_description item">Сроки</th>
					<th class="cart_quantity item">Кол.</th>
					<th width="100px" class="cart_total item">Цена (грн)</th>
					<th width="100px" class="cart_total last_item">Сумма (грн)</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$sql_="select r.rashod_kod, r.tov_kod, r.tov_name,r.count_, r.ts_, tm.tov_make, ifnull(r.cena_ * r.valyuta_cours,0) cena_, ifnull(r.cena_ * r.valyuta_cours * r.count_,0) summa_, 
                          ph.srok_min,ph.srok_max
                     from gm_rashod r left join p_tov_make tm on tm.tov_make_kod=r.tov_make_kod
                          left join p_pricesh ph on ph.pricesh_kod=r.pricesh_kod 
                    where (r.rashodh_kod is null)and((r.kod_='$kod_')or((r.user_id=$user_id)and($user_id>0)) )and(r.checked_=1)";
			$tb=mysql_query($sql_);
			@$tb_n=mysql_numrows($tb);
			$i=0;
			$pozicii_=0;
			$vsego_=0;
			$total_summa=0;      
			while ($i<$tb_n){
				$count_=number_format(mysql_result($tb,$i,"count_"),0,".","");
				$cena_=number_format(mysql_result($tb,$i,"cena_"),2,".","");
				$summa_=number_format(mysql_result($tb,$i,"summa_"),2,".","");
				$vsego_=$vsego_ + $summa_;
				$pozicii_+=1;
				$tov_name=substr(mysql_result($tb,$i,"tov_name"),0,12);
				$tov_kod=mysql_result($tb,$i,"tov_kod");
				$tov_make=mysql_result($tb,$i,"tov_make");
                $rashod_kod=mysql_result($tb,$i,"rashod_kod");
                $rashod_ts=mysql_result($tb,$i,"ts_");
                $rashod_srok_min=mysql_result($tb,$i,"srok_min");
                $rashod_srok_max=mysql_result($tb,$i,"srok_max");
				$total_summa=$total_summa+$summa_;
			?>
				<tr id="product_<?php print $rashod_kod?>" class=" cart_item">
                    <td><?php print $i+1; ?></td>
                    <td class="cart_product"><a href="search.php?search_query=<?php print $tov_kod; ?>"><?php print $tov_kod; ?></a></td>
                    <td class="cart_description"><h5><a class="product_link"><?php print $tov_name; ?></a></h5></td>
                    <td class="cart_quantity"><?php print "$rashod_srok_min - $rashod_srok_max"; ?></td>
                    <td class="cart_quantity"><?php print $count_; ?></td>
                    <td class="cart_total" align="right"><span class="price"><?php print $cena_; ?></span></td>
                    <td class="cart_total" align="right"><span class="price"><?php print $summa_; ?></span>
                    </td>
                </tr>    
			<?php
				$i+=1; 
			} 
			?>
			</tbody>
			<tfoot id="cart_total">
                <tr class="cart_total_price">
                    <td colspan="6">Всего деталей:</td>
                    <td class="price" id="total_product"><span class="price"><?php print "$total_summa"; ?></span></td>
                </tr>
                <tr class="cart_total_voucher" style="display: none;">
                    <td colspan="6">Скидка:</td>
                    <td class="price-discount" id="total_discount"><span class="price">0.00</span></td>
                </tr>
                <tr class="cart_total_delivery">
                    <td colspan="6">Доставка:</td>
                    <td class="price" id="total_shipping"><span class="price">0.00</span></td>
                </tr>
                <tr class="cart_total_price" style="display:none">
                    <td colspan="6">Всего:</td>
                    <td class="price" id="total_price_without_tax"><span class="price"><?php print "$total_summa"; ?></span></td>
                </tr>
                <tr class="cart_total_price">
                    <td colspan="6">Итого (грн.):</td>
                    <td class="price" id="total_price"><span class="price"><?php print "$total_summa"; ?></span></td>
                </tr>
			</tfoot>
		</table>
	</div>
    <form method="post" action="order.php" id="form_tostep45">
        <div align="right">
            <br>
            <table width="100%"><tr><td align="right" width="*"><label>Дополнительная информация по заказу<br><br><br>осталось символов (<span id="simb_count"></span>)</label></td><td width="10"></td><td width="300px">
                <textarea name="dop_info" id="dop_info" cols="50" rows="3" onkeyup="javascript: simb_countCalc();" onmouseup="javascript: simb_countCalc();" ></textarea>
            </td></tr></table>
            <script type="text/javascript">
                function simb_countCalc(){
                    document.getElementById('simb_count').innerHTML=255-(($('#dop_info').val())).length;
                }
                simb_countCalc();
            </script>
        </div>
        <input type="hidden" name="faces_email" id="faces_email" value="<?php print $faces_email; ?>">
        <input type="hidden" name="user_id" id="user_id" value="<?php print $user_id; ?>">
        <input type="hidden" name="faces_id" id="faces_id" value="<?php print $faces_id; ?>">
        <input type="hidden" name="deliv_id" id="deliv_id" value="<?php print $_POST["deliv_id"]; ?>">
        <input type="hidden" name="deliv_strahovka" id="deliv_strahovka" <?php if ($_POST['deliv_strahovka']==1) print "checked"; ?> value="1" >
        <input type="hidden" name="deliv_office" id="deliv_office" value="<?php print $_POST['deliv_office']; ?>">
        <textarea class="hidden" name="deliv_adr"><?php print $_POST['deliv_adr']; ?></textarea>
        <input type="hidden" name="deliv_poluchatel" id="deliv_poluchatel" value="<?php print $_POST['deliv_poluchatel']; ?>">
    <p></p>
    <div align="right">
        <table width="100%">
        <tr>
        <td align="left">
    	    <input type="button" class=" button exclusive" alt="&laquo; Назад" value="&laquo; Назад" onclick="javascript: window.history.back(); " >
        </td>
        <td align="right">
    	    <input type="hidden" name="step" id="step" value="5">
    	    <input type="hidden" name="kod" id="kod" value="<?php print $kod_; ?>">
    	    <input type="submit" class=" button_red exclusive" alt="Далее / Готово »" value="Далее / Готово »" >
        </td>
        </tr>
        </table>
    </div>
    </form>
<?php
	//на этом этапе варианты оплаты
} else if ($step_==5) {
    //соберем переменные в кучу
    if (($_POST['user_id']-0)>0) $z_user_id=$_POST['user_id']-0; else $z_user_id='null';
    if (($_POST['faces_id']-0)>0) $z_faces_id=$_POST['faces_id']-0; else $z_faces_id='null';
    if (($_POST['deliv_id']-0)>0) $z_deliv_id=$_POST['deliv_id']-0; else $z_deliv_id='null';
    $z_deliv_strahovka=$_POST['deliv_strahovka']-0;
    if (($_POST['deliv_office']-0)>0) $z_deliv_office=$_POST['deliv_office']-0; else $z_deliv_office='null';
    $z_deliv_adr=$_POST['deliv_adr'].'';
    $z_deliv_poluchatel=$_POST['deliv_poluchatel'].'';
    $z_rem=$_POST['dop_info'].'';
//создаем заказ и показываем содержание в фиксированном фиде в состоянии "оформления/ожидающем оплаты"
   $sql="insert into gm_rashodh (user_id,faces_id,rashodh_status_kod,den_schet_id,
                                 deliv_id,deliv_strahovka,deliv_office,deliv_adr,deliv_poluchatel,rem_)
                          select $z_user_id,$z_faces_id,0,null,
                                 $z_deliv_id,$z_deliv_strahovka,$z_deliv_office,'$z_deliv_adr','$z_deliv_poluchatel','$z_rem'
                            from gm_rashod r where (r.rashodh_kod is null)and((r.kod_=$kod_)or((r.user_id=$user_id)and($user_id>0)) )and(r.checked_=1) limit 1;"; 
   mysql_query($sql);
   if (mysql_affected_rows()>0) {    
       $sql = "select AUTO_INCREMENT-1 rashodh_kod from information_schema.TABLES where (table_schema=DATABASE()) and (table_name='gm_rashodh')";
       $tb=mysql_query($sql);
       @$tb_n=mysql_numrows($tb);
       if ($tb_n>0){
           @$rashodh_kod=mysql_result($tb,0,"rashodh_kod")-0;
           $sql = "update gm_rashod r
                      set r.rashodh_kod=$rashodh_kod
                    where (r.rashodh_kod is null)and((r.kod_=$kod_)or((r.user_id=$user_id)and($user_id>0)) )and(r.checked_=1); ";
           mysql_query($sql);
           mysql_query('COMMIT');
       }      
   }
?>
    <h2>Благодарим за обращение к нам.</h2>
    <?php
    if ($rashodh_kod>0){
    ?>                                   
        <h2>Ваш <a href="rashod.php?rashodh=<?php print $rashodh_kod; ?>">заказ</a> создан и в скором времени будет обработан нашими менеджерами.</h2>  
    <?php
        $mail_rashod=file_get_contents("http://".$_SERVER["SERVER_NAME"]."/__rashod.php?rashodh=$rashodh_kod&mailto=1");
        mail("zakaz@tandem-auto.com.ua", "Заказ № $rashodh_kod", $mail_rashod,"Content-type: text/html; charset=windows-1251 \r\nFrom:zakaz@tandem-auto.com.ua");
        mail($_POST["faces_email"], "Заказ № $rashodh_kod", $mail_rashod,"Content-type: text/html; charset=windows-1251 \r\nFrom:zakaz@tandem-auto.com.ua");
    }
    ?>

<?php
//создаем заказ и показываем содержание в фиксированном фиде в состоянии "оформления/ожидающем оплаты"	
}
?>

</div>
