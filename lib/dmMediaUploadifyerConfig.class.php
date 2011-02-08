<?php

class dmMediaUploadifyerConfig
{
  public static function listenToMediaLibraryControlMenuEvent(sfEvent $event)
  {
    /** @var dmMediaLibraryControlMenu */
    $media_library_menu = $event->getSubject();
    
    $media_library_menu->addChild(
      $media_library_menu->getI18n()->__('Add multiple files'),
      $media_library_menu->getHelper()->link('+/dmMediaUploadifyerAdmin/newMultipleFile?folder_id='.$event['folder']->id)
        ->set('.new_multiple_file.uploadify_dialog_me.s16.s16_file_add')
    )->end();
    
    dmContext::getInstance()->getResponse()->addJavascript('dmMediaUploadifyerPlugin.adminCtrl');
  }

  /**
   * Used to insert a JS hack to replace the dmMedia/gallery add button by the uplodifier dialog
   * @param sfEvent $event
   */
  public static function listenToActionChangeEvent(sfEvent $event) {
    if ( dmContext::hasInstance() && $event['module'] == 'dmMedia' && $event['action'] == 'gallery' ){
      $context = dmContext::getInstance();
      $context->getResponse()->addStylesheet('lib.ui-dialog');
      $context->getResponse()->addJavascript('lib.ui-dialog');
      $context->getResponse()->addJavascript('dmMediaUploadifyerPlugin.galleryHack', 'last');
    }
  }
  
}

