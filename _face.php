        <link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
    if ($user_group<1) {
        include "_autentication.php";
        exit;
    }
?>
<?php  
    if (isset($_POST['SubmitAccount'])) {
            $par_faces_id=$_POST['faces_id']-0;
            $par_faces_typ=$_POST['typ']-0;
            $par_faces_user_id=$_POST['user_id']-0;
            $par_faces_name_first=$_POST['firstname'].'';
            $par_faces_name_last=$_POST['lastname'].'';
            $par_faces_name_middle=$_POST['middlename'].'';
            $par_faces_email=$_POST['p_email'].'';
            $par_faces_skype=$_POST['p_skype'].'';
            $par_faces_icq=$_POST['p_icq'].'';
            $par_faces_country=$_POST['id_country']-0;
            $par_faces_region=$_POST['id_region']-0;
            $par_faces_city=$_POST['id_city'].'';
            $par_faces_zip=$_POST['postcode'].'';
            $par_faces_adr=$_POST['address'].'';
            $par_faces_name_organization=$_POST['company'].'';
            $par_faces_info=$_POST['other'].'';
            $par_faces_tel=$_POST['phone'].'';
            $par_faces_tel_mob=$_POST['phone_mobile'].'';
            $par_faces_deliv_strahovka=$_POST['deliv_strahovka']-0;
            $par_faces_deliv_need_adr=$_POST['deliv_need_adr']-0;
            if ($par_faces_id>0) {
                $sql_="update gm_faces set typ_=$par_faces_typ,
                                           user_id=$par_faces_user_id,
                                           name_first='$par_faces_name_first',
                                           name_last='$par_faces_name_last',
                                           name_middle='$par_faces_name_middle',
                                           email_='$par_faces_email',
                                           skype_='$par_faces_skype',
                                           icq_='$par_faces_icq',
                                           country_=$par_faces_country,
                                           region_=$par_faces_region,
                                           city_='$par_faces_city',
                                           zip_='$par_faces_zip',
                                           adr_='$par_faces_adr',
                                           name_organization='$par_faces_name_organization',
                                           info_='$par_faces_info',
                                           tel_='$par_faces_tel',
                                           tel_mob='$par_faces_tel_mob',
                                           deliv_strahovka=$par_faces_deliv_strahovka,
                                           deliv_need_adr=$par_faces_deliv_need_adr,
                                           date_modify=current_timestamp
                    where faces_id=$par_faces_id; ";
                mysql_query($sql_);
                if (isset($_POST['nextpage'])) print "<script> location.replace('".$_POST['nextpage']."'); </script>";
            } else {
                //$sql_="insert into gm_faces ()values(); ";
            }
    }
?>
<?php 
    if (isset($_GET['faces_id'])&&isset($_GET['ts'])) {
        $faces_id=$_GET['faces_id']-0;
        $faces_ts=$_GET['ts']-0;
        $faces_user_id=$_GET['user_id'];
        $faces_nextpage=$_GET['nextpage'];
    }
    if (isset($_POST['faces_id'])&&isset($_POST['ts'])) {
        $faces_id=$_POST['faces_id']-0;
        $faces_ts=$_POST['ts']-0;
        $faces_user_id=$_POST['user_id'];
        $faces_nextpage=$_POST['nextpage'];
    }
    if ($faces_id>0) {
        $sql_="select * from gm_faces f where (faces_id=$faces_id)and(f.ts_=$faces_ts)";
        $tb=mysql_query($sql_);
        if (@mysql_numrows($tb)>0) {
            $faces_typ=mysql_result($tb,0,"typ_");
            $faces_user_id=mysql_result($tb,0,"user_id");
            $faces_name_first=mysql_result($tb,0,"name_first");
            $faces_name_last=mysql_result($tb,0,"name_last");
            $faces_name_middle=mysql_result($tb,0,"name_middle");
            $faces_date_create=mysql_result($tb,0,"date_create");
            $faces_date_modify=mysql_result($tb,0,"date_modify");
            $faces_email=mysql_result($tb,0,"email_");
            $faces_skype=mysql_result($tb,0,"skype_");
            $faces_icq=mysql_result($tb,0,"icq_");
            $faces_country=mysql_result($tb,0,"country_");
            $faces_region=mysql_result($tb,0,"region_");
            $faces_city=mysql_result($tb,0,"city_");
            $faces_zip=mysql_result($tb,0,"zip_");
            $faces_adr=mysql_result($tb,0,"adr_");
            $faces_name_organization=mysql_result($tb,0,"name_organization");
            $faces_name_full=mysql_result($tb,0,"name_full");
            $faces_info=mysql_result($tb,0,"info_");
            $faces_tel=mysql_result($tb,0,"tel_");
            $faces_tel_mob=mysql_result($tb,0,"tel_mob");
            $faces_deliv_strahovka=mysql_result($tb,0,"deliv_strahovka");
            $faces_deliv_need_adr=mysql_result($tb,0,"deliv_need_adr");
        }
    }
?>
    <!-- Breadcrumb -->
    <div class="breadcrumb bordercolor">
    <div class="breadcrumb_inner">
        <a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><a href="authentication.php">Учетная запись</a><span class="navigation-pipe">&gt;</span>Контакт
    </div>
    </div>
    <!-- /Breadcrumb -->
<div id="noro_inner">
    <div id="authentication">
        <div id="center_column" class="center_column">
            <h1>Настройка контактов</h1>
            <form class="std" action="face.php" method="post">
                <?php 
                    include "_registration_address.php";
                ?>
                <p class="required required_desc"><span><sup>*</sup>Обязательные поля</span></p>
                    <script type="text/javascript">
                        function check_registration(){
                            $("#error_text").contents().remove();
                            s='';
                            if ($('#firstname').val()=='') s=s+"<li>Имя получателя</li>";
                            if ($('#lastname').val()=='') s=s+"<li>Фамилия получателя</li>";
                            if ($('#middlename').val()=='') s=s+"<li>Отчество получателя</li>";
                            //if ($('#postcode').val()=='') s=s+"<li>Почтовый индекс</li>";
                            if ($('#id_country').val()=='') s=s+"<li>Страна</li>";
                            if ($('#id_state').val()=='') s=s+"<li>Область</li>";
                            if ($('#id_city').val()=='') s=s+"<li>Город</li>";
                            if ($('#address').val()=='') s=s+"<li>Адрес</li>";
                            if (($('#phone').val()=='')&&($('#phone_mobile').val()=='')) s=s+"<li>Номер телефона</li>";
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
                    	<a href="<?php print $faces_nextpage; ?>" class="button" >&laquo; Назад / Отмена</a>    
                        <input name="SubmitAccount" id="SubmitAccount" value="Далее / Сохранить &raquo;" class="exclusive" type="submit" onclick="javascript:return check_registration();" >
                        
                        <input name="faces_id" id="faces_id" value="<?php print $faces_id; ?>" class="exclusive" type="hidden" >
                        <input name="ts" id="ts" value="<?php print $faces_ts; ?>" class="exclusive" type="hidden" >
                        <input name="typ" id="typ" value="<?php print $faces_typ; ?>" class="exclusive" type="hidden" >
                        <input name="user_id" id="user_id" value="<?php print $faces_user_id; ?>" class="exclusive" type="hidden" >
                        <input name="nextpage" id="nextpage" class="exclusive" type="hidden" value="<?php print $faces_nextpage; ?>">
                    </p>
            </form>
        </div>
    </div>
</div>