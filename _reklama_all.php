		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<?php
require_once "scripts/gm_access.php";
// pricesh_kod обязательно должна присутствовать на этой странице (>0)
if ($user_group<3) {
	//print "Доступ запрещен!";
	include "_autentication.php";
	exit;
}
?>     
<!-- MODULE Home Featured Products -->
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
<div id="featured_products">
	<h4 class="wrapfirstword">ТОП Предложения</h4>
		<div class="block_content">
		<ul>
<?php
$sql="select * from gm_reklama r left join gm_valyuta_list vl on r.valyuta_kod=vl.ISO_ left join p_tov_make tm on tm.tov_make_kod=r.tov_make_kod order by order_";
$rek=mysql_query($sql) or die(mysql_error());
@$rek_n=mysql_numrows($rek);
$i=0;
while($i<$rek_n){
	$rek_kod=mysql_result($rek,$i,"reklama_kod");
	$rek_tov_make=mysql_result($rek,$i,"tov_make");
    $rek_tov_kod=mysql_result($rek,$i,"tov_kod");
    $rek_tov_name=mysql_result($rek,$i,"tov_name");
	$rek_tov_name_short=substr($rek_tov_name,0,35);
	if (strlen($rek_tov_name)>36) $rek_tov_name_short=$rek_tov_name_short."...";
    $rek_cena=number_format(mysql_result($rek,$i,"cena_"),2,'.','');
    $rek_valyuta_pref=mysql_result($rek,$i,"pref_");
	$rek_image1=mysql_result($rek,$i,"image1_");
	if ($rek_image1=='') $rek_image1="images/gear.jpg";
	$rek_image2=mysql_result($rek,$i,"image2_");
	$rek_image3=mysql_result($rek,$i,"image3_");
	$rel_pricesh_kod=mysql_result($rek,$i,"pricesh_kod");
	$rek_url=mysql_result($rek,$i,"url_");
	$rek_text_short=mysql_result($rek,$i,"text_short");
	$rek_text_full=mysql_result($rek,$i,"text_full");
	$rek_cena_old=number_format(mysql_result($rek,$i,"cena_old"),2,'.','');
	$rek_char=mysql_result($rek,$i,"char_");
	$rek_hide=mysql_result($rek,$i,"hide_");
	$rek_ts=mysql_result($rek,$i,"ts_");
?>
			<li id="li_reklamablok_<?php print $rek_kod?>">
				<a class="product_image" href="view.php?reklama=<?php print $rek_kod; ?>" title="<?php print $rek_tov_name; ?>"><img src="<?php print $rek_image1; ?>" alt="<?php print $rek_tov_name; ?>" height="160"></a>
				<h5><a class="product_link" href="view.php?reklama=<?php print $rek_kod; ?>" title="<?php print $rek_tov_name; ?>"><?php print $rek_tov_name_short; ?></a></h5>
				<span class="price"><?php print $rek_cena." ".$rek_valyuta_pref; ?></span>
				<a class="button" href="view.php?reklama=<?php print $rek_kod; ?>" title="Открыть">Откр</a>
				<a class="button_red" href="reklama_edit.php?reklama=<?php print $rek_kod; ?>" title="Редактировать">Ред</a>
				<span id="rek_hide_<?php print $rek_kod; ?>">
					<?php if ($rek_hide==0) { ?>
						<a class="button_red" title="Скрыть" onclick=" if (confirm('Скрыть из рекламы?')==true) $('#rek_hide_<?php print $rek_kod; ?>').load('scripts/reklama_all_script.php?reklama=<?php print $rek_kod; ?>&hide=1&ts=<?php print $rek_ts; ?>&kod=<?php print $kod_; ?>'); else return 0; ">С</a>
                	<?php }else{ ?>
						<a class="button" title="Отобразить" onclick=" if (confirm('Отобразить в рекламе?')==true) $('#rek_hide_<?php print $rek_kod; ?>').load('scripts/reklama_all_script.php?reklama=<?php print $rek_kod; ?>&hide=0&ts=<?php print $rek_ts; ?>&kod=<?php print $kod_; ?>'); else return 0; ">О</a>
					<?php } ?>
				</span>
				<a class="button_red" title="Удалить" onclick=" if (confirm('Удалить из рекламы?')==true) $('#li_reklamablok_<?php print $rek_kod?>').load('scripts/reklama_all_script.php?reklama=<?php print $rek_kod; ?>&delete=1&ts=<?php print $rek_ts; ?>&kod=<?php print $kod_; ?>');  else return 0; ">X</a>
			</li>

<?php
	$i+=1;
}
?>
		  </ul>
		<div class="clearblock"></div>
  </div>
</div>
    <!-- /MODULE Home Featured Products -->		