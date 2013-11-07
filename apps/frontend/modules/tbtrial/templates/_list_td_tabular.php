<td class="sf_admin_text sf_admin_list_td_id_trial">
  <?php echo link_to($tbtrial->getIdTrial(), 'tbtrial_edit', $tbtrial) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_contactperson">
  <?php echo get_partial('tbtrial/contactperson', array('type' => 'list', 'tbtrial' => $tbtrial)) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_trialgroup">
  <?php echo get_partial('tbtrial/trialgroup', array('type' => 'list', 'tbtrial' => $tbtrial)) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_country">
  <?php echo get_partial('tbtrial/country', array('type' => 'list', 'tbtrial' => $tbtrial)) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_trialsite">
  <?php echo get_partial('tbtrial/trialsite', array('type' => 'list', 'tbtrial' => $tbtrial)) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_crop">
  <?php echo get_partial('tbtrial/crop', array('type' => 'list', 'tbtrial' => $tbtrial)) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_trlvarieties">
  <?php echo $tbtrial->getTrlvarieties() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_trlname">
  <?php echo $tbtrial->getTrlname() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_trlvariablesmeasured">
  <?php echo $tbtrial->getTrlvariablesmeasured() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_trltrialresultsfileaccess">
  <?php echo $tbtrial->getTrltrialresultsfileaccess() ?>
</td>