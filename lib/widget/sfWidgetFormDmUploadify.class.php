<?php

/**
 * sfWidgetFormDmUploadify
 *
 * @package    widget
 * @subpackage DmMedia
 * @version    SVN: $Id: sfWidgetFormDmUploadify.class.php 27875 2010-02-11 01:01:34Z ornicar2 $
 * 
 * @see        sfWidgetFormInputFile
 */
class sfWidgetFormDmUploadify extends sfWidgetFormDmInputFile
{
  
  /**
   * Constructor.
   * 
   * Available options:
   * 
   *  ** Options **
   *  * upload_route:     The route of the action that will handle the upload
   *  * uploadify_css:    The css file to be used to style the Uploadify markup
   *  * add_sessionid:    Because of a bug in Flash, it does not send the proper cookie when uploading a file; 
   *                      Use this option when you apply uploadify in a secured environment
   * 
   * 
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('upload_route', null); // will default to the form upload action through jQuery traversing
    $this->addOption('uploadify_css', 'dmMediaUploadifyerPlugin.uploadify');
    
    $this->addOption('add_sessionid', false);
  }
  
  
  /**
   * We want this to gracefully degrade to a normal file field if JS is not available 
   * Therefore, everything we will create here will be done through jQuery
   * 
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $class_addition = 'uploadify_file_field';
    
    $attributes['class'] = isset($attributes['class']) ? $attributes['class'].' '.$class_addition : $class_addition;
    
    if ($this->getOption('add_sessionid'))
    {
      $attributes['data-session_id'] = "%s";
      $attributes['data-session_name'] = "%s";
    }
    
    return sprintf(parent::render($name, $value, $attributes, $errors), "'".session_id()."'", "'".session_name()."'");
  }
  
  
  /**
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    return array($this->getOption('uploadify_css'));
  }


  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavascripts()
  {
    return array(
      'dmMediaUploadifyerPlugin.swfobject',
      'dmMediaUploadifyerPlugin.uploadify',
      'dmMediaUploadifyerPlugin.sfWidget'
    );
  }  
}