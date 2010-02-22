<?php

class dmMediaUploadifyerAdminActions extends dmAdminBaseActions
{
  
  /**
  * Allows the upload of multiple files 
  * 
  * @param sfWebRequest $request
  */
  public function executeNewMultipleFile(dmWebRequest $request)
  {
    // create new media

    $media = null;

    $this->forward404Unless($folder = dmDb::table('DmMediaFolder')->find($request->getParameter('folder_id')));

    if (!$folder->isWritable())
    {
      $this->getUser()->logAlert($this->getI18n()->__('Folder %1% is not writable', array('%1%' => $folder->fullPath)));
    }
    
    $form = new dmMediaUploadifyForm();
    $form->setDefault('dm_media_folder_id', $folder->id);
    
    if ($request->isMethod('post') && $form->bindAndValid($request))
    {
      $media = $form->save();                                        
      
      return $this->renderText('success');
    }

    $action = '@dm_media_uploadifyer_multiple_files?folder_id='.$folder->id;
    
    $uploadify_widget = new sfWidgetFormDmUploadify();
    
    return $this->renderAsync(array(
      'html'  => $form->render('.dm_form.list.little action="'.$action.'"'),
      'css'   => $uploadify_widget->getStylesheets(),
      'js'    => $uploadify_widget->getJavascripts()
    ));
  }
  
  public function executeUploadifyTest(dmWebRequest $request)
  {
    $out = 'test';
    
    $out = print_r($request->getPostParameters(), true);
    return $this->renderText($out);
  }
  
}