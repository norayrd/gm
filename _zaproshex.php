		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<?php 
    if ($user_group==0) {
        include "_autentication.php";
    } else {
?>        
<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><span class="navigation_page">Журнал запросов</span></div>
</div>
<!-- /Breadcrumb --> 
<div id="noro_inner" style="background-image: none; background-color: #EEEEEE; width: 960px;">
<h1 style="width: 960px; background-repeat: repeat;">Запросы</h1>
    <div id="order-detail-content" class="table_block">
        <table id="search_res" width="970px" class="noro_table">
            <thead>
                <tr>
                    <th>Запрос№</th>
                    <th>дата</th>
                    <th>описание</th>
                    <th>бренд</th>
                    <th>артикуль</th>
                    <th>клиент</th>
                    <th>VIN</th>
                    <th>марка</th>
                    <th>модель</th>
                    <th>статус</th>
                    <th>менеджер</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $f_date=$_POST["f_date"]."";
                $f_tov_kod=$_POST["f_tov_kod"]."";
                $f_fio=$_POST["f_fio"]."";
                $f_vin=$_POST["f_vin"]."";
                $f_marka=$_POST["f_marka"]."";
                $f_model=$_POST["f_model"]."";
                $f_status=$_POST["f_status"];
                if (!isset($f_status)) $f_status=-1;
                $f_manager=$_POST["f_manager"]."";
            ?>
            <form action="zaproshex.php" method="post">
                <tr>
                    <td></td>
                    <td><input type="text" name="f_date" id="f_date" size="8" value="<?php print $f_date; ?>" style="font-size: 10px; height: 17px;"></td>
                    <td></td>
                    <td></td>
                    <td><input type="text" name="f_tov_kod" id="f_tov_kod" size="11" value="<?php print $f_tov_kod; ?>" style="font-size: 10px; height: 17px;"></td>
                    <td><input type="text" name="f_fio" id="f_fio" size="20" value="<?php print $f_fio; ?>" style="font-size: 10px; height: 17px;"></td>
                    <td><input type="text" name="f_vin" id="f_vin" size="11" value="<?php print $f_vin; ?>" style="font-size: 10px; height: 17px;"></td>
                    <td><input type="text" name="f_marka" id="f_marka" size="11" value="<?php print $f_marka; ?>" style="font-size: 10px; height: 17px;"></td>
                    <td><input type="text" name="f_model" id="f_model" size="11" value="<?php print $f_model; ?>" style="font-size: 10px; height: 17px;"></td>
                    <td>
                        <select name="f_status" id="f_status" style="width: 100px; font-size: 10px; height: 17px;">
                            <option value="-1" <?php if ($f_status==-1) print "selected"; ?> >Все</option>
                            <?php
                                $sql_="select zapros_status_kod,name_,color_,bg_color from gm_zapros_status";
                                $tb=mysql_query($sql_);
                                @$tb_n=mysql_numrows($tb);
                                $i_=0;
                                while ($i_<$tb_n){
                                    $sel_status_kod=mysql_result($tb,$i_,"zapros_status_kod");
                                    $sel_name=mysql_result($tb,$i_,"name_");
                                    $sel_color=mysql_result($tb,$i_,"color_");
                                    $sel_bg_color=mysql_result($tb,$i_,"bg_color");
                                    if ($f_status==$sel_status_kod) print "<option value='$sel_status_kod' selected> $sel_name </option>";
                                                               else print "<option value='$sel_status_kod'> $sel_name </option>";
                                    $i_+=1;
                                }
                            ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Найти" class="button_blue_thin"></td>
                </tr>
            </form>
<?php
    $sql_="select z.zapros_id,z.zaprosh_id,z.detal_,tm.tov_make,z.tov_kod,z.status_ z_status,z.ts_, zh.user_id,
                  u.name_full, zh.users_avto_id, zh.status_ zh_status, zh.create_date, zh.vin_, zh.marka_,
                  zh.model_, zh.year_, zh.kuzov_, zh.dvig_, zh.toplivo_, zh.kpp_, zh.manager_id, k.name_ kuzov_name,
                  t.name_ toplivo_name, p.name_ kpp_name, m.name_full manager_name,
                  zs.name_ st_name, zs.color_ st_color, zs.bg_color st_bgcolor
             from gm_zapros z left join gm_zaprosh zh on z.zaprosh_id=zh.zaprosh_id
                  left join p_tov_make tm on tm.tov_make_kod=z.tov_make
                  left join gm_users u on zh.user_id=u.user_id
                  left join gm_users m on zh.manager_id=m.user_id
                  left join gm_value k on k.value_id=zh.kuzov_
                  left join gm_value t on t.value_id=zh.toplivo_
                  left join gm_value p on p.value_id=zh.kpp_
                  left join gm_zapros_status zs on zs.zapros_status_kod=z.status_
            where ((zh.manager_id=$user_id)or($user_group>1)or(zh.manager_id is null))";

    if ($f_date!="") $sql_=$sql_." and (zh.create_date >= '".date('Y.m.d',StrToTime(($f_date)))."') and (zh.create_date < DATE_ADD('".date('Y.m.d',StrToTime($f_date))."',INTERVAL 1 DAY) ) ";
    if ($f_tov_kod!="") $sql_=$sql_." and z.tov_kod='$f_tov_kod' ";
    if ($f_fio!="") $sql_=$sql_." and (u.name_full like '$f_fio%') ";
    if ($f_vin!="") $sql_=$sql_." and (z.vin_='$f_vin') ";
    if ($f_marka!="") $sql_=$sql_." and (zh.marka_='$f_marka') ";
    if ($f_model!="") $sql_=$sql_." and (zh.model_='$f_model') ";
    if ($f_status>=0) $sql_=$sql_." and (z.status_=$f_status) ";
    if ($f_manager!="") $sql_=$sql_." and (m.name_full like '$f_manager%') ";

    $tb=mysql_query($sql_);
    @$tb_n=mysql_numrows($tb);
    $i_=0;
    while ($i_<$tb_n){
        $zapros_id=mysql_result($tb,$i_,"zapros_id");
        $zaprosh_id=mysql_result($tb,$i_,"zaprosh_id");
        $zaprosh_nom=mysql_result($tb,$i_,"zaprosh_id");
        $zapros_detal=mysql_result($tb,$i_,"detal_");
        $zapros_tov_make=mysql_result($tb,$i_,"tov_make");
        $zapros_tov_kod=mysql_result($tb,$i_,"tov_kod");
        $zapros_z_status=mysql_result($tb,$i_,"z_status");
        $zapros_ts=mysql_result($tb,$i_,"ts_");
        $zapros_user_id=mysql_result($tb,$i_,"user_id");
        $zapros_name_full=mysql_result($tb,$i_,"name_full");
        $zapros_avto_id=mysql_result($tb,$i_,"users_avto_id");
        $zapros_zh_status=mysql_result($tb,$i_,"zh_status");
        $zaprosh_date=mysql_result($tb,$i_,"create_date");
        $zapros_vin=mysql_result($tb,$i_,"vin_")."";
        $zapros_marka=mysql_result($tb,$i_,"marka_")."";
        $zapros_model=mysql_result($tb,$i_,"model_")."";
        $zapros_year=mysql_result($tb,$i_,"year_");
        $zapros_kuzov=mysql_result($tb,$i_,"kuzov_");
        $zapros_kuzov_name=mysql_result($tb,$i_,"kuzov_name")."";
        $zapros_dvig=mysql_result($tb,$i_,"dvig_")."";
        $zapros_toplivo=mysql_result($tb,$i_,"toplivo_");
        $zapros_toplivo_name=mysql_result($tb,$i_,"toplivo_name")."";
        $zapros_kpp=mysql_result($tb,$i_,"kpp_");
        $zaprosh_kpp_name=mysql_result($tb,$i_,"kpp_name")."";
        $zapros_manager_id=mysql_result($tb,$i_,"manager_id");
        $zapros_manager_name=mysql_result($tb,$i_,"manager_name");
        $zapros_st_name=mysql_result($tb,$i_,"st_name");
        $zapros_st_color=mysql_result($tb,$i_,"st_color");
        $zapros_st_bgcolor=mysql_result($tb,$i_,"st_bgcolor");
?>
        <tr style=" background-color: <?php print "#".$zapros_st_bgcolor; ?>;">
            <td align="center" style="font-size: 11px; width: 50px; color: <?php print "#".$zapros_st_color; ?>;"><?php print $zaprosh_nom; ?></td>
            <td style="font-size: 11px; width: 60px; color: <?php print "#".$zapros_st_color; ?>;"><?php print date('d.m.Y',StrToTime($zaprosh_date)); ?></td>
            <td style="font-size: 11px;; color: <?php print "#".$zapros_st_color; ?>;"><?php print $zapros_detal; ?></td>
            <td style="font-size: 11px; width: 70px; color: <?php print "#".$zapros_st_color; ?>;"><?php print $zapros_tov_make; ?></td>
            <td style="font-size: 11px; width: 70px; color: <?php print "#".$zapros_st_color; ?>;"><?php print $zapros_tov_kod; ?></td>
            <td style="font-size: 11px; width: 100px; color: <?php print "#".$zapros_st_color; ?>;"><?php print $zapros_name_full; ?></td>
            <td style="font-size: 11px; width: 70px; color: <?php print "#".$zapros_st_color; ?>;"><?php print $zapros_vin; ?></td>
            <td style="font-size: 11px; width: 70px; color: <?php print "#".$zapros_st_color; ?>;"><?php print $zapros_marka; ?></td>
            <td style="font-size: 11px; width: 70px; color: <?php print "#".$zapros_st_color; ?>;"><?php print $zapros_model; ?></td>
            <td style="font-size: 11px; width: 100px; color: <?php print "#".$zapros_st_color; ?>;"><?php print $zapros_st_name; ?></td>
            <td style="font-size: 11px; width: 100px; color: <?php print "#".$zapros_st_color; ?>;"><?php print $zapros_manager_name; ?></td>
        </tr>
<?php
            $i_+=1;
        }
?>
        </tbody>
    </table>
    </div>
</div>
<?php
    }
?>