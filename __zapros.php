<?php     require_once("scripts/gm_access.php");
?>
		<!-- link href="images/global00.css" rel="stylesheet" type="text/css" media="all" -->
        
<?php
	$zaprosh_id=$_GET["zaprosh"]-0;
    $mailto=$_GET['mailto']-0;
    if ($zaprosh_id>0){
        //заказ
        $sql_="select zh.*, u.name_full, k.name_ kuzov_name, t.name_ toplivo_name, p.name_ kpp_name
                 from gm_zaprosh zh left join gm_users u on zh.user_id=u.user_id
                      left join gm_value k on k.value_id=zh.kuzov_
                      left join gm_value t on t.value_id=zh.toplivo_
                      left join gm_value p on p.value_id=zh.kpp_
                where (zh.zaprosh_id=$zaprosh_id)and((zh.user_id=$user_id)or($user_group>1)or($mailto=1))";
        
        $tb=mysql_query($sql_);
        @$tb_n=mysql_numrows($tb);
        if ($tb_n>0){
            $zaprosh_id=mysql_result($tb,0,"zaprosh_id");
            $zaprosh_nom=mysql_result($tb,0,"zaprosh_id");
            $zaprosh_date=mysql_result($tb,0,"create_date");  
            $zaprosh_user_id=mysql_result($tb,0,"user_id");
            $zaprosh_status=mysql_result($tb,0,"status_");
            $zaprosh_ts=mysql_result($tb,0,"ts_");
            
            $zaprosh_vin=mysql_result($tb,$i_,"vin_")."";
            $zaprosh_marka=mysql_result($tb,$i_,"marka_")."";
            $zaprosh_model=mysql_result($tb,$i_,"model_")."";
            $zaprosh_kuzov_name=mysql_result($tb,$i_,"kuzov_name")."";
            $zaprosh_toplivo_name=mysql_result($tb,$i_,"toplivo_name")."";
            $zaprosh_kpp_name=mysql_result($tb,$i_,"kpp_name")."";
            $zaprosh_dvig=mysql_result($tb,$i_,"dvig_")."";
        } else $zaprosh_id=0;
    }

	if ($zaprosh_id>0) {
?>
<div id="order-detail-content" class="table_block">
    <?php		
        //заказчик
        $sql_="select faces_id,name_full,email_ from gm_faces f where (f.user_id=$zaprosh_user_id) limit 1";
        $tb=mysql_query($sql_);
        @$tb_n=mysql_numrows($tb);
        if ($tb_n>0){
            $faces_id=mysql_result($tb,0,"faces_id");
            $faces_name_full=mysql_result($tb,0,"name_full");
            $faces_email=mysql_result($tb,0,"email_");
        }
    ?>
        <table border="0" width="700px" cellspacing="10">
				<tr>
					<td colspan="2">
                    <p align="center"><label style="font-weight:bold">Запрос № <u><label> <?php print $zaprosh_nom; ?> </label></u> от <u><label> <?php print date("d.m.Y",StrToTime($zaprosh_date)); ?> </label></u></label></p>
                    </td>
                </tr>
				<tr>
					<td>
                        <p>Заказчик: <label style="font-weight:bold"><?php print $faces_name_full; ?></label></p>
                        <p >E-mail: <label style="font-weight:bold"><?php print $faces_email; ?></label></p>
                        <p>Транспорт:</p>
                        <div style=" position:relative; left:100px; top:-10px;">
                            <table class=" noro_table" style=" border-style: solid; border-color: #EEEEEE;" width="250px"><tr><td>
                                        <span style=" color:#666666; "><?php print "VIN: $zaprosh_vin<br>Марка: $zaprosh_marka<br>Модель: $zaprosh_model<br>Двигатель: $zaprosh_dvig<br>Кузов: $zaprosh_kuzov_name<br>Топливо: $zaprosh_toplivo_name<br>КПП: $zaprosh_kpp_name"; ?></span>
                            </td></tr></table>
                        </div>
                    </td>
				</tr>
                <tr><td height="20"></td></tr>
        </table>
		<table id="cart_summary" class="std" border="1" style="border-style: inset; border-color: #EEEEEE;" cellspacing="1" width="700px">
			<thead>
				<tr>
					<th class="cart_product first_item" width="10px">№</th>
                    <th class="cart_description item">Описание</th>
                    <th class="cart_description item" width="70">Состояние</th>                    
                    <th class="cart_product" width="100px">Артикул</th>
                    <th class="cart_description item" width="100px">Бренд</th>
                    <th class="cart_description item hidden" width="74px"></th>                    
				</tr>
			</thead>
			<tbody>
			<?php
			$sql_="select z.zapros_id, z.tov_kod, z.detal_, z.ts_, tm.tov_make, zs.name_ status_, zs.color_, zs.bg_color
                     from gm_zapros z left join p_tov_make tm on tm.tov_make_kod=z.tov_make
                          left join gm_zapros_status zs on zs.zapros_status_kod=z.status_
                    where z.zaprosh_id=$zaprosh_id";
			$tb=mysql_query($sql_);
			@$tb_n=mysql_numrows($tb);
			$i=0;
			$pozicii_=0;
			$vsego_=0;
			$total_summa=0;
			while ($i<$tb_n){
				$tov_detal=substr(mysql_result($tb,$i,"z.detal_"),0,12);
				$tov_kod=mysql_result($tb,$i,"tov_kod");
				$tov_make=mysql_result($tb,$i,"tov_make");
                $zapros_id=mysql_result($tb,$i,"zapros_id");
                $zapros_ts=mysql_result($tb,$i,"ts_");
                $zapros_status=mysql_result($tb,$i,"status_");
                $zapros_color=mysql_result($tb,$i,"color_");
                $zapros_bgcolor=mysql_result($tb,$i,"bg_color");
			?>
				<tr id="product_<?php print $zapros_id ?>" class=" cart_item">
                    <td><p style="color: black; font-size: 12px; "><?php print $i+1; ?></p></td>
                    <td class="cart_description"><p style="color: black; font-size: 12px; "><?php print $tov_detal; ?></p></td>
                    <td class="cart_description"><p style="font-size: 12px; color: <?php print "#$zapros_color"; ?>; background-color: <?php print "#$zapros_bgcolor"; ?>;"><?php print $zapros_status; ?></p></td>
                    <td class="cart_product"><a href="search.php?search_query=<?php print $tov_kod; ?>" style="color: black; font-size: 12px; "><?php print $tov_kod; ?></a></td>
                    <td class="cart_product"><p style="color: black; font-size: 12px; "><?php print $tov_make; ?></p></td>
                    <td class="cart_total hidden" align="right">
                        <input type="button" class="button" value="...">
                        <input type="button" class="button_red" value="...">
                    </td>
                </tr>    
			<?php
				$i+=1; 
			} 
			?>
			</tbody>
		</table>
	</div>
    <p></p>
    <div align="right">
        <table width="100%">
        <tr>
        <td align="left">
    	    <a href="zaprosh.php" class="button" title="&laquo; Назад" >&laquo; Журнал запросов</a>
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
