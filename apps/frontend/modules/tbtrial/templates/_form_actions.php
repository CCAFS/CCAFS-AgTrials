<?php use_helper('Thickbox'); ?>
<ul class="sf_admin_actions_form">
    <?php if ($form->isNew()): ?>
        <li><button class="fg-button ui-state-default fg-button-icon-left" type="submit">Save</button></li>
        <li><button class="fg-button ui-state-default fg-button-icon-left" name="_save_and_add" type="submit">Save and add</button></li>
        <li><button class="fg-button ui-state-default fg-button-icon-left" type="button" onClick="location.href = '/list'">Search</button></li>
        <li><button class="fg-button ui-state-default fg-button-icon-left" type="button" onClick="location.href = '/batchupload'">Batch upload</button></li>
        <li><button class="fg-button ui-state-default fg-button-icon-left" type="button" onClick="location.href = '/permissionstrials'">Batch permissions</button></li>
    <?php else: ?>
        <?php echo $helper->linkToDelete($form->getObject(), array('params' => 'class= fg-button fg-button-icon-left', 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete', 'ui-icon' => '',)) ?>
        <li><button class="fg-button ui-state-default fg-button-icon-left" type="button" onClick="location.href = '/tbtrial/<?php echo $tbtrial->getIdTrial(); ?>'">Show</button></li>
        <li><button class="fg-button ui-state-default fg-button-icon-left" type="button" onClick="location.href = '/tbtrial/new'">New</button></li>
        <li><button class="fg-button ui-state-default fg-button-icon-left" type="submit">Save</button></li>
        <li><button class="fg-button ui-state-default fg-button-icon-left" name="_save_and_add" type="submit">Save and add</button></li>
        <li><button class="fg-button ui-state-default fg-button-icon-left" type="button" onClick="location.href = '/list'">Search</button></li>
        <li><button class="fg-button ui-state-default fg-button-icon-left" type="button" onClick="location.href = '/batchupload'">Batch upload</button></li>
        <li><button class="fg-button ui-state-default fg-button-icon-left" type="button" onClick="location.href = '/permissionstrials'">Batch permissions</button></li>
    <?php endif; ?>
</ul>