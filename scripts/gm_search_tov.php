<link href="gm_search_tov.css" rel="stylesheet" type="text/css" />
<link href="scripts/gm_search_tov.css" rel="stylesheet" type="text/css" />
<link href="<?php print $site_folder; ?>/scripts/gm_search_tov.css" rel="stylesheet" type="text/css" />
<?php include "gm_access.php"; ?>
<table width="100%" height="50" cellpadding="0" cellspacing="0" background="<?php print $site_folder ?>/images/site_top_clear.png1" bgcolor="#999999">
            <tr>
                <td heigth="*"></td><td></td><td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td width="250">
                    <form action="index.php?page_=price" method="post" id="search_tov"><label id="search_tov_label" >Поиск по коду товара </label><input type="text" id="search_tov_kod" name="search_tov_kod" value="<?php if (isset($_GET['search_tov_kod'])) print $_GET['search_tov_kod']; ?>" />&nbsp;<input type="submit" id="search_tov_submit" value="Поиск" /></form>
                </td>
                <td width="*">&nbsp;
<?php
$sql="select tov_kod from gm_search_tov_kod t where (t.kod_=".$_COOKIE["kod_"]*1 .")or((t.user_id=".$user_id*1 .")and(".$user_id*1 .">0)) order by search_date desc;";
$tbNews=mysql_query($sql) or die(mysql_error());
@$tbNews_n=mysql_numrows($tbNews);
$i=0;
while($i<$tbNews_n){
    $tb_tov_kod=mysql_result($tbNews,$i,"tov_kod");	
?>
<a href=# onClick="document.getElementById('search_tov_kod').value='<?php print $tb_tov_kod ?>'; document.getElementById('search_tov').submit(); "><font color="#000033"><?php print $tb_tov_kod ?></font></a>,
<?php
	$i++;
}
?>	    
</td>
            </tr>
            <tr>
                <td heigth="*"></td><td></td><td></td>
            </tr>
            </table>
<script type="text/javascript" src="gm_search_tov.js"></script>
<script type="text/javascript" src="scripts/gm_search_tov.js"></script>
<script type="text/javascript" src="<?php print $site_folder; ?>/scripts/gm_search_tov.js"></script>
