		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<?php
require_once "scripts/gm_access.php";
$sklad_group=$_GET["group"]-0;
?>
	<!-- Breadcrumb -->
	<div class="breadcrumb bordercolor"><div class="breadcrumb_inner">
		<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span>Склад
	</div></div>
	<!-- /Breadcrumb -->
	<div id="noro_inner">
		<h1><span class="category-product-count"></span></h1>


<?php 
if ($sklad_group>0) {
	$tbl_sql="select * from p_group g where g.group_kod=$sklad_group";
	$tb=mysql_query($tbl_sql) or die(mysql_error());
	@$tb_n=mysql_numrows($tb);
	if ($tb_n>0) $tb_top_text=mysql_result($tb,0,"text_");
	if ($tb_top_text<>"") {
?>
		<p class="cat_desc bordercolor bgcolor" id="top_text"><?php print $tb_top_text; ?>
        </p>
<?php
	}
}
?>
    
		<!-- Sort products -->
		<div class="product_sort">      
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
                        <th width="50px">Сроки </th>
						<th width="70px" colspan="2">Цена</th>
						<th>Кол.</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php
					//запоминаем номер
					if (1==1) {
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
						$tbl_sql="select ph.*, p.*, tm.*, vl.pref_, p.cena_ * ph.nacenka_ * vc.cours_ cena_rozn, ph.name_ dil_name, ph.valyuta_kod dil_valyuta_kod, vl.pref_ dil_valyuta_pref, p.cena_ dil_cena 
								from p_pricesh ph 
								left join p_prices p on p.pricesh_kod=ph.pricesh_kod 
								left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod
								left join gm_valyuta_list vl on ph.valyuta_kod=vl.ISO_
                                left join gm_valyuta_cours vc on vc.valyuta_kod=ph.valyuta_kod
								where /*(ph.moy_sklad=1)
									and*/((p.group_kod=$sklad_group)or($sklad_group=0))";
						$tb=mysql_query($tbl_sql." limit $limit_start, $limit_length") or die(mysql_error());
						@$tb_n=mysql_numrows($tb);
						$i=0;
						while($i<$tb_n){
							$tb_tov_make=mysql_result($tb,$i,"tov_make");
						    $tb_tov_kod=mysql_result($tb,$i,"tov_kod");
							$tb_tov_name=mysql_result($tb,$i,"tov_name");
							$tb_cena=mysql_result($tb,$i,"cena_rozn");
							$tb_prices_kod=mysql_result($tb,$i,"prices_kod");
							$tb_valyuta_pref='грн.'; mysql_result($tb,$i,"pref_");
                            $tb_srok_min=mysql_result($tb,$i,"srok_min");
                            $tb_srok_max=mysql_result($tb,$i,"srok_max");
							$tb_prices_kod=mysql_result($tb,$i,"prices_kod");
							$tb_prices_count=mysql_result($tb,$i,"count_");
                            
                            $tb_dil_cena=mysql_result($tb,$i,"dil_cena");
                            $tb_dil_valyuta_kod=mysql_result($tb,$i,"dil_valyuta_kod");
                            $tb_dil_valyuta_pref=mysql_result($tb,$i,"dil_valyuta_pref");
                            $tb_dil_name=mysql_result($tb,$i,"dil_name");
                            $tb_update_date=mysql_result($tb,$i,"update_date");    

                            $tb_title="$tb_tov_make $tb_tov_kod $tb_tov_name цена ".number_format($tb_cena,2,'.','')." $tb_valyuta_pref";
					?>
						<tr class="<?php if (($i % 2)==0) print "even"; else "odd"; ?>">
							<td style="font-size:9px" align="center"><?php print $i +1 + $limit_start; ?></td>
							<td><?php print $tb_tov_make; ?></td>
							<td><a href="search.php?search_query=<?php print $tb_tov_kod; ?>" title="<?php print $tb_title; ?>"><?php print $tb_tov_kod; ?></a></td>
							<td style="font-size:11px"><a href="search.php?search_query=<?php print $tb_tov_kod; ?>" title="<?php print $tb_title; ?>"><?php print $tb_tov_name; ?></a></td>
							<td align="center"><?php print "$tb_srok_min - $tb_srok_max"; ?></td>
							<td align="right" <?php if ($user_group>=2) print "title='$tb_dil_name [".number_format($tb_dil_cena,2,'.','')." $tb_dil_valyuta_pref] [".date('d.m.Y', StrToTime($tb_update_date))."]'"?> ><?php print number_format($tb_cena,2,'.',''); ?></td>
							<td align="left"><?php print $tb_valyuta_pref; ?></td>
							<td align="center"><?php print $tb_prices_count; ?></td>
							<!-- td><img src="../images/shopping-basket--plus.png" width=16; height=16; style="cursor:pointer; " onclick="$('#recicle_mini').load('./scripts/gm_recicle_mini.php?kod_=<?php print $kod_; ?>&prices_kod=<?php print $tb_prices_kod; ?>');$('#recicle_mini').hide(20);$('#recicle_mini').show(20);" /></td -->
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
						<a href="<?php print "?group=$sklad_group&start=0&length=$limit_length"; ?>" class="button_mini" title="К началу"><<</a>
						<?php
						//$sql="select count(*) count_ from p_prices p where p.pricesh_kod=$pricesh_kod";
						$tbl_sql_temp="select count(*) count_ ".substr($tbl_sql,strpos($tbl_sql,"from"),strlen($tbl_sql)-strpos($tbl_sql,"from")+1);
						$tb=mysql_query($tbl_sql_temp) or die(mysql_error());
						@$tb_n=mysql_numrows($tb);
						if ($tb_n>0) $tb_n=mysql_result($tb,0,"count_");
						$i=0;
						while(($i*$limit_length)<$tb_n){
							if (($i<2)||($i>($tb_n/$limit_length-2))||
								(($i>=($limit_start/$limit_length-2))&&($i<=($limit_start/$limit_length+2)))) {
						?>
                                
							<a href="<?php print "?group=$sklad_group&start=".($i*$limit_length)."&length=$limit_length"; ?>" class="<?php if ( (($limit_start/100)>=$i)&&(($limit_start/100)<($i+1))) print "button_red"; else print "button_mini"; ?>"><?php print $i+1; ?></a>
						<?php
							} else if (($i==2)||($i==round($tb_n/$limit_length-3))) print "...";
							$i+=1;
						}
						?>
						<a href="<?php print "?group=$sklad_group&start=".(($i-1)*$limit_length)."&length=$limit_length"; ?>" class="button_mini" title="В конец">>></a>
					</div>
					<script type="text/javascript">
						document.getElementById('tb_head').innerHTML =document.getElementById('tb_foot').innerHTML;
					</script>
				</td>
			</tr>
			</table>
		</div>
	</div>
