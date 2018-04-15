            <?php
            include_once "scripts/gm_access.php";
            //здесь нужно обязательное присутствие kod_, ts_, rashod_kod
            if (!isset($_GET["kod"]) || !isset($_GET["ts"]) || !isset($_GET["rashod"])) exit;
            $par_kod=$_GET["kod"];
            $par_ts=$_GET["ts"];
            $par_rashod_kod=$_GET["rashod"];
            if ($par_kod<>$kod_) exit;
            if (isset($_GET["add"])) {
                $sql_="update gm_rashod r set r.count_=r.count_+1 where (r.rashod_kod=$par_rashod_kod)and(r.ts_=$par_ts)";
                mysql_query($sql_);
            }
            else if (isset($_GET["sub"])) {
                $sql_="update gm_rashod r set r.count_=r.count_-1 where (r.rashod_kod=$par_rashod_kod)and(r.ts_=$par_ts)and(r.count_>1)";
                mysql_query($sql_);
            }
            else if (isset($_GET["count"])) {
                $count_=$_GET["count"]-0;
                if ($count_>0) {
                    $sql_="update gm_rashod r set r.count_=$count_ where (r.rashod_kod=$par_rashod_kod)and(r.ts_=$par_ts)and($count_>0)";
                    mysql_query($sql_);
                }
            }
            else if (isset($_GET["del"])) {
                $sql_="delete from gm_rashod where (rashod_kod=$par_rashod_kod)and(ts_=$par_ts)";
                mysql_query($sql_);
            }
            else if (isset($_GET["check"])) {
                $sql_="update gm_rashod set checked_=1 where (rashod_kod=$par_rashod_kod)and(ts_=$par_ts)";
                mysql_query($sql_);
            }
            else if (isset($_GET["uncheck"])) {
                $sql_="update gm_rashod set checked_=0 where (rashod_kod=$par_rashod_kod)and(ts_=$par_ts)";
                mysql_query($sql_);
            }
            $sql_="select tm.tov_make, ifnull(r.cena_ * r.valyuta_cours,0) cena_, ifnull(r.cena_ * r.valyuta_cours * r.count_,0) summa_,
                          ph.srok_min, ph.srok_max, r.*
                     from gm_rashod r left join p_tov_make tm on tm.tov_make_kod=r.tov_make_kod
                          left join p_pricesh ph on ph.pricesh_kod=r.pricesh_kod
                    where (r.rashod_kod=$par_rashod_kod)and(r.ts_=$par_ts)";
            $tb=mysql_query($sql_);
            @$tb_n=mysql_numrows($tb);
            if ($tb_n>0){
                $count_=number_format(mysql_result($tb,0,"count_"),0,".","");
                $cena_=number_format(mysql_result($tb,0,"cena_"),2,".","");
                $summa_=number_format(mysql_result($tb,0,"summa_"),2,".","");
                $vsego_=$vsego_ + $summa_;
                $pozicii_+=1;
                $tov_name=substr(mysql_result($tb,0,"tov_name"),0,12);
                $tov_kod=mysql_result($tb,0,"tov_kod");
                $tov_make=mysql_result($tb,0,"tov_make");
                $rashod_kod=mysql_result($tb,0,"rashod_kod");
                $rashod_reklama_kod=mysql_result($tb,0,"reklama_kod")-0;
				$rashod_checked=mysql_result($tb,0,"checked_")-0;
                $rashod_srok_min=mysql_result($tb,0,"srok_min");
                $rashod_srok_max=mysql_result($tb,0,"srok_max");
                $total_summa=$total_summa+$summa_;
            ?>
                    <td><input type="checkbox" value="1" <?php if ($rashod_checked==1) print "checked"; ?> name="product_check" id="product_check" onclick="cart(<?php print $par_rashod_kod; ?>,<?php print $par_ts; ?>,'<?php if ($rashod_checked==1) print "uncheck"; else print "check" ?>'); "></td>
                    <td class="cart_product"><a href="search.php?search_query=<?php print $tov_kod; ?>"><?php print $tov_kod; ?></a></td>
                    <td class="cart_description"><h5><a class="product_link"><?php print $tov_name; ?></a></h5></td>
                    <!--td class="cart_ref">—</td-->
                    <td class="cart_availability"><?php print "$rashod_srok_min - $rashod_srok_max"; ?></td>
                    <td class="cart_quantity">
                        <div id="cart_quantity_button">
                            <a class="cart_quantity_up" title="Увеличить" onclick="cart(<?php print $par_rashod_kod; ?>,<?php print $par_ts; ?>,'add'); "><img src="images/quantity_up.png" alt="Увеличить"></a>
                            <input class="cart_quantity_input text" size="2" value="<?php print $count_; ?>" id="quantity_<?php print $rashod_kod; ?>" type="text" onchange="cart(<?php print $par_rashod_kod; ?>,<?php print $par_ts; ?>,'count='+$('#quantity_<?php print $rashod_kod; ?>').val()); ">
                            <a class="cart_quantity_down" title="Уменьшить" onclick="cart(<?php print $par_rashod_kod; ?>,<?php print $par_ts; ?>,'sub'); "><img src="images/quantity_down.png" alt="Уменьшить"></a>
                        </div>
                        <a class="cart_quantity_delete" title="Удалить" onclick="if (confirm('Удалить из корзины?')==true) cart(<?php print $par_rashod_kod; ?>,<?php print $par_ts; ?>,'del'); else return 0; "><img src="images/delete-cart.gif" alt="Удалить" class="icon"></a>
                    </td>
                    <td class="cart_unit"><span class="price" id="product_price_13_0"><?php print $cena_; ?></span></td>
                    <td class="cart_total" align="right"><span class="price" id="total_product_price_13_0"><?php print $summa_; ?></span></td>
            <?php 
            } 
            ?>
            <?php 
                if (isset($_GET['add'])||isset($_GET['sub'])||isset($_GET['del'])||isset($_GET['count'])||isset($_GET['check'])||isset($_GET['uncheck'])) {
            ?>
                    <script type="text/javascript">
                        cart_total_refresh();
                    </script>
            <?php
                }
            ?>