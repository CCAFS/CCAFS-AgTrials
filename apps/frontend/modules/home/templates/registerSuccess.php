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

    #benefit{
        color:red;
    }

    .centrar {
        text-align: center;
        margin: 0 auto;
    }

    #error_email_address {
        border:0px solid #87B6D9;
        font-size:11px;
        color:red;
    }
    #code_error{
        border:0px solid #87B6D9;
        font-size:12px;
        color:red;
    }

    .codeBox{
        background-image:url('/images/backgrounds/bg3.jpg');
        background-repeat:no-repeat;
        width:100px;
        height:25px;
        text-align: center;
        font-family: Arial;
        font-size: 18pt;
        color:red;
        font-weight:bold;
    }

    .boton{
        text-align: left;
        font-size:15px;
        width: 350px;
        text-align: center;
        margin: 0 auto;
    }
    .obligatorio {color: #FF0000}
</style>
<script>
    $(document).ready(function() {
        $('#registersubmit').click(function() {
            var motivation = $('#motivation').val().length;

            if($('#emailaddress').attr('value') == ''){
                jAlert('error', 'Email address','Invalid', null);
            }else if($('#emailaddress').attr('value') != '' && ($("#emailaddress").val().indexOf('@', 0) == -1 || $("#emailaddress").val().indexOf('.', 0) == -1)){
                jAlert('error', 'Email address Error','Invalid', null);
            }else if($('#firstname').attr('value') == ''){
                jAlert('error', 'First name','Invalid', null);
            }else if($('#lastname').attr('value') == ''){
                jAlert('error', 'Last name','Invalid', null);
            }else if($('#institution').attr('value') == ''){
                jAlert('error', 'Institution','Invalid', null);
            }else if($('#country').attr('value') == ''){
                jAlert('error', 'Country','Invalid', null);
            }else if($('#city').attr('value') == ''){
                jAlert('error', 'City','Invalid', null);
            }else if($('#address').attr('value') == ''){
                jAlert('error', 'Address','Invalid', null);
            }else if($('#telephone').attr('value') == ''){
                jAlert('error', 'Telephone','Invalid', null);
            }else if((motivation == '') || (motivation <= 10)){
                jAlert('error', "Incomplete motivation, it's very short",'Invalid', null);
            }else if($('#code').attr('value') == ''){
                jAlert('error', 'Security Code','Invalid', null);
            }else{
                $('#div_loading').show();
                $('#form_register').submit();
            }
        });

        $('#emailaddress').blur( function() {
            var emailaddress = $('#emailaddress').attr('value');
            if($('#emailaddress').attr('value') != '' && ($("#emailaddress").val().indexOf('@', 0) == -1 || $("#emailaddress").val().indexOf('.', 0) == -1)){
                $('#error_email_address').html('Email address Error');
            }else{
                $.ajax({
                    type: "GET",
                    url: "/home/validacorreo",
                    data:"emailaddress="+emailaddress,
                    success: function(data){
                        $('#error_email_address').html(data);
                        if(data != '')
                            $('#emailaddress').attr('value','');
                    }
                });
            }
        });

        $('#refreshcode').click( function() {
            $.ajax({
                type: "GET",
                url: "/home/refreshcode",
                success: function(data){
                    $('#securitycode').attr('value',data);
                }
            });

        });

        $('#code').blur( function() {
            var code = $('#code').attr('value');
            var securitycode = $('#securitycode').attr('value');
            if(code != securitycode){
                $('#code_error').html("Sorry, the code you entered was invalid");
                $('#code').attr('value','');
            }else{
                $('#code_error').html("");
            }
        });

        $('#code').focus( function() {
            $('#code_error').html('');
        });

    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Register</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <div>
        <table>
            <br>
            <form id="form_register" width="800" name="form_register" action="<?php echo url_for('@register'); ?>" enctype="multipart/form-data" method="post">
                <tr>
                    <td><span><b>Email address:</b></span></td>
                    <td>
                        <div id="error_email_address"></div>
                        <span>
                            <input type="text" name="emailaddress" id="emailaddress" size="36">
                            <span class="obligatorio">*</span></span> </td>
                <tr>
                    <td width="150"><span><b>First name:</b></span></td>
                    <td width="650"><span>
                            <input type="text" name="firstname" id="firstname" size="36">
                            <span class="obligatorio">*</span></span> </td>
                </tr>
                <tr>
                    <td><span><b>Last name:</b></span></td>
                    <td><span>
                            <input type="text" name="lastname" id="lastname" size="36">
                            <span class="obligatorio">*</span></span> </td>
                </tr>
                <tr>
                    <td><span><b>Institution or Affiliation:</b></span></td>
                    <td><span><?php echo select_from_table("institution", "TbInstitution", "id_institution", "insname", null, 285); ?>
                            <span class="obligatorio">*</span></span></td>
                </tr>
                <tr>
                    <td><span><b>Country:</b></span></td>
                    <td><span><?php echo select_from_table("country", "TbCountry", "id_country", "cntname", null, null); ?>
                            <span class="obligatorio">*</span></span></td>

                </tr>
                <tr>
                    <td><span><b>City:</b></span></td>
                    <td><span>
                            <input type="text" name="city" id="city" size="36">
                            <span class="obligatorio">*</span></span></td>
                </tr>
                <tr>
                    <td><span><b>State:</b></span></td>
                    <td><span>
                            <input type="text" name="state" id="state" size="36">
                        </span></td>
                </tr>
                <tr>
                    <td><span><b>Address:</b></span></td>
                    <td><span>
                            <input type="text" name="address" id="address" size="36">
                            <span class="obligatorio">*</span></span></td>
                </tr>
                <tr>
                    <td><span><b>Telephone:</b></span></td>
                    <td><span>
                            <input type="text" name="telephone" id="telephone" size="36">
                            <span class="obligatorio">*</span></span></td>
                </tr
                ><tr>
                    <td colspan="2"><span><br>
                        </span>
                        <p><b>Motivation:</b> The www.agtrials.org database is not yet fully available to the general public. If you interested in full access, please state your motivation for accessing the database. Will you contribute any data to the database? What is your intended use of the data? In the short term, we will not be granting full access to everyone requesting it. After filling out this form, we will contact you regarding your collaboration with Agtrials.org. Please fill in the text box below with this information:</p>                    </td>
                </tr
                ><tr>
                    <td colspan="2">
                        <span>
                            <textarea name="motivation" id="motivation" rows="3" cols="100"></textarea>
                        </span>
                        <span class="obligatorio">*</span></td>
                </tr
                ><tr>
                    <td><span><b>Security Code:</b></span></td>
                    <td>
                        <div id="code_error"></div>
                        <span>
                            <input type="text" name="code" id="code" size="15" oncopy="return false;" onpaste="return false;" oncut="return false;" autocomplete="off">
                            <input type="text" value="<?php echo @generatecode(6); ?>" name="securitycode" id="securitycode" class="codeBox" oncopy="return false;" onpaste="return false;" oncut="return false;" readonly>
                            <img src="/images/refresh.gif" id="refreshcode" />                    </span></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div align="center" class="style5"><input type="button" value="Save" id="registersubmit"></div>                    </td>
                </tr>
            </form>
        </table>
    </div>
</div>