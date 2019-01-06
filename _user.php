        <link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
if ($user_group<1) {
    include "_autentication.php";
}else{
?>
<?php  
    if (isset($_POST['SubmitAccount'])) {
            $par_cuser_id=$_POST['cuser_id']-0;
            $par_cuser_name_first=$_POST['customer_firstname'].'';
            $par_cuser_name_last=$_POST['customer_lastname'].'';
            $par_cuser_name_middle=$_POST['customer_middlename'].'';
            $par_cuser_name_full = $par_cuser_name_last." ".$par_cuser_name_first." ".$par_cuser_name_middle;
            $par_cuser_group_id=$_POST['group_id']-0;
            $par_cuser_sex=$_POST['id_gender']-0;
            $par_cuser_avto_vin=$_POST['avto_vin'].'';
            $par_cuser_avto_marka=$_POST['avto_marka'].'';
            $par_cuser_avto_model=$_POST['avto_model'].'';
            $par_cuser_avto_year=$_POST['avto_year'].'';
            $par_cuser_email=$_POST['email'].'';
            $par_cuser_birth_day=$_POST['days'];
            $par_cuser_birth_months=$_POST['months'];
            $par_cuser_birth_year=$_POST['years'];
            if (checkdate($par_cuser_birth_months,$par_cuser_birth_day,$par_cuser_birth_year)) 
                $par_cuser_birth_date=$par_cuser_birth_day.'.'.$par_cuser_birth_months.'.'.$par_cuser_birth_year;
                else $par_cuser_birth_date="null";
            $par_cuser_ts=$_POST['ts']-0;
            if ($par_cuser_id>0) {
                $sql_="update gm_users set name_first='$par_cuser_name_first',
                                           name_last='$par_cuser_name_last',
                                           name_middle='$par_cuser_name_middle',
                                           name_full='$par_cuser_name_full',
                                           group_id=$par_cuser_group_id,
                                           sex_=$par_cuser_sex,
                                           avto_vin='$par_cuser_avto_vin',
                                           avto_marka='$par_cuser_avto_marka',
                                           avto_model='$par_cuser_avto_model',
                                           avto_year='$par_cuser_avto_year',
                                           email_='$par_cuser_email',
                                           birth_date='$par_cuser_birth_date' 
                    where (user_id=$par_cuser_id)and(ts_=$par_cuser_ts); ";
                mysql_query($sql_);
                if (isset($_POST['nextpage'])) print "<script> location.replace('".$_POST['nextpage']."'); </script>";
            } else {
                //$sql_="insert into gm_faces ()values(); ";
            }
    }
    if (isset($_POST['SubmitAccess'])) {
            $par_cuser_id=$_POST['cuser_id']-0;
            $par_cuser_group_id=$_POST['group_status']-0;
            $par_cuser_ts=$_POST['ts']-0;
            $par_cuser_view_id=$_POST['view_status']-0;
            $par_cuser_discont_id=$_POST['discont_status']-0;
            $par_cuser_city_id=$_POST['city_id']-0;
            if ($user_group>2) {
                $sql_="update gm_users set group_id=$par_cuser_group_id,
                                           view_id=$par_cuser_view_id,
                                           discont_id=$par_cuser_discont_id,
                                           city_id=$par_cuser_city_id
                    where (user_id=$par_cuser_id)and(ts_=$par_cuser_ts); ";
                mysql_query($sql_);
                if (isset($_POST['nextpage'])) print "<script> location.replace('".$_POST['nextpage']."'); </script>";
            } 
    }
?>
<?php 
    if (isset($_GET['user_id']) && isset($_GET['ts'])) {
        $cuser_id=$_GET['user_id']-0;
        $cuser_ts=$_GET['ts']-0;
        $cuser_nextpage=$_GET['nextpage'];
    }
    if (isset($_POST['user_id']) && isset($_POST['ts'])) {
        $cuser_id=$_POST['user_id']-0;
        $cuser_ts=$_POST['ts']-0;
        $cuser_nextpage=$_POST['nextpage'];
    }
    if ($cuser_id>0) {
        $sql_="select * from gm_users u where (user_id=$cuser_id)and(ts_=$cuser_ts)";
        $tb=mysql_query($sql_);
        if (@mysql_numrows($tb)>0) {
            $cuser_login=mysql_result($tb,0,"login_");            
            $cuser_pass=mysql_result($tb,0,"pass_");            
            $cuser_ip=mysql_result($tb,0,"ip_");            
            $cuser_name_first=mysql_result($tb,0,"name_first");            
            $cuser_name_last=mysql_result($tb,0,"name_last");            
            $cuser_name_middle=mysql_result($tb,0,"name_middle");            
            $cuser_last_access=mysql_result($tb,0,"last_access");            
            $cuser_group_id=mysql_result($tb,0,"group_id");            
            $cuser_directory=mysql_result($tb,0,"directory_");            
            $cuser_sex=mysql_result($tb,0,"sex_");            
            $cuser_avto_vin=mysql_result($tb,0,"avto_vin");            
            $cuser_avto_marka=mysql_result($tb,0,"avto_marka");            
            $cuser_avto_model=mysql_result($tb,0,"avto_model");            
            $cuser_avto_year=mysql_result($tb,0,"avto_year");            
            $cuser_email=mysql_result($tb,0,"email_");            
            $cuser_activated=mysql_result($tb,0,"activated_");            
            $cuser_created=mysql_result($tb,0,"created_");            
            $cuser_name_full=mysql_result($tb,0,"name_full");
            $cuser_birth_date=mysql_result($tb,0,"birth_date");
            $cuser_birth_d=getdate(StrToTime($cuser_birth_date));
            $cuser_birth_day=$cuser_birth_d[mday];
            $cuser_birth_month=$cuser_birth_d[mon];
            $cuser_birth_year=$cuser_birth_d[year];
            $cuser_view_id=mysql_result($tb,0,"view_id");
            $cuser_discont_id=mysql_result($tb,0,"discont_id");
            $cuser_city_id=mysql_result($tb,0,"city_id")-0;
        }
    }
?>
    <!-- Breadcrumb -->
    <div class="breadcrumb bordercolor">
    <div class="breadcrumb_inner">
        <a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><a href="authentication.php">Учетная запись</a><span class="navigation-pipe">&gt;</span>Настройки пользователя
    </div>
    </div>
    <!-- /Breadcrumb -->
<div id="noro_inner">
    <div id="authentication">
        <div id="center_column" class="center_column">
            <h1>Настройки пользователя</h1>
            <form class="std" action="user.php" method="post">
                <?php 
                    include "_registration_user.php";
                    //include "_registration_avto.php";
                ?>
                <p class="required required_desc"><span><sup>*</sup>Обязательные поля</span></p>
                    <script type="text/javascript">
                        function check_registration(){
                            $("#error_text").contents().remove();
                            s='';
                            if ($('#customer_firstname').val()=='') s=s+"<li>Имя</li>"; 
                            if ($('#customer_lastname').val()=='') s=s+"<li>Фамилия</li>";
                            if ($('#email').val()=='') s=s+"<li>email</li>";
                            else if (($('#email').val().indexOf('@')<=0)||
                                ($('#email').val().indexOf('@')>=($('#email').val().length-3))||
                                ($('#email').val().indexOf('.')==-1)) s=s+"<li>Некорректный email</li>"; 
                            else if ($('#email_is_free').val()==0) s=s+"<li>email занят</li>";
                            if ($('#passwd').val()=='') s=s+"<li>Пароль</li>";
                            if (s!='') {
                                $("#error_text").append("<p>Вы не заполнили следующие поля:</p><ol>"+s+"</ol>");
                                $("#error_text").show();
                                return false;
                            }else{
                                $("#error_text").hide();
                                return true;
                            }
                        }
                    </script>
                    <div id="error_text"></div>
                    <p class="submit">    
                        <input name="SubmitAccount" id="SubmitAccount" value="Сохранить/Далее" class="exclusive" type="submit" onclick="javascript:return check_registration();" >
                        <a href="<?php print $cuser_nextpage; ?>" class="button_red" >Назад/Отмена</a>
                        <input name="cuser_id" id="cuser_id" value="<?php print $cuser_id; ?>" class="exclusive" type="hidden" >
                        <input name="ts" id="ts" value="<?php print $cuser_ts; ?>" class="exclusive" type="hidden" >
                        <input name="activated" id="activated" value="<?php print $cuser_activated; ?>" class="exclusive" type="hidden" >
                        <input name="group_id" id="group_id" value="<?php print $cuser_group_id; ?>" class="exclusive" type="hidden" >
                        <input name="nextpage" id="nextpage" class="exclusive" type="hidden" value="<?php print $cuser_nextpage; ?>">
                    </p>
            </form>
            <?php if ($user_group>2) { ?>
                <h1>Доступ</h1>
                    <form class="std" action="user.php" method="post">
                    <p>
                        <label for="view_status">Уровень клиента</label>
                            <select name="view_status" id="view_status">
                            <?php
                                $sql= "select view_id, name_ from gm_view v; ";
                                $view=mysql_query($sql) or die(mysql_error());
                                @$view_n=mysql_numrows($view);
                                $i=0;
                                while($i<$view_n){
                                    $view_id=mysql_result($view,$i,"view_id");
                                    $view_name=mysql_result($view,$i,"name_");
                            ?>
                                <option value="<?php print $view_id; ?>" <?php if ($view_id==$cuser_view_id) print "selected"; ?>><?php print $view_name; ?></option>
                            <?php
                                    $i+=1;
                                }
                            ?>
                            </select>
                    </p>
                    <p>
                        <label for="discont_status">Скидка</label>
                            <select name="discont_status" id="discont_status">
                            <?php
                                $sql= "select discont_id, name_ from gm_discont; ";
                                $discont=mysql_query($sql) or die(mysql_error());
                                @$discont_n=mysql_numrows($discont);
                                $i=0;
                                while($i<$discont_n){
                                    $discont_id=mysql_result($discont,$i,"discont_id");
                                    $discont_name=mysql_result($discont,$i,"name_");
                            ?>
                                <option value="<?php print $discont_id; ?>" <?php if ($discont_id==$cuser_discont_id) print "selected"; ?>><?php print $discont_name; ?></option>
                            <?php
                                    $i+=1;
                                }
                            ?>
                            </select>
                    </p>
                    <p>
                        <label for="city_id">Регион:</label> <select name="city_id" id="city_id" >
                            <option <?php if ($cuser_city_id=="0") print "selected"; ?> value="">-</option>
                            <option <?php if ($cuser_city_id==-1) print "selected"; ?> value="-1">* Иной город (1-2 дня)</option>
                            <option <?php if ($cuser_city_id==-2) print "selected"; ?> value="-2">* Иная страна (10-14 дней)</option>
                            <?php
                                $sql="select c.city_id, c.name_ru c_name_ru, r.region_id, r.name_ru r_name_ru from gm_city c left join gm_region r on r.region_id=c.region_id where r.country_id=2 order by r.name_ru, c.name_ru;";
                                $tb=mysql_query($sql) or die(mysql_error());
                                @$tb_n=mysql_numrows($tb);
                                $i=0;
                                $tb_region_id_old='';
                                while($i<$tb_n){
                                    $tb_city_id=mysql_result($tb,$i,"city_id");    
                                    $tb_city_name=mysql_result($tb,$i,"c_name_ru");    
                                    $tb_region_id=mysql_result($tb,$i,"region_id");    
                                    $tb_region_name=mysql_result($tb,$i,"r_name_ru");    
                                    if ($tb_region_id_old==$tb_region_id) {
                            ?>
                            <option value="<?php print $tb_city_id; ?>" <?php if ($cuser_city_id==$tb_city_id) print "selected"; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php print $tb_city_name; ?></option>
                            <?php   } else { ?>
                            <optgroup label="<?php print $tb_region_name; ?>"></optgroup>
                            <?php
                                    }
                                    $tb_region_id_old=$tb_region_id;
                                    $i++;
                                }
                            ?>
                        </select>
                    </p>
                    <p>
                        <label for="group_status">Пользователь</label>
                            <select name="group_status" id="group_status">
                            <?php
                                $sql= "select group_id, group_name from gm_user_group; ";
                                $usergr=mysql_query($sql) or die(mysql_error());
                                @$usergr_n=mysql_numrows($usergr);
                                $i=0;
                                while($i<$usergr_n){
                                    $usergr_id=mysql_result($usergr,$i,"group_id");
                                    $usergr_name=mysql_result($usergr,$i,"group_name");
                                    if (($cuser_id!=$user_id)||($usergr_id==$cuser_group_id)){
                            ?>
                                <option value="<?php print $usergr_id; ?>" <?php if ($usergr_id==$cuser_group_id) print "selected"; ?>><?php print $usergr_name; ?></option>
                            <?php
                                    }
                                    $i+=1;
                                }
                            ?>
                            </select>
                    </p>
                    <p class="submit">
                        <input name="SubmitAccess" id="SubmitAccess" value="Сохранить/Далее" class="exclusive" type="submit" >
                        <a href="<?php print $cuser_nextpage; ?>" class="button_red" >Назад/Отмена</a>
                        <input name="cuser_id" id="cuser_id" value="<?php print $cuser_id; ?>" class="exclusive" type="hidden" >
                        <input name="ts" id="ts" value="<?php print $cuser_ts; ?>" class="exclusive" type="hidden" >
                        <input name="activated" id="activated" value="<?php print $cuser_activated; ?>" class="exclusive" type="hidden" >
                        <input name="group_id" id="group_id" value="<?php print $cuser_group_id; ?>" class="exclusive" type="hidden" >
                        <input name="nextpage" id="nextpage" class="exclusive" type="hidden" value="<?php print $cuser_nextpage; ?>">
                    </p>   
                </form>
            <?php } ?>
        </div>
    </div>
</div>
<?php 
}
?>