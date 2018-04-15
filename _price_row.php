<?php
require_once "scripts/gm_access.php";

$kod_=$_GET["kod_"]-0;
$par_prices_kod=$_GET["r"]-0;
$par_com=$_GET["com"]-0;

$par_tov_make="";
$tb=mysql_query("select tov_make, pricesh_kod from tmp_prices p where p.prices_kod=$par_prices_kod") or die(mysql_error());
@$tb_n=mysql_numrows($tb);
if ($tb_n>0){
    $par_tov_make=mysql_result($tb,0,"tov_make");
    $par_pricesh_kod=mysql_result($tb,0,"pricesh_kod");
}

if ($kod_==$_GET["kod_"]) {
    if (($par_com==4)&&($par_tov_make!="")) {  //добавление
        mysql_query("select get_tov_make_kod('$par_tov_make'); ");
    } /*else if ($par_com==2) {  //удаление
        mysql_query("call gm_tov_make_delete($par_mkod); ");
    } else if ($par_com==3) {  //замена
        $ss="call gm_tov_make_2to1($par_nkod,$par_mkod,1); ";
        mysql_query($ss);
    }*/
    
    $sql= "select min(p.prices_kod) prices_kod, p.tov_make, count(*) cnt  from tmp_prices p left join p_tov_make tm on p.tov_make=tm.tov_make where tm.tov_make_kod is null and p.pricesh_kod=$par_pricesh_kod and p.tov_make='$par_tov_make' group by 2";
    $tb=mysql_query($sql) or die(mysql_error());
    @$tb_n=mysql_numrows($tb);
    if ($tb_n>0){
        $tb_prices_kod=mysql_result($tb,$i,"prices_kod");
        $tb_tov_make=mysql_result($tb,$i,"tov_make");
        $tb_cnt=mysql_result($tb,$i,"cnt");
    ?>

        <td>+</td>
        <td id="tm<?php print $tb_prices_kod; ?>"> <?php print $tb_tov_make; ?></td>
        <td id="c<?php print $tb_prices_kod; ?>"> <?php print $tb_cnt; ?></td>
        <td></td>
        <td align="center"></td>
        <td align="center"></td>
    <?php
    }
}
?>