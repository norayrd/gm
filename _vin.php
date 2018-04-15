        <link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
if ($user_group<1) {
    print '<h2>Для создания VIN-запроса требуется "зарегистрироваться" или "войти" под своим пользователем.</h2>';
    include "_autentication.php";
}else{
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
            <h1>VIN - запрос</h1>
<?php
    if (isset($_POST["SubmitVin"])) {
        $tb=mysql_query("select count(*) count_ from gm_capcha where capcha_='".$_POST["id_capcha"]."'");
        @$tb_n=mysql_numrows($tb);
        if ($tb_n>0) $capcha_count=mysql_result($tb,0,"count_");
        if ($capcha_count>0) {

            if (isset($_POST["SubmitVin"]) ) {
                if (isset($_POST["avto_id"]) && isset($_POST["vin_detal"]) ) {
                    $detal=$_POST["vin_detal"];
                    $avto_id=$_POST["avto_id"]-0;
                    $avto_vin=$_POST["avto_vin"]."";
                    $avto_marka=$_POST["avto_marka"]."";
                    $avto_model=$_POST["avto_model"]."";
                    $avto_year=$_POST["avto_year"]."";
                    $avto_kuzov=$_POST["avto_kuzov"]-0;
                    $avto_dvig=$_POST["avto_dvig"]."";
                    $avto_toplivo=$_POST["avto_toplivo"]-0;
                    $avto_kpp=$_POST["avto_kpp"]-0;
                    //создаем заголовок запроса
                    $last_id=mysql_insert_id();
                    $sql="insert into gm_zaprosh (user_id,users_avto_id,status_,create_date,vin_,
                                        marka_,model_,year_,
                                        kuzov_,dvig_,toplivo_,kpp_,ts_)
                                values($user_id,$avto_id,0,CURRENT_TIMESTAMP,'$avto_vin',
                                      '$avto_marka','$avto_model','$avto_year',
                                       $avto_kuzov,'$avto_dvig',$avto_toplivo,$avto_kpp,".time().");";
                    //print $sql;
                    mysql_query($sql);
      
                    $zaprosh_id=mysql_insert_id();
                    if ($last_id!=$zaprosh_id) {
                        for ($i=0; $i<count($detal); $i++) {
                            $sql="insert into gm_zapros (zaprosh_id,detal_,tov_make,tov_kod,status_)values($zaprosh_id,'$detal[$i]',null,null,0);";
                            mysql_query($sql);
                        }
                    } else print "Ошибка! Запрос не создан!"; 

                    echo "<script> location.replace('index.php'); </script>"; 
                }
            }

        } else {
            print "<div ><p><font color='#FF0000'>Неверный код защиты! Попробуйте ввести еще раз!</font></p></div>";
        }                
    }
?>
            <form class="std" action="vin.php" method="post">
                <script type="text/javascript">
                    function newavto(new_) {
                        if (new_==1) {
                            $("#avto_choose").hide(200);
                            $("#avto_new").show(200);
                            $("#variant").val(1); 
                        } else {
                            $("#avto_new").hide(200); 
                            $("#avto_choose").show(200); 
                            $("#variant").val(0); 
                        }
                        return false;
                    }
                </script>
                <div id="avto_choose" name="avto_choose" class="<?php if (($_POST["variant"]-0)==1) print 'hidden'; ?>">
                    <p class="text">
                        <a class="button_gray" onClick="newavto(0); "> * Список машин</a> <a class="button" onClick="newavto(1); "> + Добавить машину</a>
                    </p>
                    <fieldset class="account_creation">
                        <h3>Транспортное средство</h3><br>
                        <p class="required select" >
                            <label for="avto_id">Автомобиль</label>
                            <select name="avto_id" id="avto_id">
                            <?php
                            $sql="select * from gm_users_avto a where (user_id=$user_id)";
                            $tb=mysql_query($sql) or die(mysql_error());
                            @$tb_n=mysql_numrows($tb);
                            $selected=0;
                            $i=0;
                            while($i<$tb_n){
                                $avto1_id=mysql_result($tb,$i,"users_avto_id");
                                $avto1_vin=mysql_result($tb,$i,"vin_");
                                $avto1_marka=mysql_result($tb,$i,"marka_");
                                $avto1_model=mysql_result($tb,$i,"model_");
                                $avto1_year=mysql_result($tb,$i,"year_");
                                $avto1_dvig=mysql_result($tb,$i,"dvig_");
                                $avto1_txt="$avto1_marka $avto1_model $avto1_dvig / VIN: $avto1_vin / $avto1_year";
                            ?>
                                <option value="<?php print $avto1_id; ?>" <?php if (isset($_POST["avto_id"]) && ($_POST["avto_id"]==$avto1_id)) { print "selected"; $selected=1; } ?>><?php print $avto1_txt; ?></option>
                            <?php
                                $i++;
                            }
                            ?>
                                <option value="" <? if ($selected==0) print "selected"; ?> >-</option>
                            </select>
                        </p>
                    </fieldset>
                </div>
                <div id="avto_new" name="avto_new" class="<?php if (($_POST["variant"]-0)!=1) print 'hidden'; ?>">
                    <p class="text">
                        <a class="button" onClick="newavto(0); "> * Список машин</a> <a class="button_gray" onClick="newavto(1); "> + Добавить машину</a>
                    </p>
                    <p class="text">
                        <?php include "_registration_avto.php"; ?>
                    </p>
                </div>
                <h3>Запчасти</h3><br>
                <script type="text/javascript">
                    detail_no=2;
                    function add_detal (){
                        asd='<p class="text"><label for="vin_detal[]">'+detail_no+'.</label><input  name="vin_detal[]" id="vin_detal[]" type="text" value="" style="width: 500px;"/></p>';
                        $("#content_detals").append(asd);
                        detail_no+=1;
                        return false;
                    }
                </script>
                <div id="content_detals">
                    <p class="text">
                        <label>1.</label>
                        <input  name="vin_detal[]" id="vin_detal[]" type="text" value="<?php print $_POST["vin_detal"][0]?>" style="width: 500px;"/>
                    </p>
                    <?php  
                        if (count($_POST["vin_detal"])>0) {
                            for ($i=2;$i<(count($_POST["vin_detal"])+1);$i++) {
                                print "<p class='text'><label>$i.</label><input  name='vin_detal[]' id='vin_detal[]' type='text' value='".$_POST["vin_detal"][$i-1]."' style='width: 500px;'/></p>";
                            }
                        }
                    ?>
                </div>
                <p class="text">
                    <label>.</label><a style="" type="button" class="button_gray" onclick="add_detal();"> + Еще</a>
                </p>
                <p class="text">
                    <img style=" position:absolute; left:300px" src="capcha.php"><br>
                    <label for="id_capcha">Код защиты</label>
                    <input name="id_capcha" id="id_capcha" type="text" style=" width:70px">
                </p>
                <p class="required required_desc"><span><sup>*</sup>Обязательные поля</span></p>
                <div id="error_text"></div>
                <p class="submit">    
                    <input name="SubmitVin" id="SubmitVin" value="Готово" class="exclusive" type="submit" onclick="javascript:return check_registration();" >
                    <a href="<?php print $avto_nextpage; ?>" class="button_red" >Отмена</a>
                    <input name="variant" id="variant" type="hidden" value="<?php print $_POST["variant"]; ?>">
                    <input name="nextpage" id="nextpage" type="hidden" value="<?php print $avto_nextpage; ?>">
                </p>
            </form>
        </div>
    </div>
</div>
<?php 
}
?>