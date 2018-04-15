<?php 
	require_once "gm_access.php";
	$secure_kod=$_GET["kod_"]; 
	$email=$_GET["email"];
	if ($secure_kod==$kod_) {
		if ($email!="") {
			$sql="select count(*) cnt_ from gm_users u where (u.user_id<>$user_id)and(u.email_='$email');";
			$tb=mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_assoc($tb);
			$cnt_=$row['cnt_'];
			if ($cnt_>0) print "занят <input type='hidden' name='email_is_free' id='email_is_free' value='0'>"; else print "свободен <input type='hidden' name='email_is_free' id='email_is_free' value='1'>";
		}else print "<input type='hidden' name='email_is_free' id='email_is_free' value='0'>";
	}
?>
