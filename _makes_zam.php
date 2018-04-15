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
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><a href="authentication.php" title="Учетная запись">Учетная запись</a><span class="navigation-pipe">&gt;</span>Бренды</div>
</div>
<!-- /Breadcrumb -->
<div id="noro_inner">
<h1>Замена брендов<span class="category-product-count"></span></h1>
			<!--p class="cat_desc bordercolor bgcolor">Красным цветом покрашены неиспользованные бренды.</p-->
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
        <th width="200">Вариант</th>
        <th width="30">ID</th>
        <th width="30"></th>
        <th width="100">Бренд</th>
        <th>Всего использовано</th>
        <th width="70">Использовано в кросах</th>
        <th></th>
    </tr>
</thead>
<tbody>
<script type="text/javascript">
    function ch_zam(r,com){
        if (com!=2) $('#r'+r).load('_makes_zam_row.php?kod_=<?php print $kod_; ?>&r='+r+'&tov_makev='+encodeURIComponent($('#v'+r).val())+'&com='+com);
        else {if (confirm('Удалить запись?')) $('#r'+r).load('_makes_zam_row.php?kod_=<?php print $kod_; ?>&r='+r+'&com='+com);}
    }
</script>
    <?php
	//запоминаем номер
$sql= "select v.variant_kod, v.tov_make tov_makev, t.tov_make_kod, t.tov_make, t.used_count, t.used_incroses from p_tov_make_variant v left join p_tov_make t on t.tov_make_kod=v.tov_make_kod order by t.tov_make";
$tb=mysql_query($sql) or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$i=0;
while($i<$tb_n){
    $tb_kod=mysql_result($tb,$i,"variant_kod");
    $tb_tov_make_kod=mysql_result($tb,$i,"tov_make_kod");
    $tb_tov_makev=mysql_result($tb,$i,"tov_makev");
    $tb_tov_make=mysql_result($tb,$i,"tov_make");
    $tb_used_count=mysql_result($tb,$i,"used_count");
    $tb_used_incroses=mysql_result($tb,$i,"used_incroses");
?>
      <tr class="<?php if (($i % 2)==0) print "even"; else print "odd"; ?>" style="<?php if ($tb_used_count==0) { print "background-color:#FF9999"; } ?>" id="r<?php print $tb_kod; ?>">
        <td><input type="text" id="v<?php print $tb_kod; ?>" value="<?php print $tb_tov_makev; ?>" onchange="$('#b<?php print $tb_kod; ?>').show(); ch_zam('<?php print $tb_kod; ?>',1);" onkeypress="if (event.keyCode==13) ch_zam('<?php print $tb_kod; ?>',1); else if (event.keyCode==27) ch_zam('<?php print $tb_kod; ?>',0);" ><input type="button" id="b<?php print $tb_kod; ?>" value="->" onclick="ch_zam('<?php print $tb_kod; ?>',1)" style="cursor:pointer; display:none; background-color: #ff9999;"></td>
        <td align=right style="color: gray"><?php print $tb_tov_make_kod; ?></td>
        <td></td>
        <td style="color: gray"> <?php print $tb_tov_make; ?></td>
        <td align=right style="color: gray"><?php print $tb_used_count; ?></td>
        <td align=right style="color: gray"><?php print $tb_used_incroses; ?></td>
        <td><input type="button" id="b<?php print $tb_kod; ?>" value="X" onclick="ch_zam('<?php print $tb_kod; ?>',2)" style="cursor:pointer;" class="button_red" title="Удалить"></td>
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