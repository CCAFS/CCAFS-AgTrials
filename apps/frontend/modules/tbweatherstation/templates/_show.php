<?php
include_stylesheets_for_form($form);
include_javascripts_for_form($form);
use_helper('Thickbox');
$id_weatherstation = $form->getObject()->get('id_weatherstation');
?>
<script>
    $(document).ready(function() {
        $('#downloadweatherinformation').click(function() {
            var startdate = $('#startdate').attr('value');
            var enddate = $('#enddate').attr('value');
            if(startdate == '' || enddate == ''){
                jAlert('error', 'Start date y/o End date','Incomplete Information', null);
            }else{
                window.open ("/tbweatherstation/downloadweatherinformation/?id_weatherstation=<?php echo $form->getObject()->get('id_weatherstation'); ?>&startdate="+startdate+"&enddate="+enddate,"downloadweatherinformation");
            }
        });
        
        //        $("#startdate").datetimepicker();
        //        $("#enddate").datetimepicker();
       
        $("#startdate").datepicker({changeYear: true, dateFormat: 'dd-mm-yy' });
        $("#enddate").datepicker({changeYear: true, dateFormat: 'dd-mm-yy' });
    });
</script>
<div class="sf_admin_form">
    <?php
    $count = 0;
    foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields):
        $count++;
    endforeach;
    ?>

    <div id="sf_admin_form_tab_menu">
        <?php if ($count > 1) { ?>
            <ul>
                <?php foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields): ?>
                    <?php $count++ ?>
                    <li><a href="#sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>"><?php echo __($fieldset, array(), 'messages') ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php } ?>

        <?php foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields) { ?>
            <div id="sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>">
                <div class="sf_admin_form_row">
                    <label>Id:</label>
                    <values><?php echo $form->getObject()->get('id_weatherstation'); ?></values>

                </div>

                <div class="sf_admin_form_row">
                    <label>Country:</label>
                    <values>
                        <?php
                        if ($form->getObject()->get('id_country') != '') {
                            $country = Doctrine::getTable('TbCountry')->findOneByIdCountry($form->getObject()->get('id_country'));
                            echo $country->getCntname();
                        }
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Institution:</label>
                    <values>
                        <?php
                        if ($form->getObject()->get('id_institution') != '') {
                            $Institution = Doctrine::getTable('TbInstitution')->findOneByIdInstitution($form->getObject()->get('id_institution'));
                            echo $Institution->getInsname();
                        }
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Contact person:</label>
                    <values>
                        <?php
                        if ($form->getObject()->get('id_contactperson') != '') {
                            $Contactperson = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($form->getObject()->get('id_contactperson'));
                            echo $Contactperson->getCnprfirstname() . " " . $Contactperson->getCnprlastname() . " - <a href=\"mailto:{$Contactperson->getCnpremail()}\"><font color=\"#48732A\">{$Contactperson->getCnpremail()}</font></a>";
                        }
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Name:</label>
                    <values><?php echo $form->getObject()->get('wtstname'); ?></values>

                </div>

                <div class="sf_admin_form_row">
                    <label>Latitude:</label>
                    <values><?php echo $form->getObject()->get('wtstlatitude'); ?></values>

                </div>

                <div class="sf_admin_form_row">
                    <label>Longitude:</label>
                    <values><?php echo $form->getObject()->get('wtstlongitude'); ?></values>

                </div>

                <div class="sf_admin_form_row">
                    <label>Elevation:</label>
                    <values><?php echo $form->getObject()->get('wtstelevation'); ?></values>

                </div>

                <div class="sf_admin_form_row">
                    <label>Access Restricted?:</label>
                    <values><?php echo $form->getObject()->get('wtstrestricted'); ?></values>
                </div>

                <?php if ($form->getObject()->get('wtstlicence') != '') { ?>
                    <div class="sf_admin_form_row">
                        <label>Access and Use Constraints:</label>
                        <values><?php echo $form->getObject()->get('wtstlicence'); ?></values>
                    </div>
                <?php } ?>

                <?php if ($form->getObject()->get('id_weatherstationsource') != '') { ?>
                    <div class="sf_admin_form_row">
                        <label>Source of data:</label>
                        <values> 
                            <?php
                            if ($form->getObject()->get('id_weatherstationsource') != '') {
                                $Weatherstationsource = Doctrine::getTable('TbWeatherstationsource')->findOneByIdWeatherstationsource($form->getObject()->get('id_weatherstationsource'));
                                echo $Weatherstationsource->getWtstsrname();
                            }
                            ?>
                        </values>
                    </div>
                <?php } ?>

<!--                <div class="sf_admin_form_row">
                    <label>Information of data</label>
                    <values>
                        <br>
                        <span><b>Years: </b></span><span>(<?php //echo YearsYeatherstation($id_weatherstation); ?>)</span><br>
                        <span><b>Meteorological fields: </b></span><span>(<?php //echo MeteorologicalfieldsWeatherstation($id_weatherstation); ?>)</span><br>
                    </values>
                </div>-->

                <?php
                if ($sf_user->isAuthenticated()) {
                    $id_user = sfContext::getInstance()->getUser()->getGuardUser()->getId();
                    if (($form->getObject()->get('wtstrestricted') == 'NO') || (Weatherstationuserpermission($id_weatherstation, $id_user))) {
                        ?>
                        <div class="sf_admin_form_row">
                            <label>Download weather information:</label>
                            <values>
                                Start date<input type="text" name="startdate" id="startdate" size="10" maxlength="10" value="">&ensp;&ensp;
                                End date<input type="text" name="enddate" id="enddate" size="10" maxlength="10" value="">
                                <input type='button' value='Download' id='downloadweatherinformation' name='downloadweatherinformation'>
                            </values>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>