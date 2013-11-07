<td style="white-space: nowrap;">
    <ul class="sf_admin_td_actions fg-buttonset fg-buttonset-single">
        <?php echo $helper->linkToEdit($tbvariety, array('params' => 'class=fg-button-mini fg-button ui-state-default fg-button-icon-left ', 'class_suffix' => 'edit', 'label' => 'Edit', 'ui-icon' => '',)) ?>
        <?php echo $helper->linkToShow($tbvariety, array('params' => 'class=fg-button-mini fg-button ui-state-default fg-button-icon-left ', 'class_suffix' => 'show', 'label' => 'Show', 'ui-icon' => '',)) ?>
        <?php echo $helper->linkToDelete($tbvariety, array('params' => 'class=fg-button-mini fg-button ui-state-default fg-button-icon-left ', 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete', 'ui-icon' => '',)) ?>

    </ul>
</td>
