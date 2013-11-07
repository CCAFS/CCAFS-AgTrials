<?php
$id_trial = $tbtrial->getIdTrial();
$Query = Doctrine_Query::create()
                ->select("TC.id_trial as trial")
                ->from("TbTrialcomments TC")
                ->where("TC.id_trial = $id_trial");
$Resultado = $Query->execute();
$commentsxtrial = count($Resultado);
?>
<td style="white-space: nowrap;">
    <ul class="sf_admin_td_actions fg-buttonset fg-buttonset-single">
        <?php echo $helper->linkToEdit($tbtrial, array(  'params' => 'class=fg-button-mini fg-button ui-state-default fg-button-icon-left ',  'class_suffix' => 'edit',  'label' => 'Edit',  'ui-icon' => '',)) ?>
        <?php echo $helper->linkToShow($tbtrial, array(  'params' => 'class=fg-button-mini fg-button ui-state-default fg-button-icon-left ',  'class_suffix' => 'show',  'label' => 'Show',  'ui-icon' => '',)) ?>
        <li class="sf_admin_action_comments"><?php echo link_to(__('Comments (' . $commentsxtrial . ')', array(), 'messages'), 'tbtrial/List_Comments?id_trial='.$id_trial, 'class=fg-button-mini fg-button ui-state-default fg-button-icon-left ') ?></li>
    </ul>
</td>
