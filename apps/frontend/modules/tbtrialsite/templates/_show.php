<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php use_helper('Thickbox') ?>
<?php $connection = Doctrine_Manager::getInstance()->connection(); ?>

<script>
    function downloadfile2(id_trialsitephotograph){
        location.href="/tbtrialsite/downloadfile2/?id_trialsitephotograph="+id_trialsitephotograph;
    }

    function viewphotograph(id_trialsitephotograph){
        window.open ("/tbtrialsite/viewphotograph/?id_trialsitephotograph="+id_trialsitephotograph,"View_Photograph");
    }
</script>
<div class="sf_admin_form">
    <?php
    $count = 0;
    foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields):
        $count++;
    endforeach;
    ?>

    <div id="sf_admin_form_tab_menu">
        <?php if ($count > 1) {
 ?>
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
                        <values>
<?php echo $form->getObject()->get('id_trialsite'); ?>
                </values>
            </div>

            <div class="sf_admin_form_row">
                <label>Contact persons:</label>
                <values>
                    <?php
                    $Trialsitecontactperson = Doctrine::getTable('TbTrialsitecontactperson')->findByIdTrialsite($form->getObject()->get('id_trialsite'));
                    $List_contactperson = "";
                    for ($cont = 0; $cont < count($Trialsitecontactperson); $cont++) {
                        $TbContactperson = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($Trialsitecontactperson[$cont]->getIdContactperson());
                        $List_contactperson .= $TbContactperson->getCnprfirstname() . " " . $TbContactperson->getCnprlastname() . " - ";
                    }
                    $List_contactperson = substr($List_contactperson, 0, strlen($List_contactperson) - 3);
                    echo $List_contactperson;
                    ?>
                </values>
            </div>

            <div class="sf_admin_form_row">
                <label>Location:</label>
                <values>
                    <?php
                    $TbLocation = Doctrine::getTable('TbLocation')->findOneByIdLocation($form->getObject()->get('id_location'));
                    echo $TbLocation->getLctname();
                    ?>
                </values>
            </div>

            <div class="sf_admin_form_row">
                <label>Institution:</label>
                <values>
                    <?php
                    $TbInstitution = Doctrine::getTable('TbInstitution')->findOneByIdInstitution($form->getObject()->get('id_institution'));
                    echo $TbInstitution->getInsname();
                    ?>
                </values>
            </div>

            <div class="sf_admin_form_row">
                <label>Country:</label>
                <values>
                    <?php
                    $TbCountry = Doctrine::getTable('TbCountry')->findOneByIdCountry($form->getObject()->get('id_country'));
                    echo $TbCountry->getCntname();
                    ?>
                </values>
            </div>

            <div class="sf_admin_form_row">
                <label>Site Name:</label>
                <values>
<?php echo $form->getObject()->get('trstname'); ?>
                </values>
            </div>

            <div class="sf_admin_form_row">
                <label>Latitude:</label>
                <values>
<?php echo round($form->getObject()->get('trstlatitudedecimal'),3); ?>
                </values>
            </div>

            <div class="sf_admin_form_row">
                <label>Longitude:</label>
                <values>
<?php echo round($form->getObject()->get('trstlongitudedecimal'),3); ?>
                </values>
            </div>

<?php if ($form->getObject()->get('trstaltitude') != '') { ?>
                        <div class="sf_admin_form_row">
                            <label>Altitude:</label>
                            <values>
<?php echo $form->getObject()->get('trstaltitude'); ?>
                    </values>
                </div>
<?php } ?>

                    <div class="sf_admin_form_row">
                        <label>Location verified?: </label>
                        <values>
                    <?php
                    $trststatus = $form->getObject()->get('trststatus');
                    $trststatereason = $form->getObject()->get('trststatereason');
                    if ($trststatus == 'SELECTIVE AVAILABILITY') {
                        echo "<font color='red'>$trststatus - $trststatereason</font> ";
                    } else {
                        echo "$trststatus - $trststatereason";
                    }
                    ?>
                </values>
            </div>

            <?php if ($form->getObject()->get('trstph') != '') {
 ?>
                        <div class="sf_admin_form_row">
                            <label>Ph:</label>
                            <values>
<?php echo $form->getObject()->get('trstph'); ?>
                    </values>
                </div>
<?php } ?>

<?php if ($form->getObject()->get('id_soil') != '') { ?>
                        <div class="sf_admin_form_row">
                            <label>Soil texture:</label>
                            <values>
                    <?php
                        $TbSoil = Doctrine::getTable('TbSoil')->findOneByIdSoil($form->getObject()->get('id_soil'));
                        echo $TbSoil->getSoiname();
                    ?>
                    </values>
                </div>
<?php } ?>

<?php if ($form->getObject()->get('id_taxonomyfao') != '') { ?>
                        <div class="sf_admin_form_row">
                            <label>Taxonomy FAO:</label>
                            <values>
                    <?php
                        $TbTaxonomyfao = Doctrine::getTable('TbTaxonomyfao')->findOneByIdTaxonomyfao($form->getObject()->get('id_taxonomyfao'));
                        echo $TbTaxonomyfao->getTxnname();
                    ?>
                    </values>
                </div>
<?php } ?>

            <?php
                    $TbTrialsiteweatherstation = Doctrine::getTable('TbTrialsiteweatherstation')->findByIdTrialsite($form->getObject()->get('id_trialsite'));

                    if (count($TbTrialsiteweatherstation) > 0) {
            ?>
                        <div class="sf_admin_form_row">
                            <label>Weather stations :</label>
                            <values>
                    <?php
                        $List_weatherstation = "";
                        for ($cont = 0; $cont < count($TbTrialsiteweatherstation); $cont++) {
                            $TbWeatherstation = Doctrine::getTable('TbWeatherstation')->findOneByIdWeatherstation($TbTrialsiteweatherstation[$cont]->getIdWeatherstation());
                            $List_weatherstation .= $TbWeatherstation->getWtstname() . " - ";
                        }
                        $List_weatherstation = substr($List_weatherstation, 0, strlen($List_weatherstation) - 3);
                        echo $List_weatherstation;
                    ?>
                    </values>
                </div>
<?php } ?>

                    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
                        <div class="label ui-helper-clearfix">
                            <label for="tb_trialsite_weathervariablesmeasured">Weather Information File</label>
                        </div>
                <?php
                    //TAMANO DE LAS COLUMNAS
                    $width1 = '30%';
                    $width2 = '30%';
                    $width3 = '15%';
                    $width4 = '15%';
                    $width5 = '10%';
                ?>
                    <div class="label ui-helper-clearfix">
                        <table cellspacing="1" cellpadding="10" border="1" width="100%">
                            <tbody>
                                <tr bgcolor="#C7C7C7">
                                    <td width="<?php echo $width1; ?>"><label>Variables Measured</label></td>
                                    <td width="<?php echo $width2; ?>"><label>File</label></td>
                                    <td width="<?php echo $width3; ?>"><label>Start Date</label></td>
                                    <td width="<?php echo $width4; ?>"><label>End Date</label></td>
                                    <td width="<?php echo $width5; ?>"><label>Actions</label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div>
                        <table cellspacing="1" cellpadding="10" border="1" width="100%">
                        <?php
                        $HTML = "";
                        $QUERY = Doctrine_Query::create()
                                        ->select("TSW.id_trialsiteweather,TSW.trstwtfileaccess,fc_trialsiteweathervariablesmeasured(TSW.id_trialsiteweather) AS variablesmeasured,TSW.trstwtfile,TSW.trstwtstartdate,TSW.trstwtenddate,TSW.trstwtlock")
                                        ->from("TbTrialsiteweather TSW")
                                        ->where("TSW.id_trialsite = {$form->getObject()->get('id_trialsite')}")
                                        ->orderBy("TSW.id_trialsiteweather");
                        //echo $QUERY->getSqlQuery();
                        $Results = $QUERY->execute();
                        $bgcolor = "#C0C0C0";
                        foreach ($Results AS $row) {
                            if ($bgcolor != "#FFFFD9")
                                $bgcolor = "#FFFFD9";
                            else
                                $bgcolor = "#C0C0C0";

                            if ($row['trstwtlock'] == "Y") {
                                $Imag_trstwtlock = "Lock1-icon.png";
                            } else {
                                $Imag_trstwtlock = "Unlock-icon.png";
                            }
                            $HTML .= "<tr bgcolor='$bgcolor'>";
                            $HTML .= "<td width='$width1'>{$row['variablesmeasured']}</td>";
                            $HTML .= "<td width='$width2'>{$row['trstwtfile']}</td>";
                            $HTML .= "<td width='$width3'>{$row['trstwtstartdate']}</td>";
                            $HTML .= "<td width='$width4'>{$row['trstwtenddate']}</td>";
                            $HTML .= "<td width='$width5'>";
                            $HTML .= "</td>";
                            $HTML .= "</tr>";
                        }
                        ?>
                        <tbody id="documents">
<?php echo $HTML; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
                <div class="label ui-helper-clearfix">
                    <label>Others Documents</label>
                </div>
                <?php
                        //TAMANO DE LAS COLUMNAS
                        $width1 = '30%';
                        $width2 = '50%';
                        $width3 = '20%';
                ?>
                        <div class="label ui-helper-clearfix">
                            <table cellspacing="1" cellpadding="10" border="1" width="100%">
                                <tbody>
                                    <tr bgcolor="#C7C7C7">
                                        <td width="<?php echo $width1; ?>"><label>File</label></td>
                                        <td width="<?php echo $width2; ?>"><label>Description</label></td>
                                        <td width="<?php echo $width3; ?>"><label>Actions</label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <table cellspacing="1" cellpadding="10" border="1" width="100%">
                        <?php
                        $HTML2 = "";
                        $QUERY = Doctrine_Query::create()
                                        ->select("TSP.id_trialsitephotograph,TSP.trstphfileaccess,TSP.trstphfile,TSP.trstphpersonphotograph,TSP.trstphlock")
                                        ->from("TbTrialsitephotograph TSP")
                                        ->where("TSP.id_trialsite = {$form->getObject()->get('id_trialsite')}")
                                        ->orderBy("TSP.id_trialsitephotograph");
                        //echo $QUERY->getSqlQuery();
                        $Results = $QUERY->execute();
                        $bgcolor = "#C0C0C0";
                        foreach ($Results AS $row) {
                            if ($bgcolor != "#FFFFD9")
                                $bgcolor = "#FFFFD9";
                            else
                                $bgcolor = "#C0C0C0";

                            if ($row['trstphlock'] == "Y") {
                                $Imag_trstphlock = "Lock1-icon.png";
                            } else {
                                $Imag_trstphlock = "Unlock-icon.png";
                            }
                            $A_Extension = array('JPG', 'JPEG', 'TIFF', 'PNG', 'BMP');
                            $trstphfile = $row['trstphfile'];
                            $PartFile = explode(".", $trstphfile);
                            $Extension = strtoupper($PartFile[1]);

                            $HTML2 .= "<tr bgcolor='$bgcolor'>";
                            $HTML2 .= "<td width='$width1'>{$row['trstphfile']}</td>";
                            $HTML2 .= "<td width='$width2'>{$row['trstphpersonphotograph']}</td>";
                            $HTML2 .= "<td width='$width3'>";
                            if (in_array($Extension, $A_Extension))
                                $HTML2 .= "<span alt='View' onclick='viewphotograph({$row['id_trialsitephotograph']})'><img src=\"/images/images-icon.png\"></span>&ensp;";
                            else
                                $HTML2 .= "<span alt='Download' onclick='downloadfile2({$row['id_trialsitephotograph']})'><img src=\"/images/download-icon.png\"></span>&ensp;";
                            $HTML2 .= "</td>";
                            $HTML2 .= "</tr>";
                        }
                        ?>
                        <tbody id="photographs">
<?php echo $HTML2; ?>
                        </tbody>
                    </table>
                </div>
                <br>
            </div>

<?php if ($form->getObject()->get('id_user') != '') { ?>
                            <div class="sf_admin_form_row">
                                <label>Created by user:</label>
                                <values>
                    <?php
                            $User = Doctrine::getTable('SfGuardUser')->findOneById($form->getObject()->get('id_user'));
                            echo "{$User->getFirst_name()} {$User->getLast_name()}";
                    ?>
                        </values>
                    </div>
<?php } ?>
                    </div>
<?php } ?>
    </div>
</div>