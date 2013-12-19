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
                    $('#ListVariety').html("");
                    $('#ListVarietyError').html("");
                    $('#ListVarietyCode').html("");
                }
            });
        });
        
        $('#ValidateList').click(function() {
            var ListVarieties = $('#ListVarieties').attr('value');
            if(ListVarieties == ''){
                jAlert('error', '* List Varieties','Incomplete Information', null);
            }else{
                ValidateVarieties(ListVarieties);
                $('#ListVarieties').attr('value','');
                $('#ListVarietyError').html("");
                $('#ListVarietyCode').html("");
            }
        });
    });
    
    function SelectLetter(letter){
        $.ajax({
            type: "GET",
            url: "/tbvariety/selectletter/",
            data:"letter="+letter,
            success: function(data){
                $('#ListVariety').html(data);
                $('#ListVarietyError').html("");
                $('#ListVarietyCode').html("");
            }
        });
    }
    
    function ValidateVarieties(ListVarieties){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/tbvariety/validatevarieties/",
            data:"listvarieties="+ListVarieties,
            success: function(data){
                var json = eval(data);
                var info = json.info
                var error = json.error
                var codes = json.codes
                $('#ListVariety').html(info);
                $('#ListVarietyError').html(error);
                if(codes != '')
                    $('#ListVarietyCode').html("<b>Codes varieties found</b><br><textarea id='ListVarietiesCode' name='ListVarieties' rows='4' cols='120'>"+codes+"</textarea>");

            }
        });
    }
    
</script>
<style type="text/css">
    #ListVariety{
        width:943px;
        height:250px;
        overflow-x:hidden;
        overflow-y:scroll;
    }

    #ListVarietyCode{
        width:943px;
        height:120px;
        overflow-x:hidden;
        overflow-y:scroll;
    }

    #ListVarietyError{
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
        <h1>Check Variety</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div> 
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <form id="Checkvariety" name="Checkvariety" action="<?php echo url_for('@checkvariety'); ?>" enctype="multipart/form-data" method="post">
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
                            <div id="ListVariety" name="ListVariety"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&ensp;</td>
                    </tr>                    <tr>
                        <td colspan="2">
                            <div id="ListVarietyCode" name="ListVarietyCode"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&ensp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="ListVarietyError" name="ListVarietyError"></div>
                        </td>
                    </tr>
                    <tr><td colspan="2"></td></tr>
                    <tr>
                        <td colspan="2">
                            <textarea id="ListVarieties" name="ListVarieties" rows="3" cols="134" placeholder="Enter or cut-and-paste variety names separated by comma"></textarea>
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
