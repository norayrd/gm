		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
require_once "scripts/gm_access.php";
$pricesh_kod=$_GET["crosesh"];
// проверка безопасности
if ($user_group<3) {
	//print "Доступ запрещен!";
	include "_autentication.php";
} else {
?>
	<div id="noro_inner">
		<div id="authentication">
			<div id="center_column" class="center_column">
				<!-- Breadcrumb -->
				<div class="breadcrumb bordercolor"><div class="breadcrumb_inner">
					<a href="index.php" title="На главную">Главная</a>
					<span class="navigation-pipe">&gt;</span>
					<span class="navigation_page">Управление кросами</span>
				</div></div>
				<!-- /Breadcrumb -->
				<h1>Управление кросами</h1>
				<h4>Добавление, изменение и удаление кросов.</h4>
                <br>
                <div>
                    <a onclick="javascript: showCrosAddDialog(0,'','','',980,'1.5',0,1);" title="Добавить новый крос" class="button_large">Добавить новый крос</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="download/cros_blank.xls" class="button_disabled">бланк кроса</a>
                </div><br>
                <script type="text/javascript">
                    function showCrosAddDialog(crosesh_kod,crosesh_name,crosesh_update_date,crosesh_hide){
                        $('#cros_destination').val(crosesh_kod);
                        $('#cros_name').val(crosesh_name);
                        document.getElementById('cros_hide').checked=(crosesh_hide==1);
                        $('#cros_update_date').val(crosesh_update_date);
                        $('#price_dialog_inner').position().left=($('#price_dialog').width() - $('#price_dialog_inner').width());
                        $('#price_dialog_inner').position().top=($('#price_dialog').height() - $('#price_dialog_inner').height());
                        $('#price_dialog').show(100);                 
                        window.scrollTo($('#price_dialog_inner').position().left,$('#price_dialog_inner').position().top);
                    }
                </script>

				<ul id="my_account_links">
				<?php
				$sql_="select crh.crosesh_kod,crh.name_,crh.created_,crh.update_date,crh.hide_ from 1p_crosesh crh where crh.temp_<>1 order by 1";
				$tb=mysql_query($sql_);
				@$tb_n=mysql_numrows($tb);
				$i=0;
				while ($i<$tb_n){
					$crosesh_kod          =mysql_result($tb,$i,"crosesh_kod");
					$crosesh_name         =mysql_result($tb,$i,"name_");
                    $crosesh_created      =mysql_result($tb,$i,"created_");
                    $crosesh_update_date  =mysql_result($tb,$i,"update_date");
					$crosesh_hide         =mysql_result($tb,$i,"hide_");
				?>
					<li class="cat_desc bordercolor bgcolor">
                    <div style="color: #999; position: relative; left: 10px; top: 0px; width: 250px; height: 30px; "><a href="cros.php?crosesh=<?php print $crosesh_kod; ?>" title="<?php print $crosesh_name; ?>"><img src="images/order.png" alt="<?php print $crosesh_name; ?>" class="icon"> <?php print $crosesh_name; ?></a>&nbsp;
                    <a onclick="showCrosAddDialog(<?php print "$crosesh_kod, '$crosesh_name', '$crosesh_update_date', $crosesh_hide"; ?>)" class="button">Обновить</a>&nbsp;
                    <a href="<?php print "cros_save.php?delete=1&crosesh=$crosesh_kod"; ?>" onclick="javascript: return confirm('Удалить крос?');" class="button_delete">x</a></div> 
                    <div style="color: #999; position:relative; left: 300px; top: -30px; width: 300px; height: 30px; "><?php print " обновлен: $crosesh_update_date;"; if ($crosesh_hide) print " Скрытый"; ?></div></li>
				<?php 
					$i+=1;
				} 
				?>
				</ul>
				<div id="price_dialog" class="hidden" style=" background-color:#a09d9d; position:absolute; left:0px; top:0px; width:100%; height:100%; z-index:10001; opacity:0.90;">
					<div id="price_dialog_inner" style="position: absolute; left:300px; top:150px; padding:20px 20px 20px 20px; background-color:#BBBBBB; width:350px">
						<form method="post" action="cros_from_csv.php" enctype="multipart/form-data">
							<p><label for="cros_name">Название </label>
								<input type="text" id="cros_name" name="cros_name" style="position:absolute; left:250px;">
							</p>
							<p><label for="cros_update_date">Дата обновления </label>
								<input type="date" id="cros_update_date" name="cros_update_date" disabled="disabled" value="12.11.2012" style="position:absolute; left:250px;">
							</p>
							<p><label for="cros_hide">Скрыть </label>
								<input type="checkbox" id="cros_hide" name="cros_hide" value="1" checked="checked" style="position:absolute; left:250px;">
							</p>
							<p class="text">
								<label for="cros_file">Файл кросов (csv) </label>
								<input name="MAX_FILE_SIZE" value="10000000" type="hidden">
								<input name="cros_file" id="cros_file" type="file">
							</p>
							<p align="center">
								<input name="cros_destination" id="cros_destination" value="0" type="hidden"/>
								<input type="submit" value="Создать/Обновить" class="button" name="upload"/>&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="reset" value="Отменить" class="button" onclick="javascript: $('#price_dialog').hide(100); "/>
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>