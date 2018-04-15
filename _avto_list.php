        <link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
if ($user_group<1) {
    include "_autentication.php";
}else{
?>
<?php 
    $cuser_nextpage=$_GET['nextpage'];
    /*if (isset($_GET['user_id']) && isset($_GET['ts'])) {
        $cuser_id=$_GET['user_id']-0;
        $cuser_ts=$_GET['ts']-0;
        $cuser_nextpage=$_GET['nextpage'];
    }
    if (isset($_POST['user_id']) && isset($_POST['ts'])) {
        $cuser_id=$_POST['user_id']-0;
        $cuser_ts=$_POST['ts']-0;
        $cuser_nextpage=$_POST['nextpage'];
    }*/
?>
    <!-- Breadcrumb -->
    <div class="breadcrumb bordercolor">
    <div class="breadcrumb_inner">
        <a href="index.php" title="На главную">Главная</a><span class="navigation-pipe">&gt;</span><a href="authentication.php">Учетная запись</a><span class="navigation-pipe">&gt;</span>Транспортные средства
    </div>
    </div>
    <!-- /Breadcrumb -->
<div id="noro_inner">
    <div id="authentication">
        <div id="center_column" class="center_column">
<?php
    if ($user_id>0) {
?>
            <h1>Транспортные средства</h1>
            <p></p>
            <div>
                <a href="avto_edit.php?nextpage=avto_list.php" title="Добавить новую машину" class="button_large">Добавить новую машину</a>
            </div>
            <p></p>
<table id="search_res" width="100%" class="noro_table">
<thead>
    <tr>
        <th width="30">VIN</th>
        <th width="100">Марка</th>
        <th>Модель</th>
        <th width="70">Год</th>
        <th width="70">Кузов</th>
        <th>Двигатель</th>
        <th>Топливо</th>
        <th>КПП</th>
    </tr>
</thead>
<tbody>

<?php
        $sql_="select a.users_avto_id, a.user_id, a.vin_, a.marka_, a.model_, a.year_, a.kuzov_, a.dvig_, a.toplivo_, a.kpp_, a.ts_ from gm_users u left join gm_users_avto a on a.user_id=u.user_id where (u.user_id=$user_id)and(u.ts_=$user_ts)and(a.users_avto_id is not null)";
        $tb=mysql_query($sql_);
        @$tb_n=mysql_numrows($tb);
        $i_=0;
        while ($i_<$tb_n) {
            $cuser_avto_id=mysql_result($tb,$i_,"users_avto_id");
            $cuser_avto_ts=mysql_result($tb,$i_,"ts_");
            $cuser_avto_vin=mysql_result($tb,$i_,"vin_");
            $cuser_avto_marka=mysql_result($tb,$i_,"marka_");
            $cuser_avto_model=mysql_result($tb,$i_,"model_");
            $cuser_avto_year=mysql_result($tb,$i_,"year_");
            $cuser_avto_kuzov=mysql_result($tb,$i_,"kuzov_");
            $cuser_avto_dvig=mysql_result($tb,$i_,"dvig_");
            $cuser_avto_toplivo=mysql_result($tb,$i_,"toplivo_");
            $cuser_avto_kpp=mysql_result($tb,$i_,"kpp_");
?>
      <tr class="<?php if (($i % 2)==0) print "even"; else print "odd"; ?>" style="<?php if (date('d.m.Y', StrToTime($tb_user_created))==date('d.m.Y', time())) { print "background-color:#FF9999"; } ?>" >
        <td  style="font-size:11px"><?php print "<a href='avto_edit.php?avto_id=$cuser_avto_id&ts=$cuser_avto_ts&nextpage=avto_list.php'>$cuser_avto_vin</a>"; ?></td>
        <td><?php print $cuser_avto_marka; ?></td>
        <td  style="font-size:11px"><?php print $cuser_avto_model; ?></td>
        <td align="center"><?php print $cuser_avto_year; ?></td>
        <td align="center"><?php print $cuser_avto_kuzov; ?></td>
        <td align="center"><?php print $cuser_avto_dvig; ?></td>
        <td align="center"><?php print $cuser_avto_toplivo; ?></td>
        <td align="center"><?php print $cuser_avto_kpp; ?></td>
      </tr>
<?php
            $i_+=1;
        }
?>
</tbody>
</table>

<?php 
    }
?>
        </div>
    </div>
</div>
<?php
}
?>