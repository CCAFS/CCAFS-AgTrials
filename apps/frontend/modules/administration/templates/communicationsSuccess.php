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

<link href="/autocompletemultiple/autocomplete.css" rel="stylesheet" type="text/css" />
<script src="/autocompletemultiple/jquery-1.4.3.min.js" type="text/javascript"></script>
<script src="/autocompletemultiple/jquery-ui/js/jquery-ui-1.8.6.custom.min.js" type="text/javascript"></script>
<script src="/autocompletemultiple/autocomplete.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script>
    $(function(){
        $('#user_id').autocompleteusers({
            selected: [<?php if ($selected) echo $selected; ?>]
        });

    });

    $(document).ready(function() {
        $('#communicationssubmit').click(function() {
            $('#div_loading').show();
            $('#form_communications').submit();
        });
    });
</script>
<style type="text/css">

    div.resultados {
        width:1135px;
        height:600px;
        overflow:scroll;
    }

    #tablecss{
        border:1px solid #87B6D9;
    }
    #campos{
        background-color:#87B6D9;
        color:white;
        font-size:14px;
        font-weight:bold;

    }

    #trdatos{
        background-color:#E9E9E9;
    }

    #tddatos{
        border:1px solid #87B6D9;
    }
    #tddatosbold{
        border:1px solid #87B6D9;
        font-weight:bold;
    }

    div.fbautocomplete-main-div {
        width:445px; padding:3px 3px 0;
        margin:0 auto;
        border:1px solid #aaa; background-color:#fff; cursor:text;
    }

    #bold{
        border:0px solid #87B6D9;
        font-size:15px;
        font-weight:bold;
    }

    .users
    {
        border:none;
    }

</style>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Communications</h1>
    </div>
    <div>
        <form id="form_communications" name="form_communications" action="<?php echo url_for('@communications'); ?>" enctype="multipart/form-data" method="post">
            <table align="center">
                <tr>
                <br>
                <td nowrap><b>To:</b></td>
                <td>
                    <fieldset id="users" class="users">
                        <div  align="center">
                            <input id="user_id" name="user_id" type="text" size="50" placeholder="Search">
                        </div>    
                    </fieldset>
                    <input type="checkbox" name="userssystemall" value="userssystemall"><b>All user in the system</b>

                </td>
                </tr>
                <tr><td colspan="2">&ensp;</td></tr>
                <tr>
                    <td nowrap><b>Subject:</b></td>
                    <td id="bold">&ensp;<input type="text" size="50" value="" name="subject" id="subject" style="font-weight: bold"></td>
                </tr>
                <tr>
                    <td nowrap><b>Message:</b></td>
                    <td>&ensp;
                        <textarea id="message" name="message" rows="5" cols="100"></textarea>
                        <script type="text/javascript">
                            tinyMCE.init({
                                mode:                              "exact",
                                elements:                          "message",
                                theme:                             "advanced",
                                width:                             "350px",
                                height:                            "350px",
                                theme_advanced_toolbar_location:   "top",
                                theme_advanced_toolbar_align:      "left",
                                theme_advanced_statusbar_location: "bottom",
                                theme_advanced_resizing:           true
                            });
                        </script>
                    </td>
                </tr>
                <tr align="center">
                    <td align="center" colspan="2">
                        <br>
                        <input type="hidden" value="true" id="forma" name="forma">
                        <input type="button" value="Send" id="communicationssubmit">
                        <input type="button" value="Home" OnClick="window.location = '/'">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
