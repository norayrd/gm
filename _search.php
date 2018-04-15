		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span>Склад</div>
</div>
<!-- /Breadcrumb -->
<div id="noro_inner">
<h1>Поиск товара<span class="category-product-count"></span>
		</h1>
							<p class="cat_desc bordercolor bgcolor">Последние запросы:
	<?php
	$sql="select distinct tov_kod from gm_search_tov_kod t where (t.kod_=".$_COOKIE["kod_"]*1 .")or((t.user_id=".$user_id*1 .")and(".$user_id*1 .">0)) order by search_date desc limit 20;";
	$tbNews=mysql_query($sql) or die(mysql_error());
	@$tbNews_n=mysql_numrows($tbNews);
	$i=0;
	while($i<$tbNews_n){
	    $tb_tov_kod=mysql_result($tbNews,$i,"tov_kod");	
	?>
		<a onClick="document.getElementById('search_query_top').value='<?php print $tb_tov_kod ?>';  document.getElementById('search_query_make').value=''; document.getElementById('searchbox').submit(); " style="cursor:pointer;"><?php print $tb_tov_kod ?></a>,
	<?php
		$i++;
	}
	?>
                            </p>
<?php
    $tov_kod=tov_kod_clear($_GET['search_query'])."";
    $tov_make=tov_kod_clear($_GET['search_query_make'])."";
    if (($tov_kod!="") & ($tov_make=="")){
        
        $tov_kod=tov_kod_clear($_GET['search_query']);
        $sql=" select p.tov_kod, p.tov_make_kod, tm.tov_make, max(p.tov_name) tov_name
                 from p_prices p left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod
                      left join p_pricesh ph on ph.pricesh_kod=p.pricesh_kod
                where p.hide_<>1 and ph.hide_<>1 and p.tov_kod='$tov_kod' group by 1,2 order by 2, 3; ";
        $tbMake=mysql_query($sql) or die(mysql_error());
        @$tbMake_n=mysql_numrows($tbMake);
        if ($tbMake_n>1){
?>
            <div class="product_sort">
            <table id="search_res" width="100%" class="noro_table">
            <thead>
            <tr>
                <th width="100">Бренд</th>
                <th width="100">Код</th>
                <th width="400">Наименование</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
<?php
            $i=0;
            while($i<$tbMake_n){
                $tbMake_tov_kod=mysql_result($tbMake,$i,"tov_kod");
                $tbMake_tov_make=mysql_result($tbMake,$i,"tov_make");
                $tbMake_tov_make_kod=mysql_result($tbMake,$i,"tov_make_kod");
                $tbMake_tov_name=mysql_result($tbMake,$i,"tov_name");
?>
                <tr class="<?php if (($i % 2)==0) print "even"; else print "odd"; ?> ">
                    <td><?php print $tbMake_tov_make; ?></td>
                    <td><?php print $tbMake_tov_kod; ?></td>
                    <td><?php print $tbMake_tov_name; ?></td>
                    <td>
                            <a onClick="document.getElementById('search_query_top').value='<?php print $tbMake_tov_kod ?>'; document.getElementById('search_query_make').value='<?php print $tbMake_tov_make_kod ?>'; document.getElementById('searchbox').submit(); " style="cursor:pointer;">искать -></a></td>
                </tr>
<?php
                $i++;
            }
?>
            </tbody>
            </table>
            </div>
<?php
        }else if ($tbMake_n==1){
            $tov_kod=mysql_result($tbMake,0,"tov_kod");
            $tov_make=mysql_result($tbMake,0,"tov_make_kod");
        }else{
?>
            <div class="product_sort">
            <table id="search_res" width="100%" class="noro_table">
            <thead>
            <tr>
                <th width="100">Бренд</th>
                <th width="100">Код</th>
                <th width="400">Наименование</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr><td colspan="4" style="background-color: #CCCCCC">Нет результатов</td></tr>
            </tbody>
            </table>
            </div>
<?php
        }
    }
?>

<?php 
    if (strlen($tov_kod)>0 & strlen($tov_make)>0) {
?>
    <!-- Sort products -->
        <div class="product_sort">
            <table width="100%" bordercolor="#2a2f33">
            <tr>
			    <td width="100%" align="right">
                    <p>
                        <form action="" id="form_sortby" method="get">
	                        <p>Сортировка <select name="sortby" onchange="javascript: $('#form_sortby').submit(); " >
    	                                    <option value="1" <?php if ($_GET['sortby']==1) print selected; ?>>по Бренду</option>
    	                                    <option value="2" <?php if ($_GET['sortby']==2) print selected; ?>>по Коду</option>
    	                                    <option value="3" <?php if ($_GET['sortby']==3) print selected; ?>>по Наименованию</option>
    	                                    <option value="4" <?php if ($_GET['sortby']==4) print selected; ?>>по Цене (от меньшей)</option>
    	                                    <option value="5" <?php if ($_GET['sortby']==5) print selected; ?>>по Цене (от большей)</option>
	                                      </select>
                                          <input name="search_query" type="hidden" value="<?php print $_GET['search_query']; ?>" />    
                                          <input name="tovname" type="hidden" value="<?php print $_GET['tovname']; ?>" /></p>
                        </form>
                    </p>
                </td>
		    </tr>
            <tr>
                <td>

                    <table id="search_res" class="noro_table">
                    <thead>
                    <tr>
                        <th width="10"></th>
                        <th width="90">Бренд</th>
                        <th width="90">Код</th>
                        <th width="200">Наименование</th>
                        <th width="170" <?php if ($user_view_id>0) print "width='170px'"; ?>><?php if ($user_view_id>0) print "Город / Поставщик / " ?>Сроки</th>
                        <th width="70" colspan="2">Цена</th>
                        <th width="30">Кол.</th>
                        <th width="60" colspan="4"></th>
                    </tr>
                    </thead>
                    <tbody>
    
    <?php
	//запоминаем номер
	if (isset($_GET['search_query']))
	    mysql_query("insert into gm_search_tov_kod (kod_,user_id,tov_kod,search_date)values(".$_COOKIE["kod_"].",$user_id,'".$_GET['search_query']."',current_timestamp ) ON DUPLICATE KEY UPDATE user_id=$user_id, search_date=current_timestamp;");
//
//print "CALL search_detals('".$_GET['search_query']."','".$_GET['tovname']."',$user_id,$tov_make);";
mysql_query("CALL search_detals('".$_GET['search_query']."','".$_GET['tovname']."',$user_id,$tov_make);");
$sql="select distinct * from SEARCH_RESULT order by analog_,order_";
if ($_GET['sortby']==1) $sql=$sql.",tov_make";
else if ($_GET['sortby']==2) $sql=$sql.",tov_kod";
else if ($_GET['sortby']==3) $sql=$sql.",tov_name";
else if ($_GET['sortby']==4) $sql=$sql.",cena_";
else if ($_GET['sortby']==5) $sql=$sql.",cena_ desc";
else $sql=$sql.",tov_make";
$tbNews=mysql_query($sql) or die(mysql_error());
@$tbNews_n=mysql_numrows($tbNews);
$i=0;
$analog_old=0;
$order_old=100;
$order_=0;
while($i<$tbNews_n){
    $tb_analog=mysql_result($tbNews,$i,"analog_");
    $tb_order=mysql_result($tbNews,$i,"order_");
	$tb_tov_make=mysql_result($tbNews,$i,"tov_make");
    $tb_tov_kod=mysql_result($tbNews,$i,"tov_kod");
    $tb_tov_name=mysql_result($tbNews,$i,"tov_name");
    $tb_cena=mysql_result($tbNews,$i,"cena_");
    $tb_valyuta_pref=mysql_result($tbNews,$i,"valyuta_pref");
    $tb_search_url=mysql_result($tbNews,$i,"search_url");
    $tb_dil_info=mysql_result($tbNews,$i,"dil_info");
    $tb_price_info=mysql_result($tbNews,$i,"price_info");
    if (mysql_result($tbNews,$i,"srok_min")!=null) {
        $tb_srok_dostavki=mysql_result($tbNews,$i,"srok_min");
        if ( (mysql_result($tbNews,$i,"srok_min")!=mysql_result($tbNews,$i,"srok_max"))
           &&(mysql_result($tbNews,$i,"srok_max")!=null) ) $tb_srok_dostavki.="-".mysql_result($tbNews,$i,"srok_max");
    } else {
        $tb_srok_dostavki=mysql_result($tbNews,$i,"srok_max");
    }
    
	$tb_prices_kod=mysql_result($tbNews,$i,"prices_kod");
	$tb_prices_count=mysql_result($tbNews,$i,"count_");

	$tb_dil_cena=mysql_result($tbNews,$i,"dil_cena");
	$tb_dil_valyuta_kod=mysql_result($tbNews,$i,"dil_valyuta_kod");
	$tb_dil_valyuta_pref=mysql_result($tbNews,$i,"dil_valyuta_pref");
	$tb_dil_name=mysql_result($tbNews,$i,"dil_name");
	$tb_update_date=mysql_result($tbNews,$i,"update_date");	
    $tb_crosesh_kod=mysql_result($tbNews,$i,"crosesh_kod");
    $tb_crosesh_name=mysql_result($tbNews,$i,"crosesh_name");
    $tb_title="$tb_tov_make $tb_tov_kod $tb_tov_name цена ".number_format($tb_cena,2,'.','')." $tb_valyuta_pref";
    $order_=mysql_result($tbNews,$i,"order_");
?>
<?php
    if ($order_old==100 & $order_!=100) { 
?>
    </tbody><tbody> 
<?php
    }
?>
<?php
    if ($i==3) {
?>
      <tr id="show_button" ><td colspan="11" style="background-color: #FF0000"><a style="color: #FFFFFF" onclick="$('#show_button').hide(0); $('.hidden_rows').show(500); ">Показать остальные</a></td></td></tr>
<?php
    }
?>
<?php
	if ($tb_analog<>$analog_old) {
?>
		<tr><th colspan="11" class="<?php if ($tb_order>=100) print "hidden hidden_rows"; ?>">АНАЛОГИ</th></tr>
<?php
		$analog_old=$tb_analog;
	}
?>

<?php
    if ($order_old!=100 & $order_==100) {
?>
    </tbody><tbody class="<?php if ($tb_order>=100) print "hidden hidden_rows"; ?>">
<?php
    }
?>

      <tr class="<?php if (($i % 2)==0) print "even"; else print "odd"; ?> " >
        <td><?php print ($i+1); ?></td>
        <td><?php print $tb_tov_make; ?></td>
        <td <?php if ($user_group>=2) print "title='Крос [$tb_crosesh_kod] $tb_crosesh_name'"; ?>><a href="search.php?search_query=<?php print $tb_tov_kod; ?>" title="<?php print $tb_title; ?>"><?php print $tb_tov_kod; ?></a></td>
        <td style="font-size:11px"><a href="search.php?search_query=<?php print $tb_tov_kod; ?>" title="<?php print $tb_title; ?>"><?php print $tb_tov_name; ?></a></td>
        <td align="center"><?php print $tb_dil_info; ?></td>
        <td align="right" title="<?php print $tb_price_info; ?>" ><?php print number_format($tb_cena,2,'.',''); ?></td>        <td align="left"><?php print $tb_valyuta_pref; ?></td>
        <td align="center"><?php print $tb_prices_count; ?></td>
            <td><img src="images/shopping-basket--plus.png" width=16; height=16; style="cursor:pointer; " onclick="$('#cart_macro').load('_cart_makro.php?kod_=<?php print $kod_; ?>&add&prices_kod=<?php print $tb_prices_kod; ?>');" title="Добавить в корзину" /></td>
		<?php 
		if ($user_group==3) {
		?>
            <td><img src="images/stop.png" width=16; height=16; style="cursor:pointer; " onclick="if (confirm('Скрыть из прайса?')) { $('#result_<?php print $tb_prices_kod; ?>').load('scripts/price_all_script.php?prices_kod=<?php print $tb_prices_kod; ?>&hide=1&kod=<?php print $kod_; ?>'); } " title="Скрыть из прайса" /></td>
            <td><img src="images/order.png" width=16; height=16; style="cursor:pointer; " onclick="$('#result_<?php print $tb_prices_kod; ?>').load('scripts/reklama_all_script.php?prices_kod=<?php print $tb_prices_kod; ?>&add=1&kod=<?php print $kod_; ?>');" title="добавить в рекламу" /></td>
            <td><div id="result_<?php print $tb_prices_kod; ?>"></div></td>
		<?php } ?>
      </tr>
<?php
    $order_old=$order_;

	$i++;
}
?>	        
    
                    </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
<?php
    }
?>


	</div>