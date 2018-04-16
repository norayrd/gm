		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php require_once "scripts/gm_access.php"; ?>

<script type="text/javascript">
$(document).ready(function()
    {
        $('.wrapfirstword').each(function() {
            var h = $(this).html();
            var index = h.indexOf(' ');
            if(index == -1) {
                index = h.length;
            }
            $(this).html('<span>' + h.substring(0, index) + '</span>' + h.substring(index, h.length));
        });
    });

</script>
				<!-- Breadcrumb -->
				<div class="breadcrumb bordercolor"><div class="breadcrumb_inner">
					<a href="index.php" title="На главную">Главная</a>
					<span class="navigation-pipe">&gt;</span>
					<span class="navigation_page">ТОП Предложения</span>
				</div></div>
				<!-- /Breadcrumb -->

<div id="noro_inner">,
<div class="clear" style="height:9px;"></div>
<div id="featured_products">
	<h4 class="wrapfirstword">ШИНЫ</h4>
    <script type="text/javascript">
		function doViewStyle(vst){
			$('#view_style').val(vst);
			if (vst==2) $('#length').val(100);
			       else $('#length').val(30);
			$('#form_filter').submit();
		}
	</script>
    <?php
		if ($_GET['view_style']!=2) {
			$view_style=1;
			print "<img src='images/view_style11.png'> <a onclick='javascript: doViewStyle(2); '><img src='images/view_style22.png'></a>";
		} else {
			$view_style=$_GET['view_style'];
			print "<a onclick='javascript: doViewStyle(1); '><img src='images/view_style12.png'></a> <img src='images/view_style21.png'>";
		}  
    ?>
        <?php
            $par_fwidth=$_GET["fwidth"]."";
            $par_fheight=$_GET["fheight"]."";
            $par_fradius=$_GET["fradius"]."";
            $par_fseason=$_GET["fseason"]."";
            $par_fbrand=$_GET["fbrand"]."";
			$par_ftyp=$_GET["ftyp"]."";
			$par_fcountry=$_GET["fcountry"]."";
        ?>
        <div>
        	<script type="text/javascript">
				function goNext(start,length){
					$('#start').val(start);
					$('#length').val(length);
					$('#form_filter').submit();
				}
				function Reset(){
					$('#fwidth').val('');
					$('#fheight').val('');
					$('#fradius').val('');
					$('#fseason').val('');
					$('#fbrand').val('');
					$('#ftyp').val('');
					$('#fcountry').val('');
					$('#start').val(0);
				}
			</script>
        	<form action="#" method="get" id="form_filter" >
			    <p class="cat_desc bordercolor bgcolor">
            	<label for="fwidth">Ширина</label>
                <select name="fwidth" id="fwidth">
                    <?php 
					    $tb=mysql_query("select distinct width_ from p_prices_dop");
						@$tb_n=mysql_numrows($tb);
						$i=0;
                        $selected=0;
						while ($i<$tb_n) {
							$tb_width=number_format(mysql_result($tb,$i,"width_"),2,'.','');
					?>
							<option value="<?php print $tb_width; ?>" <?php if ($par_fwidth==$tb_width) { print "selected"; $selected=1; } ?> ><?php print $tb_width; ?></option>
					<?php		
							$i+=1;
						}
					?>
                    <option value="" <?php if ($selected==0) print "selected"; ?> >-</option>
                </select>
            	<label for="fheight">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Высота</label>
                <select name="fheight" id="fheight">
                    <?php 
					    $tb=mysql_query("select distinct height_ from p_prices_dop");
						@$tb_n=mysql_numrows($tb);
						$i=0;
                        $selected=0;
						while ($i<$tb_n) {
							$tb_height=number_format(mysql_result($tb,$i,"height_"),2,'.','');
					?>
							<option value="<?php print $tb_height; ?>" <?php if ($par_fheight==$tb_height) { print "selected"; $selected=1; } ?> ><?php print $tb_height; ?></option>
					<?php		
							$i+=1;
						}
					?>
                    <option value="" <?php if ($selected==0) print "selected"; ?> >-</option>
                </select>
            	<label for="fradius">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Радиус</label>
                <select name="fradius" id="fradius">
                    <?php 
					    $tb=mysql_query("select distinct radius_ from p_prices_dop");
						@$tb_n=mysql_numrows($tb);
						$i=0;
                        $selected=0;
						while ($i<$tb_n) {
							$tb_radius=mysql_result($tb,$i,"radius_");
					?>
							<option value="<?php print $tb_radius; ?>" <?php if ($par_fradius==$tb_radius) { print "selected"; $selected=1; } ?> ><?php print $tb_radius; ?></option>
					<?php		
							$i+=1;
						}
					?>
                    <option value="" <?php if ($selected==0) print "selected"; ?> >-</option>
                </select>
            	<label for="fseason">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Сезон</label>
                <select name="fseason" id="fseason">
                	<option value="" <?php if ($par_fseason=="") print "selected"; ?> >Любой</option>
                	<option value="1" <?php if ($par_fseason=="1") print "selected"; ?> >Зима</option>
                	<option value="2" <?php if ($par_fseason=="2") print "selected"; ?> >Лето</option>
                	<option value="3" <?php if ($par_fseason=="3") print "selected"; ?> >Всесезонный</option>
                </select><br><br>
            	<label for="fbrand">Бренд</label>
                <select name="fbrand" id="fbrand">
                    <?php 
					    $tb=mysql_query("select distinct tm.tov_make, p.tov_make_kod from p_prices_dop pd left join p_prices p on pd.prices_kod=p.prices_kod left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod order by 1");
						@$tb_n=mysql_numrows($tb);
						$i=0;
                        $selected=0;
						while ($i<$tb_n) {
                            $tb_tov_make=mysql_result($tb,$i,"tov_make");
                            $tb_tov_make_kod=mysql_result($tb,$i,"tov_make_kod");
					?>
							<option value="<?php print $tb_tov_make_kod; ?>" <?php if ($par_fbrand==$tb_tov_make_kod) { print "selected"; $selected=1; } ?> ><?php print $tb_tov_make; ?></option>
					<?php		
							$i+=1;
						}
					?>
                    <option value="" <?php if ($selected==0) print "selected"; ?> >-</option>
                </select>
                <label for="ftyp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Тип</label>
                <select name="ftyp" id="ftyp">
                	<option value="" <?php if ($par_ftyp=="") print "selected"; ?> >Любой</option>
                	<option value="1" <?php if ($par_ftyp=="1") print "selected"; ?> >Легковая</option>
                	<option value="2" <?php if ($par_ftyp=="2") print "selected"; ?> >Легкогрузовая</option>
                	<option value="3" <?php if ($par_ftyp=="3") print "selected"; ?> >Внедорожник</option>
                </select>
                <label for="fcountry">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Страна</label>
                <select name="fcountry" id="fcountry">
                    <?php 
					    $tb=mysql_query("select distinct cn.name_ru, pd.country_id from p_prices_dop pd left join gm_country cn on pd.country_id=cn.country_id order by 1");
						@$tb_n=mysql_numrows($tb);
						$i=0;
                        $selected=0;
						while ($i<$tb_n) {
                            $tb_country_name=mysql_result($tb,$i,"name_ru");
                            $tb_country_id=mysql_result($tb,$i,"country_id");
					?>
							<option value="<?php print $tb_country_id; ?>" <?php if ($par_fcountry==$tb_country_id) { print "selected"; $selected=1; } ?> ><?php print $tb_country_name; ?></option>
					<?php		
							$i+=1;
						}
					?>
                    <option value="" <?php if ($selected==0) print "selected"; ?> >-</option>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="hidden" name="view_style" id="view_style" value="<?php print $_GET['view_style']; ?>">
                <input type="hidden" name="start" id="start" value="<?php print $_GET['start']; ?>">
                <input type="hidden" name="length" id="length" value="<?php print $_GET['length']; ?>">
				<input type="submit" name="Submit" value="Найти" class="button" onclick="javascript: $('#start').val(0); " />
				<input type="button" value="Сброс" class="button" onclick="javascript: Reset(); " />
                </p>
        	</form>
        </div>
        <div class="block_content">
        <br>

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


		<?php if ($view_style==1) { ?>
        <ul>
		<?php } else { ?>
		<table id="search_res" width="100%" class="noro_table">
		<thead>
		    <tr>
            <th width="35px">№</th>
        	<th width="100">Бренд</th>
        	<th width="100">Код</th>
        	<th>Наименование</th>
        	<th width="40px">Сезон</th>
        	<th width="40">Сроки</th>
        	<th colspan="2">Цена</th>
        	<th width="60">Кол.</th>
        	<th colspan="3"></th>
    		</tr>
		</thead>
		<tbody>
        <?php } ?>
<?php
			$limit_start=$_GET["start"]-0;
			$limit_length=$_GET["length"]-0;
			if (!($limit_start>=0)) $limit_start=0;
			if (!($limit_length>0)) {
				if ($view_style==1) $limit_length=30; 
							   else $limit_length=100;
			}
$tbl_sql="select pd.width_, pd.height_, pd.radius_, pd.season_, pd.image1_, 
             p.prices_kod,p.tov_make_kod, p.tov_kod, p.tov_name, p.pricesh_kod, p.count_, 
             tm.tov_make, vl.pref_, vc.cours_, p.cena_ * vc.cours_ * ph.nacenka_ cena_uah,
			 p.cena_ dil_cena,
			 ph.srok_min,ph.srok_max, ph.name_,ph.update_date, ps.pic_mini, ps.pic_max
        from p_prices_dop pd left join p_prices p on pd.prices_kod=p.prices_kod
             left join p_pricesh ph on ph.pricesh_kod=p.pricesh_kod
             left join gm_valyuta_list vl on ph.valyuta_kod=vl.ISO_ 
             left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod 
             left join gm_valyuta_cours vc on ph.valyuta_kod=vc.valyuta_kod
			 left join p_pic_shini ps on pd.image1_=ps.id_name2 
       where (ph.hide_=0)";
       if ($par_fwidth!="") $tbl_sql=$tbl_sql."and(pd.width_=$par_fwidth)";
       if ($par_fheight!="") $tbl_sql=$tbl_sql."and(pd.height_=$par_fheight)";
       if ($par_fradius!="") $tbl_sql=$tbl_sql."and(pd.radius_='$par_fradius')";
       if ($par_fseason!="") $tbl_sql=$tbl_sql."and((pd.season_=$par_fseason)or(pd.season_=0))";
       if ($par_fbrand!="") $tbl_sql=$tbl_sql."and(p.tov_make_kod=$par_fbrand)";
       if ($par_ftyp!="") $tbl_sql=$tbl_sql."and((pd.typ_=$par_ftyp)or(pd.typ_=0))";
       if ($par_fcountry!="") $tbl_sql=$tbl_sql."and(pd.country_id=$par_fcountry)";
       $tbl_sql=$tbl_sql." order by p.tov_kod";
$tb=mysql_query($tbl_sql." limit $limit_start, $limit_length") or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$i=0;
while($i<$tb_n){
	$tb_prices_kod=mysql_result($tb,$i,"prices_kod");
    $tb_pricesh_kod=mysql_result($tb,$i,"pricesh_kod");
    $tb_tov_make_kod=mysql_result($tb,$i,"tov_make_kod");
    $tb_tov_make=mysql_result($tb,$i,"tov_make");
    $tb_tov_kod=mysql_result($tb,$i,"tov_kod");
    $tb_tov_name=mysql_result($tb,$i,"tov_name");
    $tb_count=mysql_result($tb,$i,"count_");
    $tb_cena=number_format(mysql_result($tb,$i,"cena_uah"),2,'.','');
    $tb_dil_cena=number_format(mysql_result($tb,$i,"dil_cena"),2,'.','');
    $tb_valyuta_pref="руб."; 
	$tb_dil_valyuta_pref=mysql_result($tb,$i,"pref_");
	$tb_image1=mysql_result($tb,$i,"pic_mini");
	if ($tb_image1=='') $tb_image1="images/gear.jpg"; else $tb_image1="shini/images/".$tb_image1;
    $tb_width=mysql_result($tb,$i,"width_");
    $tb_height=mysql_result($tb,$i,"height_");
    $tb_radius=mysql_result($tb,$i,"radius_");
    $tb_season=mysql_result($tb,$i,"season_"); 
    $tb_srok_min=mysql_result($tb,$i,"srok_min"); 
    $tb_srok_max=mysql_result($tb,$i,"srok_max"); 
    $tb_dil_name=mysql_result($tb,$i,"name_"); 
	$tb_update_date=mysql_result($tb,$i,"update_date");
    $tb_title="$tb_tov_make $tb_tov_kod $tb_tov_name цена ".number_format($tb_cena,2,'.','')." $tb_valyuta_pref";
?>
		<?php if ($view_style==1) { ?>
		  <li>
				<h5 style=" padding-top:0px;"><a class="product_link" href="view.php?prices=<?php print $tb_prices_kod; ?>" title="<?php print $tb_tov_name; ?>"><?php print "$tb_tov_kod $tb_tov_make"; ?></a></h5>
				<a class="product_image" href="view.php?prices=<?php print $tb_prices_kod; ?>" title="<?php print $tb_tov_name; ?>"><img src="<?php print $tb_image1; ?>" alt="<?php print $tb_tov_name; ?>" style="max-height:130px; max-width:130px; "></a>
				<p style=" padding-top:5px;"><a class="product_link" href="view.php?prices=<?php print $tb_prices_kod; ?>" title="<?php print $tb_tov_name; ?>"><?php print $tb_tov_name; ?></a></p>
				<p style="color:#FF0000; font-size:20px;" title="<?php if ($user_group>=2)  print $tb_dil_name." [$tb_dil_cena $tb_dil_valyuta_pref] [".date('d.m.Y', StrToTime($tb_update_date))."]"; ?>"><?php print $tb_cena." ".$tb_valyuta_pref; ?>
                <p style="font-size:10px;"><?php print "сроки:$tb_srok_min-$tb_srok_max; кол-во:".$tb_count; ?> <?php if (($tb_season==1)||($tb_season==3)) { ?><img width="18px" src="images/sneg.jpg"><?php }; ?><?php if (($tb_season==2)||($tb_season==3)) { ?><img width="18px" src="images/solnce.jpg"><?php }; ?></p>
                </p>
				<a class="feat_btn" href="view.php?prices=<?php print $tb_prices_kod; ?>" title="Открыть"><span>Открыть</span></a>
                <?php if ($user_group==3) { ?>                <a class="button_red" href="reklama_edit.php?reklama=<?php print $tb_prices_kod; ?>" title="Открыть">Ред.</a>
                <?php } ?>
			</li>



		<?php } else { ?>
            
            
            
      <tr class="<?php if (($i % 2)==0) print "even"; else print "odd"; ?>" >
      	<td style="font-size:9px" align="center"><?php print $i +1 + $limit_start; ?></td>
        <td><?php print $tb_tov_make; ?></td>
        <td><a href="search.php?search_query=<?php print $tb_tov_kod; ?>" title="<?php print $tb_title; ?>"><?php print $tb_tov_kod; ?></a></td>
        <td  style="font-size:11px"><a href="search.php?search_query=<?php print $tb_tov_kod; ?>" title="<?php print $tb_title; ?>"><?php print $tb_tov_name; ?></a></td>
        <td align="center"><?php if (($tb_season==1)||($tb_season==3)) { ?><img width="18px" src="images/sneg.jpg"><?php }; ?><?php if (($tb_season==2)||($tb_season==3)) { ?><img width="18px" src="images/solnce.jpg"><?php }; ?></td>
        <td align="center"><?php print "$tb_srok_min - $tb_srok_max"; ?></td>
        <td align="right" <?php if ($user_group>=2) print "title='$tb_dil_name [".number_format($tb_dil_cena,2,'.','')." $tb_dil_valyuta_pref] [".date('d.m.Y', StrToTime($tb_update_date))."]'"?> ><?php print number_format($tb_cena,2,'.',''); ?></td>
        <td align="left"><?php print $tb_valyuta_pref; ?></td>
        <td align="center"><?php print $tb_count; ?></td>
        <td><img src="images/shopping-basket--plus.png" width=16; height=16; style="cursor:pointer; " onclick="$('#cart_macro').load('_cart_makro.php?kod_=<?php print $kod_; ?>&add&prices_kod=<?php print $tb_prices_kod; ?>');" title="Добавить в корзину" /></td>
		<?php 
		if ($user_group==3) {
		?>
            <td><img src="images/order.png" width=16; height=16; style="cursor:pointer; " onclick="$('#result_<?php print $tb_prices_kod; ?>').load('scripts/reklama_all_script.php?prices_kod=<?php print $tb_prices_kod; ?>&add=1&kod=<?php print $kod_; ?>');" title="добавить в рекламу" /></td>
        <td><div id="result_<?php print $tb_prices_kod; ?>"></div></td>
		<?php } ?>
      </tr>
        <?php } ?>
            

<?php
	$i+=1;
}
?>
		<?php if ($view_style!=1) { ?>
		</tbody>
		</table>
		<?php } else { ?>
		</ul>
        <?php } ?>
				</td>
			</tr>
			<tr>
				<td height="5px"></td>
			</tr>
			<tr>
				<td align="center">
					<div id="tb_foot">
						<a onclick="javascript: goNext(0,<?php print $limit_length; ?>); " class="button_mini" title="К началу"> << </a>
						<?php
						$tbl_sql_temp="select count(*) count_ ".substr($tbl_sql,strpos($tbl_sql,"from"),strlen($tbl_sql)-strpos($tbl_sql,"from")+1);
						$tb=mysql_query($tbl_sql_temp) or die(mysql_error());
						@$tb_n=mysql_numrows($tb);
						if ($tb_n>0) $tb_n=mysql_result($tb,0,"count_");
						$i=0;
						while(($i*$limit_length)<$tb_n){
							if (($i<2)||($i>($tb_n/$limit_length-2))||
								(($i>=($limit_start/$limit_length-2))&&($i<=($limit_start/$limit_length+2)))) {
						?>
							<a onclick="javascript: goNext(<?php print ($i*$limit_length); ?>,<?php print $limit_length; ?>); " class="<?php if ( (($limit_start/$limit_length)>=$i)&&(($limit_start/$limit_length)<($i+1))) print "button_red"; else print "button_mini"; ?>"><?php print $i+1; ?></a>
						<?php
							} else if (($i==2)||($i==round($tb_n/$limit_length-2))) print "...";
							$i+=1;
						}
						?>
						<a onclick="javascript: goNext(<?php print (($i-1)*$limit_length); ?>,<?php print $limit_length; ?>); " class="button_mini" title="В конец"> >> </a>
					</div>
					<script type="text/javascript">
						document.getElementById('tb_head').innerHTML =document.getElementById('tb_foot').innerHTML;
					</script>
				</td>
			</tr>
			</table>

		<div class="clearblock"></div>
  </div>
</div>
</div>
