if (document.getElementById("search_tov_kod").value=="") document.getElementById("search_tov_kod").value=" поиск по коду товара";
document.getElementById("search_tov_kod").onfocus=new Function("if (this.value == ' поиск по коду товара') {this.value = '';}");
document.getElementById("search_tov_kod").onblur=new Function("if (this.value == '') {this.value = ' поиск по коду товара';}");
document.getElementById("search_tov_label").hidden=true;
