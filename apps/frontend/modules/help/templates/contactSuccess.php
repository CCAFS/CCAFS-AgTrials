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

    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Contact us</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
   </div>
    <form id="form_contact" name="form_contact" action="<?php echo url_for('@contactagtrials'); ?>" enctype="multipart/form-data" method="post">
        <table id="tablecss" width="42%">
            <br>
            <tr>
                <td id="bold">First name:</td>
                <td><input type="text" name="firstname" id="firstname" size="36"><span id="benefit"> *</span></td>
            </tr>
            <tr>
                <td id="bold">Last name:</td>
                <td><input type="text" name="lastname" id="lastname" size="36"><span id="benefit"> *</span></td>
            </tr>
            <tr>
                <td id="bold">E-mail address:</td>
                <td><input type="text" name="emailaddress" id="emailaddress" size="36"><span id="benefit"> *</span></td>
            </tr>
                        <tr>
                <td id="bold">Phone number:</td>
                <td><input type="text" name="phonenumber" id="phonenumber" size="36"><span id="benefit"> *</span></td>
            </tr>
            <tr>
                <td id="bold">Your country:</td>
                <td><?php echo select_country(); ?><span id="benefit"> *</span></td>
            </tr>
            <tr>
                <td id="bold">Message:</td>
                <td><textarea id="message" name="message" title="Message" rows="5" cols="50"></textarea><span id="benefit"> *</span></td>
            </tr>


            <tr align="center">
                <td align="center" colspan="2">
                    <br>
                    <input type="button" value="Send" id="contactsubmit">
                    <input type="button" value="Back" OnClick="window.location = '/'">
                </td>
            </tr>
        </table>
    </form>
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