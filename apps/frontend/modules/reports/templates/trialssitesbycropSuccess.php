<?php
require_once '../lib/funtions/funtion.php';
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
?>
<style type="text/css">
    a {text-decoration: none;}
    a:hover {text-decoration: underline;}
    #bold{
        border:0px solid #87B6D9;
        font-size:15px;
        font-weight:bold;
    }

    .style1 {
        font-size: 12px;
        font-weight: bold;
    }
</style>
<script>
    $(document).ready(function() {
        $('#search').click(function() {
            $('#forma').attr('value',"OK");
//            $('#div_loading').show();
            $('#rep_trialssitesbycrop').submit();
        });
    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Reports - Trials sites by crop/animal</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <br>
    <form id="rep_trialssitesbycrop" name="rep_trialssitesbycrop" action="<?php echo url_for('rep_trialssitesbycrop'); ?>" enctype="multipart/form-data" method="post">
        <table align="center" width="60%">
            <tr>
                <td nowrap><span class="style1">Trial group</span></td>
                <td><span class="style1"><?php echo select_from_table("trialgroup", "TbTrialgroup", "id_trialgroup", "trgrname", null, null); ?></span></td>
            </tr>
            <tr>
                <td nowrap><span class="style1"><b>Contact Person</b></span></td>
                <td><span class="style1"><?php echo select_from_table("contactperson", "TbContactperson", "id_contactperson", "(cnprfirstname||' '||cnprlastname)", null, null); ?></span></td>
            </tr>
            <tr>
                <td nowrap><span class="style1"><b>Country </b></span></td>
                <td><span class="style1"><?php echo select_from_table("country", "TbCountry", "id_country", "cntname", null, null); ?></span></td>
            </tr>
            <tr>
                <td nowrap><span class="style1"><b>Trial site</b></span></td>
                <td><span class="style1"><?php echo select_from_table("trialsite", "TbTrialsite", "id_trialsite", "trstname", null, null); ?></span></td>
            </tr>
            <tr>
                <td nowrap><span class="style1"><b>Crop/Animal</b></span></td>
                <td><span class="style1"><?php echo select_from_table("crop", "TbCrop", "id_crop", "crpname", null, null); ?></span></td>
            </tr>
            <tr align="center">
                <td align="center" colspan="2"><br>
                    <input type="hidden" value="" id="forma" name="forma">
                    <input type="button" value="Search" id="search">
                    <input type="button" value="Clear" id="clear">
                </td>
            </tr>
        </table>
    </form>
    <br>
</div>