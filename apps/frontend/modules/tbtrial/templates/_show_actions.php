<ul class="sf_admin_actions_form">
    <li class="sf_admin_action_list"><a href="/list" class="fg-button ui-state-default fg-button-icon-left"><span class="ui-icon ui-icon-arrowreturnthick-1-w"></span>Search</a></li>
    <?php echo $helper->linkToNew(array('params' => 'class= fg-button ui-state-default fg-button-icon-left ', 'class_suffix' => 'new', 'label' => 'New', 'ui-icon' => '',)) ?>
    <?php echo $helper->linkToEdit($tbtrial, array('params' => 'class= fg-button ui-state-default fg-button-icon-left ', 'class_suffix' => 'edit', 'label' => 'Edit', 'ui-icon' => '',)) ?>
    <?php echo $helper->linkToDelete($form->getObject(), array('params' => 'class= fg-button ui-state-default fg-button-icon-left ', 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete', 'ui-icon' => '',)) ?>
</ul>