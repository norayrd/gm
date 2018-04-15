		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<?php 
    if ($user_group==0) {
        include "_autentication.php";
    } else {
?>        
<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><span class="navigation_page">Журнал заказов</span></div>
</div>
<!-- /Breadcrumb -->
<div id="noro_inner">
<h1 id="cart_title">Журнал заказов</h1>
    <div id="order-detail-content" class="table_block">
        <table id="search_res" width="100%" class="noro_table">
            <thead>
                <tr>
                    <th>№ заказа</th>
                    <th>Дата</th>
                    <th>Заказчик</th>
                    <th>Состояние</th>
                    <th>Сумма (грн.)</th>
                </tr>
            </thead>
            <tbody>
<?php
    $sql_="select rh.*, f.name_full 
             from gm_rashodh rh left join gm_faces f on rh.faces_id=f.faces_id 
            where ((rh.user_id=$user_id)or($user_group>1))";
    $tb=mysql_query($sql_);
    @$tb_n=mysql_numrows($tb);
    $i_=0;
    while ($i_<$tb_n){
        $rashodh_kod=mysql_result($tb,$i_,"rashodh_kod");
        $rashodh_nom=mysql_result($tb,$i_,"rashodh_nom");
        $rashodh_date=mysql_result($tb,$i_,"rashodh_date");  
        $rashodh_date_create=mysql_result($tb,$i_,"date_create");
        $rashodh_date_modified=mysql_result($tb,$i_,"date_modified");
        $rashodh_cours_usd=mysql_result($tb,$i_,"cours_usd");
        $rashodh_cours_eur=mysql_result($tb,$i_,"cours_eur");
        $rashodh_valyuta_kod=mysql_result($tb,$i_,"valyuta_kod");
        $rashodh_valyuta_cours=mysql_result($tb,$i_,"valyuta_cours");
        $rashodh_summa_bez_nds=mysql_result($tb,$i_,"summa_bez_nds");
        $rashodh_summa_nds=mysql_result($tb,$i_,"summa_nds");
        $rashodh_summa_s_nds=mysql_result($tb,$i_,"summa_s_nds");
        $rashodh_user_id=mysql_result($tb,$i_,"user_id");
        $rashodh_faces_id=mysql_result($tb,$i_,"faces_id");
        $rashodh_status_kod=mysql_result($tb,$i_,"rashodh_status_kod");
        $rashodh_deliv_id=mysql_result($tb,$i_,"deliv_id");
        $rashodh_deliv_strahovka=mysql_result($tb,$i_,"deliv_strahovka");
        $rashodh_ts=mysql_result($tb,$i_,"ts_");
        $rashodh_den_schet_id=mysql_result($tb,$i_,"den_schet_id");
        $rashodh_nds=mysql_result($tb,$i_,"nds_");
        $rashodh_deliv_poluchatel=mysql_result($tb,$i_,"deliv_poluchatel");
        $rashodh_deliv_adr=mysql_result($tb,$i_,"deliv_adr");
        $rashodh_deliv_office=mysql_result($tb,$i_,"deliv_office");
        $rashodh_rem=mysql_result($tb,$i_,"rem_");
        $rashodh_faces_name_full=mysql_result($tb,$i_,"name_full");
        $rashodh_status_kod="в работе";
?>
        <tr>
            <td align="right"><?php print "<a href='rashod.php?rashodh=$rashodh_kod' targer='_blank'>$rashodh_nom</a>"; ?></td>
            <td><?php print date('d.m.Y',StrToTime($rashodh_date)); ?></td>
            <td><?php print $rashodh_faces_name_full; ?></td>
            <td><?php print $rashodh_status_kod; ?></td>
            <td align="right"><?php print number_format($rashodh_summa_s_nds,2,'.',''); ?></td>
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