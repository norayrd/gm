		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
require_once "scripts/gm_access.php";
$pricesh_kod=$_GET["pricesh"];
// проверка безопасности
if ($user_group<3) {
	//print "Доступ запрещен!";
	include "_autentication.php";
} else {
?>
	<div id="noro_inner">
		<div id="authentication">
			<div id="center_column" class="center_column">
				<!-- Breadcrumb -->
				<div class="breadcrumb bordercolor"><div class="breadcrumb_inner">
					<a href="index.php" title="На главную">Главная</a>
					<span class="navigation-pipe">&gt;</span>
					<span class="navigation_page">Управление прайсами</span>
				</div></div>
				<!-- /Breadcrumb -->
				<h1>Управление прайсами</h1>
				<h4>Добавление, изменение и удаление прайсов.</h4>
                <br>
                <div>
                    <a onclick="javascript: showPriceAddDialog(0,'','',0,0,980,'1.5',0,1);" title="Добавить новый прайс" class="button_large">Добавить новый прайс</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="download/price_blank.xls" class="button_disabled">бланк прайса</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="download/price_blank_shini.xls" class="button_disabled">бланк прайса по шинам</a>
                </div><br>
                <script type="text/javascript">
                    function showPriceAddDialog(pricesh_kod,pricesh_name,pricesh_update_date,pricesh_srok_min,pricesh_srok_max,pricesh_valyuta_kod,pricesh_nacenka,pricesh_hide,pricesh_moy_sklad){
                        //$('#price_dialog').width($('#price_dialog').parent().width());
                        //$('#price_dialog').height($('#price_dialog').parent().height());
                        //$('#price_dialog').position().left=0;
                        //$('#price_dialog').position().top=0;
                        
                        $('#price_destination').val(pricesh_kod);
                        $('#price_name').val(pricesh_name);
                        $('#price_srok_min').val(pricesh_srok_min);
                        $('#price_srok_max').val(pricesh_srok_max);
                        $('#price_valyuta_kod').val(pricesh_valyuta_kod);
                        $('#price_nacenka').val(String(Number(pricesh_nacenka)));
                        document.getElementById('price_hide').checked=(pricesh_hide==1);
                        document.getElementById('price_moy_sklad').checked=(pricesh_moy_sklad==1);
                        $('#price_update_date').val(pricesh_update_date);
                
                        $('#price_dialog_inner').position().left=($('#price_dialog').width() - $('#price_dialog_inner').width());
                        $('#price_dialog_inner').position().top=($('#price_dialog').height() - $('#price_dialog_inner').height());
                        $('#price_dialog').show(100);                        
                        window.scrollTo($('#price_dialog_inner').position().left,$('#price_dialog_inner').position().top);
                    }
                </script>

                <table class="noro_table" width="100%">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Наименование</th>
                        <th width="90px">Город</th>
                        <th width="30px">Тип</th>
                        <th width="30px">Скрыт</th>
                        <th width="60px">Сроки</th>
                        <th width="60px">Наценка</th>
                        <th width="50px">Валюта</th>
                        <th width="80px">Обновлен</th>
                        <th width="130px"></th>
                    </tr>
                </thead>
                <?php
                $sql_="select ph.pricesh_kod,ph.name_,ph.update_date,ph.srok_min,ph.srok_max,ph.valyuta_kod,ph.nacenka_,ph.hide_, ph.moy_sklad,vl.pref_, c1.name_ru c1_name_ru, ph.city_id1 c1_city_id from p_pricesh ph left join gm_valyuta_list vl on vl.ISO_=ph.valyuta_kod left join gm_city c1 on ph.city_id1=c1.city_id where ph.temp_<>1 order by ph.name_";
                $tb=mysql_query($sql_);
                @$tb_n=mysql_numrows($tb);
                $i=0;
                while ($i<$tb_n){
                    $pricesh_kod          =mysql_result($tb,$i,"pricesh_kod");
                    $pricesh_name         =mysql_result($tb,$i,"name_");
                    $pricesh_update_date  =mysql_result($tb,$i,"update_date");
                    $pricesh_srok_min     =mysql_result($tb,$i,"srok_min");
                    $pricesh_srok_max     =mysql_result($tb,$i,"srok_max");
                    $pricesh_valyuta_kod  =mysql_result($tb,$i,"valyuta_kod");
                    $pricesh_valyuta_prefix =mysql_result($tb,$i,"pref_");
                    $pricesh_nacenka      =mysql_result($tb,$i,"nacenka_");
                    $pricesh_hide            =mysql_result($tb,$i,"hide_");
                    $pricesh_moy_sklad        =mysql_result($tb,$i,"moy_sklad");
                    $pricesh_c1_name_ru   =mysql_result($tb,$i,"c1_name_ru");
                    $pricesh_c1_city_id   =mysql_result($tb,$i,"c1_city_id");
                    if ($pricesh_c1_city_id==-1) $pricesh_c1_name_ru="* Иной город";
                    else if ($pricesh_c1_city_id==-2) $pricesh_c1_name_ru="* Иная страна";
                    
                    $dmy=date('y')*365 + (date('y')%4) + date('z') - date('y',strtotime($pricesh_update_date))*365 - (date('y',strtotime($pricesh_update_date))%4) - date('z',strtotime($pricesh_update_date));
                    if ($dmy>=7) $pricesh_update_date_over="<br>$dmy дней"; else $pricesh_update_date_over="";
                ?>
                    <tr class=" <?php if (($i % 2)==0) print "odd"; else print "even"; ?>">
                        <td style="vertical-align: middle; font-size:11px;" align="right"><?php print ($i+1); ?>&nbsp;</td>
                        <td style="vertical-align: middle;">
                            <a href="price.php?pricesh=<?php print $pricesh_kod; ?>" title="<?php print $pricesh_name; ?>" style="font-size:11px;"><img src="images/order.png" alt="<?php print $pricesh_name; ?>" class="icon"> <?php print $pricesh_name; ?></a>
                        </td>
                        <td style="vertical-align: middle; color: navy; font-size:11px;" align="left">
                            <?php print $pricesh_c1_name_ru; ?>
                        </td>
                        <td style="vertical-align: middle; font-size:11px;" align="center">
                            <?php if ($pricesh_moy_sklad) print "Склад"; else print "Прайс"; ?>
                        </td>
                        <td style="vertical-align: middle; font-size:10px;" align="center">
                            <?php if ($pricesh_hide) print "Да"; ?>
                        </td>
                        <td style="vertical-align: middle;" align="center">
                            <?php print "$pricesh_srok_min - $pricesh_srok_max"; ?>
                        </td>
                        <td style="vertical-align: middle;" align="center">
                            <?php print number_format($pricesh_nacenka,2,'.',''); ?>
                        </td>
                        <td style="vertical-align: middle;" align="center">
                            <?php print "$pricesh_valyuta_prefix"; ?>
                        </td>
                        <td style="vertical-align: middle; font-size:11px; <?php if ($dmy>=30) print "color:#DDDDDD; background-color: #333333;"; else if ($dmy>=14) print "color:#DDDDDD; background-color: #FF0000;"; else if ($dmy>=7) print " background-color: #FFFF00;"; ?>" align="center">
                            <?php print date('d.m.Y',strtotime($pricesh_update_date))." ".$pricesh_update_date_over; ?>
                        </td>
                        <td  style="vertical-align: middle;" align="center">
                            &nbsp;<a onclick="showPriceAddDialog(<?php print "$pricesh_kod, '$pricesh_name', '$pricesh_update_date', '$pricesh_srok_min', '$pricesh_srok_max', $pricesh_valyuta_kod, $pricesh_nacenka, $pricesh_hide, $pricesh_moy_sklad"; ?>)" class="button">Обновить</a>&nbsp;
                            &nbsp;<a href="<?php print "price_save.php?delete=1&pricesh=$pricesh_kod"; ?>" onclick="javascript: return confirm('Удалить прайс?');" class="button_delete">x</a>&nbsp;
                        </td>
                    </tr>
                <?php 
                    $i+=1;
                } 
                ?>
                </table>

				<div id="price_dialog" class="hidden" style=" background-color:#a09d9d; position:absolute; left:0px; top:0px; width:100%; height:100%; z-index:10001; opacity:0.97;">
					<div id="price_dialog_inner" style="position: absolute; left:300px; top:150px; padding:20px 20px 20px 20px; background-color:#BBBBBB; width:350px">
						<form method="post" action="price_from_csv.php" enctype="multipart/form-data">
							<p><label for="price_name">Название </label>
								<input type="text" id="price_name" name="price_name" style="position:absolute; left:250px;">
							</p>
							<p><label for="price_update_date">Дата обновления </label>
								<input type="date" id="price_update_date" name="price_update_date" disabled="disabled" value="12.11.2012" style="position:absolute; left:250px;">
							</p>
							<p><label for="price_srok_min">Сроки поставки в днях: от </label>
								<input type="text" id="price_srok_min" name="price_srok_min" style="width: 20px;" >
                                <label for="price_srok_max"> до </label>
                                <input type="text" id="price_srok_max" name="price_srok_max" style="width: 20px;" >
							</p>
							<p><label for="price_valyuta_kod">Валюта </label>
								<select id="price_valyuta_kod" name="price_valyuta_kod" style="position:absolute; left:250px;">
								<?php 
									$tb=mysql_query("select vc.valyuta_kod, vl.pref_ from gm_valyuta_cours vc left join gm_valyuta_list vl on vc.valyuta_kod=vl.ISO_");
									@$tb_n=mysql_numrows($tb);
									$i=0;
									while ($i<$tb_n) {
										$valyuta_kod=mysql_result($tb,$i,"valyuta_kod");
										$valyuta_pref=mysql_result($tb,$i,"pref_");
								?>
										<option value="<?php print $valyuta_kod; ?>" ><?php print $valyuta_pref; ?></option>
								<?php		
										$i+=1;
									}
								?>
								</select>
							</p>
							<p><label for="price_nacenka_">Наценка (например 1.5) </label>
								<select id="price_nacenka" name="price_nacenka" style="position:absolute; left:250px;">
									<option value="1.1">1.05</option>
									<option value="1.1">1.10</option>
									<option value="1.15">1.15</option>
									<option value="1.2">1.20</option>
									<option value="1.25">1.25</option>
									<option value="1.3">1.30</option>
									<option value="1.35">1.35</option>
									<option value="1.4">1.40</option>
									<option value="1.45">1.45</option>
									<option value="1.5">1.50</option>
									<option value="1.55">1.55</option>
									<option value="1.6">1.60</option>
									<option value="1.65">1.65</option>
									<option value="1.7">1.70</option>
									<option value="1.75">1.75</option>
									<option value="1.8">1.80</option>
									<option value="1.85">1.85</option>
									<option value="1.9">1.90</option>
									<option value="1.95">1.95</option>
									<option value="2">2.00</option>
								</select>
							</p>
							<p><label for="price_hide">Скрыть </label>
								<input type="checkbox" id="price_hide" name="price_hide" value="1" checked="checked" style="position:absolute; left:250px;">
							</p>
							<p><label for="price_moy_sklad">Мой склад </label>
								<input type="checkbox" id="price_moy_sklad" name="price_moy_sklad" value="1" checked="checked" style="position:absolute; left:250px;">
							</p>
							<p class="text">
								<label for="price_file">Файл прайса (csv) </label>
								<input name="MAX_FILE_SIZE" value="40000000" type="hidden">
								<input name="price_file" id="price_file" type="file">
							</p>
							<p align="center">
								<input name="price_destination" id="price_destination" value="0" type="hidden"/>
								<input type="submit" value="Создать/Обновить" class="button" name="upload"/>&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="reset" value="Отменить" class="button" onclick="javascript: $('#price_dialog').hide(100); "/>
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>