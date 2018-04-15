<?php
if (isset($_GET["reklama"])) $reklama_kod=$_GET["reklama"]-0;
if ($reklama_kod>0) {
	if (isset($_GET["delete"])) { //изменение рекламы
		$rek_kod=$_GET["rek_kod"];
		$rek_typ=$_GET["rek_typ"];
		$rek_tov_make=$_GET["rek_tov_make"];
		$rek_tov_kod=$_GET["rek_tov_kod"];
		$rek_tov_name=$_GET["rek_tov_name"];
		$rek_cena=$_GET["rek_cena"];
		$rek_valyuta_kod=$_GET["rek_valyuta_kod"];
		$rek_order=$_GET["rek_order"];
		$rek_pricesh_kod=$_GET["rek_pricesh_kod"];
		$rek_text_short=$_GET["rek_text_short"];
		$rek_text_full=$_GET["rek_text_full"];
		$rek_cena_old=$_GET["rek_cena_old"];
		$rek_char=$_GET["rek_char"];
		$rek_image1=$_GET["rek_image1"];
		$rek_image2=$_GET["rek_image2"];
		$rek_image3=$_GET["rek_image3"];
		$rek_url=$_GET["rek_url"];
		$rek_hide=$_GET["rek_hide"];
	} else if (isset($_GET["delete"])) { //удаление из рекламы
		mysql_query("delete from gm_reklama where reklama_kod=$reklama_kod");
	}
}
?>

		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
       
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
	<h4 class="wrapfirstword">Предлагаемая продукция</h4>
		<div class="block_content">
		<ul>
<?php
	//запоминаем номер
$sql="select * from gm_reklama r left join gm_valyuta_list vl on r.valyuta_kod=vl.ISO_ left join p_tov_make tm on tm.tov_make_kod=r.tov_make_kod where (hide_=0)and(typ_=1) order by order_ limit 6";
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
				<a class="product_image" href="<?php print $rek_url; ?>" title="<?php print $rek_tov_name; ?>"><img src="<?php print $rek_image1; ?>" alt="<?php print $rek_tov_name; ?>"></a>
				<h5><a class="product_link" href="<?php print $rek_url; ?>" title="<?php print $rek_tov_name; ?>"><?php print $rek_tov_name_short; ?></a></h5>
				<span class="price"><?php print $rek_cena." ".$rek_valyuta_pref; ?></span>
				<a class="feat_btn" href="<?php print $rek_url; ?>" title="Открыть"><span>Открыть</span></a>
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