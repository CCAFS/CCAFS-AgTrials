<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * (c) Jonathan H. Wage <jonwage@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormDoctrineChoice represents a choice widget for a model.
 *
 * @package    symfony
 * @subpackage doctrine
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: sfWidgetFormDoctrineChoice.class.php 29679 2010-05-30 14:46:03Z Kris.Wallsmith $
 */
class sfWidgetFormnuevo extends sfWidgetFormInput
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('url');
    $this->addRequiredOption('icon');
    $this->addOption('txt_nombre', "");
    $this->addRequiredOption('id_txt');
    parent::configure($options, $attributes);
  }
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $html = parent::render($name, $value, $attributes, $errors);
    $img = image_tag($this->getOption('icon'));
    /*
    $link = link_to($img, 'javascript://', array(
      'onclick' => _popup_javascript_function(array(
        'popupWindow', 'status=no, location=yes, resizable=no, width=610, height=400'
      ), 'http://www.google.com')
    ));*/
    $link = link_to($img, $this->getOption('url'), array(
      'popup' => array('popupWindow', 'location=no,width=700,height=600,left=300,top=0, resizable=no, scrollbars=yes, menubar=no')));

    $input = new sfWidgetFormInput();
    return $html.$link."&nbsp;&nbsp;&nbsp;&nbsp;".$input->render($this->getOption('id_txt'),$this->getOption("txt_nombre"),array('class' => 'nombrelargo', 'readonly' => 'readonly'));
  }
}