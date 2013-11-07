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

.tituloinicial {
    font-family: Verdana;
    border-top:2px solid #FFD41C;
    background-color: #48732A;
    font-size: 16px;
    color: #FFFFFF;
    font-weight: bold;
    padding: 1px;
}

.titulosesiones {
    font-family: Verdana;
    border-top:2px solid #FFD41C;
    background-color: #48732A;
    font-size: 16px;
    color: #FFFFFF;
    font-weight: bold;
    padding: 4px;
}
</style>
<script>
    $(document).ready(function() {
        $('#contactsubmit').click(function() {
            if($('#firstname').attr('value') == ''){
                jAlert('error', 'First name','Invalid', null);
            }else if($('#lastname').attr('value') == ''){
                jAlert('error', 'Last name','Invalid', null);
            }else if($('#emailaddress').attr('value') == ''){
                jAlert('error', 'Email address','Invalid', null);
            }else if($('#emailaddress').attr('value') != '' && ($("#emailaddress").val().indexOf('@', 0) == -1 || $("#emailaddress").val().indexOf('.', 0) == -1)){
                jAlert('error', 'Email address Error','Invalid', null);
            }else if($('#phonenumber').attr('value') == ''){
                jAlert('error', 'Phone number','Invalid', null);
            }else if($('#country').attr('value') == ''){
                jAlert('error', 'Country','Invalid', null);
            }else if($('#message').attr('value') == ''){
                jAlert('error', 'Message','Invalid', null);
            }else{
                $('#div_loading').show();
                $('#form_contact').submit();
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
        <h1>Contact Us</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
        <table width="940" border="0" align="center">
            <form id="form_contact" name="form_contact" action="<?php echo url_for('@contactagtrials'); ?>" enctype="multipart/form-data" method="post">
                <tr><td colspan="2"></td></tr>
                <tr>
                    <td width="140"><b>First name:</b></td>
                    <td width="800"><input type="text" name="firstname" id="firstname" size="36"><span id="benefit"> *</span></td>
                </tr>
                <tr>
                    <td><b>Last name:</b></td>
                    <td><input type="text" name="lastname" id="lastname" size="36"><span id="benefit"> *</span></td>
                </tr>
                <tr>
                    <td><b>E-mail address:</b></td>
                    <td><input type="text" name="emailaddress" id="emailaddress" size="36"><span id="benefit"> *</span></td>
                </tr>
                <tr>
                    <td><b>Phone number:</b></td>
                    <td><input type="text" name="phonenumber" id="phonenumber" size="36"><span id="benefit"> *</span></td>
                </tr>
                <tr>
                    <td><b>Your country:</b></td>
                    <td><?php echo select_country(); ?><span id="benefit"> *</span></td>
                </tr>
                <tr>
                    <td><b>Message:</b></td>
                    <td><textarea id="message" name="message" title="Message" rows="5" cols="50"></textarea><span id="benefit"> *</span></td>
                </tr>
                <tr>
                    <td><b>Security Code:</b></td>
                    <td>
                        <div id="code_error"></div>
                        <input type="text" name="code" id="code" size="15" oncopy="return false;" onpaste="return false;" oncut="return false;" autocomplete="off">
                        <input type="text" value="<?php echo @generatecode(6); ?>" name="securitycode" id="securitycode" class="codeBox" oncopy="return false;" onpaste="return false;" oncut="return false;" readonly>
                        <img src="/images/refresh.gif" id="refreshcode" />
                    </td>
                </tr>
                <tr align="center">
                    <td align="center" colspan="2">
                        <input type="button" value="Send" id="contactsubmit">
                    </td>
                </tr>
            </form>
        </table>
</div>
<?php
function select_country() {
    $QUERY00 = Doctrine_Query::create()
                    ->select("cntname")
                    ->from("TbCountry")
                    ->orderBy("cntname");
    $Resultado00 = $QUERY00->execute();
    $OPTION = "<OPTION VALUE=''></OPTION>";
    foreach ($Resultado00 AS $fila) {
        $OPTION .= "<OPTION VALUE='{$fila['cntname']}'>{$fila['cntname']}</OPTION>";
    }
    $HTML = "<SELECT NAME='country' id='country' SIZE='1'>";
    $HTML .= $OPTION;
    $HTML .= "</SELECT>";
    return $HTML;
}
?>