document.getElementById("identification_submit").value="Вход";
//показываем текст в логин и пароль, и убираем автоматом
document.getElementById("identification_login").value=" логин";
document.getElementById("identification_login").onfocus=new Function("if (this.value == ' логин') {this.value = '';}");
document.getElementById("identification_login").onblur=new Function("if (this.value == '') {this.value = ' логин';}");
//скрываем текст логин
document.getElementById("identification_label_login").hidden=true;

document.getElementById("identification_password").value=" пароль";
document.getElementById("identification_password").onfocus=new Function("if (this.value == ' пароль') {this.value = ''; }");
document.getElementById("identification_password").onblur=new Function("if (this.value == '') {this.value = ' пароль'; }");
document.getElementById("identification_label_password").hidden=true;

