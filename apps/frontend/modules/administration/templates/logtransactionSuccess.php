<?php
use_stylesheet('/sfAdminThemejRollerPlugin/css/reset.css', 'first');
use_javascript('/sfAdminThemejRollerPlugin/js/jquery.min.js', 'first');
use_javascript('/sfAdminThemejRollerPlugin/js/jquery-ui.custom.min.js', 'first');
use_stylesheet('/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/jroller.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.menu.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.buttons.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/ui.selectmenu.css');
use_stylesheet('/css/jquery.alerts.css');
use_javascript('/sfAdminThemejRollerPlugin/js/fg.menu.js');
use_javascript('/sfAdminThemejRollerPlugin/js/jroller.js');
use_javascript('/sfAdminThemejRollerPlugin/js/ui.selectmenu.js');
use_javascript('/js/jquery.alerts.js');
?>
<script>
    $(document).ready(function() {
        $('#logtransactionsearch').click(function() {
            if ($('#modulelog').attr('value') == '') {
                jAlert('error', '* Module', 'Incomplete Data', null);
            } else if ($('#idrecord').attr('value') == '') {
                jAlert('error', '* Id Record', 'Incomplete Data', null);
            } else {
                $('#div_loading').show();
                $('#logtransaction').submit();
            }
        });

        $('#logtransactionclear').click(function() {
            $('#modulelog').val("");
            $('#idrecord').val("");
        });
    });
</script>
<style type="text/css">
    div.resultados {
        width:1135px;
        height:500px;
        overflow:scroll;
    }

    #tablecss{
        border:1px solid #FFD511;
    }
    #campos{
        background-color:#6B8E53;
        color:#FFD511;
        font-size:14px;
        font-weight:bold;
        border:1px solid #FFD511;
    }

    #trdatos{
        background-color:#F0F0F0;
    }

    #tddatos{
        border:1px solid #FFD511;
    }
    #tddatosbold{
        border:1px solid #FFD511;
        font-weight:bold;
    }

</style>

<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Log Transaction</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div> 
    <div id="Logtransaction">
        <form id="logtransaction" name="logtransaction" action="<?php echo url_for('@logtransaction'); ?>" enctype="multipart/form-data" method="post">
            <table align="center">
                <tr>
                    <td nowrap><b>Module:</b></td>
                    <td>
                        <select name="modulelog" id="modulelog">
                            <option value="">Select One</option>
                            <option value="tb_bibliography"<?php if ($modulelog == 'tb_bibliography') echo "selected"; ?>>Bibliography</option>
                            <option value="tb_contactperson"<?php if ($modulelog == 'tb_contactperson') echo "selected"; ?>>Contact person</option>
                            <option value="tb_contactpersontype"<?php if ($modulelog == 'tb_contactpersontype') echo "selected"; ?>>Contact person type</option>
                            <option value="tb_country"<?php if ($modulelog == 'tb_country') echo "selected"; ?>>Country</option>
                            <option value="tb_crop"<?php if ($modulelog == 'tb_crop') echo "selected"; ?>>Crop</option>
                            <option value="tb_fieldnamenumber"<?php if ($modulelog == 'tb_fieldnamenumber') echo "selected"; ?>>Field name number</option>
                            <option value="tb_institution"<?php if ($modulelog == 'tb_institution') echo "selected"; ?>>Institution</option>
                            <option value="tb_institutionnetwork"<?php if ($modulelog == 'tb_institutionnetwork') echo "selected"; ?>>Institution network</option>
                            <option value="tb_language"<?php if ($modulelog == 'tb_language') echo "selected"; ?>>Language</option>
                            <option value="tb_location"<?php if ($modulelog == 'tb_location') echo "selected"; ?>>Location</option>
                            <option value="tb_network"<?php if ($modulelog == 'tb_network') echo "selected"; ?>>Network</option>
                            <option value="tb_objective"<?php if ($modulelog == 'tb_objective') echo "selected"; ?>>Objective</option>
                            <option value="tb_origin"<?php if ($modulelog == 'tb_origin') echo "selected"; ?>>Origin</option>
                            <option value="tb_primarydiscipline"<?php if ($modulelog == 'tb_primarydiscipline') echo "selected"; ?>>Primary discipline</option>
                            <option value="tb_soil"<?php if ($modulelog == 'tb_soil') echo "selected"; ?>>Soil</option>
                            <option value="tb_taxonomyfao"<?php if ($modulelog == 'tb_taxonomyfao') echo "selected"; ?>>Taxonomy FAO</option>
                            <option value="tb_traitclass"<?php if ($modulelog == 'tb_traitclass') echo "selected"; ?>>Trait class</option>
                            <option value="tb_trial"<?php if ($modulelog == 'tb_trial') echo "selected"; ?>>Trial</option>
                            <option value="tb_trialenvironmenttype"<?php if ($modulelog == 'tb_trialenvironmenttype') echo "selected"; ?>>Trial environment type</option>
                            <option value="tb_trialgroup"<?php if ($modulelog == 'tb_trialgroup') echo "selected"; ?>>Trial group</option>
                            <option value="tb_trialgrouptype"<?php if ($modulelog == 'tb_trialgrouptype') echo "selected"; ?>>Trial group type</option>
                            <option value="tb_trialsite"<?php if ($modulelog == 'tb_trialsite') echo "selected"; ?>>Trial site</option>
                            <option value="tb_trialvariablesmeasured"<?php if ($modulelog == 'tb_trialvariablesmeasured') echo "selected"; ?>>Trial variables measured</option>
                            <option value="tb_trialvariety"<?php if ($modulelog == 'tb_trialvariety') echo "selected"; ?>>Trial variety</option>
                            <option value="tb_variablesmeasured"<?php if ($modulelog == 'tb_variablesmeasured') echo "selected"; ?>>Variables measured</option>
                            <option value="tb_variety"<?php if ($modulelog == 'tb_variety') echo "selected"; ?>>Variety</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td nowrap><b>Id record:</b></td>
                    <td><input type="text" size="5" maxlength="10" value="<?php echo $idrecord ?>" name="idrecord" id="idrecord"></td>
                </tr>
                <tr align="center">
                    <td align="center" colspan="6">
                        <input type="hidden" size="2" maxlength="7" value="" name="paginar" id="paginar">
                        <input type="button" value="Search" id="logtransactionsearch">
                        <input type="button" value="Clear" id="logtransactionclear">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php if (count($fields) > 0): ?>
        <div class="resultados">
            <table id="tablecss">
                <tr>
                    <td id='campos'><?php echo "Operation"; ?>&nbsp&nbsp&nbsp</td>
                    <td id='campos'><?php echo "Date"; ?>&nbsp&nbsp&nbsp</td>
                    <?php
                    $nun_fields = 1;
                    foreach ($fields AS $field) {
                        if ($field[0] == 'id_user')
                            $id_user_a = $nun_fields + 1;
                        if ($field[0] == 'id_user_update')
                            $id_user_update_a = $nun_fields + 1;
                        echo "<td id='campos'>{$field[0]}&nbsp&nbsp&nbsp</td>";
                        $nun_fields++;
                    }
                    ?>
                </tr>
                <?php
                $trdatos = 'trdatos';
                foreach ($records AS $record) {
                    $tddatos = 'tddatos';
                    if (($record[0] == 'UPDATE') || ($record[0] == 'DELETE'))
                        $tddatos = 'tddatosbold';
                    ?>
                    <tr id="<?php echo $trdatos; ?>">
                        <?php
                        $field_tmp = $nun_fields - 1;
                        for ($a = 0; $a <= $nun_fields; $a++) {
                            if ($a == 1) {
                                echo "<td id='$tddatos'>" . substr($record[$a], 0, 19) . "&nbsp&nbsp&nbsp</td>";
                            } elseif (($a == $id_user_a || $a == $id_user_update_a) && $record[$a] != '') {
                                $Usuario = Doctrine::getTable('SfGuardUser')->findOneById($record[$a]);
                                echo "<td id='$tddatos'>{$Usuario->getUsername()}</td>";
                            } else {
                                echo "<td id='$tddatos'>{$record[$a]}</td>";
                            }
                        }
                        if ($trdatos == 'trdatos')
                            $trdatos = '';
                        else
                            $trdatos = 'trdatos';
                        ?>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php endif; ?>
</div>