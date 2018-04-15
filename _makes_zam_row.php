<?php
require_once "scripts/gm_access.php";

$kod_=$_GET["kod_"]-0;
$par_vkod=$_GET["r"]-0;
$par_tov_makev=$_GET["tov_makev"]."";
$par_tov_makev=mb_convert_encoding($par_tov_makev, 'WINDOWS-1251', 'UTF-8');
$par_com=$_GET["com"]-0;

if ($kod_==$_GET["kod_"]) {
    if ($par_com==1) {  //изменение
        mysql_query("update p_tov_make_variant set tov_make=upper('$par_tov_makev') where variant_kod=$par_vkod;");
    } else if ($par_com==2) {  //удаление
        mysql_query("delete from p_tov_make_variant where variant_kod=$par_vkod;");
    }
    
    $sql= "select v.variant_kod, v.tov_make tov_makev, t.tov_make_kod, t.tov_make, t.used_count, t.used_incroses from p_tov_make_variant v left join p_tov_make t on t.tov_make_kod=v.tov_make_kod where variant_kod=$par_vkod";
    $tb=mysql_query($sql) or die(mysql_error());
    @$tb_n=mysql_numrows($tb);
    if ($tb_n>0){
        $tb_kod=mysql_result($tb,0,"variant_kod");
        $tb_tov_make_kod=mysql_result($tb,0,"tov_make_kod");
        $tb_tov_makev=mysql_result($tb,0,"tov_makev");
        $tb_tov_make=mysql_result($tb,0,"tov_make");
        $tb_used_count=mysql_result($tb,0,"used_count");
        $tb_used_incroses=mysql_result($tb,0,"used_incroses");
    ?>

        <td><input type="text" id="v<?php print $tb_kod; ?>" value="<?php print $tb_tov_makev; ?>" onchange="$('#b<?php print $tb_kod; ?>').show(); ch_zam('<?php print $tb_kod; ?>',1);" onkeypress="if (event.keyCode==13) ch_zam('<?php print $tb_kod; ?>',1); else if (event.keyCode==27) ch_zam('<?php print $tb_kod; ?>',0);" ><input type="button" id="b<?php print $tb_kod; ?>" value="->" onclick="ch_zam('<?php print $tb_kod; ?>',1)" style="cursor:pointer; display:none; background-color: #ff9999;"></td>
        <td align=right style="color: gray"><?php print $tb_tov_make_kod; ?></td>
        <td></td>
        <td style="color: gray"> <?php print $tb_tov_make; ?></td>
        <td align=right style="color: gray"><?php print $tb_used_count; ?></td>
        <td align=right style="color: gray"><?php print $tb_used_incroses; ?></td>
        <td><input type="button" id="b<?php print $tb_kod; ?>" value="X" onclick="ch_zam('<?php print $tb_kod; ?>',2)" style="cursor:pointer;" class="button_red" title="Удалить"></td>
    <?php
    }
}
?>