<?php use_helper('Thickbox');?>
<ul class="sf_admin_actions_form">
<?php if ($form->isNew()): ?>
  <?php echo $helper->linkToDelete($form->getObject(), array(  'params' => 'class= fg-button ui-state-default fg-button-icon-left ',  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',  'ui-icon' => '',)) ?>
  <?php echo $helper->linkToList(array(  'params' => 'class= fg-button ui-state-default fg-button-icon-left ',  'class_suffix' => 'list',  'label' => 'Back to list',  'ui-icon' => '',)) ?>
  <?php echo $helper->linkToSave($form->getObject(), array(  'params' => 'class= fg-button ui-state-default fg-button-icon-left ',  'class_suffix' => 'save',  'label' => 'Save',  'ui-icon' => '',)) ?>
  <?php echo $helper->linkToSaveAndAdd($form->getObject(), array(  'params' => 'class= fg-button ui-state-default fg-button-icon-left ',  'class_suffix' => 'save_and_add',  'label' => 'Save and add',  'ui-icon' => '',)) ?>
  <a href="/batchuploadvariety?pop=1&amp;KeepThis=true&amp;TB_iframe=true&amp;width=800&amp;height=500" class="thickbox fg-button-mini fg-button ui-state-default fg-button-icon-left"><img src="/images/upload-file-icon.png">Batch upload</a>

<?php else: ?>
  <?php echo $helper->linkToDelete($form->getObject(), array(  'params' => 'class= fg-button ui-state-default fg-button-icon-left ',  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',  'ui-icon' => '',)) ?>
  <?php echo $helper->linkToList(array(  'params' => 'class= fg-button ui-state-default fg-button-icon-left ',  'class_suffix' => 'list',  'label' => 'Back to list',  'ui-icon' => '',)) ?>
  <?php echo $helper->linkToSave($form->getObject(), array(  'params' => 'class= fg-button ui-state-default fg-button-icon-left ',  'class_suffix' => 'save',  'label' => 'Save',  'ui-icon' => '',)) ?>
  <?php echo $helper->linkToSaveAndAdd($form->getObject(), array(  'params' => 'class= fg-button ui-state-default fg-button-icon-left ',  'class_suffix' => 'save_and_add',  'label' => 'Save and add',  'ui-icon' => '',)) ?>
  <a href="/batchuploadvariety?pop=1&amp;KeepThis=true&amp;TB_iframe=true&amp;width=800&amp;height=500" class="thickbox fg-button-mini fg-button ui-state-default fg-button-icon-left"><img src="/images/upload-file-icon.png">Batch upload</a>
<?php endif; ?>
</ul>