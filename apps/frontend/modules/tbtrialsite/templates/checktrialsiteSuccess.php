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
        $('#id_country').change(function() {
            var id_country = $('#id_country').attr('value');
            $('#ListTrialsite').html("");
            $('#ListTrialsiteError').html("");
            $('#ListTrialsiteCode').html("");
            $('#Latitude1').attr('value','');
            $('#Latitude2').attr('value','');
            $('#Longitude1').attr('value','');
            $('#Longitude2').attr('value','');

            $.ajax({
                type: "GET",
                url: "/tbtrialsite/assigncountry/",
                data:"id_country="+id_country,
                success: function(){}
            });
        });
        
        $('#ValidateList').click(function() {
            var ListTrialSite = $('#ListTrialSite').attr('value');
            $('#ListTrialsiteError').html("");
            $('#ListTrialsiteCode').html("");
            $('#Latitude1').attr('value','');
            $('#Latitude2').attr('value','');
            $('#Longitude1').attr('value','');
            $('#Longitude2').attr('value','');

            if(ListTrialSite == ''){
                jAlert('error', '* List Trial Site','Incomplete Information', null);
            }else{
                ValidateTrialsite(ListTrialSite);
            }
        });
        
        $('#ValidateCoordenates').click(function() {
            var Latitude1 = $('#Latitude1').attr('value');
            var Latitude2 = $('#Latitude2').attr('value');
            var Longitude1 = $('#Longitude1').attr('value');
            var Longitude2 = $('#Longitude2').attr('value');
            $('#ListTrialsiteError').html("");
            $('#ListTrialsiteCode').html("");
            $('#ListTrialSite').attr('value','');
                
            if(Latitude1 == '' || Latitude2 == '' || Longitude1 == '' || Longitude2 == ''){
                jAlert('error', '* Coordenates','Incomplete Information', null);
            }else{
                ValidateCoordenates(Latitude1,Latitude2,Longitude1,Longitude2);
            }
        });

        $('#Latitude1').blur(function() {
            var valor = $('#Latitude1').attr('value');
            var field = "#Latitude1";
            if(valor != '')
                ValidaLatitudeDecimal(field,valor);
        });
        $('#Latitude2').blur(function() {
            var valor = $('#Latitude2').attr('value');
            var field = "#Latitude2";
            if(valor != '')
                ValidaLatitudeDecimal(field,valor);
        });
        $('#Longitude1').blur(function() {
            var valor = $('#Longitude1').attr('value');
            var field = "#Longitude1";
            if(valor != '')
                ValidaLongitudeDecimal(field,valor);
        });
        $('#Longitude2').blur(function() {
            var valor = $('#Longitude2').attr('value');
            var field = "#Longitude2";
            if(valor != '')
                ValidaLongitudeDecimal(field,valor);
        });


    });
    
    function SelectLetter(letter){
        $.ajax({
            type: "GET",
            url: "/tbtrialsite/selectletter/",
            data:"letter="+letter,
            success: function(data){
                $('#ListTrialsite').html(data);
                $('#ListTrialsiteError').html("");
                $('#ListTrialsiteCode').html("");
                $('#ListTrialSite').attr('value','');
                $('#Latitude1').attr('value','');
                $('#Latitude2').attr('value','');
                $('#Longitude1').attr('value','');
                $('#Longitude2').attr('value','');
            }
        });
    }
    
    function ValidateTrialsite(Listtrialsite){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/tbtrialsite/validatetrialsite/",
            data:"listtrialsite="+Listtrialsite,
            success: function(data){
                var json = eval(data);
                var info = json.info
                var error = json.error
                var codes = json.codes
                $('#ListTrialsite').html(info);
                $('#ListTrialsiteError').html(error);
                if(codes != "")
                    $('#ListTrialsiteCode').html("<b>Codes trial site found</b><br><textarea id='ListTrialsiteCode' name='ListTrialsiteCode' rows='4' cols='120'>"+codes+"</textarea>");

            }
        });
    }

    function  ValidateCoordenates(Latitude1,Latitude2,Longitude1,Longitude2){
        $.ajax({
            type: "GET",
            url: "/tbtrialsite/validatecoordenates/",
            data:"Latitude1="+Latitude1+"&Latitude2="+Latitude2+"&Longitude1="+Longitude1+"&Longitude2="+Longitude2,
            success: function(data){
                $('#ListTrialsite').html(data);
                $('#ListTrialsiteError').html("");
                $('#ListTrialsiteCode').html("");
            }
        });
    }

    function  ValidaLatitudeDecimal(Field,Valor){
        if(!isNaN(Valor)){
            if((Valor > 90) ||(Valor < -90)){
                jAlert('error', '* Latitude Incorrect (-90, 90)','Incorrect Information', null);
                $(Field).attr('value','');
            }
        }else{
            jAlert('error', '* Latitude must be numeric (-90, 90)','Incorrect Information', null);
            $(Field).attr('value','');
        }
    }

    function  ValidaLongitudeDecimal(Field,Valor){
        if(!isNaN(Valor)){
            if((Valor > 180) ||(Valor < -180)){
                jAlert('error', '* Longitude Incorrect (-180, 180)','Incorrect Information', null);
                $(Field).attr('value','');
            }
        }else{
            jAlert('error', '* Longitude must be numeric (-180, 180)','Incorrect Information', null);
            $(Field).attr('value','');
        }
    }

    function CambiaColorOver(celda){
        celda.style.backgroundColor="#83A070";
    }
    function CambiaColorOut(celda){
        celda.style.backgroundColor="#F9F8F6";
    }
    
</script>
<style type="text/css">
    #ListTrialsite{
        width:943px;
        height:250px;
        overflow-x:hidden;
        overflow-y:scroll;
    }

    #ListTrialsiteCode{
        width:943px;
        height:120px;
        overflow-x:hidden;
        overflow-y:scroll;
    }

    #ListTrialsiteError{
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
        <h1>Check Trial site</h1>
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
                        <td colspan="2"><b>Country: </b><?php echo select_from_table("id_country", "TbCountry", "id_country", "cntname", null, null); ?>                            <?php
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
                            <div id="ListTrialsite" name="ListTrialsite"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&ensp;</td>
                    </tr>                    <tr>
                        <td colspan="2">
                            <div id="ListTrialsiteCode" name="ListTrialsiteCode"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&ensp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="ListTrialsiteError" name="ListTrialsiteError"></div>
                        </td>
                    </tr>
                    <tr><td colspan="2"></td></tr>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <textarea id="ListTrialSite" name="ListTrialSite" rows="2" cols="50" placeholder="Enter or cut-and-paste trial site names separated by comma"></textarea>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td align="center">
                                        <input type="button" value="Validate List" id="ValidateList" name="ValidateList">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Latitude Between: </td>
                                    <td><input type="text" value="" size="15" id="Latitude1" name="Latitude1"> And <input type="text" value="" size="15" id="Latitude2" name="Latitude2"></td>
                                </tr>
                                <tr>
                                    <td>Longitude Between: </td>
                                    <td><input type="text" value="" size="15" id="Longitude1" name="Longitude1"> And <input type="text" value="" size="15" id="Longitude2" name="Longitude2"></td>
                                </tr>
                                <tr><td colspan="2">&ensp;</td></tr>
                                <tr align="center">
                                    <td align="center">
                                        <input type="button" value="Validate Coordenates" id="ValidateCoordenates" name="ValidateCoordenates">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </form>
            <br>
        </div>
    </div>
</div>
