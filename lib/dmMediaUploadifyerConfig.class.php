<?php

class dmMediaUploadifyerConfig
{
  public static function listenToMediaLibraryControlMenuEvent(sfEvent $event)
  {
    /** @var dmMediaLibraryControlMenu */
    $media_library_menu = $event->getSubject();
    
    $media_library_menu->addChild(
      $media_library_menu->getI18n()->__('Add multiple files'),
      $media_library_menu->getHelper()->link('@dm_media_uploadifyer_multiple_files?folder_id='.$event['folder']->id)
        ->set('.new_multiple_file.uploadify_dialog_me.s16.s16_file_add')
    )->end();
    
    dmContext::getInstance()->getResponse()->addJavascript('dmMediaUploadifyerPlugin.adminCtrl');
  }

}

