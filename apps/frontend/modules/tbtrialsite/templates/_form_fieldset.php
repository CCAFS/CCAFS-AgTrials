<?php use_helper('Thickbox') ?>
<script>
    $(document).ready(function() {
        $('#otherfile').click(function() {
            var filadocument = $('#filadocument').attr('value');
            filadocument = (filadocument * 1) + 1;
            $('#document' + filadocument).show();
            $('#filadocument').attr('value', filadocument);
        });

        $('#nextphotograph').click(function() {
            var filaphotograph = $('#filaphotograph').attr('value');
            filaphotograph = (filaphotograph * 1) + 1;
            $('#photograph' + filaphotograph).show();
            $('#filaphotograph').attr('value', filaphotograph);
        });

    });
    function deletenew(i) {
        $('#variablesmeasured' + i).attr('value', '');
        $('#trstwtstartdate' + i).attr('value', '');
        $('#trstwtenddate' + i).attr('value', '');
        $('#file' + i).attr('value', '');
        $('#document' + i).hide();
    }

    function deletenew2(i) {
        $('#trstphfileaccess' + i).attr('value', '');
        $('#trstphfile' + i).attr('value', '');
        $('#trstphpersonphotograph' + i).attr('value', '');
        $('#photograph' + i).hide();
    }

    function deleterow(id_trialsiteweather) {
        $.ajax({
            type: "GET",
            url: "/tbtrialsite/deleterow/",
            data: "id_trialsiteweather=" + id_trialsiteweather,
            success: function(data) {
                $('#documents').html(data);
            }
        });
    }

    function deleterow2(id_trialsitephotograph) {
        $.ajax({
            type: "GET",
            url: "/tbtrialsite/deleterow2/",
            data: "id_trialsitephotograph=" + id_trialsitephotograph,
            success: function(data) {
                $('#photographs').html(data);
            }
        });

    }

    function Lock_Unlock(id_trialsiteweather) {
        $.ajax({
            type: "GET",
            url: "/tbtrialsite/LockUnlock/",
            data: "id_trialsiteweather=" + id_trialsiteweather,
            success: function(data) {
                $('#documents').html(data);
            }
        });
    }

    function Lock_Unlock2(id_trialsitephotograph) {
        $.ajax({
            type: "GET",
            url: "/tbtrialsite/LockUnlock2/",
            data: "id_trialsitephotograph=" + id_trialsitephotograph,
            success: function(data) {
                $('#photographs').html(data);
            }
        });
    }

    function downloadfile(id_trialsiteweather) {
        location.href = "/tbtrialsite/downloadfile/?id_trialsiteweather=" + id_trialsiteweather;
    }

    function downloadfile2(id_trialsitephotograph) {
        location.href = "/tbtrialsite/downloadfile2/?id_trialsitephotograph=" + id_trialsitephotograph;
    }

    function viewphotograph(id_trialsitephotograph) {
        window.open("/tbtrialsite/viewphotograph/?id_trialsitephotograph=" + id_trialsitephotograph, "View_Photograph");
    }

    $(function() {
        $("#trstwtstartdate1").datepicker();
        $("#trstwtenddate1").datepicker();
        $("#trstwtstartdate2").datepicker();
        $("#trstwtenddate2").datepicker();
        $("#trstwtstartdate3").datepicker();
        $("#trstwtenddate3").datepicker();
        $("#trstwtstartdate4").datepicker();
        $("#trstwtenddate4").datepicker();
        $("#trstwtstartdate5").datepicker();
        $("#trstwtenddate5").datepicker();
        $("#trstwtstartdate6").datepicker();
        $("#trstwtenddate6").datepicker();
        $("#trstwtstartdate7").datepicker();
        $("#trstwtenddate7").datepicker();
        $("#trstwtstartdate8").datepicker();
        $("#trstwtenddate8").datepicker();
        $("#trstwtstartdate9").datepicker();
        $("#trstwtenddate9").datepicker();
        $("#trstwtstartdate10").datepicker();
        $("#trstwtenddate10").datepicker();
    });
</script>

<div class="ui-corner-all" id="sf_fieldset_none">
    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_institution']->renderLabel('Institution') ?>
            <?php echo HelpModule("Trial site", "id_institution"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_institution']->renderError() ?>
        </div>
        <?php echo $form['id_institution']->render() ?>
        <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tbinstitution/new', array('pop' => '1'), array(), array('width' => '500', 'height' => '500')) ?>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <div class="label ui-helper-clearfix">
                <label>Contact persons</label>
                <?php echo HelpModule("Trial site", "id_contactperson"); ?>
            </div>
        </div>
        <?php
        $id_trialsite = $form->getObject()->get('id_trialsite');
        $user = sfContext::getInstance()->getUser();
        $session_contactperson_name = $user->getAttribute('contactperson_name');
        $list_contactperson = "";
        if (isset($session_contactperson_name)) {
            foreach ($session_contactperson_name as $contactperson) {
                $list_contactperson .= $contactperson . ", ";
            }
            $list_contactperson = substr($list_contactperson, 0, strlen($list_contactperson) - 2);
        }
        echo thickbox_iframe("<textarea id='contactperson' name='contactperson' readonly='readonly' cols='37' rows='2'>$list_contactperson</textarea>" . image_tag('user.jpg'), '@trialsitecontactperson', array('pop' => '1'));
        echo thickbox_iframe(image_tag('add-icon.png'), 'tbcontactperson/new', array('pop' => '1'), array(), array('width' => '500', 'height' => '500'))
        ?>
    </div>
    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_country']->renderLabel('Country') ?>
            <?php echo HelpModule("Trial site", "id_country"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_country']->renderError() ?>
        </div>
        <?php echo $form['id_country']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_location']->renderLabel('Location') ?>
            <?php echo HelpModule("Trial site", "id_location"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_location']->renderError() ?>
        </div>
        <?php echo $form['id_location']->render() ?>
        <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tblocation/new', array('pop' => '1'), array(), array('width' => '500', 'height' => '500')) ?>

    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trstname']->renderLabel('Name') ?>
            <?php echo HelpModule("Trial site", "trstname"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trstname']->renderError() ?>
        </div>
        <?php echo $form['trstname']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trstlatitude']->renderLabel('Latitude') ?>
            <?php echo HelpModule("Trial site", "trstlatitude"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trstlatitude']->renderError() ?>
        </div>
        <div class="help">
            <span class="ui-icon ui-icon-help floatleft"></span>
            Latitude of site. Degree (2 digits) minutes (2 digits), and seconds (2 digits) followed by N (North) or S (South) (e.g. 103020S).
        </div>
        <?php echo $form['trstlatitude']->render() ?>
        <?php echo thickbox_iframe(image_tag('map.gif'), '@maptrialsites', array('pop' => '1'), array(), array('width' => '800', 'height' => '600')) ?>

        <br>
        <b>or</b>
        <div class="help">
            <span class="ui-icon ui-icon-help floatleft"></span>
            Latitude of site. Decimal degrees (e.g. -10.505556).
        </div>
        <?php echo $form['trstlatitudedecimal']->render() ?>
        <?php echo thickbox_iframe(image_tag('map.gif'), '@maptrialsites', array('pop' => '1'), array(), array('width' => '800', 'height' => '600')) ?>

    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trstlongitude']->renderLabel('Longitude') ?>
            <?php echo HelpModule("Trial site", "trstlongitude"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trstlongitude']->renderError() ?>
        </div>
        <div class="help">
            <span class="ui-icon ui-icon-help floatleft"></span>
            Longitude of site. Degree (3 digits), minutes (2 digits), and seconds (2 digits) followed by E (East) or W (West) (e.g. 0762510W).
        </div>
        <?php echo $form['trstlongitude']->render() ?>
        <?php echo thickbox_iframe(image_tag('map.gif'), '@maptrialsites', array('pop' => '1'), array(), array('width' => '800', 'height' => '600')) ?>
        <br>
        <b>or</b>
        <div class="help">
            <span class="ui-icon ui-icon-help floatleft"></span>
            Longitude of site. Decimal degrees (e.g. 76.419444).
        </div>
        <?php echo $form['trstlongitudedecimal']->render() ?>
        <?php echo thickbox_iframe(image_tag('map.gif'), '@maptrialsites', array('pop' => '1'), array(), array('width' => '800', 'height' => '600')) ?>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trstaltitude']->renderLabel('Altitude') ?>
            <?php echo HelpModule("Trial site", "trstaltitude"); ?>
        </div>
        <div class="help">
            <span class="ui-icon ui-icon-help floatleft"></span>
            Elevation of site expressed in meters above sea level. Negative values are allowed (e.g. -1500).
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trstaltitude']->renderError() ?>
        </div>
        <?php echo $form['trstaltitude']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trstph']->renderLabel('Ph') ?>
            <?php echo HelpModule("Trial site", "trstph"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trstph']->renderError() ?>
        </div>
        <?php echo $form['trstph']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_soil']->renderLabel('Soil texture') ?>
            <?php echo HelpModule("Trial site", "id_soil"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_soil']->renderError() ?>
        </div>
        <?php echo $form['id_soil']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_taxonomyfao']->renderLabel('Taxonomy FAO') ?>
            <?php echo HelpModule("Trial site", "id_taxonomyfao"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_taxonomyfao']->renderError() ?>
        </div>
        <?php echo $form['id_taxonomyfao']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['weatherstation']->renderLabel('Weather stations') ?>
            <?php echo HelpModule("Trial site", "Weather stations"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['weatherstation']->renderError() ?>
        </div>
        <?php
        $user = sfContext::getInstance()->getUser();
        $session_weatherstation_name = $user->getAttribute('weatherstation_name');
        $list_weatherstation = "";
        if (isset($session_weatherstation_name)) {
            foreach ($session_weatherstation_name as $weatherstation) {
                $list_weatherstation .= $weatherstation . ", ";
            }
            $list_weatherstation = substr($list_weatherstation, 0, strlen($list_weatherstation) - 2);
        }
        echo thickbox_iframe("<textarea id='tb_trialsite_weatherstation' name='tb_trialsite_weatherstation' readonly='readonly' cols='58' rows='5'>$list_weatherstation</textarea> " . image_tag('list-icon.png'), '@trialsiteweatherstation', array('pop' => '1'))
        ?>
    </div>

    <?php
    $trstsupplementalinformationfile = $form->getObject()->get('trstsupplementalinformationfile');
    if ($trstsupplementalinformationfile != '') {
        echo "<A HREF='/uploads/$trstsupplementalinformationfile'> **** Download File *** </A>";
    }
    ?>

    <!--  PARTE PARA CARGAR MULTIPLES ARCHIVOS  -->
    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <label for="tb_trialsite_weathervariablesmeasured">Weather Information File</label>
            <?php echo HelpModule("Trial site", "Weather Information File"); ?>
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
        <?php if ($form->getObject()->get('id_trialsite')) {
            ?>
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
                        $HTML .= "<span title='Download' alt='Download' onclick='downloadfile({$row['id_trialsiteweather']})'><img src=\"/images/download-icon.png\"></span>&ensp;";
                        $HTML .= "<span title='Delete' alt='Delete' onclick='deleterow({$row['id_trialsiteweather']})'><img src=\"/images/cross.png\"></span>&ensp;";
                        $HTML .= "<span title='Click on the lock to change' alt='Click on the lock to change' onclick='Lock_Unlock({$row['id_trialsiteweather']})'><img src=\"/images/$Imag_trstwtlock\"></span>&ensp;";
                        $HTML .= "</td>";
                        $HTML .= "</tr>";
                    }
                    ?>
                    <tbody id="documents">
                        <?php echo $HTML; ?>
                    </tbody>
                </table>
            </div>
            <br>
        <?php } ?>
        <div id="document1">
            <table cellspacing="1" cellpadding="10" border="1" width="100%">
                <tbody>
                    <tr>
                        <td width="<?php echo $width1; ?>">
                            <?php echo thickbox_iframe("<input type=\"text\" size=\"35\" id=\"variablesmeasured1\" name=\"variablesmeasured1\">", "@weathervariablesmeasuredlist", array('pop' => '1', 'fila' => '1'), array(), array('width' => '500', 'height' => '500')) ?>
                        </td>
                        <td width="<?php echo $width2; ?>">
                            <input type="file" name="file1" id="file1">
                        </td>
                        <td width="<?php echo $width3; ?>">
                            <input type="text" size="15" id="trstwtstartdate1" name="trstwtstartdate1">
                        </td>
                        <td width="<?php echo $width4; ?>">
                            <input type="text" size="15" id="trstwtenddate1" name="trstwtenddate1">
                        </td>
                        <td width="<?php echo $width5; ?>">

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php for ($i = 2; $i <= 10; $i++) { ?>
            <div id="document<?php echo $i; ?>" style="display:none;">
                <table cellspacing="1" cellpadding="10" border="1" width="100%">
                    <tbody>
                        <tr>
                            <td width="<?php echo $width1; ?>">
                                <?php echo thickbox_iframe("<input type=\"text\" size=\"35\" id=\"variablesmeasured$i\" name=\"variablesmeasured$i\">", "@weathervariablesmeasuredlist", array('pop' => '1', 'fila' => $i), array(), array('width' => '500', 'height' => '500')) ?>
                            </td>
                            <td width="<?php echo $width2; ?>">
                                <input type="file" name="file<?php echo $i; ?>" id="file<?php echo $i; ?>">
                            </td>
                            <td width="<?php echo $width3; ?>">
                                <input class="campodate" type="text" size="15" id="trstwtstartdate<?php echo $i; ?>" name="trstwtstartdate<?php echo $i; ?>">
                            </td>
                            <td width="<?php echo $width4; ?>">
                                <input class="campodate" type="text" size="15" id="trstwtenddate<?php echo $i; ?>" name="trstwtenddate<?php echo $i; ?>">
                            </td>
                            <td width="<?php echo $width5; ?>">
                                <span id="deletenew" onclick="deletenew(<?php echo $i; ?>)"><?php echo image_tag("cross.png"); ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <input type="button" value="Next File" id="otherfile">
        <input type="hidden" value="1" id="filadocument" name="filadocument">
    </div>

    <!--  PARTE PARA CARGAR MULTIPLES FOTOS  -->
    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <label>Others Documents</label>
            <?php echo HelpModule("Trial site", "Others Documents"); ?>
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
        <?php if ($form->getObject()->get('id_trialsite')) { ?>
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
                        $HTML2 .= "<span alt='Delete' onclick='deleterow2({$row['id_trialsitephotograph']})'><img src=\"/images/cross.png\"></span>&ensp;";
                        $HTML2 .= "<span title='Click on the lock to change' alt='Click on the lock to change' onclick='Lock_Unlock2({$row['id_trialsitephotograph']})'><img src=\"/images/$Imag_trstphlock\"></span>&ensp;";
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
        <?php } ?>
        <div id="photograph1">
            <table cellspacing="1" cellpadding="10" border="1" width="100%">
                <tbody>
                    <tr>
                        <td width="<?php echo $width1; ?>">
                            <input type="file" name="trstphfile1" id="trstphfile1">
                        </td>
                        <td width="<?php echo $width2; ?>">
                            <input type="text" size="60" id="trstphpersonphotograph1" name="trstphpersonphotograph1">
                        </td>
                        <td width="<?php echo $width3; ?>"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php for ($i = 2; $i <= 10; $i++) { ?>
            <div id="photograph<?php echo $i; ?>" style="display:none;">
                <table cellspacing="1" cellpadding="10" border="1" width="100%">
                    <tbody>
                        <tr>
                            <td width="<?php echo $width1; ?>">
                                <input type="file" name="trstphfile<?php echo $i; ?>" id="trstphfile<?php echo $i; ?>">
                            </td>
                            <td width="<?php echo $width2; ?>">
                                <input type="text" size="60" id="trstphpersonphotograph<?php echo $i; ?>" name="trstphpersonphotograph<?php echo $i; ?>">
                            </td>
                            <td width="<?php echo $width3; ?>">
                                <span id="deletenew" onclick="deletenew2(<?php echo $i; ?>)"><?php echo image_tag("cross.png"); ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <input type="button" value="Next Documents" id="nextphotograph">
        <input type="hidden" value="1" id="filaphotograph" name="filaphotograph">
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trstfileaccess']->renderLabel('Files access') ?>
            <?php echo HelpModule("Trial site", "trstfileaccess"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trstfileaccess']->renderError() ?>
        </div>
        <?php echo $form['trstfileaccess']->render() ?>
    </div>
    <?php
    $st_display = "none";
    if ($form->getObject()->get('trstfileaccess') == 'Open to specified users')
        $st_display = "block";
    ?>
    <div id="tbtrialsite_users"  style="display: <?php echo $st_display; ?>">
        <div class="sf_admin_form_row sf_admin_text">
            <div class="label ui-helper-clearfix"><b>Specified users</b></div>
            <span id="add_listuser">
                <?php
                $id_trialsite = $form->getObject()->get('id_trialsite');
                $user = sfContext::getInstance()->getUser();
                $session_user_name = $user->getAttribute('user_name');
                $list_user = "";
                if (isset($session_user_name)) {
                    foreach ($session_user_name as $username) {
                        $list_user .= $username . ", ";
                    }
                    $list_user = substr($list_user, 0, strlen($list_user) - 2);
                }
                echo thickbox_iframe("<textarea id='tb_trialsite_user' name='tb_trialsite_user' readonly='readonly' cols='58' rows='5'>$list_user</textarea> " . image_tag('user.jpg'), '@trialsitespecifiedusers', array('pop' => '1'))
                ?>
            </span>
        </div>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trststatus']->renderLabel('Location verified?') ?>
            <?php echo HelpModule("Trial site", "trststatus"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trststatus']->renderError() ?>
        </div>
        <?php echo $form['trststatus']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trststatereason']->renderLabel('Notes on the location (100 characters max)') ?>
            <?php echo HelpModule("Trial site", "trststatereason"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trststatereason']->renderError() ?>
        </div>
        <?php echo $form['trststatereason']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_trialsitetype']->renderLabel('Trial site type') ?>
            <?php echo HelpModule("Trial site", "id_trialsitetype"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_trialsitetype']->renderError() ?>
        </div>
        <?php echo $form['id_trialsitetype']->render() ?>
    </div>

    <?php if (sfContext::getInstance()->getUser()->hasCredential('Administrator')) { ?>
        <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
            <div class="label ui-helper-clearfix">
                <?php echo $form['trstactive']->renderLabel('Is active?') ?>
                <?php echo HelpModule("Trial site", "trstactive"); ?>
            </div>
            <div class="label ui-state-error-text">
                <?php echo $form['trstactive']->renderError() ?>
            </div>
            <?php echo $form['trstactive']->render() ?>
        </div>
    <?php } else { ?>
        <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
            <div class="label ui-helper-clearfix">
                <?php echo $form['trstactive']->renderLabel('Is active?') ?>
            </div>
            <?php
            if ($form->getObject()->get('trstactive') == 1)
                echo "YES";
            else
                echo "NO";
            ?>
        </div>
    <?php } ?>

</div>