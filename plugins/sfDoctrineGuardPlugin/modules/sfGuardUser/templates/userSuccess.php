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
use_helper('Thickbox');
$sfGuardUser = Doctrine::getTable('sfGuardUser')->findOneBy("Username", sfContext::getInstance()->getUser()->getUsername());
$userid = $sfGuardUser->id;
$sfGuardUserInformation = Doctrine::getTable('sfGuardUserInformation')->findOneByUserId($userid);
if ($sfGuardUserInformation->key == '')
    $key = strtoupper(generatecode(15));
else
    $key = $sfGuardUserInformation->key;

$EmailAddress = "";
if (!(strpos($sfGuardUser->email_address, "none")))
    $EmailAddress = $sfGuardUser->email_address;
?>
<script> 
    $(document).ready(function() {
        $('#usersubmit').click(function() {
            if($('#email_address').attr('value') == ''){
                jAlert('error', 'Email address','Incomplete information', null);
            }else if($('#email_address').attr('value') != '' && ($("#email_address").val().indexOf('@', 0) == -1 || $("#email_address").val().indexOf('.', 0) == -1)){
                jAlert('error', 'Email address Error','Invalid information', null);
            }else if($('#first_name').attr('value') == ''){
                jAlert('error', 'First name','Incomplete information', null);
            }else if($('#last_name').attr('value') == ''){
                jAlert('error', 'Last name','Incomplete information', null);
            }else if($('#institution').attr('value') == ''){
                jAlert('error', 'Institution or Affiliation','Invalid', null);
            }else if($('#country').attr('value') == ''){
                jAlert('error', 'Country','Invalid', null);
            }else if($('#city').attr('value') == ''){
                jAlert('error', 'City','Invalid', null);
            }else if($('#address').attr('value') == ''){
                jAlert('error', 'Address','Invalid', null);
            }else if($('#telephone').attr('value') == ''){
                jAlert('error', 'Telephone','Invalid', null);
            }else{
                $('#div_loading').show();
                $('#form_user').submit();
            }
        });

        $('#email_address').blur( function() {
            var emailaddress = $('#email_address').attr('value');
            var userid = $('#user_id').attr('value');
            if($('#email_address').attr('value') != '' && ($("#email_address").val().indexOf('@', 0) == -1 || $("#email_address").val().indexOf('.', 0) == -1)){
                $('#error_email_address').html('Email address Error');
            }else{
                $.ajax({
                    type: "GET",
                    url: "/sfGuardUser/validacorreo",
                    data:"userid="+userid+"&emailaddress="+emailaddress,
                    success: function(data){
                        $('#error_email_address').html(data);
                        if(data != '')
                            $('#email_address').attr('value','');
                    }
                });
            }
        });
    });
</script>
<style type="text/css">

    #bold{
        border:0px solid #87B6D9;
        font-size:15px;
        font-weight:bold;
    }

    #error_email_address{
        border:0px solid #87B6D9;
        font-size:11px;
        color:red;
    }

    .style1 {font-size: 14px}
    .mandatory {font-size: 14px; color:red; font-weight:bold;}
</style>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Profile</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <br>
            <form id="form_user" name="form_user" action="<?php echo url_for('/sfGuardUser/user'); ?>" enctype="multipart/form-data" method="post">
                <table align="center">
                    <tr>
                        <td><span class="style1">
                                <label>Username:</label>
                            </span></td>
                        <td id="bold"><span class="style1"><b><?php echo sfContext::getInstance()->getUser()->getUsername(); ?></b>
                                <input type="hidden" name="user_id" id="user_id" size="35" value="<?php echo $sfGuardUser->id; ?>">
                            </span></td>
                    </tr>
                    <tr>
                        <td><span class="style1">
                                <label>Email address:</label>
                            </span></td>
                        <td id="bold">
                            <div class="style1" id="error_email_address"></div>
                            <span class="style1">
                                <input type="text" name="email_address" id="email_address" size="35" value="<?php echo $EmailAddress; ?>"><span class="mandatory">*</span>
                            </span></td>
                    </tr>
                    <tr>
                        <td><span class="style1">
                                <label>First name:</label>
                            </span></td>
                        <td id="bold"><input name="first_name" type="text" id="first_name" value="<?php echo $sfGuardUser->first_name; ?>" size="35"><span class="mandatory">*</span></td>
                    </tr>
                    <tr>
                        <td><span class="style1">
                                <label>Last name:</label>
                            </span></td>
                        <td id="bold"><input name="last_name" type="text" id="last_name" value="<?php echo $sfGuardUser->last_name; ?>" size="35"><span class="mandatory">*</span></td>
                    </tr>
                    <tr>
                        <td><span class="style1"><label>Institution or Affiliation:</label></span></td>
                        <td><span class="style1"><?php echo select_from_table("institution", "TbInstitution", "id_institution", "insname", null, $sfGuardUserInformation->id_institution); ?>
                            </span><span class="mandatory">*</span></td>
                    </tr>
                    <tr>
                        <td><span class="style1"><label>Country:</label></span></td>
                        <td><span class="style1"><?php echo select_from_table("country", "TbCountry", "id_country", "cntname", null, $sfGuardUserInformation->id_country); ?>
                            </span><span class="mandatory">*</span></td>
                    </tr>
                    <tr>
                        <td><span class="style1"><label>City:</label></span></td>
                        <td><span class="style1">
                                <input type="text" name="city" id="city" size="35" value="<?php echo $sfGuardUserInformation->city; ?>">
                            </span><span class="mandatory">*</span></td>
                    </tr>
                    <tr>
                        <td><span class="style1"><label>State:</label></span></td>
                        <td><span class="style1">
                                <input type="text" name="state" id="state" size="35" value="<?php echo $sfGuardUserInformation->state; ?>">
                            </span></td>
                    </tr>
                    <tr>
                        <td><span class="style1"><label>Address:</label></span></td>
                        <td><span class="style1">
                                <input type="text" name="address" id="address" size="35" value="<?php echo $sfGuardUserInformation->address; ?>">
                            </span><span class="mandatory">*</span></td>
                    </tr>
                    <tr>
                        <td><span class="style1"><label>Telephone:</label></span></td>
                        <td><span class="style1">
                                <input type="text" name="telephone" id="telephone" size="35" value="<?php echo $sfGuardUserInformation->telephone; ?>">
                            </span><span class="mandatory">*</span></td>
                    </tr>
                    <tr>
                        <td><span class="style1"><label>Key:</label></span></td>
                        <td><span class="style1">
                                <input type="text" name="key" id="key" size="35" value="<?php echo $key; ?>" readonly>
                            </span></td>
                    </tr>
                    <tr align="center">
                        <td align="center" colspan="2"><span class="style1"><br>
                                <input type="button" value="Save" id="usersubmit">
                                <input type="button" value="Back" OnClick="window.location = '/'">
                            </span></td>
                    </tr>
                </table>
            </form>
            <br>
        </div>
    </div>
</div>
