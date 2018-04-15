<?php 
	include "gm_access.php"; 
?>
			<label for="avto_marka">Марка</label>
			<select name="avto_marka" id="avto_marka" onchange="loadAvtoModel(); ">
				<option selected="selected" value="">-</option>
<?php
$sql="select marka_id, name_ from gm_avto_marka order by name_;";
$tb=mysql_query($sql) or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$i=0;
while($i<$tb_n){
    $tb_marka_id=mysql_result($tb,$i,"marka_id");	
    $tb_marka_name=mysql_result($tb,$i,"name_");	
?>
<option value="<?php print $tb_marka_id; ?>"><?php print $tb_marka_name; ?></option>
<?php
	$i++;
}
?>
			</select>
        