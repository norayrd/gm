<?php 
	include "gm_access.php"; 
	$country_id=$_GET["country_id"];
	$region_id=$_GET["region_id"];
?>

			<label for="id_region">Область</label>
			<select name="id_region" id="id_region" >
<?php
$sql="select region_id, name_ru from gm_region where country_id='$country_id' order by name_ru;";
$tb=mysql_query($sql) or die(mysql_error());
@$tb_n=mysql_numrows($tb);
$i=0;
$selected=0;
while($i<$tb_n){
    $tb_region_id=mysql_result($tb,$i,"region_id");	
    $tb_region_name=mysql_result($tb,$i,"name_ru");	
?>
<option <?php if ($region_id==$tb_region_id) { print "selected"; $selected=1; } ?> value="<?php print $tb_region_id; ?>"><?php print $tb_region_name; ?></option>
<?php
	$i++;
}
?>
				<option <?php if ($selected==0) print "selected"; ?> value="">-</option>
			</select>
			<sup>*</sup>
