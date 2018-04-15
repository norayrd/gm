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
<!-- script type="text/javascript" src="images/product0.js"></script -->
<!-- TinyMCE -->
<script type="text/javascript" src="scripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
</script>
<!-- /TinyMCE -->

<?php
$reklama_kod=$_GET["reklama"]-0;
//если нажали сохранить, то ...
if (isset($_POST['rek_save'])) {
	$rek_kod=$_POST['rek_kod']-0;
	$rek_ts=$_POST['rek_ts']-0;
	$rek_tov_kod=$_POST['rek_tov_kod']."";
	$rek_tov_make=$_POST['rek_tov_make']."";
	$rek_tov_name=$_POST['rek_tov_name']."";
	$rek_text_short=$_POST['rek_text_short']."";
	$rek_text_full=$_POST['rek_text_full']."";
	$rek_char=$_POST['rek_char']."";
	$rek_hide=$_POST['rek_hide']-0;
	$rek_typ=$_POST['rek_typ']-0;
	$rek_valyuta_kod=$_POST['rek_valyuta_kod']-0;
	$rek_cena=$_POST['rek_cena']-0;
	$rek_cena_old=$_POST['rek_cena_old']-0;

	$folder = 'pics/';
	unset($rek_img1_file);
	if(is_uploaded_file($_FILES['img1_file']['tmp_name'])){
		$imageinfo = getimagesize($_FILES['img1_file']['tmp_name']);
		if($imageinfo['mime'] == 'image/gif' || $imageinfo['mime'] == 'image/jpeg' || $imageinfo['mime'] == 'image/png') {
			$uploadedFile = $folder."pic_".time()."_".basename($_FILES['img1_file']['name']);
			if(move_uploaded_file($_FILES['img1_file']['tmp_name'],$uploadedFile)) {
				//echo "Файл загружен<br>";
				$rek_img1_file=$uploadedFile;
			}
		}
	}
	unset($rek_img2_file);
	if(is_uploaded_file($_FILES['img2_file']['tmp_name'])){
		$imageinfo = getimagesize($_FILES['img2_file']['tmp_name']);
		if($imageinfo['mime'] == 'image/gif' || $imageinfo['mime'] == 'image/jpeg' || $imageinfo['mime'] == 'image/png') {
			$uploadedFile = $folder."pic_".time()."_".basename($_FILES['img2_file']['name']);
			if(move_uploaded_file($_FILES['img2_file']['tmp_name'],$uploadedFile)) {
				//echo "Файл загружен<br>";
				$rek_img2_file=$uploadedFile;
			}
		}
	}
	unset($rek_img3_file);
	if(is_uploaded_file($_FILES['img3_file']['tmp_name'])){
		$imageinfo = getimagesize($_FILES['img3_file']['tmp_name']);
		if($imageinfo['mime'] == 'image/gif' || $imageinfo['mime'] == 'image/jpeg' || $imageinfo['mime'] == 'image/png') {
			$uploadedFile = $folder."pic_".time()."_".basename($_FILES['img3_file']['name']);
			if(move_uploaded_file($_FILES['img3_file']['tmp_name'],$uploadedFile)) {
				//echo "Файл загружен<br>";
				$rek_img3_file=$uploadedFile;
			}
		}
	}		

	$sql="update gm_reklama 
			set typ_=$rek_typ,
				tov_make_kod=get_tov_make_kod('$rek_tov_make'),
				tov_kod='$rek_tov_kod',
				tov_name='$rek_tov_name',
				cena_=$rek_cena,
				valyuta_kod=$rek_valyuta_kod,
				cena_old=$rek_cena_old,
				text_short='$rek_text_short',
				text_full='$rek_text_full',
				char_='$rek_char',
				hide_=$rek_hide";
	if (isset($rek_img1_file)) $sql=$sql.", image1_='$rek_img1_file'";
	if (isset($rek_img2_file)) $sql=$sql.", image2_='$rek_img2_file'";
	if (isset($rek_img3_file)) $sql=$sql.", image3_='$rek_img3_file'";
				
	$sql=$sql." where (reklama_kod=$rek_kod)and(ts_=$rek_ts)";
	mysql_query($sql);
}
if ($reklama_kod>0) {
	$sql="select rk.*, tm.tov_make, vl.pref_ from gm_reklama rk left join p_tov_make tm on rk.tov_make_kod=tm.tov_make_kod left join gm_valyuta_list vl on rk.valyuta_kod=vl.ISO_ where (rk.reklama_kod=$reklama_kod)";
	$tb=mysql_query($sql) or die(mysql_error());
	@$tb_n=mysql_numrows($tb);
	if ($tb_n>0) {
		$reklama_typ=mysql_result($tb,0,"typ_");
		$reklama_hide=mysql_result($tb,0,"hide_");		
		$reklama_tov_make=mysql_result($tb,0,"tov_make");
		$reklama_tov_kod=mysql_result($tb,0,"tov_kod");
		$reklama_tov_name=mysql_result($tb,0,"tov_name");
		$reklama_cena=number_format(mysql_result($tb,0,"cena_"),2,'.','');
		$reklama_valyuta_pref=mysql_result($tb,0,"pref_");
		$reklama_valyuta_kod=mysql_result($tb,0,"valyuta_kod");
		$reklama_pricesh_kod=mysql_result($tb,0,"pricesh_kod");
		$reklama_text_short=str_replace(chr(13), "<br>",mysql_result($tb,0,"text_short"));
		$reklama_text_full=str_replace(chr(13), "<br>",mysql_result($tb,0,"text_full"));
		$reklama_cena_old=number_format(mysql_result($tb,0,"cena_old"),2,'.','');
		$reklama_char=str_replace(chr(13), "<br>",mysql_result($tb,0,"char_"));
		$reklama_image1=mysql_result($tb,0,"image1_");
		$reklama_image2=mysql_result($tb,0,"image2_");
		$reklama_image3=mysql_result($tb,0,"image3_");
		$reklama_ts=mysql_result($tb,0,"ts_");
	?>

<!-- Breadcrumb -->
	<div class="breadcrumb bordercolor"><div class="breadcrumb_inner">
			<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><span class="navigation_end"><?php print $reklama_tov_name; ?></span>
	</div></div>
<!-- /Breadcrumb -->
<div id="noro_inner">
	<div id="center_column" class="center_column">
		<form method="post" action="reklama_edit.php?reklama=<?php print $reklama_kod; ?>" enctype="multipart/form-data">
			<div id="primary_block" class="clearfix">
				<div id="pb-right-column">
							<p class="text">
								<label for="rek_hide">Скрытый</label>
								<input type="checkbox" value="1" name="rek_hide" <? if ($reklama_hide==1) print "checked"; ?> />
							</p>
							<p class="text">
								<label for="rek_hide">Тип</label>
								<select name="rek_typ">
									<option value="0" <?php if ($reklama_typ==0) print "selected"; ?>>Акция</option>
									<option value="1" <?php if ($reklama_typ==1) print "selected"; ?>>Реклама</option>
								</select>
							</p>
							<input name="MAX_FILE_SIZE" value="10000000" type="hidden">
							<p class="text">
								<img src="<?php print $reklama_image1; ?>" height="80" width="80">
								<label for="img1_file">Рис.1</label><br />
								<input name="img1_file" id="img1_file" type="file">
							</p>
							<p class="text">
								<img id="thumb_2" src="<?php print $reklama_image2; ?>" height="80" width="80">
								<label for="img2_file">Рис.2</label><br />
								<input name="img2_file" id="img2_file" type="file">
							</p>
							<p class="text">
								<img id="thumb_3" src="<?php print $reklama_image3; ?>" height="80" width="80">
								<label for="img3_file">Рис.3</label><br />
								<input name="img3_file" id="img3_file" type="file">
							</p>
				</div>
				<div id="pb-left-column">
					<p class="text">
						Артикул <input type="text" name="rek_tov_kod" value="<?php print $reklama_tov_kod; ?>" /> 
						Бренд <input type="text" name="rek_tov_make" value="<?php print $reklama_tov_make; ?>" />
					</p>
                    <p>Наименование<br /><br /><h1><input name="rek_tov_name" type="text" value="<?php print $reklama_tov_name; ?>" style="font-size:20px; width:390px;"></h1></p>
					<div class="price bordercolor">
						<p class="pricecolor"> Розничная цена
						<input type="text" style="font-size:20px; width:80px " name="rek_cena" id="rek_cena" value="<?php print $reklama_cena; ?>" /> 
        		        <select style=" font-size:17px" name="rek_valyuta_kod" >
						<?php 
							$tb=mysql_query("select vc.valyuta_kod, vl.pref_ from gm_valyuta_cours vc left join gm_valyuta_list vl on vc.valyuta_kod=vl.ISO_");
							@$tb_n=mysql_numrows($tb);
							$i=0;
							while ($i<=$tb_n) {
								$valyuta_kod=mysql_result($tb,$i,"valyuta_kod");
								$valyuta_pref=mysql_result($tb,$i,"pref_");
							?>
								<option value="<?php print $valyuta_kod; ?>" <?php if ($valyuta_kod==$reklama_valyuta_kod) print "selected"; ?>><?php print $valyuta_pref; ?></option>
							<?php		
								$i+=1;
							}
							?>
						</select></p>
					</div>
					<p id="old_price"> Преждняя цена
						<span id="old_price_display">
							<input type="text" style="font-size:20px; width:80px" name="rek_cena_old" id="rek_cena_old" value="<?php print $reklama_cena_old; ?>" />
						</span>
					</p>
					<div id="short_description_block" class="bordercolor">
						<div id="short_description_content" class="rte align_justify"><p>
							Краткое описание
							<textarea style="width:390px; height:100px" name="rek_text_short"><?php print $reklama_text_short; ?></textarea>
						</p></div>
					</div>
					<div class="clearblock"></div>
				</div>
			</div>
			<div id="more_info_block" class="clear" style="width:700px">
				<ul id="more_info_tabs" class="idTabs idTabsShort">
					<li><a id="idTabb1" onclick="javascript: showTab('1');" class="selected">Подробная информация</a></li>			
				</ul>
        		
				<div id="more_info_sheets" class="bgcolor bordercolor">
					<div id="idTab1"><div><p><textarea name="rek_text_full" style=" width:655px; height:100px;"><?php print $reklama_text_full; ?></textarea></p></div></div>
				</div>
				<ul id="more_info_tabs" class="idTabs idTabsShort">			
					<li><a id="idTabb2" onclick="javascript: showTab('2');" class="selected">Характеристики</a></li>
				</ul>
				<div id="more_info_sheets" class="bgcolor bordercolor">
					<div id="idTab2" class="bullet">
						<textarea name="rek_char" style=" width:655px; height:100px;">
							<?php print $reklama_char; ?>
						</textarea>
					</div>
				</div>
			</div>
			<p class="hidden">
				<input type="hidden" name="rek_kod" value="<?php print $reklama_kod; ?>">
				<input type="hidden" name="rek_ts" value="<?php print $reklama_ts; ?>">
			</p>
			<p>
				<input class="button_red" type="submit" value="Сохранить" name="rek_save" />
				<input class="button" type="button" value="Назад" onclick="javascript: document.location='reklama_all.php';" />
			</p>
		</form>
	</div>
<?php 
	}
}
?>
</div>
