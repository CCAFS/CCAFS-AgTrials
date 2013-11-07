$(document).ready(function() {
    
    $("#tb_weatherstation_wtstrestricted_NO").click(function(){
        $("#tb_weatherstation_userpermission").css("display", "none");
    });

    $("#tb_weatherstation_wtstrestricted_YES").click(function(){
        $("#tb_weatherstation_userpermission").css("display", "block");
    }); 
});