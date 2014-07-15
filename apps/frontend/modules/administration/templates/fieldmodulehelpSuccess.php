<?php
use_stylesheet('/sfAdminThemejRollerPlugin/css/reset.css', 'first');
use_javascript('/sfAdminThemejRollerPlugin/js/jquery.min.js', 'first');
use_javascript('/sfAdminThemejRollerPlugin/js/jquery-ui.custom.min.js', 'first');
use_stylesheet('/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/jroller.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.menu.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.buttons.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/ui.selectmenu.css');
use_javascript('/sfAdminThemejRollerPlugin/js/fg.menu.js');
use_javascript('/sfAdminThemejRollerPlugin/js/jroller.js');
use_javascript('/sfAdminThemejRollerPlugin/js/ui.selectmenu.js');
use_helper('Thickbox');
?>
<script>
    $(document).ready(function() {
        //LoadFields
        $('#LoadFields').click(function() {
            if ($('#flmdhlmodule').attr('value') === '') {
                jAlert('error', '* Module', 'Incomplete Information', null);
            } else {
                $('#div_loading').show();
                $('#FormFieldModuleHelp').submit();
            }
        });

        $('#SaveFields').click(function() {
            $('#div_loading').show();
            $('#FormFieldModuleHelpUpdate').submit();
        });
    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <?php if (isset($notice)) { ?>
        <div id="notice" class="sf_admin_flashes ui-widget">
            <div class="notice ui-state-highlight ui-corner-all">
                <span class="ui-icon ui-icon-info floatleft"></span>&ensp;<?php echo $notice; ?>
            </div>
        </div>
    <?php } ?>
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Field module Help</h1>
    </div>
    <div>
        <form id="FormFieldModuleHelp" name="FormFieldModuleHelp" action="<?php echo url_for('@fieldmodulehelp'); ?>" enctype="multipart/form-data" method="post">
            <table>
                <tr>
                    <td><label>Module:</label>&ensp;&ensp;</td>
                    <td><?php echo select_from_table_module(); ?>&ensp;&ensp;</td>
                    <td>
                        <button type="button" name="Load Fields" id="LoadFields" title="Load Fields"><b>Load Fields</b></button>
                        <input type="hidden" value="LoadFields" id="LoadFields" name="LoadFields"/>
                    </td>
                </tr>
            </table>
        </form>
        <?php if (count($R_FieldModuleHelp) > 0) { ?>
            <form id="FormFieldModuleHelpUpdate" name="FormFieldModuleHelpUpdate" action="<?php echo url_for('@fieldmodulehelp'); ?>" enctype="multipart/form-data" method="post">
                <table width="100%">
                    <tr width="100%">
                        <td width="25%"><label>Module</label></td>
                        <td width="30%"><label>Name</label></td>
                        <td width="45%"><label>Text help</label></td>
                    </tr>
                    <?php
                    $bgcolor = "#C0C0C0";
                    $a = 1;
                    foreach ($R_FieldModuleHelp AS $Values) {
                        if ($bgcolor != "#FFFFD9")
                            $bgcolor = "#FFFFD9";
                        else
                            $bgcolor = "#C0C0C0";
                        ?>
                        <tr bgcolor="<?php echo $bgcolor; ?>">
                            <td>
                                <input type="hidden" value="<?php echo $Values['id_fieldmodulehelp']; ?>" id="id_fieldmodulehelp<?php echo $a; ?>" name="id_fieldmodulehelp<?php echo $a; ?>"/>
                                <input type="hidden" value="<?php echo $Values['flmdhlmodule']; ?>" id="flmdhlmodule<?php echo $a; ?>" name="flmdhlmodule<?php echo $a; ?>"/>
                                <?php echo $Values['flmdhlmodule']; ?>
                            </td>
                            <td><input type="hidden" value="<?php echo $Values['flmdhlname']; ?>" id="flmdhlname<?php echo $a; ?>" name="flmdhlname<?php echo $a; ?>"/><?php echo $Values['flmdhlname']; ?></td>
                            <td><input type="text" size="65" value="<?php echo $Values['trgrflhelp']; ?>" id="trgrflhelp<?php echo $a; ?>" name="trgrflhelp<?php echo $a; ?>"/></td>
                        </tr>
                        <?php
                        $a++;
                    }
                    $a--;
                    ?>
                    <tr>                    
                        <td colspan="5">
                            <input type="hidden" value="<?php echo $a; ?>" id="Fields" name="Fields"/>
                            <button type="button" name="Save Fields" id="SaveFields" title="Save Fields"><b>Save Fields</b></button>
                        </td>
                    </tr>
                </table>
            </form>
        <?php } ?>
    </div>
</div>
