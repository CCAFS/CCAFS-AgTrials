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
<style type="text/css">

#bold{
    border:0px solid #87B6D9;
    font-size:12px;
    font-weight:bold;
}
#benefit{
    color:red;
}
</style>
<script>
    $(document).ready(function() {

        //VALIDAMOS EL CAMPO DE ALTITUDE
        $('#forgotpasswordsubmit').click(function() {
            if($('#emailaddress').attr('value') == ''){
                jAlert('error', 'Email address','Invalid', null);
            }else if($('#emailaddress').attr('value') != '' && ($("#emailaddress").val().indexOf('@', 0) == -1 || $("#emailaddress").val().indexOf('.', 0) == -1)){
                jAlert('error', 'Email address Error','Invalid', null);
            }else{
                $('#div_loading').show();
                $('#form_forgotpassword').submit();
            }
        });

    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Forgot Password</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <br>
            <form id="form_forgotpassword" name="form_forgotpassword" action="<?php echo url_for('@forgotpassword'); ?>" enctype="multipart/form-data" method="post">
                <table align="center">
                    <tr>
                        <td id="bold">E-mail address:&ensp;</td>
                        <td><input type="text" name="emailaddress" id="emailaddress" size="40"><span id="benefit"> *</span></td>
                    </tr>
                    <tr align="center">
                        <td align="center" colspan="2">
                            <br>
                            <input type="button" value="Send" id="forgotpasswordsubmit">
                            <input type="button" value="Back" OnClick="window.location = '/'">
                        </td>
                    </tr>
                </table>
            </form>
            <br><br>
        </div>
    </div>

</div>
