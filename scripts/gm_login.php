<link href="gm_login.css" rel="stylesheet" type="text/css" />
<link href="scripts/gm_login.css" rel="stylesheet" type="text/css" />
<link href="<?php print $site_folder; ?>/scripts/gm_login.css" rel="stylesheet" type="text/css" />
    <?php if ($user_id>0)  { ?>
        <div align="right" style="width:300px"><label id="identification_label_logined">Добро пожаловать <?php print "$user_name_first"; ?>&nbsp;</label><a href="#" id="identification_logout" onClick="var ws=new Date();
  ws.setMinutes(1-ws.getMinutes());
  document.cookie='kod_=done; path=/; expires='+ ws.toGMTString();
  location.href='';" >Выход</a></div>
    <?php }else{ ?>
        <div align="left" style="width:300px">
            <form action="#" method="post" id="form_identification">
<table>
<tr>
    <td align="left"><a href="login_registration.php">Регистрация</a></td>
    <td align="right"><a href="login_recovery.php">Вспомнить пароль</a></td>
</tr>
<tr>
    <td colspan="2">
        <label id="identification_label_login">Логин </label> <input name="identification_login" type="text" id="identification_login" />
                <label id="identification_label_password">Пароль </label> <input name="identification_password" type="password" id="identification_password" />
                <input type="submit" id="identification_submit" value="Вход" />
    </td>
</tr>
</table>
            </form>
        </div>
    <?php } ?>
<script type="text/javascript" src="gm_login.js"></script>
<script type="text/javascript" src="scripts/gm_login.js"></script>
<script type="text/javascript" src="<?php print $site_folder; ?>/scripts/gm_login.js"></script>
