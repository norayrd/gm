<?php
	$username="root";
	$password="";
	$database="avtotim";
	$host="localhost";

	/* $username="bigmar_gm";
	$password="dng1201197";
	$database="bigmar_gm";
	$host="db13.freehost.com.ua"; */

	mysql_connect($host,$username,$password);
	@mysql_select_db($database) or die("Unable connect to database!");
        mysql_query ("set character_set_client='cp1251'");
        mysql_query ("set character_set_results='cp1251'");
        mysql_query ("set collation_connection='cp1251_general_ci'");
    
    //ищем папку сайта
    $host_=$_SERVER['HTTP_HOST'];
	//print $_SERVER['HTTP_USER_AGENT'];
    $sql="select s.folder_, s.site_name, s.keywords_, s.site_kod from gm_sites s where (s.host_='".$host_."')or(s.host_='www.".$host_."')";
    $tb=mysql_query($sql);
    if ($row = mysql_fetch_assoc($tb)){
        $site_folder=mysql_real_escape_string($row['folder_']);
        $site_name=mysql_real_escape_string($row['site_name']);
        $site_keywords=mysql_real_escape_string($row['keywords_']);
        $site_kod=mysql_real_escape_string($row['site_kod']);
    }
    //задаем путь к скриптам движка
    //$scripts_folder="$host_/scripts"; 
    $scripts_folder="scripts"; 
    
	$kod_=$_COOKIE["kod_"];
    if(isset($kod_)) {
        $kod_ok=1; 
	}else{ 
	    $kod_ok=0; 
    }
	//ищем куки
	if (isset($kod_)){
        //если есть, то проверяем на просроченность на серваке
        $sql="select current_timestamp - k.last_access_dt - 86400 time_ from gm_kod k where (k.kod_='$kod_');";
        $tb=mysql_query($sql);
        $row = mysql_fetch_assoc($tb);
        if(!($row['time_']<=0)) unset($kod_);
    }
    if (!isset($kod_)) {
		$kod_=time();
	    setcookie("kod_",$kod_,$kod_+86400);
	}
	
//--------------------------------------

    //создаем новый код, или обновляем время последнего обращения
	unset($user_id);
    if (isset($_POST['SubmitLogin']) and isset($_POST['email']) and isset($_POST['passwd'])){
	    $sql="select u.user_id from gm_users u where (u.email_='".$_POST['email']."')and(u.pass_='".$_POST['passwd']."')";
		$tb=mysql_query($sql);
		if ($row = mysql_fetch_assoc($tb)) $user_id=$row['user_id'];
        unset($_POST['email']);               
        unset($_POST['passwd']);
        unset($_POST['SubmitLogin']);
        if (!isset($user_id)) $user_id=0;
		mysql_query("insert into gm_kod (kod_, ip_, user_id,HTTP_USER_AGENT, create_dt, last_access_dt)values('$kod_','".$_SERVER['REMOTE_ADDR']."',".$user_id.",'".$_SERVER['HTTP_USER_AGENT']."',current_timestamp,current_timestamp) ON DUPLICATE KEY UPDATE ip_='".$_SERVER['REMOTE_ADDR']."', user_id=$user_id,HTTP_USER_AGENT='".$_SERVER['HTTP_USER_AGENT']."',last_access_dt=current_timestamp;");
		//header("Location: #");
	}else{
		$sql="insert into gm_kod (kod_, ip_         ,HTTP_USER_AGENT,create_dt, last_access_dt)values('$kod_','".$_SERVER['REMOTE_ADDR']."'             ,'".$_SERVER['HTTP_USER_AGENT']."',current_timestamp,current_timestamp) ON DUPLICATE KEY UPDATE ip_='".$_SERVER['REMOTE_ADDR']."',HTTP_USER_AGENT='".$_SERVER['HTTP_USER_AGENT']."',last_access_dt=current_timestamp;";
	    mysql_query($sql);
		
	}
		

//инициируем 		
	$sql="select * from gm_kod k left join gm_users u on u.user_id=k.user_id where k.kod_='$kod_'";
	$tb=mysql_query($sql);
	if ($row = mysql_fetch_assoc($tb)){
		$user_id=mysql_real_escape_string($row['user_id']);
		$user_name_first=mysql_real_escape_string($row['name_first']);
	}
	//print $_COOKIE["kod_"];
	/*
	// < < ОБРАБАТЫВАЕМ ФОРМЫ > >
	if (isset($_POST['form_id'])) {
		
		//если введены логин/пароль, то авторизуем
		if ($_POST['form_id']="login"){
			$sql="select u.user_id from gm_users u where (u.login_='".$_POST['lgn_']."')and(u.pass_='".$_POST['psw_']."')";
			$tb=mysql_query($sql);
			if ($row = mysql_fetch_assoc($tb)){
				$user_id=mysql_real_escape_string($row['user_id']);
				$sql="insert into gm_kod (kod_, create_dt, ip_, user_id)values(".$_COOKIE["kod_"].",current_timestamp,'".$_SERVER['REMOTE_ADDR']."',".$user_id.") ON DUPLICATE KEY UPDATE ip_='".$_SERVER['REMOTE_ADDR']."', user_id=".$user_id.";";
				$tb=mysql_query($sql);
			}
			//header("Location: #");
		}
		
		
	}
    */
//  print $_POST['identification_login'].'<br>';
//  print $_COOKIE["kod_"]."<br>";
//  print '$kod_ok='.$kod_ok.'<br>'.$sql.'<br>';
//  print $row['time_'];   
?>
