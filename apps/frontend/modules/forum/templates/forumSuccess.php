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
    border:1px solid #FFD90F;
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
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1><?php echo image_tag('conversation-icon.png'); ?><a href="forum">Forum</a></h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <table id="tablecss" width="80%">
                <tr>
                    <td id='campos'>Category</td>
                    <td id='campos'>Total publications</td>
                    <td id='campos'>Last publication</td>
                </tr>
                <?php foreach ($categorias AS $fila){ ?>
                    <tr>
                        <td id='tddatos'>
                            <table>
                                <tr>
                                    <td>
                                        <span><?php echo image_tag('Folder-icon.png'); ?></span>
                                    </td>
                                    <td>
                                        <span id='bold'>&ensp;<a href="theme?cat=<?php echo $fila['id_category'] ?>"><?php echo $fila['ctgname'] ?></a></span><br>
                                        <span>&ensp;<?php echo $fila['ctgdescription'] ?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td id='tddatos2'><?php echo $fila['totalpublications'] ?></td>
                        <td id='tddatos2'><?php echo $fila['lastpublications'] ?></td>
                    </tr>
                <?php } ?>
                    <tr align="center">
                        <td align="center" colspan="3">
                            <br>
                            <input type="button" value="New Category" OnClick="location.href='/newcategory'">
                        </td>
                    </tr>
            </table>
        </div>
    </div>

</div>