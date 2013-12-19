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
  a {text-decoration: none;}
a:hover {text-decoration: underline;}
    
 div.resultados {
  width:1135px;
  height:600px;
  overflow:scroll;
  }

#tablecss{
    border:0px solid #FFD90F;
}
#campos{
    background-color:#6C8E54;
    color:white;
    font-size:14px;
    font-weight:bold;
    text-align: center;

}

#trdatos{
    background-color:#6C8E54;
}

#tddatos{
    border:1px solid #FFD90F;
}

#tddatos2{
    border:1px solid #FFD90F;
    text-align: center;
}

#bold{
    border:0px solid #FFD90F;
    font-weight:bold;
}
</style>
<script>
    $(document).ready(function() {
        $('#newcategorysubmit').click(function() {
            var ctgname = $('#ctgname').attr('value');
            var ctgdescription = $('#ctgdescription').attr('value');
            if(ctgname == ''){
                jAlert('error', 'Name','Invalid', null)
            }else if(ctgdescription == ''){
                jAlert('error', 'Description','Invalid', null)
            }else{
                $('#div_loading').show();
                $('#form_newcategory').submit();
            }
        });
    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1><?php echo image_tag('conversation-icon.png'); ?><a href="forum">Forum / New Category</a></h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <form id="form_newcategory" name="form_newcategory" action="<?php echo url_for('@newcategory'); ?>" enctype="multipart/form-data" method="post">
                <table id="tablecss" width="25%">
                    <br>
                    <tr>
                        <td id="bold">Name:</td>
                        <td><input type="text" name="ctgname" id="ctgname" size="36"></td>
                    </tr>
                    <tr>
                        <td id="bold">Description:</td>
                        <td><input type="text" name="ctgdescription" id="ctgdescription" size="36"></td>
                    </tr>
                    <tr align="center">
                        <td align="center" colspan="2">
                            <br>
                            <input type="button" value="Send" id="newcategorysubmit">
                            <input type="button" value="Back" OnClick="window.location = '/forum'">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</div>