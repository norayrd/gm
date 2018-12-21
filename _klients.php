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
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><a href="authentication.php" title="Учетная запись">Учетная запись</a><span class="navigation-pipe">&gt;</span>Пользователи сайта</div>
</div>
<!-- /Breadcrumb -->
<div id="noro_inner">
<h1>Пользователи сайта<span class="category-product-count"></span>
		</h1>
			<p class="cat_desc bordercolor bgcolor">Красным цветом покрашены сегодняшние зарегистрировавшиеся.</p>
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
        <th width="100">Логин</th>
        <th>Пользователь</th>
        <th width="70">E-mail</th>
        <th width="70">VIN</th>
        <th>Личный втомобиль</th>
    </tr>
</thead>
<tbody>
    
    <?php
	//запоминаем номер
$sql= "select u.*, f.faces_id, f.ts_ fts_ from gm_users u left join gm_faces f on f.user_id=u.user_id;";
$tb=mysql_query($sql) or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$i=0;
while($i<$tb_n){
    $tb_user_id=mysql_result($tb,$i,"user_id");
    $tb_user_ts=mysql_result($tb,$i,"ts_");
    $tb_user_login=mysql_result($tb,$i,"login_");
    $tb_user_name_full=mysql_result($tb,$i,"name_full");
    $tb_user_created=mysql_result($tb,$i,"created_");

    $tb_user_email=mysql_result($tb,$i,"email_");
    $tb_user_avto_vin=mysql_result($tb,$i,"avto_vin");
    $tb_user_avto_marka=mysql_result($tb,$i,"avto_marka");
    $tb_user_avto_model=mysql_result($tb,$i,"avto_model");
    $tb_user_avto_year=mysql_result($tb,$i,"avto_year");

    $tb_user_faces_id=mysql_result($tb,$i,"faces_id");
    $tb_user_faces_ts=mysql_result($tb,$i,"fts_");
 
?>
      <tr class="<?php if (($i % 2)==0) print "even"; else print "odd"; ?>" style="<?php if (date('d.m.Y', StrToTime($tb_user_created))==date('d.m.Y', time())) { print "background-color:#FF9999"; } ?>" >
        <td  style="font-size:11px"><?php print "<a href='user.php?user_id=$tb_user_id&ts=$tb_user_ts&nextpage=klients.php'>$tb_user_id</a>"; ?></td>
        <td><a style="font-size:11px"><?php print $tb_user_login; ?></a></td>
        <td  style="font-size:11px"><?php print "<a href='face.php?faces_id=$tb_user_faces_id&ts=$tb_user_faces_ts&nextpage=klients.php'>$tb_user_name_full</a>"; ?></td>
        <td align="center"><?php print "<a style='font-size:11px' href='mailto:$tb_user_email?subject=&body=%0AС уважением интернет магазин www.tandem-auto.com.ua'>$tb_user_email</a>"; ?></td>
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