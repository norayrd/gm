		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
	if (isset($_POST['from'])) {
		$sql_="select count(*) count_ from gm_capcha where capcha_='".$_POST["id_capcha"]."'";
		$tb=mysql_query($sql_);
		@$tb_n=mysql_numrows($tb);
		if ($tb_n>0) $capcha_count=mysql_result($tb,0,"count_");
		if ($capcha_count>0) {				
			if (isset($_POST['message'])) $message_=$_POST['message']; else $message_="";
			if (isset($_POST['id_order'])) $message_="����� � ".$_POST['id_order']."<br>\r\n".$message_;
			if ($_POST['id_contact']==1) {
                mail("info@tandem-auto.com.ua", "��������� ���������� (�� �����)", $message_, "Content-type: text/html; charset=windows-1251 \r\nFrom:".$_POST['from']);
			}else if ($_POST['id_contact']==2) {
                mail("zakaz@tandem-auto.com.ua", "��������� � ����� ������� (�� �����)", $message_,"Content-type: text/html; charset=windows-1251 \r\nFrom:".$_POST['from']);
			}
?>
			<div ><p>���� ��������� ����������!</p></div>

<?php			
		}else{
?>
		<div ><p>�������� ��� ������! ��������� � ���������� ������ ��� ���!</p></div>
<?php
		}
	}else{ 
	//XMail( $from, $to, $subj, $text, $filename)
	//XMail( "norayrd@rambler.ru", "info@tandem-auto.com.ua", "������ � ���������", "��������", "statusy.xlsx")
?>
<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="�� �������">�������</a><span class="navigation-pipe">&gt;</span><span class="navigation_page">��������</span></div>
</div>
<!-- /Breadcrumb -->

<div id="noro_inner">
<div id="contact-form" class="center_column">
<h1>���� ��������</h1>
	<p class="bold">���� � ��� ���� ������� �� �������, ��� ����� ����� ��������� ���������� � ���������, �� �� ������ �������� �� �������� ����� ����, ��� �� �������� +38(066) 970-12-48.</p>
    <table width="100%">
    <tr>
    <td width="25%"><h3>����</h3><p>��.��������������, 13</p></td>
    <td width="25%"><h3>��������������</h3><p>��.��������, 31</p></td>
    <td width="25%"><h3>���������</h3><p>��.��������, 4</p></td>
    <td width="25%"><h3>�����</h3><p>��.���������, 13</p></td>
    </tr>
    <tr><td colspan=4>&nbsp;</td></tr>
    </table>
		<form action="contact-form.php" method="post" class="std bordercolor" enctype="multipart/form-data" id="contact_form">
		<fieldset>
			<h3>�������� ���������</h3>
			<p class="select">
				<label for="id_contact">��� ��������� *</label>
							<select id="id_contact" name="id_contact" onchange="showElemFromSelect('id_contact', 'desc_contact')">
					<option selected="selected" value="0">-- �������� --</option>
									<option value="2">����� �������</option>
									<option value="1">����������</option>
								</select>
			</p>
			<p id="desc_contact0" class="desc_contact">&nbsp;</p>
									<p id="desc_contact2" class="desc_contact" style="display:none;">
						��� ������� ��������� �������� �� ������� ��� ���������
					</p>
									<p id="desc_contact1" class="desc_contact" style="display:none;">
						��� ������� ����������� �������� ��� ������ �� �����.
					</p>
										<p class="text">
				<label for="email">E-mail *</label>
									<input id="email" name="from" type="text">
							</p>
								<p class="text">
				<label for="id_order">����� ������</label>
									<input name="id_order" id="id_order" type="text">
							</p>
													<p class="text file_input" hidden>
			<label for="fileUpload">������� ����</label>
				<input name="MAX_FILE_SIZE" value="200000000" type="hidden">
				<input name="fileUpload" id="fileUpload" type="file">
			</p>
				<p class="textarea">
			<label for="message">��������� *</label>
			 <textarea id="message" name="message" rows="15" cols="20"></textarea>
		</p>
		<p class="text">
        	<img style=" position:absolute; left:300px" src="capcha.php"><br>
			<label for="id_capcha">��� ������</label>
            
			<input name="id_capcha" id="id_capcha" type="text" style=" width:70px">
		</p>

		<p class="submit">        
			<input name="submitMessage" id="submitMessage" value="���������" class="button_large" type="submit">
		</p>
	</fieldset>
</form>
		</div>
        </div>
<?php 
	}
?>