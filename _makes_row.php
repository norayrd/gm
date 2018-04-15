<?php
require_once "scripts/gm_access.php";

$kod_=$_GET["kod_"]-0;
$par_mkod=$_GET["r"]-0;
$par_nkod=$_GET["n"]-0;
$par_com=$_GET["com"]-0;

if ($kod_==$_GET["kod_"]) {
    /*if ($par_com==1) {  //изменение
        mysql_query("update p_tov_make_variant set tov_make=upper('$par_tov_makev') where variant_kod=$par_vkod;");
    } else*/ if ($par_com==2) {  //удаление
        mysql_query("call gm_tov_make_delete($par_mkod); ");
    } else if ($par_com==3) {  //замена
        $ss="call gm_tov_make_2to1($par_nkod,$par_mkod,1); ";
        mysql_query($ss);
    }
    
    $sql= "select tov_make_kod, tov_make, used_count, used_incroses from p_tov_make t where tov_make_kod=$par_mkod";
    $tb=mysql_query($sql) or die(mysql_error());
    @$tb_n=mysql_numrows($tb);
    if ($tb_n>0){
        $tb_tov_make_kod=mysql_result($tb,0,"tov_make_kod");
        $tb_tov_make=mysql_result($tb,0,"tov_make");
        $tb_used_count=mysql_result($tb,0,"used_count");
        $tb_used_incroses=mysql_result($tb,0,"used_incroses");
    ?>

        <td>!</td>
        <td align=right><?php print $tb_tov_make_kod; ?></td>
        <td></td>
        <td> <?php print $tb_tov_make; ?></td>
        <td align=right><?php print $tb_used_count; ?></td>
        <td align=right><?php print $tb_used_incroses; ?></td>
        <td align="center" style=" visibility: hidden"></td>
        <td align="center"></td>
        <td align="center"></td>
    <?php
    }
}
?>