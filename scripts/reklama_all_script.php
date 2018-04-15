<?php
require_once "gm_access.php";
	if ($kod_!=$_GET["kod"]) exit;

	$reklama_kod=$_GET["reklama"];
	$reklama_ts=$_GET["ts"];
?>
	<?php
	//добавление в рекламу
	if (isset($_GET['add'])&&($_GET['add']==1)) {
		$prices_kod=$_GET["prices_kod"];
		$sql="call reklama_add_from_price($prices_kod)";
		$tb=mysql_query($sql);
		$sql="select @result_ result_, @result_kod result_kod";
		$tb=mysql_query($sql);
		$tb_n=mysql_numrows($tb);
		if ($tb_n>0){
			$tb_result=mysql_result($tb,0,"result_");
		    $tb_result_kod=mysql_result($tb,0,"result_kod");
		}
		if ($tb_result_kod==1) print "<font color='#FF0000' title='Ошибка: $tb_result'>!</font>";
		else print "<font title='ОК: $tb_result'>OK</font>";
	}
	?>
	<?php
	//скрытие/отображение рекламы
	if (isset($_GET["hide"])) {
		$reklama_hide=$_GET["hide"];
		$sql="update gm_reklama set hide_=$reklama_hide where (reklama_kod=$reklama_kod)and(ts_=$reklama_ts)";
		mysql_query($sql);
		if ($reklama_hide==0) { 
	?>
			<a class="button_red" title="Скрыть" onclick=" if (confirm('Скрыть из рекламы?')==true) $('#rek_hide_<?php print $reklama_kod; ?>').load('scripts/reklama_all_script.php?reklama=<?php print $reklama_kod; ?>&hide=1&ts=<?php print $reklama_ts; ?>&kod=<?php print $kod_; ?>'); else return 0; ">С</a>
		<?php 
		}else{ 
		?>
			<a class="button" title="Отобразить" onclick=" if (confirm('Отобразить в рекламе?')==true) $('#rek_hide_<?php print $reklama_kod; ?>').load('scripts/reklama_all_script.php?reklama=<?php print $reklama_kod; ?>&hide=0&ts=<?php print $reklama_ts; ?>&kod=<?php print $kod_; ?>'); else return 0; ">О</a>
		<?php 
		}
	}
	?>
	<?php
	//удаление рекламы
	if ((isset($_GET["delete"]))&&($_GET["delete"]==1)) {
		$sql="delete from gm_reklama where (reklama_kod=$reklama_kod)and(ts_=$reklama_ts)";
		mysql_query($sql);
	?>
    	<script type="text/javascript">
		$('#li_reklamablok_<?php print $reklama_kod; ?>').hide(1000);
		</script>
	<?php
	}
	?>
