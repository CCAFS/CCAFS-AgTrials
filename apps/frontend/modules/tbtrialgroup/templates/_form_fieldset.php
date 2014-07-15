<?php use_helper('Thickbox') ?>
<script>
    $(document).ready(function() {
        $('#nextdocument').click(function() {
            var filadocument = $('#filadocument').attr('value');
            filadocument = (filadocument * 1) + 1;
            $('#document' + filadocument).show();
            $('#filadocument').attr('value', filadocument);
        });

    });

    function deletenew(i) {
        $('#trgrflfile' + i).attr('value', '');
        $('#trgrfldescription' + i).attr('value', '');
        $('#document' + i).hide();
    }


    function downloadfile(id_trialgroupfile) {
        location.href = "/tbtrialgroup/downloadfile/?id_trialgroupfile=" + id_trialgroupfile;
    }
</script>
<div class="ui-corner-all" id="sf_fieldset_none">
    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_institution']->renderLabel('Institution') ?>
            <?php echo HelpModule("Trial group", "id_institution"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_institution']->renderError() ?>
        </div>
        <?php echo $form['id_institution']->render() ?>
        <span id="add_institution">
            <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tbinstitution/new', array('pop' => '1'), array(), array('width' => '500', 'height' => '500')) ?>
        </span>
    </div>

    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <div class="label ui-helper-clearfix">
                <label>Contact persons</label>
                <?php echo HelpModule("Trial group", "id_contactperson"); ?>
            </div>

        </div>
        <?php
        $id_trialgroup = $form->getObject()->get('id_trialgroup');
        $user = sfContext::getInstance()->getUser();
        $session_contactperson_name = $user->getAttribute('contactperson_name');
        $list_contactperson = "";
        if (isset($session_contactperson_name)) {
            foreach ($session_contactperson_name as $contactperson) {
                $list_contactperson .= $contactperson . ", ";
            }
            $list_contactperson = substr($list_contactperson, 0, strlen($list_contactperson) - 2);
        }
        echo thickbox_iframe("<textarea id='contactperson' name='contactperson' readonly='readonly' cols='37' rows='2'>$list_contactperson</textarea>" . image_tag('user.jpg'), '@trialgroupcontactperson', array('pop' => '1'));
        echo thickbox_iframe(image_tag('add-icon.png'), 'tbcontactperson/new', array('pop' => '1'), array(), array('width' => '500', 'height' => '500'))
        ?>
        <input type="hidden" id="tb_trialgroup_id_contactperson" value="1" name="tb_trialgroup[id_contactperson]" size="30">
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_trialgrouptype']->renderLabel('Trial group type') ?>
            <?php echo HelpModule("Trial group", "id_trialgrouptype"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_trialgrouptype']->renderError() ?>
        </div>
        <?php echo $form['id_trialgrouptype']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_objective']->renderLabel('Objective') ?>
            <?php echo HelpModule("Trial group", "id_objective"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_objective']->renderError() ?>
        </div>
        <?php echo $form['id_objective']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_primarydiscipline']->renderLabel('Primary discipline') ?>
            <?php echo HelpModule("Trial group", "id_primarydiscipline"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_primarydiscipline']->renderError() ?>
        </div>
        <?php echo $form['id_primarydiscipline']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trgrname']->renderLabel('Name') ?>
            <?php echo HelpModule("Trial group", "trgrname"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trgrname']->renderError() ?>
        </div>
        <?php echo $form['trgrname']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trgrstartyear']->renderLabel('Start year') ?>
            <?php echo HelpModule("Trial group", "trgrstartyear"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trgrstartyear']->renderError() ?>
        </div>
        <?php echo $form['trgrstartyear']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trgrendyear']->renderLabel('End year') ?>
            <?php echo HelpModule("Trial group", "trgrendyear"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trgrendyear']->renderError() ?>
        </div>
        <?php echo $form['trgrendyear']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trgrtrialgrouprecordstatus']->renderLabel('Trial group record status') ?>
            <?php echo HelpModule("Trial group", "trgrtrialgrouprecordstatus"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trgrtrialgrouprecordstatus']->renderError() ?>
        </div>
        <?php echo $form['trgrtrialgrouprecordstatus']->render() ?>
    </div>

    <!--  PARTE PARA CARGAR MULTIPLES DOCUMENTOS  -->
    <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
        <div class="label ui-helper-clearfix">
            <label>Documents</label>
            <?php echo HelpModule("Trial group", "Documents"); ?>
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
        <?php if ($form->getObject()->get('id_trialgroup')) {
            ?>
            <div>
                <table cellspacing="1" cellpadding="10" border="1" width="100%">
                    <?php
                    $HTML2 = "";
                    $QUERY = Doctrine_Query::create()
                            ->select("TGF.id_trialgroupfile,TGF.trgrflfile,TGF.trgrfldescription")
                            ->from("TbTrialgroupfile TGF")
                            ->where("TGF.id_trialgroup = {$form->getObject()->get('id_trialgroup')}")
                            ->orderBy("TGF.id_trialgroupfile");
                    //echo $QUERY->getSqlQuery();
                    $Results = $QUERY->execute();
                    $bgcolor = "#C0C0C0";
                    foreach ($Results AS $row) {
                        if ($bgcolor != "#FFFFD9")
                            $bgcolor = "#FFFFD9";
                        else
                            $bgcolor = "#C0C0C0";

                        $trgrflfile = $row['trgrflfile'];
                        $PartFile = explode(".", $trgrflfile);
                        $Extension = strtoupper($PartFile[1]);
                        $HTML2 .= "<tr bgcolor='$bgcolor'>";
                        $HTML2 .= "<td width='$width1'>{$row['trgrflfile']}</td>";
                        $HTML2 .= "<td width='$width2'>{$row['trgrfldescription']}</td>";
                        $HTML2 .= "<td width='$width3'>";
                        $HTML2 .= "<span alt='Download' onclick='downloadfile({$row['id_trialgroupfile']})'><img src=\"/images/download-icon.png\"></span>&ensp;";
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
        <div id="document1">
            <table cellspacing="1" cellpadding="10" border="1" width="100%">
                <tbody>
                    <tr>
                        <td width="<?php echo $width1; ?>">
                            <input type="file" name="trgrflfile1" id="trgrflfile1">
                        </td>
                        <td width="<?php echo $width2; ?>">
                            <input type="text" size="60" id="trgrfldescription1" name="trgrfldescription1">
                        </td>
                        <td width="<?php echo $width3; ?>"></td>
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
                                <input type="file" name="trgrflfile<?php echo $i; ?>" id="trgrflfile<?php echo $i; ?>">
                            </td>
                            <td width="<?php echo $width2; ?>">
                                <input type="text" size="60" id="trgrfldescription<?php echo $i; ?>" name="trgrfldescription<?php echo $i; ?>">
                            </td>
                            <td width="<?php echo $width3; ?>">
                                <span id="deletenew" onclick="deletenew(<?php echo $i; ?>)"><?php echo image_tag("cross.png"); ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <input type="button" value="Next Documents" id="nextdocument">
        <input type="hidden" value="1" id="filadocument" name="filadocument">
    </div>

</div>