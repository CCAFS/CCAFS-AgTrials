$(document).ready(function() {

    //PASAMOS LA PRIMERA LETRA A MAYUSCULA
    //FILTER VARIETY
    $('#tb_variety_filters_vrtname').blur(function() {
        var valor = $('#tb_variety_filters_vrtname').attr('value');
        valor = valor.replace(/^(\s|\&nbsp;)*|(\s|\&nbsp;)*$/g, "");
        valor = ucfirst(valor);
        $('#tb_variety_filters_vrtname').attr('value', valor);
    });

    // VARIABLES MEASURED
    $('#tb_variablesmeasured_filters_vrmsname').blur(function() {
        var valor = $('#tb_variablesmeasured_filters_vrmsname').attr('value');
        valor = valor.replace(/^(\s|\&nbsp;)*|(\s|\&nbsp;)*$/g, "");
        valor = ucfirst(valor);
        $('#tb_variablesmeasured_filters_vrmsname').attr('value', valor);
    });

    //TRIAL GROUP
    $('#tb_trialgroup_filters_trgrname').blur(function() {
        var valor = $('#tb_trialgroup_filters_trgrname').attr('value');
        valor = valor.replace(/^(\s|\&nbsp;)*|(\s|\&nbsp;)*$/g, "");
        valor = ucfirst(valor);
        $('#tb_trialgroup_filters_trgrname').attr('value', valor);
    });

    //COUNTRY
    $('#tb_country_filters_cntname').blur(function() {
        var valor = $('#tb_country_filters_cntname').attr('value');
        valor = valor.replace(/^(\s|\&nbsp;)*|(\s|\&nbsp;)*$/g, "");
        valor = ucfirst(valor);
        $('#tb_country_filters_cntname').attr('value', valor);
    });
    $('#tb_country_filters_cntiso').blur(function() {
        var valor = $('#tb_country_filters_cntiso').attr('value');
        valor = valor.replace(/^(\s|\&nbsp;)*|(\s|\&nbsp;)*$/g, "");
        valor = ucfirst(valor);
        $('#tb_country_filters_cntiso').attr('value', valor);
    });



    //PAGINACION DE MODULOS IR A PAGINA
    $('#tb_bibliography_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_bibliography_pagination_page').attr('value');
            document.location.href = 'tbbibliography?page=' + valor;
        }
    });
    $('#tb_contactperson_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_contactperson_pagination_page').attr('value');
            document.location.href = 'tbcontactperson?page=' + valor;
        }
    });
    $('#tb_contactpersontype_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_contactpersontype_pagination_page').attr('value');
            document.location.href = 'tbcontactpersontype?page=' + valor;
        }
    });
    $('#tb_country_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_country_pagination_page').attr('value');
            document.location.href = 'tbcountry?page=' + valor;
        }
    });
    $('#tb_crop_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_crop_pagination_page').attr('value');
            document.location.href = 'tbcrop?page=' + valor;
        }
    });
    $('#tb_fieldnamenumber_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_fieldnamenumber_pagination_page').attr('value');
            document.location.href = 'tbfieldnamenumber?page=' + valor;
        }
    });
    $('#tb_institution_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_institution_pagination_page').attr('value');
            document.location.href = 'tbinstitution?page=' + valor;
        }
    });
    $('#tb_location_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_location_pagination_page').attr('value');
            document.location.href = 'tblocation?page=' + valor;
        }
    });
    $('#tb_network_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_network_pagination_page').attr('value');
            document.location.href = 'tbnetwork?page=' + valor;
        }
    });
    $('#tb_objective_pagination_page_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_objective_pagination_page').attr('value');
            document.location.href = 'tbobjective?page=' + valor;
        }
    });
    $('#tb_origin_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_origin_pagination_page').attr('value');
            document.location.href = 'tborigin?page=' + valor;
        }
    });
    $('#tb_primarydiscipline_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_primarydiscipline_pagination_page').attr('value');
            document.location.href = 'tbprimarydiscipline?page=' + valor;
        }
    });
    $('#tb_soil_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_soil_pagination_page').attr('value');
            document.location.href = 'tbsoil?page=' + valor;
        }
    });
    $('#tb_taxonomyfao_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_taxonomyfao_pagination_page').attr('value');
            document.location.href = 'tbtaxonomyfao?page=' + valor;
        }
    });
    $('#tb_traitclass_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_traitclass_pagination_page').attr('value');
            document.location.href = 'tbtraitclass?page=' + valor;
        }
    });
    $('#tb_trial_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_trial_pagination_page').attr('value');
            document.location.href = 'tbtrial?page=' + valor;
        }
    });
    $('#tb_trialenvironmenttype_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_trialenvironmenttype_pagination_page').attr('value');
            document.location.href = 'tbtrialenvironmenttype?page=' + valor;
        }
    });
    $('#tb_trialgroup_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_trialgroup_pagination_page').attr('value');
            document.location.href = 'tbtrialgroup?page=' + valor;
        }
    });
    $('#tb_trialgrouptype_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_trialgrouptype_pagination_page').attr('value');
            document.location.href = 'tbtrialgrouptype?page=' + valor;
        }
    });
    $('#tb_trialsite_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_trialsite_pagination_page').attr('value');
            document.location.href = 'tbtrialsite?page=' + valor;
        }
    });
    $('#tb_variablesmeasured_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_variablesmeasured_pagination_page').attr('value');
            document.location.href = 'tbvariablesmeasured?page=' + valor;
        }
    });
    $('#tb_variety_pagination_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#tb_variety_pagination_page').attr('value');
            document.location.href = 'tbvariety?page=' + valor;
        }
    });

    $('#sf_guard_user_page').keyup(function(e) {
        if (e.keyCode == 13) {
            var valor = $('#sf_guard_user_page').attr('value');
            document.location.href = '/guard/users?page=' + valor;
        }
    });




    //******** FUNCIONES ***************
    function ucfirst(string) {
        string = string.toLowerCase();
        return string.substring(0, 1).toUpperCase() + string.substring(1).toLowerCase();
    }


});
function openWindow(url)
{
    window.open(url, '_blank');
    window.focus();
}

function openWindowPopUp(url) {
    open(url, '', 'top=300,left=300,width=600,height=500');
}

function ValidaFecha(Fecha) {
    var Campo = Fecha.name;
    var Valor = Fecha.value;
    var LenFecha = Valor.length;
    if (LenFecha <= 4) {
        if (isNaN(Valor)) {
            Valor = Valor.substring(0, (LenFecha - 1));
            $('#' + Campo).attr('value', Valor);
        }
        LenFecha = Valor.length;
        if (LenFecha == 4) {
            $('#' + Campo).attr('value', Valor + "-");
        }
    } else if (LenFecha <= 7) {
        var Valor2 = Valor.substring(5, (LenFecha))
        if (isNaN(Valor2)) {
            Valor = Valor.substring(0, (LenFecha - 1));
            $('#' + Campo).attr('value', Valor);
        }
        if ((Valor2 >= 0) && (Valor2 <= 12)) {
            LenFecha = Valor.length;
            if (LenFecha == 7) {
                $('#' + Campo).attr('value', Valor + "-");
            }
        } else {
            Valor = Valor.substring(0, (LenFecha - 2));
            $('#' + Campo).attr('value', Valor);
        }
    } else if (LenFecha <= 10) {
        var Valor3 = Valor.substring(8, (LenFecha))
        if (isNaN(Valor3)) {
            Valor = Valor.substring(0, (LenFecha - 1))
            $('#' + Campo).attr('value', Valor);
        }
        if ((Valor3 >= 0) && (Valor3 <= 31)) {
            LenFecha = Valor.length;
        } else {
            Valor = Valor.substring(0, (LenFecha - 2));
            $('#' + Campo).attr('value', Valor);
        }
    }
}