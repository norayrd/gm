<?php
require_once "gm_access.php";
	if ($kod_!=$_GET["kod"]) exit;

	$prices_kod=$_GET["prices_kod"]-0;
    if ($prices_kod==0) exit;
?>
	<?php
	//добавление в рекламу
	if (isset($_GET['hide'])&&($_GET['hide']==1)) {
		$sql="update p_prices set hide_=1 where prices_kod=$prices_kod; ";
		$tb=mysql_query($sql);
		print "<font title='ОК: $tb_result'>OK</font>";
	}
	?>
