<?php use_helper('I18N') ?>
<?php use_stylesheet('/sfAdminThemejRollerPlugin/css/reset.css', 'first') ?>
<?php use_javascript('/sfAdminThemejRollerPlugin/js/jquery.min.js', 'first') ?>
<?php use_javascript('/sfAdminThemejRollerPlugin/js/jquery-ui.custom.min.js', 'first') ?>
<?php use_stylesheet('/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css') ?>
<?php use_stylesheet('/sfAdminThemejRollerPlugin/css/jroller.css') ?>
<?php
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.menu.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.buttons.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/ui.selectmenu.css');
use_javascript('/sfAdminThemejRollerPlugin/js/fg.menu.js');
use_javascript('/sfAdminThemejRollerPlugin/js/jroller.js');
use_javascript('/sfAdminThemejRollerPlugin/js/ui.selectmenu.js');
?>
<style type="text/css">
    .centrar {
        text-align: center;
        margin: 0 auto;
    }
</style>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Welcome to Trial Site - Sign In</h1>
    </div>
    <br>
    <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
        <table class="centrar">
            <tbody>
                <?php echo $form ?>
            </tbody>
            <tfoot>
                <tr class="centrar">
                    <td colspan="2" class="centrar">
                        <input type="submit" value="<?php echo __('Signin', null, 'sf_guard') ?>" />
                        <input type="button" value="Forgot your password?" OnClick="window.location = '/forgotpassword'">
                        <input type="button" value="AgMIP" OnClick="window.location = 'https://auth.agmip.org/?s=agtrials'">
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <br>
</div>
