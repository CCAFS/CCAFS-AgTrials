$(document).ready(function() {
    
    //VALIDAMOS TIPO ARCHIVOS
    $('#tb_trial_trltrialresultsfile').blur(function() {
        validatrialresultsfile();
    });

    $('#tb_trial_trlsupplementalinformationfile').blur(function() {
        validasupplementalinformationfile();
    });

    $('#tb_trial_trlweatherduringtrialfile').blur(function() {
        validaweatherduringtrialfile();
    });

    $('#tb_trial_trlsoiltypeconditionsduringtrialfile').blur(function() {
        validasoiltypeconditionsduringtrialfile();
    });

    $('#autocomplete_tb_trial_id_crop').change(function() {
        limpiardatoscultivos();
    });

    $('#autocomplete_tb_trial_id_crop').change(function() {
        limpiardatoscultivos();
    });

    $("#tb_trial_trlfileaccess_Public_domain").click(function(){
        $("#tbtrial_users").css("display", "none");
        $("#tbtrial_groups").css("display", "none");
    });

    $("#tb_trial_trlfileaccess_Open_to_all_users").click(function(){
        $("#tbtrial_users").css("display", "none");
        $("#tbtrial_groups").css("display", "none");
    });

    $("#tb_trial_trlfileaccess_Open_to_specified_users").click(function(){
        $("#tbtrial_users").css("display", "block");
        $("#tbtrial_groups").css("display", "none");
    });

    $("#tb_trial_trlfileaccess_Open_to_specified_groups").click(function(){
        $("#tbtrial_users").css("display", "none");
        $("#tbtrial_groups").css("display", "block");
    });

    $("#tb_trial_trltrialclass_Crop").click(function(){
        $("#tbtrial_crop").css("display", "block");
        $("#tbtrial_animal").css("display", "none");
    });

    $("#tb_trial_trltrialclass_Animal").click(function(){
        $("#tbtrial_animal").css("display", "block");
        $("#tbtrial_crop").css("display", "none");
    });
    
    //GENERAR LOS FIEL NAME NUMBER
    $('#autocomplete_tb_trial_id_trialsite').change(function() {
        var id_trialsite = $('#tb_trial_id_trialsite').attr('value');
        $.ajax({
            type: "GET",
            url: "/agtrials/web/tbtrial/tbtrial/selectfieldnamenumber",
            data:"id_trialsite="+id_trialsite,
            success: function(data){
                $('#selected_fieldnamenumber').html(data);
                if(data != '')
                    $('#selected_fieldnamenumber').attr('value','');
            }
        });
    });


    //******** FUNCIONES ***************
    function validatrialresultsfile(){
        var file = $('#tb_trial_trltrialresultsfile').attr('value');
        if(file != ''){
            var fragmento = file.split('.');
            var extension = fragmento[1];
            if(!((extension == 'xls') || (extension == 'xlsx') || (extension == 'doc') || (extension == 'docx') || (extension == 'ppt') || (extension == 'pptx') || (extension == 'pdf') || (extension == 'zip') || (extension == 'rar'))){
                $('#tb_trial_trltrialresultsfile').attr('value','');
                jAlert('error', 'Permitted file With extension (xls - xlsx - doc - docx - ppt - pptx - pdf - zip - rar)!','Invalid File', null);
            }
        }
    }

    function validasupplementalinformationfile(){
        var file = $('#tb_trial_trlsupplementalinformationfile').attr('value');
        if(file != ''){
            var fragmento = file.split('.');
            var extension = fragmento[1];
            if(!((extension == 'xls') || (extension == 'xlsx') || (extension == 'doc') || (extension == 'docx') || (extension == 'ppt') || (extension == 'pptx') || (extension == 'pdf') || (extension == 'zip') || (extension == 'rar'))){
                $('#tb_trial_trlsupplementalinformationfile').attr('value','');
                jAlert('error', 'Permitted file With extension (xls - xlsx - doc - docx - ppt - pptx - pdf - zip - rar)!','Invalid File', null);
            }
        }
    }

    function validaweatherduringtrialfile(){
        var file = $('#tb_trial_trlweatherduringtrialfile').attr('value');
        if(file != ''){
            var fragmento = file.split('.');
            var extension = fragmento[1];
            if(!((extension == 'xls') || (extension == 'xlsx') || (extension == 'doc') || (extension == 'docx') || (extension == 'ppt') || (extension == 'pptx') || (extension == 'pdf') || (extension == 'zip') || (extension == 'rar'))){
                $('#tb_trial_trlweatherduringtrialfile').attr('value','');
                jAlert('error', 'Permitted file With extension (xls - xlsx - doc - docx - ppt - pptx - pdf - zip - rar)!','Invalid File', null);
            }
        }
    }

    function validasoiltypeconditionsduringtrialfile(){
        var file = $('#tb_trial_trlsoiltypeconditionsduringtrialfile').attr('value');
        if(file != ''){
            var fragmento = file.split('.');
            var extension = fragmento[1];
            if(!((extension == 'xls') || (extension == 'xlsx') || (extension == 'doc') || (extension == 'docx') || (extension == 'ppt') || (extension == 'pptx') || (extension == 'pdf') || (extension == 'zip') || (extension == 'rar'))){
                $('#tb_trial_trlsoiltypeconditionsduringtrialfile').attr('value','');
                jAlert('error', 'Permitted file With extension (xls - xlsx - doc - docx - ppt - pptx - pdf - zip - rar)!','Invalid File', null);
            }
        }
    }

    function limpiardatoscultivos(){
        $('#tb_trial_trlvarieties').attr('value','');
        $('#tb_trial_trlvariablesmeasured').attr('value','');
    }

    //FORMULARIO DE BUSQUEDA DE ENSAYOS

    $('#id_trialgroup_list').change(function() {
        ChangeList();
    });
    $('#id_contactperson_list').change(function() {
        ChangeList();
    });
    $('#id_country_list').change(function() {
        ChangeList();
    });
    $('#id_trialsite_list').change(function() {
        ChangeList();
    });

    $('#id_crop_list').change(function() {
        var id_crop = $('#id_crop_list').attr('value');
        $('#varieties').val("");
        $('#variablesmeasured').val("");
        $.ajax({
            type: "GET",
            url: "/tbtrial/assigncrop/",
            data:"id_crop="+id_crop,
            success: function(){}
        });
        ChangeList();
    });

    $('#Div_id_trialgroup_list_Clear').click(function() {
        $('#id_trialgroup_list').val("");
        ChangeList();
    });
    $('#Div_id_contactperson_list_Clear').click(function() {
        $('#id_contactperson_list').val("");
        ChangeList();
    });
    $('#Div_id_country_list_Clear').click(function() {
        $('#id_country_list').val("");
        ChangeList();
    });
    $('#Div_id_trialsite_list_Clear').click(function() {
        $('#id_trialsite_list').val("");
        ChangeList();
    });
    $('#Div_id_crop_list_Clear').click(function() {
        $('#id_crop_list').val("");
        $('#varieties').val("");
        $('#variablesmeasured').val("");
        $.ajax({
            type: "GET",
            url: "/tbtrial/assigncrop/",
            data:"id_crop=",
            success: function(){}
        });
        ChangeList();
    });
    $('#Div_varieties_list_Clear').click(function() {
        ResetListVarieties();
        ChangeList();
        $('#Div_varieties_list_Clear').hide();
    });
    $('#Div_variablesmeasured_list_Clear').click(function() {
        ResetListVariablesmeasured();
        ChangeList();
        $('#Div_variablesmeasured_list_Clear').hide();
    });

    $('#tbtrialfilter').click(function() {
        $('#div_loading').show();
        $('#tbtriallist').submit();
    });

    $('#tbtrialclear').click(function() {
        $('#div_loading').show();
        window.location = "/list";
    });

    $("#sowdate1").datepicker({
        dateFormat: 'dd-mm-yy'
    });
    $("#sowdate2").datepicker({
        dateFormat: 'dd-mm-yy'
    });

    $("#harvestdate1").datepicker({
        dateFormat: 'dd-mm-yy'
    });
    $("#harvestdate2").datepicker({
        dateFormat: 'dd-mm-yy'
    });

    $("#date1").datepicker({
        dateFormat: 'dd-mm-yy'
    });
    $("#date2").datepicker({
        dateFormat: 'dd-mm-yy'
    });

});

function paginar(page){
    document.tbtriallist.paginar.value = page;
    document.tbtriallist.submit();
}

function muestra_oculta(id){
    if (document.getElementById){ //se obtiene el id
        var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
        el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
    }
}
window.onload = function(){
    //AQUI SE COLOCA QUE CARGUE OCULTO
    //muestra_oculta('tbtrial_list');
    //muestra_oculta('tbtrial_map');
    }

function wopen(trial){
    window.open("/tbtrial/"+trial,"Trial","width=800,height=800,scrollbars=1")
}

function validarpagina(e,valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==13){
        paginar(valor);
    }
}

function ChangeList(){
    var ArrayFields = ["id_trialgroup","id_contactperson","id_country","id_trialsite","id_crop"];
    var ArrayFieldsInfo = ["id_trialgroup_list","id_contactperson_list","id_country_list","id_trialsite_list","id_crop_list"];
    var ArrayValuesFields = new Array();
    for (var i=0; i<ArrayFieldsInfo.length; i++)        {
        ArrayValuesFields[i] = $('#'+ArrayFieldsInfo[i]).attr('value');
        $('#Div_'+ArrayFields[i]+'_list').show();
        $('#'+ArrayFieldsInfo[i]).html("<OPTION VALUE=''>Loading...</OPTION>");
    }

    $.ajax({
        type: "GET",
        url: "/tbtrial/ReloadField/",
        data:"&ArrayFields="+ArrayFields+"&ArrayValuesFields="+ArrayValuesFields,
        dataType: 'json',
        success: function(data){
            for (var i=0; i<ArrayFieldsInfo.length; i++)        {
                Fields = ArrayFieldsInfo[i];
                $('#'+Fields).html(data[Fields]);
                $('#Div_'+Fields).hide();
                if(ArrayValuesFields[i] != '')
                    $('#Div_'+Fields+'_Clear').show();
                else
                    $('#Div_'+Fields+'_Clear').hide();
            }
        }
    });
}

function ResetListVarieties(){
    $('#varieties').val("");
    $.ajax({
        type: "GET",
        url: "/tbtrial/resetlistsvarieties/",
        success: function(){}
    });
}

function ResetListVariablesmeasured(){
    $('#variablesmeasured').val("");
    $.ajax({
        type: "GET",
        url: "/tbtrial/resetlistsvariablesmeasured/",
        success: function(){}
    });
}