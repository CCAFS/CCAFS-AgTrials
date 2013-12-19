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

$id_trial = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id_trial');
$Trial = Doctrine::getTable('TbTrial')->findOneByIdTrial($id_trial);
$connection = Doctrine_Manager::getInstance()->connection();

$QUERY00 = "SELECT TC.id_trialcomments, TC.trcmcomment, (U.first_name||' '||U.last_name) AS user, TC.created_at ";
$QUERY00 .= "FROM tb_trialcomments TC INNER JOIN sf_guard_user U ON TC.id_user = U.id ";
$QUERY00 .= "WHERE TC.id_trial = $id_trial ";
$QUERY00 .= "ORDER BY TC.created_at ";
$st = $connection->execute($QUERY00);
$Resultado00 = $st->fetchAll();
?>
<script>
    $(document).ready(function() {
        $('#trialcommentssubmit').click(function() {
            var trialcomment = $('#trialcomment').attr('value');
            if(trialcomment == ''){
                jAlert('error', 'Write a comment!','Incomplete Information', null);
            }else{
                $('#div_loading').show();
                $('#trialcomments').submit();
            }
        });

    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1><?php echo "Trial Comments: {$Trial->getTrlname()}"; ?></h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <br>
            <?php 
                if(count($Resultado00) == 0)
                    echo "<span>No comments</span><br>";
                foreach ($Resultado00 AS $Resultado) {
            ?>
            <span><b><?php echo "{$Resultado['user']} - {$Resultado['created_at']}"; ?></b> - <?php echo $Resultado['trcmcomment']; ?></span><br>
            <?php } ?>
            <br>
            <?php if ($sf_user->isAuthenticated()) { ?>
                <form id="trialcomments" name="trialcomments" action="<?php echo url_for('@savetrialcomment'); ?>" enctype="multipart/form-data" method="post">
                    <table align="center">
                        <br>
                        <tr>
                            <td><b>New Comment:</b></td>
                        </tr>
                        <tr>
                            <td><textarea id="trialcomment" name="trialcomment" title="Comment" rows="2" cols="100"></textarea></td>
                        </tr>
                        <tr align="center">
                            <td align="center">
                                <input type="hidden" id="id_trial" name="id_trial" value="<?php echo $id_trial; ?>">
                                <input type="button" value="Add comment" id="trialcommentssubmit">
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