if (document.getElementById("search_tov_kod").value=="") document.getElementById("search_tov_kod").value=" ����� �� ���� ������";
document.getElementById("search_tov_kod").onfocus=new Function("if (this.value == ' ����� �� ���� ������') {this.value = '';}");
document.getElementById("search_tov_kod").onblur=new Function("if (this.value == '') {this.value = ' ����� �� ���� ������';}");
document.getElementById("search_tov_label").hidden=true;
