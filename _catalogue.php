<?php
    require_once "scripts/gm_access.php";
    $sql_="insert into gm_catview (kod_, ip_, user_id,HTTP_USER_AGENT,create_dt,last_access_dt)values('$kod_','".$_SERVER['REMOTE_ADDR']."',".$user_id.",'".$_SERVER['HTTP_USER_AGENT']."',current_timestamp,current_timestamp);";
    mysql_query($sql_);
?>

<script language="JavaScript">
  window.location.href = "http://catalog.avto-polit.ru/totalcatalog/";
</script>