<?php
	include("scripts/gm_access.php");
//	$sql="delete from tb_capcha where 1";
//	mysql_query($sql);
	$i=0;
	while ($i<100){
		$new_capcha=chr(97+rand('0','25')).chr(97+rand('0','25')).chr(97+rand('0','25')).chr(97+rand('0','25'));
		$sql="select count(*) gm_capcha where capcha_='$new_capcha')";
		if (mysql_query($sql) == 0) {
			$sql="insert into gm_capcha (capcha_) values ('".$new_capcha."')";
			mysql_query($sql);
			$i++;
		}
	}

	$sql="select count(*) count_ from gm_capcha";
	$tbCapcha=mysql_query($sql);
	$tbCapcha_Count=mysql_result($tbCapcha,0,"count_");
	$tbCapcha_Count=$tbCapcha_Count-100;
	if ($tbCapcha_Count>=100) {
		$sql="delete from gm_capcha limit $tbCapcha_Count ";
		mysql_query($sql);
	}

	//print "<script language=javascript> window.location='index.php?page_=book_admin.php'; </script>";
?>