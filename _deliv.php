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
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><a href="authentication.php" title="Учетная запись">Учетная запись</a><span class="navigation-pipe">&gt;</span>Список перевозчиков</div>
</div>
<!-- /Breadcrumb -->
<div id="noro_inner">
<h1>Список перевозчиков<span class="category-product-count"></span>
		</h1>
			<p class="cat_desc bordercolor bgcolor">Красным цветом покрашены сегодняшние зарегистрированные.</p>
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
        <th width="30">ID</th>
        <th width="100">Город</th>
        <th width="*">Название</th>
        <th width="70">E-mail</th>
        <th width="70">Телефоны</th>
        <th width="100">Адрес</th>
    </tr>
</thead>
<tbody>
    
    <?php
	//запоминаем номер
$sql= "select f.*,u.* from gm_faces f left join gm_users u on u.user_id=f.user_id where f.typ_=3;";
$tb=mysql_query($sql) or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$i=0;
while($i<$tb_n){
	$tb_user_id=mysql_result($tb,$i,"user_id");
    $tb_user_city=mysql_result($tb,$i,"city_");
    $tb_user_name_full=mysql_result($tb,$i,"name_full");
    $tb_user_adr=mysql_result($tb,$i,"adr_");
    $tb_user_email=mysql_result($tb,$i,"email_");
    $tb_user_tel=mysql_result($tb,$i,"tel_")."";
    if ($tb_user_tel!="") $tb_user_tel="; ";
    $tb_user_tel=$tb_user_tel.mysql_result($tb,$i,"tel_mob");
 
?>
      <tr class="<?php if (($i % 2)==0) print "even"; else print "odd"; ?>" style="<?php if (date('d.m.Y', StrToTime($tb_user_created))==date('d.m.Y', time())) { print "background-color:#FF9999"; } ?>" >
        <td  style="font-size:11px"><?php print $tb_user_id; ?></td>
        <td><a style="font-size:11px"><?php print $tb_user_city; ?></a></td>
        <td  style="font-size:11px"><?php print $tb_user_name_full; ?></td>
        <td align="center"><?php print "<a style='font-size:11px' href='mailto:$tb_user_email?subject=&body=%0AС уважением интернет магазин www.tandem-auto.com.ua'>$tb_user_email</a>"; ?></td>
        <td align="center"><?php print $tb_user_tel; ?></td>
        <td style="font-size:10px"><?php print $tb_user_adr; ?></td>
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