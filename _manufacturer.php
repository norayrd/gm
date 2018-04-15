		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span>Производители</div>
</div>
<!-- /Breadcrumb -->
<div id="noro_inner">
<h1>Производители<span class="category-product-count"></span></h1>
<p>Мы можем Вас предложить запчасти от перечисленных ниже производителей, и для Вашего удобства при поиске, отобрали наиболее повторяющеся наименования деталей.</p>
<?php
$tovmake=$_GET["tovmake"]-0;
if ($tovmake>0) $sql="select * from p_tov_make tm where tm.tov_make_kod=$tovmake order by tm.tov_make"; else $sql="select * from p_tov_make tm order by tm.tov_make";

$tm=mysql_query($sql) or die(mysql_error());
@$tm_n=mysql_numrows($tm);
$i=0;
while($i<$tm_n){
	$tm_tov_make_kod=mysql_result($tm,$i,"tov_make_kod");
	$tm_tov_make=mysql_result($tm,$i,"tov_make");

	if ($tovmake>0) {
		$sql="select distinct SUBSTRING_INDEX(p.tov_name,' ',2) tov_name from p_prices p where	p.tov_make_kod=$tm_tov_make_kod";
		$tb=mysql_query($sql) or die(mysql_error());
		@$tb_n=mysql_numrows($tb);
		$j=0;
		while($j<$tb_n){
			$tb_tov_name=mysql_result($tb,$j,"tov_name");
			if ($j==0) print "<p class='cat_desc bordercolor bgcolor' title='Запчасти $tm_tov_make'>Запчасти $tm_tov_make <br> ";
			if ($j>0) print ", ";
		?>
			<?php print $tb_tov_name; ?>, 
		<?php
			$j+=1;
		}
		if ($j>0) print "</p>";
	}else{ 
		$sql="select count( distinct SUBSTRING_INDEX(p.tov_name,' ',2)) count_ from p_prices p where	p.tov_make_kod=$tm_tov_make_kod group by p.tov_make_kod";
		$tb=mysql_query($sql) or die(mysql_error());
		@$tb_n=mysql_numrows($tb);
		$tb_count=0;
		if ($tb_n>0) $tb_count=mysql_result($tb,0,"count_");
		
    print "<p class='cat_desc bordercolor bgcolor'><a href='manufacturer.php?tovmake=$tm_tov_make_kod' title='Запчасти $tm_tov_make'>Запчасти $tm_tov_make ($tb_count)</a> </p>";
	}
		?>

<?php
	$i+=1;
}
?>

</div>