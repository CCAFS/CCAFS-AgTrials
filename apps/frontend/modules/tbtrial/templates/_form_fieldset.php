<?php use_helper('Thickbox') ?>
<script>
    $(document).ready(function() {
        $('#autocomplete_tb_trial_id_crop').blur(function() {
            var id_crop = $('#tb_trial_id_crop').attr('value');
            $('#varieties').attr('value', '');
            $('#variablesmeasured').attr('value', '');
            $.ajax({
                type: "GET",
                url: "<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/tbtrial/cleardatacrops/",
                data: "id_crop=" + id_crop,
                success: function(data) {
                    $('#VariablesMeasureds').html(data);
                }
            });
        });

        $('#tb_trial_trlreplications').change(function() {
            var trlreplications = $('#tb_trial_trlreplications').attr('value');
            $.ajax({
                type: "GET",
                url: "<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/tbtrial/changereplications/",
                data: "replications=" + trlreplications,
                success: function(data) {
                    true;
                }
            });
        });

    });

    //ADICCIONAR VARIABLE MEDIDA A ARREGLO TEMPORAL
    function addrow() {
        var trdtreplication_new = $('#trdtreplication_new').attr('value');
        var id_variety_new = $('#id_variety_new').attr('value');
        var id_variablesmeasured_new = $('#id_variablesmeasured_new').attr('value');
        var value_new = $('#value_new').attr('value');
        var unit_new = $('#unit_new').attr('value');

        if (trdtreplication_new == '') {
            jAlert('error', 'Empty Replication', 'Incomplete Information', null);
            document.getElementById('trdtreplication_new').focus();
        } else if (id_variety_new == '') {
            jAlert('error', 'Empty Varieties/Race', 'Incomplete Information', null);
            document.getElementById('id_variety_new').focus();
        } else if (id_variablesmeasured_new == '') {
            jAlert('error', 'Empty Variables Measured', 'Incomplete Information', null);
            document.getElementById('id_variablesmeasured_new').focus();
        } else if (value_new == '') {
            jAlert('error', 'Empty Value', 'Incomplete Information', null);
            document.getElementById('value_new').focus();
        } else {
            $.ajax({
                type: "GET",
                url: "<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/tbtrial/addrow/",
                data: "replication=" + trdtreplication_new + "&id_variety=" + id_variety_new + "&id_variablesmeasured=" + id_variablesmeasured_new + "&value=" + value_new + "&unit=" + unit_new,
                success: function(data) {
                    $('#VariablesMeasureds').html(data);
                }
            });
        }
    }

    //OPTENER UNIDAD DE LA VARIABLE MEDIDA
    function getunitvariablesmeasured() {
        var id_variablesmeasured = $('#id_variablesmeasured_new').attr('value');
        if (id_variablesmeasured != '') {
            $.ajax({
                type: "GET",
                url: "<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/tbtrial/getunitvariablesmeasured/",
                data: "id_variablesmeasured=" + id_variablesmeasured,
                success: function(data) {
                    $('#unit_label').html(data);
                    $('#unit_new').attr('value', data);
                }
            });
        } else {
            $('#unit_label').html("");
            $('#unit_new').attr('value', "");
        }
    }

    //ELIMINAR VARIABLE MEDIDA A ARREGLO TEMPORAL
    function deleterow(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/tbtrial/deleterow/",
            data: "id=" + id,
            success: function(data) {
                $('#VariablesMeasureds').html(data);
            }
        });
    }
</script>
<div class="ui-corner-all" id="sf_fieldset_none">
    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_trialgroup']->renderLabel('Trial group') ?>
            <?php echo HelpModule("Trial", "id_trialgroup"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_trialgroup']->renderError() ?>
        </div>
        <?php echo $form['id_trialgroup']->render() ?>
        <span id="add_trialgroup">
            <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tbtrialgroup/new', array('pop' => '1')) ?>
        </span>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trlname']->renderLabel('Trial name') ?>
            <?php echo HelpModule("Trial", "trlname"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trlname']->renderError() ?>
        </div>
        <?php echo $form['trlname']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_contactperson']->renderLabel('Contact person') ?>
            <?php echo HelpModule("Trial", "id_contactperson"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_contactperson']->renderError() ?>
        </div>
        <?php echo $form['id_contactperson']->render() ?>
        <span id="add_contactperson">
            <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tbcontactperson/new', array('pop' => '1')) ?>
        </span>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_country']->renderLabel('Country') ?>
            <?php echo HelpModule("Trial", "id_country"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_country']->renderError() ?>
        </div>
        <?php echo $form['id_country']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_trialsite']->renderLabel('Trial site') ?>
            <?php echo HelpModule("Trial", "id_country"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_trialsite']->renderError() ?>
        </div>
        <?php echo $form['id_trialsite']->render() ?>
        <span id="add_trialsite">
            <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tbtrialsite/new', array('pop' => '1')) ?>
        </span>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_fieldnamenumber']->renderLabel('Field name number') ?>
            <?php echo HelpModule("Trial", "id_fieldnamenumber"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_fieldnamenumber']->renderError() ?>
        </div>
        <span id="selected_fieldnamenumber">
            <select id="tb_trial_id_fieldnamenumber" name="tb_trial[id_fieldnamenumber]">
                <option selected="selected" value=""></option>
            </select>
        </span>
        <span id="add_fieldnamenumber">
            <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tbfieldnamenumber/new', array('pop' => '1')) ?>
        </span>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trlsowdate']->renderLabel('Sow/plant date') ?>
            <?php echo HelpModule("Trial", "trlsowdate"); ?>
            <div class="help">
                <span class="ui-icon ui-icon-info floatleft"></span>
                Format (yyyy-mm-dd).
            </div>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trlsowdate']->renderError() ?>
        </div>
        <?php echo $form['trlsowdate']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trlharvestdate']->renderLabel('Harvest date') ?>
            <?php echo HelpModule("Trial", "trlharvestdate"); ?>
            <div class="help">
                <span class="ui-icon ui-icon-info floatleft"></span>
                Format (yyyy-mm-dd).
            </div>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trlharvestdate']->renderError() ?>
        </div>
        <?php echo $form['trlharvestdate']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trlirrigation']->renderLabel('Irrigation') ?>
            <?php echo HelpModule("Trial", "trlirrigation"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trlirrigation']->renderError() ?>
        </div>
        <?php echo $form['trlirrigation']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_crop']->renderLabel('Technology') ?>
            <?php echo HelpModule("Trial", "id_crop"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_crop']->renderError() ?>
        </div>
        <?php echo $form['id_crop']->render() ?>
        <span id="add_crop">
            <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tbcrop/new', array('pop' => '1')) ?>
        </span>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trlreplications']->renderLabel('Replications') ?>
            <?php echo HelpModule("Trial", "trlreplications"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trlreplications']->renderError() ?>
        </div>
        <?php echo $form['trlreplications']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trlvarieties']->renderLabel('Varieties/Race') ?>
            <?php echo HelpModule("Trial", "trlvarieties"); ?>
            <div class="help">
                <span class="ui-icon ui-icon-info floatleft"></span>
                Before adding a variety, specify the Technology.
            </div>
        </div>

        <div class="label ui-state-error-text">
            <?php echo $form['trlvarieties']->renderError() ?>
        </div>
        <span id="add_listvarieties">
            <?php
            $user = sfContext::getInstance()->getUser();
            $session_varieties_name = $user->getAttribute('varieties_name');
            $list_varieties_name = "";
            if (isset($session_varieties_name)) {
                foreach ($session_varieties_name as $varietiesname) {
                    $list_varieties_name .= $varietiesname . ", ";
                }
                $list_varieties_name = substr($list_varieties_name, 0, strlen($list_varieties_name) - 2);
            }
            echo thickbox_iframe("<textarea id='varieties' name='varieties' readonly='readonly' cols='58' rows='5' placeholder='Click to select Varieties/Race'>$list_varieties_name</textarea>" . image_tag('list-icon.png'), '@listvarieties', array('pop' => '1'));
            ?>
        </span>
        <span id="add_variety">
            <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tbvariety/new', array('pop' => '1')) ?>
        </span>
    </div>
    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trlvariablesmeasured']->renderLabel('Variables measured') ?>
            <?php echo HelpModule("Trial", "trlvariablesmeasured"); ?>
            <div class="help">
                <span class="ui-icon ui-icon-info floatleft"></span>
                Before adding variables measured, specify the Technology and Varieties/Race.
            </div>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trlvariablesmeasured']->renderError() ?>
        </div>
        <span id="add_listvarieties">
            <?php
            $user = sfContext::getInstance()->getUser();
            $session_variablesmeasured_name = $user->getAttribute('variablesmeasured_name');
            $list_variablesmeasured_name = "";
            if (isset($session_variablesmeasured_name)) {
                foreach ($session_variablesmeasured_name as $variablesmeasured) {
                    $list_variablesmeasured_name .= $variablesmeasured . ", ";
                }
                $list_variablesmeasured_name = substr($list_variablesmeasured_name, 0, strlen($list_variablesmeasured_name) - 2);
            }
            echo thickbox_iframe("<textarea id='variablesmeasured' name='variablesmeasured' readonly='readonly' cols='58' rows='5' placeholder='Click to select Variables measured'>$list_variablesmeasured_name</textarea>" . image_tag('list-icon.png'), '@listvariablesmeasured', array('pop' => '1'));
            ?>
        </span>
        <span id="add_variablesmeasured">
            <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tbvariablesmeasured/new', array('pop' => '1')) ?>
        </span>

        <!--INICIO ADICCION VARIABLES MEDIDAS-->
        <div class="sf_admin_form_row sf_admin_text">
            <table cellspacing="1" cellpadding="10" border="1" width="100%">
                <tbody id="VariablesMeasureds"><?php echo SesionTrialData(); ?></tbody>
            </table>
        </div>
        <!--FIN ADICCION VARIABLES MEDIDAS-->
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trltrialresultsfile']->renderLabel('Trial results file') ?>
            <?php echo HelpModule("Trial", "trltrialresultsfile"); ?>
            <div class="help"><span class="ui-icon ui-icon-info floatleft"></span>The file must be of .doc, .xls, .ppt, pdf and .zip format. - Max size 10 MB</div>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trltrialresultsfile']->renderError() ?>
        </div>
        <?php echo $form['trltrialresultsfile']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trlsupplementalinformationfile']->renderLabel('Supplemental information file') ?>
            <?php echo HelpModule("Trial", "trlsupplementalinformationfile"); ?>
            <div class="help"><span class="ui-icon ui-icon-info floatleft"></span>The file must be of .doc, .xls, .ppt, pdf and .zip format. - Max size 10 MB</div>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trlsupplementalinformationfile']->renderError() ?>
        </div>
        <?php echo $form['trlsupplementalinformationfile']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trlweatherduringtrialfile']->renderLabel('Weather during trial file') ?>
            <?php echo HelpModule("Trial", "trlweatherduringtrialfile"); ?>
            <div class="help"><span class="ui-icon ui-icon-info floatleft"></span>The file must be of .doc, .xls, .ppt, pdf and .zip format. - Max size 10 MB</div>    
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trlweatherduringtrialfile']->renderError() ?>
        </div>
        <?php echo $form['trlweatherduringtrialfile']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trlsoiltypeconditionsduringtrialfile']->renderLabel('Soil type conditions during trial file') ?>
            <?php echo HelpModule("Trial", "trlsoiltypeconditionsduringtrialfile"); ?>
            <div class="help"><span class="ui-icon ui-icon-info floatleft"></span>The file must be of .doc, .xls, .ppt, pdf and .zip format. - Max size 10 MB</div>    
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trlsoiltypeconditionsduringtrialfile']->renderError() ?>
        </div>
        <?php echo $form['trlsoiltypeconditionsduringtrialfile']->render() ?>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trllicense']->renderLabel('License') ?>
            <?php echo HelpModule("Trial", "trllicense"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trllicense']->renderError() ?>
        </div>
        <?php echo $form['trllicense']->render() ?>
        <span id="add_licence">
            <?php echo thickbox_iframe(image_tag('licence-icon.png') . 'Creative Commons License Generator', '@license_generator', array('pop' => '1'), array(), array('width' => '800', 'height' => '500')) ?>
        </span>
    </div>

    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trlfileaccess']->renderLabel('Files access') ?>
            <?php echo HelpModule("Trial", "trlfileaccess"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trlfileaccess']->renderError() ?>
        </div>
        <?php echo $form['trlfileaccess']->render() ?>
    </div>
    <?php
    $st_display_users = "none";
    if ($form->getObject()->get('trlfileaccess') == 'Open to specified users')
        $st_display_users = "block";
    ?>
    <div id="tbtrial_users"  style="display: <?php echo $st_display_users; ?>">
        <div class="sf_admin_form_row sf_admin_text">
            <div class="label ui-helper-clearfix"><b>Specified users</b></div>
            <span id="add_listuser">
                <?php
                $id_trial = $form->getObject()->get('id_trial');
                $user = sfContext::getInstance()->getUser();
                $session_user_name = $user->getAttribute('user_name');
                $list_user = "";
                if (isset($session_user_name)) {
                    foreach ($session_user_name as $username) {
                        $list_user .= $username . ", ";
                    }
                    $list_user = substr($list_user, 0, strlen($list_user) - 2);
                }
                echo thickbox_iframe("<textarea id='tb_trial_user' name='tb_trial_user' readonly='readonly' cols='58' rows='5'>$list_user</textarea> " . image_tag('user.jpg'), '@specifiedusers', array('pop' => '1'))
                ?>
            </span>
        </div>
    </div>
    <?php
    $st_display_groups = "none";
    if ($form->getObject()->get('trlfileaccess') == 'Open to specified groups')
        $st_display_groups = "block";
    ?>
    <div id="tbtrial_groups"  style="display: <?php echo $st_display_groups; ?>">
        <div class="sf_admin_form_row sf_admin_text">
            <div class="label ui-helper-clearfix"><b>Specified groups</b></div>
            <span id="add_listgroup">
                <?php
                $id_trial = $form->getObject()->get('id_trial');
                $user = sfContext::getInstance()->getUser();
                $session_group_name = $user->getAttribute('group_name');
                $list_group = "";
                if (isset($session_group_name)) {
                    foreach ($session_group_name as $groupname) {
                        $list_group .= $groupname . ", ";
                    }
                    $list_group = substr($list_group, 0, strlen($list_group) - 2);
                }
                echo thickbox_iframe("<textarea id='tb_trial_group' name='tb_trial_group' readonly='readonly' cols='58' rows='5'>$list_group</textarea> " . image_tag('user.jpg'), '@specifiedgroups', array('pop' => '1'))
                ?>
            </span>
        </div>
    </div>


    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['trltrialtype']->renderLabel('Trial type') ?>
            <?php echo HelpModule("Trial", "trltrialtype"); ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trltrialtype']->renderError() ?>
        </div>
        <?php echo $form['trltrialtype']->render() ?>
    </div>
</div>