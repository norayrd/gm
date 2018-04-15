<?php
    require_once "scripts/gm_access.php";
    $param_kod=$_GET['kod']-0;
    $param_deliv_id=$_GET['deliv']-0;
    $param_adr_typ=$_GET['deliv_typ']-0;  //=1 забрать на офисе, =2 курьерская доставка
    $param_strahovka=$_GET['strahovka']-0;
    if (($kod_==$param_kod)&&($param_deliv_id>0)) {
        $sql="select f.faces_id,f.name_full,f.deliv_strahovka,f.deliv_need_adr,f.deliv_have_office,f.typ_ from gm_faces f where (f.faces_id=$param_deliv_id)and(f.typ_ in (3,4))";
        $tb=mysql_query($sql);
        @$tb_n=mysql_numrows($tb);
        $tb_perevozchik_typ=3;
        if ($tb_n>0) {
            $tb_perevozchik_faces_id=mysql_result($tb,$i_,"faces_id");    
            $tb_perevozchik_name_full=mysql_result($tb,$i_,"name_full");
            $tb_perevozchik_deliv_strahovka=mysql_result($tb,$i_,"deliv_strahovka");
            $tb_perevozchik_deliv_have_office=mysql_result($tb,$i_,"deliv_have_office");
            $tb_perevozchik_deliv_need_adr=mysql_result($tb,$i_,"deliv_need_adr");
            $tb_perevozchik_typ=mysql_result($tb,$i_,"typ_");
            if ($param_adr_typ==0) {
                if ($tb_perevozchik_deliv_have_office!=0) {
                    $param_adr_typ=1;
                } else if ($tb_perevozchik_deliv_need_adr!=0) {
                    $param_adr_typ=2;
                }
            }

            if ($tb_perevozchik_deliv_strahovka==1) {
?>
                <h2>Страховка</h2>
                <p id="adres_deliv_strahovka" style="left:50px; position:relative;">
                    <label for="deliv_strahovka" >Страховать заказ</label>
                    <input type="checkbox" name="deliv_strahovka" id="deliv_strahovka" value="1" <?php if ($param_strahovka==1) print "checked"?> >
                </p>
<?php
            }
?>
            <?php
            if (($tb_perevozchik_deliv_have_office!=0)||($tb_perevozchik_deliv_need_adr)) {
                $sql="select concat(ifnull(f.name_last,''),' ',ifnull(f.name_first,''),' ',ifnull(f.name_middle,'')) fio_,
                  CONCAT(ifnull(f.tel_,''),';',ifnull(f.tel_mob,''),char(13),
                         ifnull(f.adr_,''),char(13),ifnull(f.city_,''),char(13),
                         ifnull(rg.name_ru,''),char(13),
                         ifnull(cn.name_ru,''),char(13),
                         ifnull(f.zip_,'')) address_
                       from gm_faces f left join gm_country cn on f.country_=cn.country_id
                         left join gm_city ci on f.city_=ci.city_id
                         left join gm_region rg on f.region_=rg.region_id
                      where f.user_id=$user_id
                       limit 0,1 ";
                $tb=mysql_query($sql);
                @$tb_n=mysql_numrows($tb);
                unset($zakaz_add_from_contacts);
                if ($tb_n>0) {
                    $zakaz_add_from_contacts=mysql_result($tb,0,"address_")."";
                    $zakaz_add_from_contacts_poluchatel=mysql_result($tb,0,"fio_")."";
                }    
                ?>
                <h2>Получатель</h2>
                <p>
                    <input type="text" name="deliv_poluchatel" id="deliv_poluchatel" style="left:50px; position:relative;" size="50" value="<?php print $zakaz_add_from_contacts_poluchatel; ?>">
                </p>
                <h2>Адрес доставки</h2>
            <?php
                if (($tb_perevozchik_deliv_need_adr!=0)&&($tb_perevozchik_deliv_have_office!=0)) {
            ?>
                <p style="left:50px; position:relative;">
                    <select name="deliv_typ" id="deliv_typ" style=" background: #FF9999; color: #FFFFFF;" onchange="javascript: if ($('#deliv_strahovka')[0].checked) strahovka_=1; else strahovka_=0; $('#deliv_info').load('_order_deliv.php?kod=<?php print $kod_; ?>&deliv='+$('#deliv_id').val()+'&deliv_typ='+$('#deliv_typ').val()+'&strahovka='+strahovka_)" >
                        <option value="1" <?php if ($param_adr_typ==1) print "selected"; ?> >Забрать на офисе перевозчика</option>
                        <option value="2" <?php if ($param_adr_typ==2) print "selected"; ?> >Курьерская доставка по Вашему адресу</option>
                    </select>
                </p>
            <?php
                }
            ?>
            <?php
            }
            ?>
            <?php
            if (($param_adr_typ==1)&&($tb_perevozchik_deliv_have_office!=0)) {
                $sql="select od.deliv_office_id id_, concat(trim(city_),', ',od.adr_) name_, concat(coalesce(rg.name_ru,''),' ',cn.name_ru) rgn_ 
                        from gm_deliv_office od left join gm_country cn on cn.country_id=od.country_id 
                             left join gm_region rg on rg.region_id=od.region_id
                       where od.faces_id=$param_deliv_id order by rgn_,name_";
                $tb=mysql_query($sql);
                @$tb_n=mysql_numrows($tb);
                $i_=0;
                $deloffice_options="";
                $tb_deloffice_rgn_old="";
                while ($i_<$tb_n) {
                    $tb_deloffice_id=mysql_result($tb,$i_,"id_");    
                    $tb_deloffice_name=mysql_result($tb,$i_,"name_");
                    $tb_deloffice_rgn=mysql_result($tb,$i_,"rgn_");
                    if (($tb_deloffice_rgn!='')&&($tb_deloffice_rgn!=$tb_deloffice_rgn_old)) {
                        $deloffice_options=$deloffice_options."<optgroup label='$tb_deloffice_rgn'></optgroup>"; 
                    }
                    $deloffice_options=$deloffice_options."<option value='".$tb_deloffice_id."'>$tb_deloffice_name</option>";
                    $i_+=1;
                    $tb_deloffice_rgn_old=$tb_deloffice_rgn;
                }
                if ($deloffice_options) {
            ?>   
                <p style="left:50px; position:relative;"> 
                    <select name="deliv_office" id="deliv_office" style="width: 300px" >
                        <option selected="selected" value="0">-</option>
                        <?php print $deloffice_options; ?>
                    </select>
                </p>
                
            <?php
                }
            }
            ?>

<?php
            if (($param_adr_typ==2)&&($tb_perevozchik_deliv_need_adr!=0)) {
?>
                <br>              
                <div class="cart_block_customizations" >
                <?php if (isset($zakaz_add_from_contacts)) { ?>
                    <div style="left:50px; position:relative;">
                        <input type="radio" name="cart_address" id="cart_address1" value="1" ><label for="cart_address">По моему адресу из контактов</label>
                        <br><br>
                        <div style="position:relative; left:50px;">
                            <textarea id="addres1" cols="50" rows="7" readonly ><?php print "$zakaz_add_from_contacts"; ?></textarea>
                        </div>
                    </div>
                    <br>
                <?php } ?>
                    <div style="left:50px; position:relative;">
                        <input type="radio" name="cart_address" id="cart_address2" value="2" > <label for="cart_address">По другому адресу</label>
                        <br><br>
                        <div style="position:relative; left:50px;">
                            <table><tr>
                            <td><textarea id="addres2" class="cart_quantity_input text"  cols="50" rows="7" ></textarea></td>
                            <td width="10"></td>
                            <td><label>Пример: <br>Иванов Иван Иванович<br>тел. +380123456789<br>ул.Космонавта, 6, кв.3<br>г.Донецк<br>Донецкая облать<br>Украина<br>83011</label></td>
                            </tr></table>
                        </div>
                    </div>
                </div>
<?php
            }
?>
        <script type="text/javascript">       
            function totalSubmit(){
                res=true;
                $('#deliv_adr').val('');
                <?php if (($tb_perevozchik_deliv_need_adr!=0)&&($param_adr_typ==2)) { ?>
                if (document.getElementsByName('cart_address')[0].checked) $('#deliv_adr').val($('#addres1').val());
                else 
                if (document.getElementsByName('cart_address')[1].checked) $('#deliv_adr').val($('#addres2').val());
                <?php } ?>
                <?php if ($tb_perevozchik_deliv_strahovka!=0) { ?>
                if (!$('#deliv_strahovka')[0].checked) {
                    res= confirm('Выбранный способ доставки позволяет застраховать товар, на случай его повреждения при транспортировке.\r\nЗаказать без страховки?');
                } else res=true;
                <?php } ?>
                return res;
            }
        </script>

<?php
        }
    }
?>

                                                                                                                                                              
