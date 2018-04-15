		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
require_once "scripts/gm_access.php";
if ($user_group<2) {
    //print "Доступ запрещен!";
    include "_autentication.php";
    exit;
}
?> 

<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><a href="authentication.php" title="Учетная запись">Учетная запись</a><span class="navigation-pipe">&gt;</span>Последние запросы</div>
</div>
<!-- /Breadcrumb -->
<div id="noro_inner">
<h1>Последние запросы<span class="category-product-count"></span>
		</h1>
			<p class="cat_desc bordercolor bgcolor">Красным цветом покрашены сегодняшние запросы.</p>
		<!-- Sort products -->
<div class="product_sort">
<table width="100%" bordercolor="#2a2f33">
        <tr>
			<td width="100%" align="right">
            </td>
		</tr>
        <tr>
            <td>

<table id="search_res" width="100%" class="noro_table">
<thead>
    <tr>
        <th width="100">Дата поиска</th>
        <th width="100">Код товара</th>
        <th>Пользователь</th>
        <th width="70">E-mail</th>
        <th width="70">VIN</th>
        <th>Личный втомобиль</th>
    </tr>
</thead>
<tbody>
    
    <?php
	//запоминаем номер
$sql= "select t.search_tov_kod,t.kod_,t.user_id,t.tov_kod,t.search_date, u.name_full, u.* from gm_search_tov_kod t left join gm_users u on t.user_id=u.user_id "
     ." where (u.group_id<2) order by search_date desc limit 100;";
$tb=mysql_query($sql) or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$i=0;
while($i<$tb_n){
	$tb_search_date=mysql_result($tb,$i,"search_date");
    $tb_tov_kod=mysql_result($tb,$i,"tov_kod");
    $tb_user_name_full=mysql_result($tb,$i,"name_full");

    $tb_user_email=mysql_result($tb,$i,"email_");
    $tb_user_avto_vin=mysql_result($tb,$i,"avto_vin");
    $tb_user_avto_marka=mysql_result($tb,$i,"avto_marka");
    $tb_user_avto_model=mysql_result($tb,$i,"avto_model");
    $tb_user_avto_year=mysql_result($tb,$i,"avto_year");
 
?>
      <tr class="<?php if (($i % 2)==0) print "even"; else print "odd"; ?>" style="<?php if (date('d.m.Y', StrToTime($tb_search_date))==date('d.m.Y', time())) { print "background-color:#FF9999"; } ?>" >
        <td  style="font-size:10px"><?php print $tb_search_date; ?></td>
        <td><a href="search.php?search_query=<?php print $tb_tov_kod; ?>"><?php print $tb_tov_kod; ?></a></td>
        <td  style="font-size:11px"><?php print $tb_user_name_full; ?></td>
        <td align="center"><?php print "<a href='mailto:$tb_user_email?subject=&body=%0AС уважением интернет магазин www.avto-polit.ru'>$tb_user_email</a>"; ?></td>
        <td align="center"><?php print $tb_user_avto_vin; ?></td>
        <td><?php print "$tb_user_avto_marka / $tb_user_avto_model / $tb_user_avto_year"; ?></td>
      </tr>
<?php
	$i++;
}
?>	        
    
</tbody>
</table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;
                
            </td>
        </tr>
        <tr>
            <td>&nbsp;
                
            </td>
        </tr>
        </table>
        
        
</div>



	</div>