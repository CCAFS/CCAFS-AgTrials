<?php

function connectionblog() {
    $servidor = '172.22.52.15';
    $usuario = 'application';
    $password = 'application';
    $basedatos = 'trialsitesblog';
    if (!($link = mysql_connect($servidor, $usuario, $password))) {
        exit();
    }
    if (!(mysql_select_db($basedatos, $link))) {
        exit();
    }
    return $link;
}

function wp_username_exists($username) {
    $conexion = connectionblog();
    $user_id = null;
    $Result = mysql_query("SELECT * FROM wp_users WHERE user_login = '$username'");
    if (mysql_num_rows($Result) != 0) {
        while ($row = mysql_fetch_array($Result)) {
            $user_id = $row["ID"];
        }
    }
    return $user_id;
    mysql_close($conexion);
}

function wp_create_user($username, $password, $email, $firstname, $lastname) {
    $conexion = connectionblog();
    $user_registered = date("Y-m-d") . " " . date("H:i:s");
    $user_pass = crypt($password);
    $display_name = $firstname . " " . $lastname;
    $INSERT00 = "INSERT INTO wp_users(user_login,user_pass,user_nicename,user_email,user_registered,display_name) ";
    $INSERT00 .= "VALUES('$username','$user_pass','$username','$email','$user_registered','$display_name');";
    mysql_query($INSERT00);
    $user_id = mysql_insert_id();
    $INSERT01 = "INSERT INTO wp_usermeta(user_id,meta_key,meta_value) VALUES";
    $INSERT01 .= "($user_id,'first_name','$firstname'), ";
    $INSERT01 .= "($user_id,'last_name','$lastname'), ";
    $INSERT01 .= "($user_id,'nickname','$username'), ";
    $INSERT01 .= "($user_id,'description',null), ";
    $INSERT01 .= "($user_id,'rich_editing','true'), ";
    $INSERT01 .= "($user_id,'comment_shortcuts','false'), ";
    $INSERT01 .= "($user_id,'admin_color','fresh'), ";
    $INSERT01 .= "($user_id,'use_ssl','0'), ";
    $INSERT01 .= "($user_id,'show_admin_bar_front','true'), ";
    $INSERT01 .= "($user_id,'wp_capabilities','a:1:{s:6:\"author\";s:1:\"1\";}'), ";
    $INSERT01 .= "($user_id,'wp_user_level','2'), ";
    $INSERT01 .= "($user_id,'dismissed_wp_pointers','wp330_toolbar,wp330_media_uploader,wp330_saving_widgets,wp340_choose_image_from_library,wp340_customize_current_theme_link'), ";
    $INSERT01 .= "($user_id,'wp_dashboard_quick_press_last_post_id','14'); ";
    mysql_query($INSERT01);
    mysql_close($conexion);
}

function wp_update_password($user_id, $password) {
    $conexion = connectionblog();
    $user_pass = crypt($password);
    $UPDATE = "UPDATE wp_users SET user_pass = '$user_pass' WHERE id = $user_id";
    mysql_query($UPDATE);
    mysql_close($conexion);
}

?>