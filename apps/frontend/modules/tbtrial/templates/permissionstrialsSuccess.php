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
        $('#add').click(function() {
            $('#notice').html("");
            if(($('#trialgroups').attr('value') == '') && ($('#trials').attr('value') == '')){
                jAlert('error', '* Trial Groups or Trials','Incomplete Information', null);
            }else if($('#tb_trial_user').attr('value') == ''){
                jAlert('error', '* Users','Incomplete Information', null);
            }else{
                $('#form').val("add");
                $('#div_loading').show();
                $('#permissionstrials').submit();           }
        });

        $('#remove').click(function() {
            $('#notice').html("");
            if(($('#trialgroups').attr('value') == '') && ($('#trials').attr('value') == '')){
                jAlert('error', '* Trial Groups or Trials','Incomplete Information', null);
            }else if($('#tb_trial_user').attr('value') == ''){
                jAlert('error', '* Users','Incomplete Information', null);
            }else{
                $('#form').val("remove");
                $('#div_loading').show();
                $('#permissionstrials').submit();           }
        });
        
        $('#clear').click(function() {
            location.href="/permissionstrials";
        });
    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Permissions trials</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <?php if (isset($notice)) {
 ?>
            <div id="notice" class="sf_admin_flashes ui-widget">
                <div class="notice ui-state-highlight ui-corner-all">
                    <span class="ui-icon ui-icon-info floatleft"></span>&ensp;<?php echo $notice; ?>
                </div>
            </div>
<?php } ?>

        <div id="sf_admin_content">
            <div class="sf_admin_form">
                <form id="permissionstrials" name="permissionstrials" action="<?php echo url_for('@permissionstrials'); ?>" enctype="multipart/form-data" method="post">
                    <table align="center">
                        <tr><td colspan="2">&ensp;</td></tr>
                        <tr>
                            <td><b>Trial Groups:</b></td>
                            <td><?php echo thickbox_iframe("<textarea id=\"trialgroups\" name=\"trialgroups\" readonly=\"readonly\" cols=\"58\" rows=\"2\"></textarea>" . image_tag('list-icon.png'), '@trialgroups', array('pop' => '1')) ?></td>
                        </tr>
                        <tr>
                            <td><b>Trials:</b></td>
                            <td><?php echo thickbox_iframe("<textarea id=\"trials\" name=\"trials\" readonly=\"readonly\" cols=\"58\" rows=\"2\"></textarea>" . image_tag('list-icon.png'), '@trials', array('pop' => '1')) ?></td>
                        </tr>
                        <tr>
                            <td><b>Users:</b></td>
                            <td><?php echo thickbox_iframe("<textarea id=\"tb_trial_user\" name=\"tb_trial_user\" readonly=\"readonly\" cols=\"58\" rows=\"2\"></textarea> " . image_tag('user.jpg'), '@specifiedusers', array('pop' => '1')) ?></td>
                    </tr>
                    <tr><td colspan="2">&ensp;</td></tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="button" value=" Add " id="add"/>
                            <input type="button" value=" Remove " id="remove"/>
                            <input type="button" value="Clear" id="clear"/>
                            <input type="hidden" value="" id="form" name="form"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>