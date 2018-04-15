<fieldset class="account_creation">
		<h3>Транспортное средство</h3>
					<p class="text">
			<label for="avto_vin">VIN код</label>
			<input id="avto_vin" name="avto_vin" type="text" value="<?php if (isset($_POST["avto_vin"])) print $_POST["avto_vin"]; else print $avto_vin; ?>" />
		</p>
		<p id="select_avto_marka" class="text">
			<label for="avto_marka">Марка</label>
            <input name="avto_marka" id="avto_marka" type="text" value="<?php if (isset($_POST["avto_marka"])) print $_POST["avto_marka"]; else print $avto_marka; ?>"/>
			<!--select name="avto_marka" id="avto_marka">
				<option selected="selected" value="">-</option>
			</select-->
		</p>
        <!--script type="text/javascript">
			function loadAvtoMarka(){
				          $('#select_avto_marka').load("./scripts/gm_list_avto_marka.php");
			}
			loadAvtoMarka();
			          </script-->
		<p id="select_avto_model" class="text">
			<label for="avto_model">Модель</label>
            <input  name="avto_model" id="avto_model" type="text" value="<?php if (isset($_POST["avto_model"])) print $_POST["avto_model"]; else print $avto_model; ?>"/>
			<!--select name="avto_model" id="avto_model">
				<option selected="selected" value="">-</option>
			</select-->
		</p>
        <!--script type="text/javascript">
			function loadAvtoModel(){
				          $('#select_avto_model').load("./scripts/gm_list_avto_model.php?avto_marka="+document.getElementById('avto_marka').value);
			}
			loadAvtoModel();
			          </script-->
		<p class="text">
			<label for="avto_year">Год выпуска</label>
			<input id="avto_year" name="avto_year" type="text" value="<?php if (isset($_POST["avto_year"])) print $_POST["avto_year"]; else print $avto_year; ?>"/>
		</p>
        <p class="required select" id="p_id_kuzov">
            <label for="avto_kuzov">Кузов</label>
            <select name="avto_kuzov" id="avto_kuzov">
                <?php
                $sql="select value_id, name_ from gm_value where group_=1 order by order_, name_;";
                $tb=mysql_query($sql) or die(mysql_error());
                @$tb_n=mysql_numrows($tb);
                $selected=0;
                $i=0;
                while($i<$tb_n){
                    $tb_id=mysql_result($tb,$i,"value_id");
                    $tb_name=mysql_result($tb,$i,"name_");
                ?>
                <option <?php if ((isset($_POST["avto_kuzov"])&& ($_POST["avto_kuzov"]==$tb_id))||($avto_kuzov==$tb_id)) { print "selected"; $selected=1; } print $_POST["avto_kuzov"]." == $tb_id" ?> value="<?php print $tb_id; ?>"><?php print $tb_name; ?></option>
                <?php
                    $i++;
                }
                ?>
                <option value="" <? if ($selected==0) print "selected"; ?> >-</option>
            </select>
        </p>      
        
        <p id="p_id_dvig" class="text">
            <label for="avto_dvig">Объем двигателя</label>
            <input  name="avto_dvig" id="avto_dvig" type="text" value="<?php if (isset($_POST["avto_dvig"])) print $_POST["avto_dvig"]; else print $avto_dvig; ?>"/>
        </p>
        
        <p class="required select" id="p_id_toplivo">
            <label for="avto_toplivo">Топливо</label>
            <select name="avto_toplivo" id="avto_toplivo">
                <?php
                $sql="select value_id, name_ from gm_value where group_=3 order by order_, name_;";
                $tb=mysql_query($sql) or die(mysql_error());
                @$tb_n=mysql_numrows($tb);
                $selected=0;
                $i=0;
                while($i<$tb_n){
                    $tb_id=mysql_result($tb,$i,"value_id");
                    $tb_name=mysql_result($tb,$i,"name_");
                ?>
                <option <?php if ((isset($_POST["avto_toplivo"])&& ($_POST["avto_toplivo"]==$tb_id))||($avto_toplivo==$tb_id)) { print "selected"; $selected=1; } ?> value="<?php print $tb_id; ?>"><?php print $tb_name; ?></option>
                <?php
                    $i++;
                }
                ?>
                <option value="" <? if ($selected==0) print "selected"; ?> >-</option>
            </select>
        </p>        
        <p class="required select" id="p_id_kpp">
            <label for="avto_kpp">КПП</label>
            <select name="avto_kpp" id="avto_kpp">
                <?php
                $sql="select value_id, name_ from gm_value where group_=4 order by order_, name_;";
                $tb=mysql_query($sql) or die(mysql_error());
                @$tb_n=mysql_numrows($tb);
                $selected=0;
                $i=0;
                while($i<$tb_n){
                     $tb_id=mysql_result($tb,$i,"value_id");
                    $tb_name=mysql_result($tb,$i,"name_");
                ?>
                <option <?php if ((isset($_POST["avto_kpp"])&& ($_POST["avto_kpp"]==$tb_id))||($avto_kpp==$tb_id)) { print "selected"; $selected=1; } ?> value="<?php print $tb_id; ?>"><?php print $tb_name; ?></option>
                <?php
                    $i++;
                }
                ?>
                <option value="" <? if ($selected==0) print "selected"; ?> >-</option>
            </select>
        </p>        

	</fieldset>