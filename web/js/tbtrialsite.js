$(document).ready(function() {
    //VALIDAMOS EL CAMPO DE LATITUDE
    $('#tb_trialsite_trstlatitude').blur(function() {
        validaLatitudeTrialSite();
    });
    //VALIDAMOS EL CAMPO DE LATITUDE DECIMAL
    $('#tb_trialsite_trstlatitudedecimal').blur(function() {
        validaLatitudeDedecimalTrialSite();
    });
    //VALIDAMOS EL CAMPO DE LONGITUDE
    $('#tb_trialsite_trstlongitude').blur(function() {
        validaLongitudeTrialSite();
    });
    //VALIDAMOS EL CAMPO DE LONGITUDE DECIMAL
    $('#tb_trialsite_trstlongitudedecimal').blur(function() {
        validaLongitudeDedecimalTrialSite();
    });

    //VALIDAMOS EL CAMPO DE ALTITUDE
    $('#tb_trialsite_trstaltitude').blur(function() {
        validaAltitudeTrialSite();
    });

    //VALIDAMOS EL CAMPO DE ALTITUDE
    $('#tb_trialsite_trstph').blur(function() {
        validaPhTrialSite();
    });
    
    $("#tb_trialsite_trstfileaccess_Open_to_all_users").click(function(){
        $("#tbtrialsite_users").css("display", "none");
    });

    $("#tb_trialsite_trstfileaccess_Open_to_specified_users").click(function(){
        $("#tbtrialsite_users").css("display", "block");
    });

    //******** FUNCIONES ***************
    //VALIDAMOS LA LATITUDE
    function validaLatitudeTrialSite(){
        var latitude = '';
        var latitudedecimal = 0;
        var degree = '';
        var minutes  = '';
        var seconds  = '';
        var cardinal  = '';
        var error  = '';
        latitude = $('#tb_trialsite_trstlatitude').attr('value');
        if(latitude != ''){
            if((latitude.length != 7)){
                jAlert('error', 'Latitude of site. Degree (2 digits) minutes (2 digits), and seconds (2 digits) followed by N (North) or S (South) (e.g. 103020S)','Invalid Latitude', null);
                $('#tb_trialsite_trstlatitude').attr('value','');
                $('#tb_trialsite_trstlatitudedecimal').attr('value','');
            }else{
                degree = latitude.substring(0,2) * 1;
                minutes = latitude.substring(2,4) * 1;
                seconds = latitude.substring(4,6) * 1;
                cardinal = latitude.substring(6,7);

                if((0 > degree) || (degree > 90) || (isNaN(degree))){
                    error += "* Range of degrees (00 - 90) \n";
                }
                if((0 > minutes) || (minutes > 59) || (isNaN(minutes))){
                    error += "* Range of minutes (00 - 59) \n";
                }
                if((0 > seconds) || (seconds > 59) || (isNaN(seconds))){
                    error += "* Range of seconds (00 - 59) \n";
                }
                if((cardinal != 'N') && (cardinal != 'S') && (cardinal != 'n') && (cardinal != 's')){
                    error += "* Cardinal points values (N - S) \n";
                }

                if(error != ''){
                    jAlert('error', error ,'Invalid Latitude', null);
                    $('#tb_trialsite_trstlatitude').attr('value','');
                    $('#tb_trialsite_trstlatitudedecimal').attr('value','');
                }else{
                    var temp = 0;
                    latitudedecimal = 0;
                    temp = seconds / 60;
                    temp = minutes+temp * 1;
                    temp = temp / 60;
                    latitudedecimal = degree + temp;
                    latitudedecimal = Math.round(latitudedecimal*1000)/1000;
                    if((cardinal == 'S') || (cardinal == 's')){
                        latitudedecimal = latitudedecimal * -1;
                    }
                    $('#tb_trialsite_trstlatitudedecimal').attr('value',latitudedecimal);
                }
            }
        }else{
            $('#tb_trialsite_trstlatitude').attr('value','');
            $('#tb_trialsite_trstlatitudedecimal').attr('value','');
        }
    }

    //VALIDAMOS LA LATITUDE DECIMAL
    function validaLatitudeDedecimalTrialSite(){
        var latitude = '';
        var latitudedecimal = 0;
        var degree = '';
        var minutes  = '';
        var seconds  = '';
        var cardinal  = 'N';
        var error  = '';
        var temp = 0;
        latitudedecimal = $('#tb_trialsite_trstlatitudedecimal').attr('value');
        if(latitudedecimal != ''){
            latitudedecimal = latitudedecimal * 1;
            if(!isNaN(latitudedecimal)){
                if(latitudedecimal < 0){
                    cardinal  = 'S';
                    latitudedecimal = latitudedecimal * -1;
                }
                degree = parseInt(latitudedecimal);
                temp = (latitudedecimal - degree);
                temp = (temp * 60);
                minutes = parseInt(temp);
                temp = (temp - minutes);
                seconds = parseInt((temp * 60));

                degree = degree+"";
                if (degree.length == 1)
                    degree = "0"+degree;
                minutes = minutes+"";
                if (minutes.length == 1)
                    minutes = "0"+minutes;
                seconds = seconds+"";
                if (seconds.length == 1)
                    seconds = "0"+seconds;

                latitude = degree+''+minutes+''+seconds+''+cardinal;
                $('#tb_trialsite_trstlatitude').attr('value',latitude);
            }else{
                jAlert('error', 'Latitude of site. Decimal degrees (e.g. -10.505556)','Invalid Latitude', null);
                $('#tb_trialsite_trstlatitude').attr('value','');
                $('#tb_trialsite_trstlatitudedecimal').attr('value','');
            }
        }else{
            $('#tb_trialsite_trstlatitude').attr('value','');
            $('#tb_trialsite_trstlatitudedecimal').attr('value','');
        }
    }

    //VALIDAMOS LA LONGITUDE
    function validaLongitudeTrialSite(){
        var longitude = '';
        var longitudedecimal = 0;
        var degree = '';
        var minutes  = '';
        var seconds  = '';
        var cardinal  = '';
        var error  = '';
        longitude = $('#tb_trialsite_trstlongitude').attr('value');
        if(longitude != ''){
            if((longitude.length != 8)){
                jAlert('error', 'Longitude of site. Degree (3 digits), minutes (2 digits), and seconds (2 digits) followed by E (East) or W (West) (e.g. 0762510W)','Invalid Longitude', null);
                $('#tb_trialsite_trstlongitude').attr('value','');
                $('#tb_trialsite_trstlongitudedecimal').attr('value','');
            }else{
                degree = longitude.substring(0,3) * 1;
                minutes = longitude.substring(3,5) * 1;
                seconds = longitude.substring(5,7) * 1;
                cardinal = longitude.substring(7,9);
                if((0 > degree) || (degree > 180) || (isNaN(degree))){
                    error += "* Range of degrees (000 - 180) \n";
                }
                if((0 > minutes) || (minutes > 59) || (isNaN(minutes))){
                    error += "* Range of minutes (00 - 59) \n";
                }
                if((0 > seconds) || (seconds > 59) || (isNaN(seconds))){
                    error += "* Range of seconds (00 - 59) \n";
                }
                if((cardinal != 'E') && (cardinal != 'W') && (cardinal != 'e') && (cardinal != 'w')){
                    error += "* Cardinal points values (E - W) \n";
                }

                if(error != ''){
                    jAlert('error', error,'Invalid Longitude', null);
                    $('#tb_trialsite_trstlongitude').attr('value','');
                    $('#tb_trialsite_trstlongitudedecimal').attr('value','');
                }else{
                    var temp = 0;
                    longitudedecimal = 0;
                    temp = seconds / 60;
                    temp = minutes+temp * 1;
                    temp = temp / 60;
                    longitudedecimal = degree + temp;
                    longitudedecimal = Math.round(longitudedecimal*1000)/1000;
                    if((cardinal == 'W') || (cardinal == 'W')){
                        longitudedecimal = longitudedecimal * -1;
                    }
                    $('#tb_trialsite_trstlongitudedecimal').attr('value',longitudedecimal);
                }
            }
        }else{
            $('#tb_trialsite_trstlongitude').attr('value','');
            $('#tb_trialsite_trstlongitudedecimal').attr('value','');
        }
    }

    //VALIDAMOS LA LONGITUDE DECIMAL
    function validaLongitudeDedecimalTrialSite(){
        var longitude = '';
        var longitudedecimal = 0;
        var degree = '';
        var minutes  = '';
        var seconds  = '';
        var cardinal  = 'E';
        var error  = '';
        var temp = 0;

        longitudedecimal = $('#tb_trialsite_trstlongitudedecimal').attr('value');
        if(longitudedecimal != ''){
            longitudedecimal = longitudedecimal * 1;
            if(!isNaN(longitudedecimal)){
                if(longitudedecimal < 0){
                    cardinal  = 'W';
                    longitudedecimal = longitudedecimal * -1;
                }
                degree = parseInt(longitudedecimal);
                temp = (longitudedecimal - degree);
                temp = (temp * 60);
                minutes = parseInt(temp);
                temp = (temp - minutes);
                seconds = parseInt((temp * 60));

                degree = degree+"";
                if (degree.length == 1)
                    degree = "00"+degree;
                if (degree.length == 2)
                    degree = "0"+degree;
                minutes = minutes+"";
                if (minutes.length == 1)
                    minutes = "0"+minutes;
                seconds = seconds+"";
                if (seconds.length == 1)
                    seconds = "0"+seconds;

                longitude = degree+''+minutes+''+seconds+''+cardinal;
                $('#tb_trialsite_trstlongitude').attr('value',longitude);
            }else{
                jAlert('error', 'Longitude of site. Decimal degrees (e.g. 76.419444)','Invalid Longitude', null);
                $('#tb_trialsite_trstlongitude').attr('value','');
                $('#tb_trialsite_trstlongitudedecimal').attr('value','');
            }
        }else{
            $('#tb_trialsite_trstlongitude').attr('value','');
            $('#tb_trialsite_trstlongitudedecimal').attr('value','');
        }
    }

    //VALIDAMOS LA ALTITUDE
    function validaAltitudeTrialSite(){
        var altitude = $('#tb_trialsite_trstaltitude').attr('value');
        if(altitude != ''){
            altitude = altitude * 1;
            if(isNaN(altitude)){
                jAlert('error', 'Elevation of site expressed in meters above sea level. Negative values are allowed (e.g. -1500)','Invalid Altitude', null);
                $('#tb_trialsite_trstaltitude').attr('value','');
            }
        }
    }

    //VALIDAMOS LA ALTITUDE
    function validaPhTrialSite(){
        var ph = $('#tb_trialsite_trstph').attr('value');
        if(ph != ''){
            ph = ph * 1;
            if(isNaN(ph)){
                $('#tb_trialsite_trstph').attr('value','');
                jAlert('error', 'The value must be numeric ranging with 1 and 14','Invalid Ph', null);
            }else{
                if((1 > ph) || (ph > 14)){
                    $('#tb_trialsite_trstph').attr('value','');
                    jAlert('error', 'Range is between 1 and 14 nornally','Invalid Ph', null);                    
                }
            }
        }
    }
});