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
	<h4 class="wrapfirstword">ТОП Предложения</h4>
		<div class="block_content">
		<ul>
<?php
$sql="select r.*, tm.tov_make, vl.pref_, vc.cours_, cena_ * cours_ cena_uah from gm_reklama r left join gm_valyuta_list vl on r.valyuta_kod=vl.ISO_ left join p_tov_make tm on tm.tov_make_kod=r.tov_make_kod left join gm_valyuta_cours vc on r.valyuta_kod=vc.valyuta_kod where (hide_=0) order by order_";
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
    $rek_cena=number_format(mysql_result($rek,$i,"cena_uah"),2,'.','');
    $rek_valyuta_pref="руб."; //mysql_result($rek,$i,"pref_");
	$rek_image1=mysql_result($rek,$i,"image1_");
	if ($rek_image1=='') $rek_image1="images/gear.jpg";
	$rek_image2=mysql_result($rek,$i,"image2_");
	$rek_image3=mysql_result($rek,$i,"image3_");
	$rel_pricesh_kod=mysql_result($rek,$i,"pricesh_kod");
	$rek_text_short=mysql_result($rek,$i,"text_short");
	$rek_text_full=mysql_result($rek,$i,"text_full");
	$rek_cena_old=number_format(mysql_result($rek,$i,"cena_old"),2,'.','');
	$rek_char=mysql_result($rek,$i,"char_");
?>
		  <li>
				<h5 style=" padding-top:0px;"><a class="product_link" href="view.php?reklama=<?php print $rek_kod; ?>" title="<?php print $rek_tov_name; ?>"><?php print "$rek_tov_kod $rek_tov_make"; ?></a></h5>
				<a class="product_image" href="view.php?reklama=<?php print $rek_kod; ?>" title="<?php print $rek_tov_name; ?>"><img src="<?php print $rek_image1; ?>" alt="<?php print $rek_tov_name; ?>" style="max-height:160px; max-width:160px; "></a>
				<h5 style=" padding-top:5px;"><a class="product_link" href="view.php?reklama=<?php print $rek_kod; ?>" title="<?php print $rek_tov_name; ?>"><?php print $rek_tov_name_short; ?></a></h5>
				<span class="price"><?php print $rek_cena." ".$rek_valyuta_pref; ?></span>
				<a class="feat_btn" href="view.php?reklama=<?php print $rek_kod; ?>" title="Открыть"><span>Открыть</span></a>
                <?php if ($user_group==3) { ?>                <a class="button_red" href="reklama_edit.php?reklama=<?php print $rek_kod; ?>" title="Открыть">Ред.</a>

                <?php } ?>
			</li>

<?php
	$i+=1;
}
?>
		  </ul>
		<div class="clearblock"></div>
  </div>
</div>
</div>
