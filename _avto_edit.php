        <link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
if ($user_group<1) {
    include "_autentication.php";
}else{
?>
<?php  
    if (isset($_POST['SubmitAvto'])) {
            $par_avto_id=$_POST['avto_id']-0;
            $par_avto_vin=$_POST['avto_vin'].'';
            $par_avto_marka=$_POST['avto_marka'].'';
            $par_avto_model=$_POST['avto_model'].'';
            $par_avto_year=$_POST['avto_year'].'';
            $par_avto_ts=$_POST['ts']-0;
            $par_avto_kuzov=$_POST['avto_kuzov']-0;
            $par_avto_dvig=$_POST['avto_dvig']."";
            $par_avto_toplivo=$_POST['avto_toplivo']-0;
            $par_avto_kpp=$_POST['avto_kpp']-0;
            if ($par_avto_id>0) {
                $sql_="update gm_users_avto 
                          set vin_='$par_avto_vin',
                              marka_='$par_avto_marka',
                              model_='$par_avto_model',
                              year_='$par_avto_year',
                              kuzov_=$par_avto_kuzov,
                              dvig_='$par_avto_dvig',
                              toplivo_=$par_avto_toplivo,
                              kpp_=$par_avto_kpp,
                              ts_=$par_avto_ts
                    where (users_avto_id=$par_avto_id)and(ts_=$par_avto_ts); ";
                mysql_query($sql_);
                if (isset($_POST['nextpage'])) print "<script> location.replace('".$_POST['nextpage']."'); </script>";
            } else {
                $sql_="insert into gm_users_avto (user_id,vin_,marka_,model_,year_,
                                                  kuzov_,dvig_,toplivo_,kpp_)
                                           values($user_id,'$par_avto_vin','$par_avto_marka','$par_avto_model','$par_avto_year',
                                                  $par_avto_kuzov,'$par_avto_dvig',$par_avto_toplivo,$par_avto_kpp);";
                mysql_query($sql_);
            }
    }
?>
<?php 
    if (isset($_GET['avto_id']) && isset($_GET['ts'])) {
        $avto_id=$_GET['avto_id']-0;
        $avto_ts=$_GET['ts']-0;
        $avto_nextpage=$_GET['nextpage'];
    }
    if (isset($_POST['avto_id']) && isset($_POST['ts'])) {
        $avto_id=$_POST['avto_id']-0;
        $avto_ts=$_POST['ts']-0;
        $avto_nextpage=$_POST['nextpage'];
    }
    if ($avto_id>0) {
        $sql_="select * from gm_users_avto a where (users_avto_id=$avto_id)and(ts_=$avto_ts)";
        $tb=mysql_query($sql_);
        if (@mysql_numrows($tb)>0) {
            $avto_id=mysql_result($tb,0,"users_avto_id");
            $avto_ts=mysql_result($tb,0,"ts_");
            $avto_vin=mysql_result($tb,0,"vin_");
            $avto_marka=mysql_result($tb,0,"marka_");
            $avto_model=mysql_result($tb,0,"model_");
            $avto_year=mysql_result($tb,0,"year_");
            $avto_kuzov=mysql_result($tb,0,"kuzov_");
            $avto_dvig=mysql_result($tb,0,"dvig_");
            $avto_toplivo=mysql_result($tb,0,"toplivo_");
            $avto_kpp=mysql_result($tb,0,"kpp_");
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
            <form class="std" action="avto_edit.php" method="post">
                <?php 
                    include "_registration_avto.php";
                ?>
                <p class="required required_desc"><span><sup>*</sup>Обязательные поля</span></p>
                    <script type="text/javascript">
                        function check_registration(){
                            $("#error_text").contents().remove();
                            s='';
                            if ($('#customer_firstname').val()=='') s=s+"<li>Имя</li>"; 
                            if ($('#customer_lastname').val()=='') s=s+"<li>Фамилия</li>";
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
                        <input name="SubmitAvto" id="SubmitAvto" value="Сохранить/Далее" class="exclusive" type="submit" onclick="javascript:return check_registration();" >
                        <a href="<?php print $avto_nextpage; ?>" class="button_red" >Назад/Отмена</a>
                        <input name="avto_id" id="avto_id" value="<?php print $avto_id; ?>" class="exclusive" type="hidden" >
                        <input name="ts" id="ts" value="<?php print $avto_ts; ?>" class="exclusive" type="hidden" >
                        <input name="nextpage" id="nextpage" class="exclusive" type="hidden" value="<?php print $avto_nextpage; ?>">
                    </p>
            </form>
        </div>
    </div>
</div>
<?php 
}
?>