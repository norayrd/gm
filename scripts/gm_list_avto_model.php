<?php 
	include "gm_access.php"; 
	$avto_marka=$_GET['avto_marka'];
?>
			<label for="avto_model">Модель</label>
			<select name="avto_model" id="avto_model">
				<option selected="selected" value="">-</option>
<?php
$sql="select model_id, name_ from gm_avto_model where marka_id=$avto_marka order by name_;";
$tb=mysql_query($sql) or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$i=0;
while($i<$tb_n){
    $tb_model_id=mysql_result($tb,$i,"model_id");	
    $tb_model_name=mysql_result($tb,$i,"name_");	
?>
<option value="<?php print $tb_model_id; ?>"><?php print $tb_model_name; ?></option>
<?php
	$i++;
}
?>
			</select>
                