<?php
    require_once "scripts/gm_access.php";
    $page_title="";
    if (isset($_GET["group"])) { //если вызывали из sklad.php
        $param=$_GET["group"]-0;
        $title_tb=mysql_query("select g.group_name from p_group g where g.group_kod=$param");
        if (@mysql_numrows($title_tb)>0) $page_title=mysql_result($title_tb,0,'group_name'); 
    } else if (isset($_GET["search_query"])) { //если вызывали из search.php
        $param=$_GET["search_query"]."";
        $title_tb=mysql_query("select concat(tm.tov_make,' ',p.tov_kod,' ',p.tov_name) tov_name from p_prices p left join p_tov_make tm on tm.tov_make_kod=p.tov_make_kod where (p.tov_kod='$param')and(tov_name<>'') limit 0,1");
        if (@mysql_numrows($title_tb)>0) $page_title=mysql_result($title_tb,0,'tov_name'); 
    }
    if ($page_title<>"") $page_title="$page_title - $site_name";
?>