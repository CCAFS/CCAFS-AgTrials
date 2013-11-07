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

        //VALIDAMOS EL CAMPO DE ALTITUDE
        $('#changepasswordsubmit').click(function() {
            validaInformacion();
        });

        function validaInformacion(){
            var newpassword = $('#newpassword').attr('value');
            var confirmnewpassword = $('#confirmnewpassword').attr('value');
            if((newpassword != '') && (confirmnewpassword != '')){
                if(newpassword != confirmnewpassword){
                    jAlert('error', 'The new password is not equal to the confirmation','Invalid password', null);
                    $('#newpassword').attr('value','');
                    $('#confirmnewpassword').attr('value','');
                }else{
                    $('#div_loading').show();
                    $('#changepw').submit();
                }
            }else{
                jAlert('error', 'The new password or confirmation are empty','Invalid password', null);
            }
        }
    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Change Password</h1>
    </div>
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
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <form id="changepw" name="changepw" action="<?php echo url_for('/sfGuardUser/changepassword'); ?>" enctype="multipart/form-data" method="post">
                <table align="center">
                    <br>
                    <tr>
                        <td>User:</td>
                        <td><span><b><?php echo sfContext::getInstance()->getUser()->getUsername(); ?></b></span></td>
                    </tr>
                    <tr>
                        <td>New password:</td>
                        <td><input type="password" name="newpassword" id="newpassword" size="25"></td>
                    </tr>
                    <tr>
                        <td>Confirm new password:</td>
                        <td><input type="password" name="confirmnewpassword" id="confirmnewpassword" size="25"></td>
                    </tr>
                    <tr align="center">
                        <td align="center" colspan="2"><br>
                            <input type="button" value="Change password" id="changepasswordsubmit">
                        </td>
                    </tr>
                </table>
            </form>
            <br><br>
        </div>
    </div>

</div>
