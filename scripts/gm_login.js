document.getElementById("identification_submit").value="����";
//���������� ����� � ����� � ������, � ������� ���������
document.getElementById("identification_login").value=" �����";
document.getElementById("identification_login").onfocus=new Function("if (this.value == ' �����') {this.value = '';}");
document.getElementById("identification_login").onblur=new Function("if (this.value == '') {this.value = ' �����';}");
//�������� ����� �����
document.getElementById("identification_label_login").hidden=true;

document.getElementById("identification_password").value=" ������";
document.getElementById("identification_password").onfocus=new Function("if (this.value == ' ������') {this.value = ''; }");
document.getElementById("identification_password").onblur=new Function("if (this.value == '') {this.value = ' ������'; }");
document.getElementById("identification_label_password").hidden=true;

