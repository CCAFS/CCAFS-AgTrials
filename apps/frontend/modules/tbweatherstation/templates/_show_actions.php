<ul class="sf_admin_actions_form">
    <?php if ($sf_user->isAuthenticated()) { ?>
        <?php echo $helper->linkToList(array('params' => 'class= fg-button ui-state-default fg-button-icon-left ', 'class_suffix' => 'list', 'label' => 'Back to list', 'ui-icon' => '',)) ?>
        <?php echo $helper->linkToEdit($tbweatherstation, array('params' => 'class= fg-button ui-state-default fg-button-icon-left ', 'class_suffix' => 'edit', 'label' => 'Edit', 'ui-icon' => '',)) ?>
        <?php echo $helper->linkToDelete($form->getObject(), array('params' => 'class= fg-button ui-state-default fg-button-icon-left ', 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete', 'ui-icon' => '',)) ?>
    <?php } ?>
</ul>