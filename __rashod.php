<?php     require_once("scripts/gm_access.php");
?>
		<!-- link href="images/global00.css" rel="stylesheet" type="text/css" media="all" -->
        
<?php
	$rashodh_kod=$_GET["rashodh"]-0;
    $mailto=$_GET['mailto']-0;
    if ($rashodh_kod>0){
        //заказ
        $sql_="select * from gm_rashodh rh where (rh.rashodh_kod=$rashodh_kod)and((rh.user_id=$user_id)or($user_group>1)or($mailto=1))";
        $tb=mysql_query($sql_);
        @$tb_n=mysql_numrows($tb);
        if ($tb_n>0){
            $rashodh_kod=mysql_result($tb,0,"rashodh_kod");
            $rashodh_nom=mysql_result($tb,0,"rashodh_nom");
            $rashodh_date=mysql_result($tb,0,"rashodh_date");  
            $rashodh_date_create=mysql_result($tb,0,"date_create");
            $rashodh_date_modified=mysql_result($tb,0,"date_modified");
            $rashodh_cours_usd=mysql_result($tb,0,"cours_usd");
            $rashodh_cours_eur=mysql_result($tb,0,"cours_eur");
            $rashodh_valyuta_kod=mysql_result($tb,0,"valyuta_kod");
            $rashodh_valyuta_cours=mysql_result($tb,0,"valyuta_cours");
            $rashodh_summa_bez_nds=mysql_result($tb,0,"summa_bez_nds");
            $rashodh_summa_nds=mysql_result($tb,0,"summa_nds");
            $rashodh_summa_s_nds=mysql_result($tb,0,"summa_s_nds");
            $rashodh_user_id=mysql_result($tb,0,"user_id");
            $rashodh_faces_id=mysql_result($tb,0,"faces_id");
            $rashodh_status_kod=mysql_result($tb,0,"rashodh_status_kod");
            $rashodh_deliv_id=mysql_result($tb,0,"deliv_id");
            $rashodh_deliv_strahovka=mysql_result($tb,0,"deliv_strahovka");
            $rashodh_ts=mysql_result($tb,0,"ts_");
            $rashodh_den_schet_id=mysql_result($tb,0,"den_schet_id");
            $rashodh_nds=mysql_result($tb,0,"nds_");
            $rashodh_deliv_poluchatel=mysql_result($tb,0,"deliv_poluchatel");
            $rashodh_deliv_adr=mysql_result($tb,0,"deliv_adr");
            $rashodh_deliv_office=mysql_result($tb,0,"deliv_office");
            $rashodh_rem=mysql_result($tb,0,"rem_");
        } else $rashodh_kod=0;
    }

	if ($rashodh_kod>0) {
?>
<div id="order-detail-content" class="table_block">
    <?php		
        //заказчик
        $sql_="select faces_id,name_full,email_ from gm_faces f where (f.faces_id=$rashodh_faces_id)";
        $tb=mysql_query($sql_);
        @$tb_n=mysql_numrows($tb);
        if ($tb_n>0){
            $faces_id=mysql_result($tb,0,"faces_id");
            $faces_name_full=mysql_result($tb,0,"name_full");
            $faces_email=mysql_result($tb,0,"email_");
        }
        //перевозчик
        if ($rashodh_deliv_id>0) {
            $sql_="select faces_id,name_full,email_ from gm_faces f where (f.faces_id=$rashodh_deliv_id)";
            $tb=mysql_query($sql_);
            @$tb_n=mysql_numrows($tb);
            if ($tb_n>0){
                $deliv_id=mysql_result($tb,0,"faces_id");
                $deliv_name_full=mysql_result($tb,0,"name_full");
                $deliv_email=mysql_result($tb,0,"email_");
            }
        }
        if ($rashodh_deliv_office>0) {
            $sql_="select * from gm_deliv_office do where (do.deliv_office_id=$rashodh_deliv_office)";
            $tb=mysql_query($sql_);
            @$tb_n=mysql_numrows($tb);
            if ($tb_n>0){
                $deliv_office_city=mysql_result($tb,0,"city_");
                $deliv_office_adr=mysql_result($tb,0,"adr_");
                $deliv_office_tel=mysql_result($tb,0,"tel_");
            }
        }
    ?>
        <table border="0" width="700px" cellspacing="10">
				<tr>
					<td colspan="2">
                    <p align="center"><label style="font-weight:bold">Заказ № <u><label> <?php print $rashodh_nom; ?> </label></u> от <u><label> <?php print date("d.m.Y",StrToTime($rashodh_date)); ?> </label></u></label></p>
                    </td>
                </tr>
				<tr>
					<td>
                        <p>Заказчик: <label style="font-weight:bold"><?php print $faces_name_full; ?></label></p>
                        <p >E-mail: <label style="font-weight:bold"><?php print $faces_email; ?></label></p>
                        <p>Доставка: <label style="font-weight:bold"><?php print $deliv_name_full; ?> <?php if ($rashodh_deliv_strahovka==1) { ?> <span style="color: red;">(застраховать)</span><?php } else { ?><span style="color: red;">(не страховать)</span><?php } ?></label></p>
                        <p>Получатель: <label style="font-weight:bold"><?php print $rashodh_deliv_poluchatel; ?></label></p>
                        <p>Адрес:</p>
                        <div style=" position:relative; left:100px; top:-10px;">
                            <table class=" noro_table" style=" border-style: solid; border-color: #EEEEEE;" width="250px"><tr><td>
                                <pre style=" color:#666666; "><?php print $rashodh_deliv_adr; ?></pre>
                                <pre style=" color:#666666; "><?php if ($deliv_office_tel) print $deliv_office_tel; if ($deliv_office_city) print '<br>(город/село) '.$deliv_office_city; if ($deliv_office_adr) print '<br>адрес: '.$deliv_office_adr; ?></pre>
                            </td></tr></table>
                        </div>
                    </td>
				</tr>
                <tr><td height="20"></td></tr>
        </table>
		<table id="cart_summary" class="std" border="1" style="border-style: inset; border-color: #EEEEEE;" cellspacing="1" width="700px">
			<thead>
				<tr>
					<th class="cart_product first_item">№</th>
					<th class="cart_product">Артикул</th>
					<th class="cart_description item">Наименование</th>
                    <th class="cart_description item">Сроки</th>
					<th class="cart_quantity item">Кол.</th>
					<th width="100px" class="cart_total item">Цена (руб)</th>
					<th width="100px" class="cart_total last_item">Сумма (руб)</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$sql_="select r.rashod_kod, r.tov_kod, r.tov_name,r.count_, r.ts_, tm.tov_make, ifnull(r.cena_ * r.valyuta_cours,0) cena_, ifnull(r.cena_ * r.valyuta_cours * r.count_,0) summa_, 
                          ph.srok_min, ph.srok_max
                     from gm_rashod r left join p_tov_make tm on tm.tov_make_kod=r.tov_make_kod
                          left join p_pricesh ph on ph.pricesh_kod=r.pricesh_kod 
                    where r.rashodh_kod=$rashodh_kod";
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
				$tov_name=substr(mysql_result($tb,$i,"tov_name"),0,12);
				$tov_kod=mysql_result($tb,$i,"tov_kod");
				$tov_make=mysql_result($tb,$i,"tov_make");
                $rashod_kod=mysql_result($tb,$i,"rashod_kod");
                $rashod_ts=mysql_result($tb,$i,"ts_");
                $rashod_srok_min=mysql_result($tb,$i,"srok_min");
                $rashod_srok_max=mysql_result($tb,$i,"srok_max");
			?>
				<tr id="product_<?php print $rashod_kod?>" class=" cart_item">
                    <td><?php print $i+1; ?></td>
                    <td class="cart_product"><a href="search.php?search_query=<?php print $tov_kod; ?>" title="<? print $tov_make; ?>"><?php print $tov_kod; ?></a></td>
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
                    <td class="price" id="total_product"><span class="price"><?php print number_format($rashodh_summa_s_nds,2,'.',''); ?></span></td>
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
                    <td class="price" id="total_price_without_tax"><span class="price"><?php print number_format($rashodh_summa_s_nds,2,'.',''); ?></span></td>
                </tr>
                <tr class="cart_total_price">
                    <td colspan="6">Итого (руб.):</td>
                    <td class="price" id="total_price"><span class="price"><?php print number_format($rashodh_summa_s_nds,2,'.',''); ?></span></td>
                </tr>
			</tfoot>
		</table>
	</div>
    <div align="right" style=" width: 700px;">
            <br>
            <table width="650px"><tr><td align="right" width="*"><label>Дополнительная информация по заказу</label></td><td width="10"></td><td width="300px">
                <table class=" noro_table" style=" border-style: solid; border-color: #EEEEEE;" width="300px"><tr><td><pre><label><?php print $rashodh_rem; ?></label></pre></td></tr></table>
            </td></tr></table>
        </div>
    <p></p>
    <div align="right">
        <table width="100%">
        <tr>
        <td align="left">
    	    <a href="rashodh.php" class="button" title="&laquo; Назад" >&laquo; Журнал заказов</a>
        </td>
        <td align="right" style="display: none;">
    	    <input type="hidden" name="kod" id="kod" value="<?php print $kod_; ?>">
    	    <input type="submit" class=" button_blue exclusive" alt="Оплатить »" value="Оплатить »" >
        </td>
        </tr>
        </table>
    </div>
<?php
	} else {
?>
     <p>Нет доступа или Вы не авторизованы!</p>
<?php
    }
?>
