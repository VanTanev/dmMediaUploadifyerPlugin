<?php

/**
 * PluginDmMedia form.
 *
 * @package    form
 * @subpackage DmMedia
 * @version    SVN: $Id: dmMediaUploadifyForm.class.php 27543 2010-02-04 08:28:51Z Crafty_Shadow $
 */
class dmMediaUploadifyForm extends PluginDmMediaForm
{
  public function configure()
  {
    $this->widgetSchema['file'] = new sfWidgetFormDmUploadify(array('add_sessionid' => true));
  }
}