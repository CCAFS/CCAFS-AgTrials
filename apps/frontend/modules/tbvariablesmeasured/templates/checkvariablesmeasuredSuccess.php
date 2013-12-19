<?php
use_stylesheet('/sfAdminThemejRollerPlugin/css/reset.css', 'first');
use_javascript('/sfAdminThemejRollerPlugin/js/jquery.min.js', 'first');
use_javascript('/sfAdminThemejRollerPlugin/js/jquery-ui.custom.min.js', 'first');
use_stylesheet('/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/jroller.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.menu.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.buttons.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/ui.selectmenu.css');
use_stylesheet('/css/jquery.alerts.css');
use_javascript('/sfAdminThemejRollerPlugin/js/fg.menu.js');
use_javascript('/sfAdminThemejRollerPlugin/js/jroller.js');
use_javascript('/sfAdminThemejRollerPlugin/js/ui.selectmenu.js');
use_javascript('/js/jquery.alerts.js');
use_helper('Thickbox');
?>
<script>
    $(document).ready(function() {
        $('#id_crop').change(function() {
            var id_crop = $('#id_crop').attr('value');
            $.ajax({
                type: "GET",
                url: "/tbtrial/assigncrop/",
                data:"id_crop="+id_crop,
                success: function(){
                    $('#ListVariablesmeasured').html("");
                    $('#ListVariablesmeasuredError').html("");
                    $('#ListVariablesmeasuredCode').html("");
                }
            });
        });
        
        $('#ValidateList').click(function() {
            var ListVariablesmeasureds = $('#ListVariablesmeasureds').attr('value');
            if(ListVariablesmeasureds == ''){
                jAlert('error', '* List Variables Measured','Incomplete Information', null);
            }else{
                ValidateVariablesmeasureds(ListVariablesmeasureds);
                $('#ListVariablesmeasureds').attr('value','');
                $('#ListVariablesmeasuredError').html("");
                $('#ListVariablesmeasuredCode').html("");
            }
        });
    });
    
    function SelectLetter(letter){
        $.ajax({
            type: "GET",
            url: "/tbvariablesmeasured/selectletter/",
            data:"letter="+letter,
            success: function(data){
                $('#ListVariablesmeasured').html(data);
                $('#ListVariablesmeasuredError').html("");
                $('#ListVariablesmeasuredCode').html("");
            }
        });
    }
    
    function ValidateVariablesmeasureds(ListVariablesmeasureds){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/tbvariablesmeasured/validatevariablesmeasured/",
            data:"ListVariablesmeasureds="+ListVariablesmeasureds,
            success: function(data){
                var json = eval(data);
                var info = json.info
                var error = json.error
                var codes = json.codes
                $('#ListVariablesmeasured').html(info);
                $('#ListVariablesmeasuredError').html(error);
                if(codes != '')
                    $('#ListVariablesmeasuredCode').html("<b>Codes variables measured found</b><br><textarea id='ListVariablesmeasuredCode' name='ListVariablesmeasuredCode' rows='4' cols='120'>"+codes+"</textarea>");
            }
        });
    }
    
</script>
<style type="text/css">
    #ListVariablesmeasured{
        width:943px;
        height:250px;
        overflow-x:hidden;
        overflow-y:scroll;
    }

    #ListVariablesmeasuredCode{
        width:943px;
        height:120px;
        overflow-x:hidden;
        overflow-y:scroll;
    }

    #ListVariablesmeasuredError{
        width:943px;
        height:100px;
        overflow-x:hidden;
        overflow-y:scroll;
    }

    #Div1{
        float:left;
        width:460px;
    }
    #Div2{
        float:left;
        width:460px;
    }    
</style>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Check Variables Measured</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div> 
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <form id="Checkvariablesmeasured" name="Checkvariablesmeasured" action="<?php echo url_for('@checkvariablesmeasured'); ?>" enctype="multipart/form-data" method="post">
                <table align="center" width="100%">
                    <tr><td colspan="2"></td></tr>
                    <tr>
                        <td width="10%"><b>Technology:</b></td>
                        <td width="90%"> 
                            <?php
                            echo select_from_table("id_crop", "TbCrop", "id_crop", "crpname", null, null);
                            $Arr_Abecedario = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
                            echo "&ensp;&ensp;&ensp;&ensp;";
                            foreach ($Arr_Abecedario AS $Letter) {
                                echo "<a href='#' title=\"Search by $Letter\" onclick=\"SelectLetter('$Letter');\"><b><u>$Letter</u></b></a>&ensp;&ensp;";
                            }
                            ?>

                        </td>
                    </tr>
                    <tr><td colspan="2"></td></tr>
                    <tr>
                        <td colspan="2">
                            <div id="ListVariablesmeasured" name="ListVariablesmeasured"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&ensp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="ListVariablesmeasuredCode" name="ListVariablesmeasuredCode"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&ensp;</td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div id="ListVariablesmeasuredError" name="ListVariablesmeasuredError"></div>
                        </td>
                    </tr>
                    <tr><td colspan="2"></td></tr>
                    <tr>
                        <td colspan="2">
                            <textarea id="ListVariablesmeasureds" name="ListVariablesmeasureds" rows="3" cols="134" placeholder="Enter or cut-and-paste Variables Measured names separated by comma" value=""></textarea>
                        </td>
                    </tr>
                    <tr align="center">
                        <td align="center">
                            <input type="button" value="Validate List" id="ValidateList" name="ValidateList">
                        </td>
                    </tr>
                </table>
            </form>
            <br>
        </div>
    </div>
</div>
