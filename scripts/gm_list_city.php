<?php 
	include "gm_access.php"; 
	$region_id=$_GET["region_id"];
?>
			<label for="id_city">Город</label>
			<select name="id_city" id="id_city" >
				<option selected="selected" value="">-</option>
<?php
$sql="select city_id, name_ru from gm_city where region_id='$region_id' order by name_ru;";
$tb=mysql_query($sql) or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$i=0;
while($i<$tb_n){
    $tb_city_id=mysql_result($tb,$i,"city_id");	
    $tb_city_name=mysql_result($tb,$i,"name_ru");	
?>
<option value="<?php print $tb_city_id; ?>"><?php print $tb_city_name; ?></option>
<?php
	$i++;
}
?>
			</select>
			<sup>*</sup>