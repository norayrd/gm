<?php
    include "gm_access.php";
    //if (isset($_GET["kod_"]))
	//if ($_GET["kod_"]<>""){
		//$kod_=$_GET["kod_"];
		if (isset($_GET["prices_kod"])){
            $sql_="call gm_recicle_add('$kod_', ".$_GET["prices_kod"].");";
			mysql_query($sql_) or trigger_error(mysql_error().$sql);
		}
		$sql_="select count(*) pozicii_, ifnull(sum(r.cena_ * r.valyuta_cours),0) summa_ from gm_rashod r left join gm_kod k on k.kod_=$kod_ where (r.kod_='$kod_')or((r.user_id=k.user_id)and(k.user_id>0))";
		$tb=mysql_query($sql_);
		@$tb_n=mysql_numrows($tb);
        if ($tb_n>0){
            $pozicii_=mysql_result($tb,0,"pozicii_");
            $summa_=number_format(mysql_result($tb,0,"summa_"),2,".","");
        }else{
            $pozicii_=0;
            $summa_=0;
        }
?>



<link href="gm_recicle_mini.css" rel="stylesheet" type="text/css" />
<link href="scripts/gm_recicle_mini.css" rel="stylesheet" type="text/css" />
<link href="<?php print $site_folder; ?>/scripts/gm_recicle_mini.css" rel="stylesheet" type="text/css" />

<!-- table cellspacing="0" bgcolor="#9999FF" style="border-bottom-color:#FF0000; border-bottom-style:solid; border-top-color:#FF0000; border-top-style:solid; border-left-color:#FF0000; border-left-style:solid; border-right-color:#FF0000; border-right-style:solid;" -->
<table cellspacing="0" bgcolor="#FFFFFF" >
<tr>
    <td><a href="recicle.php?kod=<?php print $_COOKIE["kod_"] ?>" id="recicle_mini_name"><font color="#FF0000">Ваша корзина</font> <img src="../images/shopping-basket.png" /></a></td>
</tr>
<tr>
    <td height="1" bgcolor="#FF0000"></td>
</tr>
<tr>
    <td>
<label id="recicle_mini_txt1">Позиций:<?php print $pozicii_; ?></label>
        <label id="recicle_mini_txt2"><br>Всего: <?php print $summa_; ?> грн.</label>
    </td>
</tr>
</table>

<script type="text/javascript" src="gm_recicle_mini.js"></script>
<script type="text/javascript" src="scripts/gm_recicle_mini.js"></script>
<script type="text/javascript" src="<?php print $site_folder; ?>/scripts/gm_recicle_mini.js"></script>
		
<?php		
	//}
?>
