		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
<?php
require_once "scripts/gm_access.php";
if ($user_group<2) {
    //print "������ ��������!";
    include "_autentication.php";
    exit;
}

 $post_tov_make=$_POST['tov_make']."";
 $post_used_incroses=$_POST['used_incroses'];
 
 $post_recalc=$_POST['used_incroses']-0;
 if ($post_recalc==1) {
     mysql_query("call gm_tov_make_count(null); ");
 }
?> 


<!-- Breadcrumb -->
<div class="breadcrumb bordercolor">
<div class="breadcrumb_inner">
	<a href="index.php" title="�� �������">�������</a><span class="navigation-pipe">&gt;</span><a href="authentication.php" title="������� ������">������� ������</a><span class="navigation-pipe">&gt;</span>������</div>
</div>
<!-- /Breadcrumb -->
<div id="noro_inner">
<h1>������<span class="category-product-count"><form action="#" method="post"><input type="hidden" name="recalc" value="1"><input type="submit" value="�����������" style="background-color: green; color: #aaaaaa; cursor:pointer;" title="������� �����!" onclick="return confirm('�����������? ����������� ��������� �����!');"></form></span>
		</h1>
			<p class="cat_desc bordercolor bgcolor">������� ������ ��������� ���������������� ������.</p>
		<!-- Sort products -->
<div class="product_sort">
<table width="100%" bordercolor="#2a2f33">
        <tr>
			<td width="100%" align="right">
            </td>
		</tr>
        <tr>
            <td>

<table id="search_res" width="100%" class="noro_table">
<thead>
    <tr>
        <th width="30px">�</th>
        <th width="30px">ID</th>
        <th width="30px"></th>
        <th width="200px">�����</th>
        <th width="40px">����� ������������</th>
        <th width="40px">������������ � ������</th>
        <th width="10px"></th>
        <th width="10px"></th>
        <th width="10px"></th>
    </tr>
    <form action="#" method="post">
    <nobr>
    <tr>
        <th style="background-color: #cccccc;"></th>
        <th style="background-color: #cccccc;"></th>
        <th style="background-color: #cccccc;"></th>
        <th style="background-color: #cccccc;">
                    <input type="text" value="<?php print $post_tov_make; ?>" name="tov_make" size="25">
        </th>
        <th style="background-color: #cccccc;"></th>
        <th style="background-color: #cccccc;">
                    <input type="checkbox" name="used_incroses" value="1" <?php if ($post_used_incroses==1) print "checked"; ?>> <label>�������</label>
        </th>
        <th style="background-color: #cccccc;"></th>
        <th style="background-color: #cccccc;">
                    <input type="submit" value="�����" style="background-color: #5555FF; color: #cccccc;">
        </th>
        <th style="background-color: #cccccc;"></th>
    </tr>
    </nobr>
    </form>
</thead>
<tbody>
    
<script type="text/javascript">
    function ch_make(r,com){
        if ( (com==2) && confirm('������� ������ "'+$('#tm'+r).html()+'"?') )  $('#r'+r).load('_makes_row.php?kod_=<?php print $kod_; ?>&r='+r+'&com='+com);
        if (com==3) {
            txt='������� ������ ��� "'+$('#tm'+r).html()+'"';
            tmp_tov_make=prompt(txt,'');
            if (tmp_tov_make!=null) {
                new_tov_make= parseInt(tmp_tov_make);
                if (isNaN(new_tov_make)) alert('�� �� ������� �������� ��������!'); 
                else $('#r'+r).load('_makes_row.php?kod_=<?php print $kod_; ?>&r='+r+'&n='+new_tov_make+'&com='+com);
            }
        }
    }
</script>
    <?php
	//���������� �����
$sql= "select tov_make_kod, tov_make, used_count, used_incroses from p_tov_make t where 1=1";
if ($post_tov_make!="") $sql=$sql." and tov_make like '%{$post_tov_make}%' ";
if ($post_used_incroses==1) $sql=$sql." and used_incroses=0 ";
$sql=$sql." order by 2";
$tb=mysql_query($sql) or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$i=0;
while($i<$tb_n){
	$tb_tov_make_kod=mysql_result($tb,$i,"tov_make_kod");
    $tb_tov_make=mysql_result($tb,$i,"tov_make");
    $tb_used_count=mysql_result($tb,$i,"used_count");
    $tb_used_incroses=mysql_result($tb,$i,"used_incroses");
?>
      <tr class="<?php if (($i % 2)==0) print "even"; else print "odd"; ?>" style="<?php if ($tb_used_count==0) { print "background-color:#FF9999"; } ?>" id="r<?php print $tb_tov_make_kod; ?>">
        <td><?php print $i+1; ?></td>
        <td align=right><?php print $tb_tov_make_kod; ?></td>
        <td></td>
        <td id="tm<?php print $tb_tov_make_kod; ?>"> <?php print $tb_tov_make; ?></td>
        <td align=right><?php print $tb_used_count; ?></td>
        <td align=right><?php print $tb_used_incroses; ?></td>
        <td></td>
        <td align="center"><input type="button" id="z<?php print $tb_tov_make_kod; ?>" value="Z" onclick="ch_make(<?php print $tb_tov_make_kod; ?>,3);" style="cursor:pointer;" title="�������� �� ..." class="button"></td>
        <td align="center"><input type="button" id="b<?php print $tb_tov_make_kod; ?>" value="X" onclick="ch_make(<?php print $tb_tov_make_kod; ?>,2);" style="cursor:pointer;" title="�������" class="button_red"></td>
      </tr>
<?php
	$i++;
}
?>	        
    
</tbody>
</table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;
                
            </td>
        </tr>
        <tr>
            <td>&nbsp;
                
            </td>
        </tr>
        </table>
        
        
</div>



	</div>