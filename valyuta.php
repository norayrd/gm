<?php
require_once "scripts/gm_access.php";
//require_once "Excel/reader.php";
require_once "scripts/gm_tools_avto.php";

$valyuta_kod=$_GET["vl_kod"]-0;
$basic_valyuta_kod=$_GET["vl_basic_kod"]-0;
$vl_ch=$_GET["vl_ch"];
$new_vl_cours=$_GET["vl_cours"]-0.00;
if ($kod_==$_GET["kod_"]) {

    if ($user_group>1){
        $sql_="select vl.ISO_, vl.pref_, vc.cours_, bvl.pref_ bpref_, vc.date_update, u.name_full 
                           from gm_valyuta_cours vc left join gm_valyuta_list vl on vl.ISO_=vc.valyuta_kod 
                                left join gm_valyuta_list bvl on bvl.ISO_=vc.basic_valyuta_kod 
                                left join gm_users u on u.user_id=vc.user_id
                          where vc.valyuta_kod=$valyuta_kod and vc.basic_valyuta_kod=$basic_valyuta_kod";
        $tb=mysql_query($sql_);
        @$tb_n=mysql_numrows($tb);
        if ($tb_n>0) {
            $v_cours=mysql_result($tb,0,"cours_");
            $v_pref=mysql_result($tb,0,"pref_"); 
            $v_bpref =mysql_result($tb,0,"bpref_");
            $v_name_full=mysql_result($tb,0,"name_full");
            $v_date_update=mysql_result($tb,0,"date_update");

            if ($user_group==3){
                if (isset($vl_ch)) { 
                    if (($new_vl_cours>0)&&(abs($new_vl_cours-$v_cours)<=5)&&($new_vl_cours!=$v_cours)) {
                        mysql_query("update gm_valyuta_cours set cours_=$new_vl_cours, user_id=$user_id, date_update=CURRENT_TIMESTAMP where valyuta_kod=$valyuta_kod and basic_valyuta_kod=$basic_valyuta_kod and cours_=$v_cours");
                        $tb=mysql_query($sql_);
                        @$tb_n=mysql_numrows($tb);
                        if ($tb_n>0) {
                            $v_cours=mysql_result($tb,0,"cours_");
                            $v_pref=mysql_result($tb,0,"pref_"); 
                            $v_bpref =mysql_result($tb,0,"bpref_");
                        }
                    }
                }
            }
            print "<p title='".date('d.m.Y',strtotime($v_date_update))."; $v_name_full'>$v_pref - ".number_format($v_cours,2)." $v_bpref;&nbsp;&nbsp;&nbsp;&nbsp;";
            if ($user_group==3) print "<img src='images/pencil.png' style='cursor:pointer;' onclick='chcourse($valyuta_kod,$basic_valyuta_kod,$v_cours)'>";
            print "</p>"; 
        }
    }
}		
?>