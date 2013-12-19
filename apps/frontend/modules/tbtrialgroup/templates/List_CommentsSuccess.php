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

$id_trialgroup = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id_trialgroup');
$Trialgroup = Doctrine::getTable('TbTrialgroup')->findOneByIdTrialgroup($id_trialgroup);
$connection = Doctrine_Manager::getInstance()->connection();

$QUERY00 = "SELECT TGC.id_trialgroupcomments, TGC.trgpcmcomment, (U.first_name||' '||U.last_name) AS user, TGC.created_at ";
$QUERY00 .= "FROM tb_trialgroupcomments TGC INNER JOIN sf_guard_user U ON TGC.id_user = U.id ";
$QUERY00 .= "WHERE TGC.id_trialgroup = $id_trialgroup ";
$QUERY00 .= "ORDER BY TGC.created_at ";
$st = $connection->execute($QUERY00);
$Resultado00 = $st->fetchAll();
?>
<script>
    $(document).ready(function() {
        $('#trialgroupcommentssubmit').click(function() {
            var trialgroupcomment = $('#trialgroupcomment').attr('value');
            if(trialgroupcomment == ''){
                jAlert('error', 'Write a comment!','Incomplete Information', null);
            }else{
                $('#div_loading').show();
                $('#trialgroupcomments').submit();
            }
        });

    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1><?php echo "Trial Group Comments: {$Trialgroup->getTrgrname()}"; ?></h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <br>
            <?php
                if(count($Resultado00) == 0)
                    echo "<span>No comments</span><br>";
                foreach ($Resultado00 AS $Resultado) {
            ?>
	            <span><b><?php echo "{$Resultado['user']} - {$Resultado['created_at']}"; ?></b> - <?php echo $Resultado['trgpcmcomment']; ?></span><br>

            <?php } ?>
            <br>
            <?php if ($sf_user->isAuthenticated()) { ?>
                <form id="trialgroupcomments" name="trialgroupcomments" action="<?php echo url_for('@savetrialgroupcomment'); ?>" enctype="multipart/form-data" method="post">
                    <table align="center">
                        <br>
                        <tr>
                            <td><b>New Comment:</b></td>
                        </tr>
                        <tr>
                            <td><textarea id="trialgroupcomment" name="trialgroupcomment" title="Comment" rows="2" cols="100"></textarea></td>
                        </tr>
                        <tr align="center">
                            <td align="center">
                                <input type="hidden" id="id_trialgroup" name="id_trialgroup" value="<?php echo $id_trialgroup; ?>">
                                <input type="button" value="Add comment" id="trialgroupcommentssubmit">
                                <input type="button" value="Done" OnClick="history.back()">
                            </td>
                        </tr>
                    </table>
                </form>
            <?php }else{ ?>
                <tr align="center">
                    <td align="center">
                        <input type="button" value="Done" OnClick="history.back()">
                    </td>
                </tr>
            <?php } ?>
        </div>
    </div>
</div>