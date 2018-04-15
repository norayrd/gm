		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<?php
require_once "scripts/gm_access.php";
// crosesh_kod обязательно должна присутствовать на этой странице (>0)
$crosesh_kod=$_GET["crosesh"]-0;
if ($user_group<3) {
	//print "Доступ запрещен!";
	include "_autentication.php";
} else if ($crosesh_kod<=0) {
	print "Неверный id кроса!";
} else {
?>
	<!-- Breadcrumb -->
	<div class="breadcrumb bordercolor"><div class="breadcrumb_inner">
		<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span>Крос
	</div></div>
	<!-- /Breadcrumb -->
	<div id="noro_inner">
		<?php
		if ($crosesh_kod>0) {
			$sql="select * from 1p_crosesh ph where crosesh_kod=$crosesh_kod";
			$tb=mysql_query($sql) or die(mysql_error());
			@$tb_n=mysql_numrows($tb);
			if ($tb_n>0) {
				$crosesh_name=mysql_result($tb,0,"name_");
				$crosesh_update_date=mysql_result($tb,0,"update_date");
				$crosesh_hide=mysql_result($tb,0,"hide_");
				$crosesh_destination=mysql_result($tb,0,"destination_");		
			}
		}
		?>
		<h1>Крос: <?php print $crosesh_name ?><span class="category-product-count">Дата обновления: <?php print $crosesh_update_date ?></span></h1>
		<form method="post" action="cros_save.php?crosesh=<?php if ($crosesh_destination>0) print $crosesh_destination; else print $crosesh_kod; ?>" >
			<p class="cat_desc bordercolor bgcolor">
				Название: <input name="cros_name" type="text" value="<?php print $crosesh_name ?>" style=" width:200px; position:absolute; left:120px;" /> <br><br>
				Скрыть: <input name="cros_hide" type="checkbox" value="1" <?php if ($crosesh_hide==1) print "checked"; ?> style=" position:absolute; left:220px;" />
			</p>
			<br>
			<input type="submit" value="Сохранить" name="cros_save" class="<?php if ($crosesh_destination>0) print "button_red"; else print "button"; ?>" />
			<input type="hidden" name="cros_source" value="<?php print $crosesh_kod; ?>">
			<input type="button" value="Назад к кросам" class="button" onclick="javascript: document.location='croses.php';" />
		</form>
    
		<!-- Sort products -->
		<div class="product_sort">      
			<input type="hidden" name="cros_source" value="<?php print $crosesh_kod; ?>" />
			<table width="100%" bordercolor="#2a2f33">
			<tr>
				<td width="100%" align="center">
					<div id="tb_head"></div>
				</td>
			</tr>
			<tr>
				<td height="5px"></td>
			</tr>
			<tr>
				<td>

					<table id="search_res" width="100%" class="noro_table" >
					<thead>
					<tr>
						<th width="35px">№</th>
                        <th>Бренд1</th>
                        <th>Код1</th>
                        <th>Бренд2</th>
                        <th>Код2</th>
					</tr>
					</thead>
					<tbody>
					<?php
					//запоминаем номер
					if ($crosesh_kod>0) {
						$limit_start=$_GET["start"];
						$limit_length=$_GET["length"];
						if (isset($limit_start)) {
							if (!($limit_start>=0)) $limit_start=0;
						}else $limit_start=0; 
						if (isset($limit_length)) {
							if ($limit_length>100) $limit_length=100;
							if ($limit_length<0) $limit_length=0;
						}else $limit_length=100;
						//выводим содержание прайса/склада
						$sql="select croses_id, tov_kod1, tov_kod2, crosesh_kod, tm1.tov_make tov_make1, tm2.tov_make tov_make2 from 1p_croses p left join p_tov_make tm1 on tm1.tov_make_kod=p.tov_make1  left join p_tov_make tm2 on tm2.tov_make_kod=p.tov_make2 where p.crosesh_kod=$crosesh_kod limit $limit_start, $limit_length";
						$tb=mysql_query($sql) or die(mysql_error());
						@$tb_n=mysql_numrows($tb);
						$i=0;
						while($i<$tb_n){
                            $tb_tov_make1=mysql_result($tb,$i,"tov_make1");
                            $tb_tov_kod1=mysql_result($tb,$i,"tov_kod1");
                            $tb_tov_make2=mysql_result($tb,$i,"tov_make2");
                            $tb_tov_kod2=mysql_result($tb,$i,"tov_kod2");
					?>
						<tr class="<?php if (($i % 2)==0) print "even"; else print "odd"; ?>">
							<td style="font-size:9px" align="center"><?php print $i +1 + $limit_start; ?></td>
                            <td><?php print $tb_tov_make1; ?></td>
                            <td><?php print $tb_tov_kod1; ?></td>
                            <td><?php print $tb_tov_make2; ?></td>
                            <td><?php print $tb_tov_kod2; ?></td>
						</tr>
					<?php
							$i++;
						}
					}
					?>
					</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td height="5px"></td>
			</tr>
			<tr>
				<td align="center">
					<div id="tb_foot">
						<a href="<?php print "cros.php?crosesh=$crosesh_kod&start=0&length=$limit_length"; ?>" class="button_mini" title="К началу"> << </a>
						<?php
						$sql="select count(*) count_ from 1p_croses p where p.crosesh_kod=$crosesh_kod";
						$tb=mysql_query($sql) or die(mysql_error());
						@$tb_n=mysql_numrows($tb);
						if ($tb_n>0) $tb_n=mysql_result($tb,0,"count_");
						$i=0;
						while(($i*$limit_length)<$tb_n){
						?>                
							<a href="<?php print "cros.php?crosesh=$crosesh_kod&start=".($i*$limit_length)."&length=$limit_length"; ?>" class="<?php if ( (($limit_start/100)>=$i)&&(($limit_start/100)<($i+1))) print "button_red"; else print "button_mini"; ?>"><?php print $i+1; ?></a>
						<?php
							$i+=1;
						}
						?>
						<a href="<?php print "cros.php?crosesh=$crosesh_kod&start=".(($i-1)*$limit_length)."&length=$limit_length"; ?>" class="button_mini" title="В конец"> >> </a>
					</div>
					<script type="text/javascript">
						document.getElementById('tb_head').innerHTML =document.getElementById('tb_foot').innerHTML;
					</script>
				</td>
			</tr>
			</table>
		</div>
	</div>
<?php
}
?>