<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_id_trial ui-state-default ui-th-column">
  <?php if ('id_trial' == $sort[0]): ?>
    <?php /*echo link_to(__('id', array(), 'messages'), '@tbtrial?sort=id_trial&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), array('class' => $sort[1]))*/ ?>
                

    <a href="<?php echo url_for('@tbtrial?sort=id_trial&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>">
      <span class="ui-icon <?php echo ($sort[1] == 'asc' ? 'ui-icon-circle-triangle-s' : 'ui-icon-circle-triangle-n') ?>"></span>
      <?php echo __('id', array(), 'messages') ?>
    </a>

    <?php //echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php /*echo link_to(__('id', array(), 'messages'), '@tbtrial?sort=id_trial&sort_type=asc')*/ ?>

    <a href="<?php echo url_for('@tbtrial?sort=id_trial&sort_type=asc') ?>">
      <span class="ui-icon ui-icon-triangle-2-n-s"></span>
      <?php echo __('id', array(), 'messages') ?>
    </a>

  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_contactperson ui-state-default ui-th-column">
  <?php echo __('Contact person', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_trialgroup ui-state-default ui-th-column">
  <?php echo __('Trial group', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_country ui-state-default ui-th-column">
  <?php echo __('Country', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_trialsite ui-state-default ui-th-column">
  <?php echo __('Trial site', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_crop ui-state-default ui-th-column">
  <?php echo __('Trial crop', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_trlvarieties ui-state-default ui-th-column">
  <?php if ('trlvarieties' == $sort[0]): ?>
    <?php /*echo link_to(__('Variety', array(), 'messages'), '@tbtrial?sort=trlvarieties&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), array('class' => $sort[1]))*/ ?>

    <a href="<?php echo url_for('@tbtrial?sort=trlvarieties&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>">
      <span class="ui-icon <?php echo ($sort[1] == 'asc' ? 'ui-icon-circle-triangle-s' : 'ui-icon-circle-triangle-n') ?>"></span>
      <?php echo __('Variety', array(), 'messages') ?>
    </a>

    <?php //echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php /*echo link_to(__('Variety', array(), 'messages'), '@tbtrial?sort=trlvarieties&sort_type=asc')*/ ?>

    <a href="<?php echo url_for('@tbtrial?sort=trlvarieties&sort_type=asc') ?>">
      <span class="ui-icon ui-icon-triangle-2-n-s"></span>
      <?php echo __('Variety', array(), 'messages') ?>
    </a>

  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_trlname ui-state-default ui-th-column">
  <?php if ('trlname' == $sort[0]): ?>
    <?php /*echo link_to(__('Name', array(), 'messages'), '@tbtrial?sort=trlname&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), array('class' => $sort[1]))*/ ?>

    <a href="<?php echo url_for('@tbtrial?sort=trlname&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>">
      <span class="ui-icon <?php echo ($sort[1] == 'asc' ? 'ui-icon-circle-triangle-s' : 'ui-icon-circle-triangle-n') ?>"></span>
      <?php echo __('Name', array(), 'messages') ?>
    </a>

    <?php //echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php /*echo link_to(__('Name', array(), 'messages'), '@tbtrial?sort=trlname&sort_type=asc')*/ ?>

    <a href="<?php echo url_for('@tbtrial?sort=trlname&sort_type=asc') ?>">
      <span class="ui-icon ui-icon-triangle-2-n-s"></span>
      <?php echo __('Name', array(), 'messages') ?>
    </a>

  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_trlvariablesmeasured ui-state-default ui-th-column">
  <?php if ('trlvariablesmeasured' == $sort[0]): ?>
    <?php /*echo link_to(__('Variables measured', array(), 'messages'), '@tbtrial?sort=trlvariablesmeasured&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), array('class' => $sort[1]))*/ ?>

    <a href="<?php echo url_for('@tbtrial?sort=trlvariablesmeasured&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>">
      <span class="ui-icon <?php echo ($sort[1] == 'asc' ? 'ui-icon-circle-triangle-s' : 'ui-icon-circle-triangle-n') ?>"></span>
      <?php echo __('Variables measured', array(), 'messages') ?>
    </a>

    <?php //echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php /*echo link_to(__('Variables measured', array(), 'messages'), '@tbtrial?sort=trlvariablesmeasured&sort_type=asc')*/ ?>

    <a href="<?php echo url_for('@tbtrial?sort=trlvariablesmeasured&sort_type=asc') ?>">
      <span class="ui-icon ui-icon-triangle-2-n-s"></span>
      <?php echo __('Variables measured', array(), 'messages') ?>
    </a>

  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_trltrialresultsfileaccess ui-state-default ui-th-column">
  <?php if ('trltrialresultsfileaccess' == $sort[0]): ?>
    <?php /*echo link_to(__('Trial results file access', array(), 'messages'), '@tbtrial?sort=trltrialresultsfileaccess&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), array('class' => $sort[1]))*/ ?>

    <a href="<?php echo url_for('@tbtrial?sort=trltrialresultsfileaccess&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>">
      <span class="ui-icon <?php echo ($sort[1] == 'asc' ? 'ui-icon-circle-triangle-s' : 'ui-icon-circle-triangle-n') ?>"></span>
      <?php echo __('Trial results file access', array(), 'messages') ?>
    </a>

    <?php //echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php /*echo link_to(__('Trial results file access', array(), 'messages'), '@tbtrial?sort=trltrialresultsfileaccess&sort_type=asc')*/ ?>

    <a href="<?php echo url_for('@tbtrial?sort=trltrialresultsfileaccess&sort_type=asc') ?>">
      <span class="ui-icon ui-icon-triangle-2-n-s"></span>
      <?php echo __('Trial results file access', array(), 'messages') ?>
    </a>

  <?php endif; ?>
</th>
<?php end_slot(); ?>

<?php include_slot('sf_admin.current_header') ?>
