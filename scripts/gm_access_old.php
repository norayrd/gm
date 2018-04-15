<?php
	$username="root";
	$password="";
	$database="gm";
	$host="localhost";


	mysql_connect($host,$username,$password);
	@mysql_select_db($database) or die("Unable connect to database!");
        mysql_query ("set character_set_client='cp1251'");
        mysql_query ("set character_set_results='cp1251'");
        mysql_query ("set collation_connection='cp1251_general_ci'");
    
    //ищем папку сайта
    $host_=$_SERVER['HTTP_HOST'];
	//print $_SERVER['HTTP_USER_AGENT'];
    $sql="select s.folder_ from gm_sites s where (s.host_='".$host_."')or(s.host_='www.".$host_."')";
    $tb=mysql_query($sql) or trigger_error(mysql_error().$sql);;
    if ($row = mysql_fetch_assoc($tb)){
        $site_folder=mysql_real_escape_string($row['folder_']);
    }
    //задаем путь к скриптам движка
    //$scripts_folder="$host_/scripts"; 
    $scripts_folder="scripts"; 
     
    if(isset($_COOKIE["kod_"])) $kod_ok=1; else $kod_ok=0; 
	//ищем куки
	if ($kod_ok==1){
        //если есть, то проверяем на просроченность на серваке
        $sql="select current_timestamp - k.last_access_dt - 86400 time_ from gm_kod k where (k.kod_='".$_COOKIE["kod_"]."');";
        $tb=mysql_query($sql);
        $row = mysql_fetch_assoc($tb);
        if($row['time_']<=0) $kod_ok=1; else $kod_ok=0;
    }
    if ($kod_ok==0) setcookie("kod_",time(),time()+86400);
//--------------------------------------

    //создаем новый код, или обновляем время последнего обращения
	unset($user_id);
    if (isset($_POST['identification_login']) and isset($_POST['identification_password'])){
	    $sql="select u.user_id from gm_users u where (u.login_='".$_POST['identification_login']."')and(u.pass_='".$_POST['identification_password']."')";
		$tb=mysql_query($sql) or trigger_error(mysql_error().$sql);
		if ($row = mysql_fetch_assoc($tb)) $user_id=$row['user_id'];
        unset($_POST['identification_login']);               
        unset($_POST['identification_password']);
        if (!isset($user_id)) $user_id=0;
		mysql_query("insert into gm_kod (kod_, ip_, user_id,HTTP_USER_AGENT)values(".$_COOKIE["kod_"].",'".$_SERVER['REMOTE_ADDR']."',".$user_id.",'".$_SERVER['HTTP_USER_AGENT']."') ON DUPLICATE KEY UPDATE ip_='".$_SERVER['REMOTE_ADDR']."', user_id=$user_id,HTTP_USER_AGENT='".$_SERVER['HTTP_USER_AGENT']."';")  or trigger_error(mysql_error().$sql);
		//header("Location: #");
	}else{
		$sql="insert into gm_kod (kod_, ip_         ,HTTP_USER_AGENT)values(".$_COOKIE["kod_"].",'".$_SERVER['REMOTE_ADDR']."'             ,'".$_SERVER['HTTP_USER_AGENT']."') ON DUPLICATE KEY UPDATE ip_='".$_SERVER['REMOTE_ADDR']."',HTTP_USER_AGENT='".$_SERVER['HTTP_USER_AGENT']."';";
		print $sql;
	    mysql_query($sql)   or trigger_error(mysql_error().$sql);
		
	}
		

//инициируем 		
	$sql="select * from gm_kod k left join gm_users u on u.user_id=k.user_id where k.kod_='".$_COOKIE["kod_"]."'";
	$tb=mysql_query($sql) or trigger_error(mysql_error().$sql);
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
			$tb=mysql_query($sql) or trigger_error(mysql_error().$sql);
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
