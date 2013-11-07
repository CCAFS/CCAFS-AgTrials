<?php

/**
 * @package    symfony.plugins
 * @subpackage mqThickboxPlugin
 * @author     Mark Quezada <mark (at) mirthlab.com>
 * @version    SVN: $Id$
 */

pake_desc('Creates the proper symlinks for mqThickboxPlugin');
pake_task('mqThickbox-install', 'project_exists');


function run_mqThickbox_install($task, $args)
{
  $plugin = 'mqThickboxPlugin';
  $link   = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.$plugin;
  $target   = '..'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.$plugin.DIRECTORY_SEPARATOR.'web';
  
  if (symlink($target, $link))
  {
    pake_echo_action($plugin,'Plugin installed, symlink made from '. $target.' to '.$link.'.');
  }
}

