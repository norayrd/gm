		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<?php
require_once "scripts/gm_access.php";
// pricesh_kod обязательно должна присутствовать на этой странице (>0)
$pricesh_kod=$_GET["pricesh"]*1;
if ($user_group<3) {
	//print "Доступ запрещен!";
	include "_autentication.php";
} else if ($pricesh_kod<=0) {
	print "Неверный прайс!";
} else {
?>
	<!-- Breadcrumb -->
	<div class="breadcrumb bordercolor"><div class="breadcrumb_inner">
		<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span>Прайс
	</div></div>
	<!-- /Breadcrumb -->
	<div id="noro_inner">
		<?php
		if ($pricesh_kod>0) {
			$sql="select * from p_pricesh ph where pricesh_kod=$pricesh_kod";
			$tb=mysql_query($sql) or die(mysql_error());
			@$tb_n=mysql_numrows($tb);
			if ($tb_n>0) {
				$pricesh_name=mysql_result($tb,0,"name_");
				$pricesh_update_date=mysql_result($tb,0,"update_date");
                $pricesh_srok_min=mysql_result($tb,0,"srok_min");
                $pricesh_srok_max=mysql_result($tb,0,"srok_max");
				$pricesh_valyuta_kod=mysql_result($tb,0,"valyuta_kod");
				$pricesh_nacenka=mysql_result($tb,0,"nacenka_");
				$pricesh_hide=mysql_result($tb,0,"hide_");
				$pricesh_moy_sklad=mysql_result($tb,0,"moy_sklad");		
                $pricesh_destination=mysql_result($tb,0,"destination_");        
                $pricesh_temp=mysql_result($tb,0,"temp_")-0;        

                $pricesh_tel=mysql_result($tb,0,"tel_");        
                $pricesh_email=mysql_result($tb,0,"email_");        
                $pricesh_view_status=mysql_result($tb,0,"view_status");        
                $pricesh_skype=mysql_result($tb,0,"skype_");        
                $pricesh_icq=mysql_result($tb,0,"icq_");

                $pricesh_search_url=mysql_result($tb,0,"search_url");
                $pricesh_search_url_login=mysql_result($tb,0,"search_url_login");
                $pricesh_search_url_pass=mysql_result($tb,0,"search_url_pass");
                $pricesh_manager=mysql_result($tb,0,"manager_");

                $pricesh_city_id1=mysql_result($tb,0,"city_id1");
                $pricesh_city_id2=mysql_result($tb,0,"city_id2");
                $pricesh_city_id3=mysql_result($tb,0,"city_id3");
                $pricesh_city_id4=mysql_result($tb,0,"city_id4");
                $pricesh_city_id5=mysql_result($tb,0,"city_id5");
			}
		}
		?>
		<h1>Прайс: <?php print $pricesh_name ?><span class="category-product-count">Дата обновления: <?php print $pricesh_update_date ?></span></h1>
		<form method="post" action="price_save.php?pricesh=<?php if ($pricesh_destination>0) print $pricesh_destination; else print $pricesh_kod; ?>" >
			<p class="cat_desc bordercolor bgcolor">
				Название: <input name="price_name" type="text" value="<?php print $pricesh_name ?>" style=" width:200px; position:absolute; left:120px;" /> <br><br>
				Сроки доставки (в днях): от <input name="price_srok_min" type="text" value="<?php print $pricesh_srok_min ?>" style=" width:20px;  " /> до <input name="price_srok_max" type="text" value="<?php print $pricesh_srok_max ?>" style=" width:20px; " /> <br><br>
				Валюта: <select name="price_valyuta_kod" style=" position:absolute; left:120px;">
						<?php 
						$tb=mysql_query("select vc.valyuta_kod, vl.pref_ from gm_valyuta_cours vc left join gm_valyuta_list vl on vc.valyuta_kod=vl.ISO_");
						@$tb_n=mysql_numrows($tb);
						$i=0;
						while ($i<=$tb_n) {
							$valyuta_kod=mysql_result($tb,$i,"valyuta_kod");
							$valyuta_pref=mysql_result($tb,$i,"pref_");
						?>
							<option value="<?php print $valyuta_kod; ?>" <?php if ($valyuta_kod==$pricesh_valyuta_kod) print "selected"; ?>><?php print $valyuta_pref; ?></option>
						<?php		
							$i+=1;
						}
						?>
						</select>
						<br><br>
				Наценка: <input name="price_nacenka" type="text" value="<?php print $pricesh_nacenka ?>" style=" width:50px; position:absolute; left:120px;" /><br><br>
				Мой склад: <input name="price_moy_sklad" type="checkbox" value="1" <?php if ($pricesh_moy_sklad==1) print "checked"; ?> style=" position:absolute; left:120px;" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Скрыть: <input name="price_hide" type="checkbox" value="1" <?php if ($pricesh_hide==1) print "checked"; ?> style=" position:absolute; left:230px;" /><br><br>
                Регион: <select name="city_id1" id="city_id1" >
                            <option <?php if ($pricesh_city_id1=="") print "selected"; ?> value="">-</option>
                            <option <?php if ($pricesh_city_id1==-1) print "selected"; ?> value="-1">* Иной город (1-2 дня)</option>
                            <option <?php if ($pricesh_city_id1==-2) print "selected"; ?> value="-2">* Иная страна (10-14 дней)</option>
                            <?php
                                $sql="select c.city_id, c.name_ru c_name_ru, r.region_id, r.name_ru r_name_ru from gm_city c left join gm_region r on r.region_id=c.region_id where r.country_id=2 order by r.name_ru, c.name_ru;";
                                $tb=mysql_query($sql) or die(mysql_error());
                                @$tb_n=mysql_numrows($tb);
                                $i=0;
                                $tb_region_id_old='';
                                while($i<$tb_n){
                                    $tb_city_id=mysql_result($tb,$i,"city_id");    
                                    $tb_city_name=mysql_result($tb,$i,"c_name_ru");    
                                    $tb_region_id=mysql_result($tb,$i,"region_id");    
                                    $tb_region_name=mysql_result($tb,$i,"r_name_ru");    
                                    if ($tb_region_id_old==$tb_region_id) {
                            ?>
                            <option value="<?php print $tb_city_id; ?>" <?php if ($pricesh_city_id1==$tb_city_id) print "selected"; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php print $tb_city_name; ?></option>
                            <?php   } else { ?>
                            <optgroup label="<?php print $tb_region_name; ?>"></optgroup>
                            <?php
                                    }
                                    $tb_region_id_old=$tb_region_id;
                                    $i++;
                                }
                            ?>
                        </select>
                <p class="cat_desc bordercolor bgcolor">
                    Телефоны: <input name="price_tel" type="text" value="<?php print $pricesh_tel; ?>" style=" width:200px; position:absolute; left:120px;" /> <br><br>
                    E-mail: <input name="price_email" type="text" value="<?php print $pricesh_email ?>" style=" width:200px; position:absolute; left:120px;" /> <br><br>
                    Skype: <input name="price_skype" type="text" value="<?php print $pricesh_skype ?>" style=" width:200px; position:absolute; left:120px;" /> <br><br>
                    ICQ: <input name="price_icq" type="text" value="<?php print $pricesh_icq ?>" style=" width:200px; position:absolute; left:120px;" /> <br><br>
                    Видимость: <select name="price_view_status" style=" position:absolute; left:120px;">
                            <option value="-1" <?php if ($pricesh_view_status==-1) print "selected"; ?> >Закрыт для всех</option>
                            <option value="0" <?php if ($pricesh_view_status==0) print "selected"; ?> >По региональныя</option>
                            <option value="1" <?php if ($pricesh_view_status==1) print "selected"; ?>>Открыт для всех</option>
                        </select>
                        <br><br>
                    Количество складов: <select name="price_city_count" style=" position:absolute; left:200px;">
                        <?php 
                        $i=1;
                        while ($i<=10) {
                        ?>
                            <option value="<?php print $i; ?>" <?php if ($i==$pricesh_city_count) print "selected"; ?>><?php print $i; ?></option>
                        <?php        
                            $i+=1;
                        }
                        ?>
                        </select>
                        <br><br>
                    Сайт: <input name="price_search_url" type="text" value="<?php print $pricesh_search_url ?>" style=" width:200px; position:absolute; left:120px;" /> <br><br>
                    Логин: <input name="price_search_url_login" type="text" value="<?php print $pricesh_search_url_login ?>" style=" width:100px; position:absolute; left:120px;" /> <br><br>
                    Пароль: <input name="price_search_url_pass" type="text" value="<?php print $pricesh_search_url_pass ?>" style=" width:100px; position:absolute; left:120px;" /> <br><br>
                    Менеджер: <input name="price_manager" type="text" value="<?php print $pricesh_manager ?>" style=" width:200px; position:absolute; left:120px;" /> <br><br>
                </p>
			</p>
			<br>
			<input type="submit" value="Сохранить" name="price_save" class="<?php if ($pricesh_destination>0) print "button_red"; else print "button"; ?>" />
			<input type="hidden" name="price_source" value="<?php print $pricesh_kod; ?>">
			<input type="button" value="Назад к прайсам" class="button" onclick="javascript: document.location='prices.php';" />
            <input type="hidden" name="price_temp" value="<?php print $pricesh_temp; ?>">
		</form>
    
		<!-- Sort products -->
        <?php
        if ($pricesh_temp==1) {
        ?>
        <div align="right" style="width: 99%;">
            <input type="button" id="button_prod" class="button_blue" onclick="$('#make').hide(100); $('#prod').show(100); $('#button_prod').addClass('button_blue'); $('#button_prod').removeClass('button_gray'); $('#button_make').removeClass('button_blue'); $('#button_make').addClass('button_gray');" value="Товар" style=" border-radius-top: 10px;" >
            <input type="button" id="button_make" class="button_gray" onclick="$('#make').show(100); $('#prod').hide(100); $('#button_prod').removeClass('button_blue'); $('#button_prod').addClass('button_gray'); $('#button_make').addClass('button_blue'); $('#button_make').removeClass('button_gray');" value="Новые бренды" ></div>
        <div class="product_sort" id="make" style="display:none; border-color:black; border-width:thin; border:solid; border-color:#5555ff; border-radius:10px;">
        


<table id="search_res" width="100%" class="noro_table">
<thead>
    <tr>
        <th width="30px">№</th>
        <th width="200px">Бренд</th>
        <th width="10px">Кол-во позиций</th>
        <th width="10px"></th>
        <th width="10px"></th>
        <th width="10px"></th>
    </tr>
</thead>
<tbody>
    
<script type="text/javascript">
    function ch_make3(r,com){
        if ( (com==4) && confirm('Добавить бренд "'+$('#tm'+r).html()+'"?') )  $('#r'+r).load('_price_row.php?kod_=<?php print $kod_; ?>&r='+r+'&com='+com);
        if (com==3) {
            txt='Укажите замену для "'+$('#tm'+r).html()+'"';
            tmp_tov_make=prompt(txt,'');
            if (tmp_tov_make!=null) {
                new_tov_make= parseInt(tmp_tov_make);
                if (isNaN(new_tov_make)) alert('Вы не указали числовое значение!'); 
                else $('#r'+r).load('_price_row.php?kod_=<?php print $kod_; ?>&r='+r+'&n='+new_tov_make+'&com='+com);
            }
        }
    }
</script>
    <?php
    //запоминаем номер
$sql= " select min(p.prices_kod) prices_kod, p.tov_make, count(*) cnt  ".
      "   from tmp_prices p left join p_tov_make tm on p.tov_make=tm.tov_make ".
      "        left join p_tov_make_variant v on v.tov_make=p.tov_make ".
      "  where tm.tov_make_kod is null ".
      "    and v.tov_make_kod is null ".
      "    and p.pricesh_kod=$pricesh_kod ".
      "  group by 2 ".
      "  order by 2 ";
$tb=mysql_query($sql) or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$i=0;
while($i<$tb_n){
    $tb_prices_kod=mysql_result($tb,$i,"prices_kod");
    $tb_tov_make=mysql_result($tb,$i,"tov_make");
    $tb_cnt=mysql_result($tb,$i,"cnt");
?>
      <tr class="<?php if (($i % 2)==0) print "even"; else print "odd"; ?>" id="r<?php print $tb_prices_kod; ?>">
        <td><?php print $i+1; ?></td>
        <td id="tm<?php print $tb_prices_kod; ?>"> <?php print $tb_tov_make; ?></td>
        <td id="c<?php print $tb_prices_kod; ?>"> <?php print $tb_cnt; ?></td>
        <td></td>
        <td align="center"><input type="button" id="b<?php print $tb_prices_kod; ?>" value="+" onclick="ch_make3(<?php print $tb_prices_kod; ?>,4);" style="cursor:pointer;" title="Добавить бренд" class="button_red"></td>
      </tr>
<?php
    $i++;
}
?>            
<script type="text/javascript"> $('#button_make').val($('#button_make').val()+' (<?php print $i; ?>)');   </script>
</tbody>
</table>

        <?php
        }
        ?>








        
        </div>
		<div class="product_sort" id="prod" <?php if ($pricesh_temp==1) print 'style="border-color:black; border-width:thin; border:solid; border-color:#5555ff; border-radius:10px;"'; ?> >
			<input type="hidden" name="price_source" value="<?php print $pricesh_kod; ?>" />
			<table width="100%" bordercolor="#2a2f33">
			<tr>
				<td width="100%" align="center">
					<div id="tb_head"></div>
				</td>
			</tr>
			<tr>
				<td height="5px"></td>
			</tr>
			<tr>
				<td>

					<table id="search_res" width="100%" class="noro_table" >
					<thead>
					<tr>
						<th width="35px">№</th>
						<th>Бренд</th>
						<th>Код</th>
						<th>Наименование</th>
                        <th>Цена</th>
                        <th>Кол-во</th>
						<th></th>
						<th></th>                        
					</tr>
					</thead>
					<tbody>
					<?php
					//запоминаем номер
					if ($pricesh_kod>0) {
						$limit_start=$_GET["start"];
						$limit_length=$_GET["length"];
						if (isset($limit_start)) {
							if (!($limit_start>=0)) $limit_start=0;
						}else $limit_start=0; 
						if (isset($limit_length)) {
							if ($limit_length>100) $limit_length=100;
							if ($limit_length<0) $limit_length=0;
						}else $limit_length=100;
						//выводим содержание прайса/склада
                        //if ($pricesh_temp==1) $sql="select * from tmp_prices p left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod where p.pricesh_kod=$pricesh_kod order by p.tov_make limit $limit_start, $limit_length";
                        //                 else $sql="select * from p_prices p left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod where p.pricesh_kod=$pricesh_kod order by p.tov_make limit $limit_start, $limit_length";
                        if ($pricesh_temp==1) $sql="select * from tmp_prices p where p.pricesh_kod=$pricesh_kod order by p.tov_make limit $limit_start, $limit_length";
                                         else $sql="select * from p_prices p left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod where p.pricesh_kod=$pricesh_kod order by tm.tov_make limit $limit_start, $limit_length";
						$tb=mysql_query($sql) or die(mysql_error());
						@$tb_n=mysql_numrows($tb);
						$i=0;
						while($i<$tb_n){
							$tb_tov_make=mysql_result($tb,$i,"tov_make");
						    $tb_tov_kod=mysql_result($tb,$i,"tov_kod");
							$tb_tov_name=mysql_result($tb,$i,"tov_name");
							$tb_cena=mysql_result($tb,$i,"cena_");
                            $tb_prices_kod=mysql_result($tb,$i,"prices_kod");
                            $tb_count=mysql_result($tb,$i,"count_");
					?>
						<tr class="<?php if (($i % 2)==0) print "even"; else "odd"; ?>">
							<td style="font-size:9px" align="center"><?php print $i +1 + $limit_start; ?></td>
							<td><?php print $tb_tov_make; ?></td>
							<td><?php print $tb_tov_kod; ?></td>
							<td  style="font-size:11px"><?php print $tb_tov_name; ?></td>
                            <td align="right"><?php print number_format($tb_cena,2,'.',''); ?></td>
                            <td align="center"><?php print $tb_count; ?></td>
							<td><img src="images/order.png" width=16; height=16; style="cursor:pointer; " onclick="$('#result_<?php print $tb_prices_kod; ?>').load('scripts/reklama_all_script.php?prices_kod=<?php print $tb_prices_kod; ?>&add=1&kod=<?php print $kod_; ?>');" title="Добавить в рекламу" /></td>
                            <td><div id="result_<?php print $tb_prices_kod; ?>"></div>
                            </td>
						</tr>
					<?php
							$i++;
						}
					}
					?>
					</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td height="5px"></td>
			</tr>
			<tr>
				<td align="center">
					<div id="tb_foot">
						<a href="<?php print "price.php?pricesh=$pricesh_kod&start=0&length=$limit_length"; ?>" class="button_mini" title="К началу"><<</a>
						<?php
                        if ($pricesh_temp==1) $sql="select count(*) count_ from tmp_prices p where p.pricesh_kod=$pricesh_kod";
                                         else $sql="select count(*) count_ from p_prices p where p.pricesh_kod=$pricesh_kod";
						$tb=mysql_query($sql) or die(mysql_error());
						@$tb_n=mysql_numrows($tb);
						if ($tb_n>0) $tb_n=mysql_result($tb,0,"count_");
						$i=0;
						while(($i*$limit_length)<$tb_n){
                            if (($i<2)||($i>($tb_n/$limit_length-2))||
                                (($i>=($limit_start/$limit_length-2))&&($i<=($limit_start/$limit_length+2)))) {
						?>
							<a href="<?php print "price.php?pricesh=$pricesh_kod&start=".($i*$limit_length)."&length=$limit_length"; ?>" class="<?php if ( (($limit_start/100)>=$i)&&(($limit_start/100)<($i+1))) print "button_red"; else print "button_mini"; ?>"><?php print $i+1; ?></a>
						<?php
                            } else if (($i==2)||($i==round($tb_n/$limit_length-3))) print "...";
							$i+=1;
						}
						?>
						<a href="<?php print "price.php?pricesh=$pricesh_kod&start=".(($i-1)*$limit_length)."&length=$limit_length"; ?>" class="button_mini" title="В конец">>></a>
					</div>
                    <script type="text/javascript">
                        document.getElementById('tb_head').innerHTML =document.getElementById('tb_foot').innerHTML;
                    </script>
                    
				</td>
			</tr>
			</table>
		</div>
	</div>
<?php
}
?>