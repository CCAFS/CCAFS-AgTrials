<?php
$id_trialgroup = $tbtrialgroup->getIdTrialgroup();
$Query = Doctrine_Query::create()
        ->select("T.id_trialgroup as trialgroup")
        ->from("TbTrial T")
        ->where("T.id_trialgroup = $id_trialgroup");
$Resultado = $Query->execute();
$trialsxtrialgroup = count($Resultado);
$Query2 = Doctrine_Query::create()
        ->select("TGC.id_trialgroup as trialgroup")
        ->from("TbTrialgroupcomments TGC")
        ->where("TGC.id_trialgroup = $id_trialgroup");
$Resultado2 = $Query2->execute();
$commentsxtrialgroup = count($Resultado2);
?>
<td width="150">
    <ul class="fg-buttonset fg-buttonset-single" style="list-style:none;">
        <li class="sf_admin_action"><a href="/tbtrialgroup/<?php echo $id_trialgroup; ?>/edit" class="fg-button-mini fg-button ui-state-default fg-button-icon-left">Edit</a></li>
        <li class="sf_admin_action"><a href="/tbtrialgroup/<?php echo $id_trialgroup; ?>" class="fg-button-mini fg-button ui-state-default fg-button-icon-left">Show</a></li>
        <li class="sf_admin_action"><?php echo link_to(__('Add trial', array(), 'messages'), 'tbtrialgroup/List_AddTrial?id_trialgroup=' . $id_trialgroup, 'class=fg-button-mini fg-button ui-state-default fg-button-icon-left ') ?></li>
        <li class="sf_admin_action"><?php echo link_to(__('Show trial (' . $trialsxtrialgroup . ')', array(), 'messages'), '@list?id_trialgroup=' . $id_trialgroup, 'class=fg-button-mini fg-button ui-state-default fg-button-icon-left ') ?></li>
        <li class="sf_admin_action"><?php echo link_to(__('Comments (' . $commentsxtrialgroup . ')', array(), 'messages'), 'tbtrialgroup/List_Comments?id_trialgroup=' . $id_trialgroup, 'class=fg-button-mini fg-button ui-state-default fg-button-icon-left ') ?></li>
    </ul>
</td>
