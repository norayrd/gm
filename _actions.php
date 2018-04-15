		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
        
<div id="tmspecials" class="block">
	<h4>
		АКЦИИ
		<a class="tmsp_prev"></a>
		<a class="tmsp_next"></a>
	</h4>
	<div class="block_content">
		<ul>
<?php
	//запоминаем номер
$sql="select r.*, tm.tov_make, vl.pref_, vc.cours_, cena_ * cours_ cena_uah from gm_reklama r left join gm_valyuta_list vl on r.valyuta_kod=vl.ISO_ left join p_tov_make tm on tm.tov_make_kod=r.tov_make_kod left join gm_valyuta_cours vc on r.valyuta_kod=vc.valyuta_kod where (hide_=0)and(typ_=0) order by order_ limit 6";
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
    $rek_valyuta_pref="грн."; //mysql_result($rek,$i,"pref_");
	$rek_image1=mysql_result($rek,$i,"image1_");
	$rek_image2=mysql_result($rek,$i,"image2_");
	$rek_image3=mysql_result($rek,$i,"image3_");
	$rel_pricesh_kod=mysql_result($rek,$i,"pricesh_kod");
	$rek_url=mysql_result($rek,$i,"url_");
	$rek_text_short=mysql_result($rek,$i,"text_short");
	$rek_text_full=mysql_result($rek,$i,"text_full");
	$rek_cena_old=number_format(mysql_result($rek,$i,"cena_old"),2,'.','');
	$rek_char=mysql_result($rek,$i,"char_");
?>
		<li>
			<a class="product_image" href="view.php?reklama=<?php print $rek_kod; ?>"><img src="<?php print $rek_image1; ?>" alt="<?php print $rek_tov_name; ?>" width="80"></a>
				<div>
					<h5><a class="product_link" href="view.php?reklama=<?php print $rek_kod; ?>" title="<?php print $rek_image2; ?>"><?php print $rek_tov_name_short; ?></a></h5>
					<span class="price"><?php print $rek_cena." ".$rek_valyuta_pref; ?></span>
					<?php if ($rek_cena_old>0) { ?> <span class="old_price"><?php print $rek_cena_old." ".$rek_valyuta_pref; ?></span> <?php } ?>
				</div>
			</li>

<?php
	$i+=1;
}
?>
						</ul>
	</div>
</div>