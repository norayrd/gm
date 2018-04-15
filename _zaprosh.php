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
<div id="noro_inner">
<h1 id="cart_title">Журнал запросов</h1>
    <div id="order-detail-content" class="table_block">
        <table id="search_res" width="100%" class="noro_table">
            <thead>
                <tr>
                    <th>№ запроса</th>
                    <th>Дата</th>
                    <th>Заказчик</th>
                    <th>Состояние</th>
                    <th>Транспорт</th>
                </tr>
            </thead>
            <tbody>
<?php
    $sql_="select zh.*, u.name_full, 
                  k.name_ kuzov_name,
                  t.name_ toplivo_name,
                  p.name_ kpp_name
             from gm_zaprosh zh left join gm_users u on zh.user_id=u.user_id
                  left join gm_value k on k.value_id=zh.kuzov_
                  left join gm_value t on t.value_id=zh.toplivo_
                  left join gm_value p on p.value_id=zh.kpp_
            where ((zh.user_id=$user_id)or($user_group>1))";
    $tb=mysql_query($sql_);
    @$tb_n=mysql_numrows($tb);
    $i_=0;
    while ($i_<$tb_n){
        $zaprosh_id=mysql_result($tb,$i_,"zaprosh_id");
        $zaprosh_nom=mysql_result($tb,$i_,"zaprosh_id");
        $zaprosh_date=mysql_result($tb,$i_,"create_date");  
        $zaprosh_user_id=mysql_result($tb,$i_,"user_id");
        $zaprosh_status=mysql_result($tb,$i_,"status_");
        $zaprosh_status_name='в работе';
        $zaprosh_ts=mysql_result($tb,$i_,"ts_");
        $zaprosh_name_full=mysql_result($tb,$i_,"name_full");
        $zaprosh_vin=mysql_result($tb,$i_,"vin_")."";
        $zaprosh_marka=mysql_result($tb,$i_,"marka_")."";
        $zaprosh_model=mysql_result($tb,$i_,"model_")."";
        $zaprosh_kuzov_name=mysql_result($tb,$i_,"kuzov_name")."";
        $zaprosh_toplivo_name=mysql_result($tb,$i_,"toplivo_name")."";
        $zaprosh_kpp_name=mysql_result($tb,$i_,"kpp_name")."";
        $zaprosh_dvig=mysql_result($tb,$i_,"dvig_")."";
        $avto_info="";
        if ($zaprosh_vin!="") $avto_info=$avto_info.$zaprosh_vin."; ";
        if ($zaprosh_marka!="") $avto_info=$avto_info.$zaprosh_marka."; ";
        if ($zaprosh_model!="") $avto_info=$avto_info.$zaprosh_model."; ";
        if ($zaprosh_dvig!="") $avto_info=$avto_info."(".$zaprosh_dvig.") ";
?>
        <tr>
            <td align="right"><?php print "<a href='zapros.php?zaprosh=$zaprosh_id' targer='_blank'>$zaprosh_nom</a>"; ?></td>
            <td><?php print date('d.m.Y',StrToTime($zaprosh_date)); ?></td>
            <td><?php print $zaprosh_name_full; ?></td>
            <td><?php print $zaprosh_status_name; ?></td>
            <td><?php print $avto_info; ?></td>
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