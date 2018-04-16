            <?php
            include_once "scripts/gm_access.php";
            //здесь нужно обязательное присутствие kod_, ts_, rashod_kod
            if (!isset($_GET["kod"])) exit;
            $par_kod=$_GET["kod"];
            if ($par_kod<>$kod_) exit;

            $sql_="select sum(ifnull(r.cena_ * r.valyuta_cours * r.count_,0)) vsego_ 
                     from gm_rashod r left join p_tov_make tm on tm.tov_make_kod=r.tov_make_kod 
                    where (r.rashodh_kod is null)and(r.checked_=1)and((r.kod_='$par_kod')or((r.user_id=$user_id)and($user_id>0)) );";
            $tb=mysql_query($sql_);
            @$tb_n=mysql_numrows($tb);
            if ($tb_n>0){
                $vsego_=number_format(mysql_result($tb,$i,"vsego_"),2,".","");
                $total_summa=number_format(mysql_result($tb,$i,"vsego_"),2,".","");
            ?>
                <tr class="cart_total_price">
                    <td colspan="6">Всего деталей:</td>
                    <td class="price" id="total_product"><span class="price"><?php print "$total_summa"; ?></span></td>
                </tr>
                <tr class="cart_total_voucher" style="display: none;">
                    <td colspan="6">Скидка:</td>
                    <td class="price-discount" id="total_discount"><span class="price">0.00</span></td>
                </tr>
                <tr class="cart_total_voucher" style="display: none;">
                    <td colspan="6">Упаковка:</td>
                    <td class="price-discount" id="total_wrapping"><span class="price">0.00</span></td>
                </tr>
                <tr class="cart_total_delivery">
                    <td colspan="6">Доставка:</td>
                    <td class="price" id="total_shipping"><span class="price">0.00</span></td>
                </tr>
                <tr class="cart_total_price" style="display:none">
                    <td colspan="6">Всего:</td>
                    <td class="price" id="total_price_without_tax"><span class="price"><?php print "$total_summa"; ?></span></td>
                </tr>
                <tr class="cart_total_tax" style="display: none;">
                    <td colspan="6">Комиссия от продаж:</td>
                    <td class="price" id="total_tax"><span class="price">0.00</span></td>
                </tr>
                <tr class="cart_total_price">
                    <td colspan="6">Итого (руб.):</td>
                    <td class="price" id="total_price"><span class="price"><?php print "$total_summa"; ?></span></td>
                </tr>
            <? 
                } 
            ?>