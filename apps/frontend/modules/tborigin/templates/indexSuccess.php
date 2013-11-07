<?php use_helper('I18N', 'Date') ?>
<?php include_partial('tborigin/assets') ?>
<div id="sf_admin_container">
    <div id="sf_admin_header">
        <?php include_partial('tborigin/list_header', array('pager' => $pager)) ?>
    </div>

    <div id="sf_admin_bar ui-helper-hidden" style="display:none">
        <?php include_partial('tborigin/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_actions_block floatleft">
            <div id="sf_admin_actions_menu" class="ui-helper-hidden fg-menu fg-menu-has-icons">
                <ul class="sf_admin_actions" id="sf_admin_actions_menu_list">
                    <?php include_partial('tborigin/list_actions', array('helper' => $helper)) ?>
                </ul>
            </div>
        </div>
        <?php include_partial('tborigin/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'hasFilters' => $hasFilters)) ?>
        <ul class="sf_admin_actions"><?php include_partial('tborigin/list_batch_actions', array('helper' => $helper)) ?></ul>
     </div>
    <div id="sf_admin_footer">
        <?php include_partial('tborigin/list_footer', array('pager' => $pager)) ?>
    </div>
    <?php include_partial('tborigin/themeswitcher') ?>
</div>