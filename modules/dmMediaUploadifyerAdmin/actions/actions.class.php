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

    // Retrived the folder by folder_id or by object in case of usage in dmMedia/gallery module
    if ( $request->hasParameter('folder_id') )
    {
      $folderId = $request->getParameter('folder_id');
    }
    else 
    {
      $objectModel = $request->getParameter('model');
      $objectPk = $request->getParameter('pk');
      $object = dmDb::table($objectModel)->find($objectPk);
      $folderId = $object->getDmMediaFolder()->getId();
    }
    $this->forward404Unless($folder = dmDb::table('DmMediaFolder')->find($folderId));
    if (!$folder->isWritable())
    {
      $this->getUser()->logAlert($this->getI18n()->__('Folder %1% is not writable', array('%1%' => $folder->fullPath)));
    }
    
    $form = new dmMediaUploadifyForm();
    $form->setDefault('dm_media_folder_id', $folder->id);
    
    if ($request->isMethod('post') && $form->bindAndValid($request))
    {
      $media = $form->save();                                        
      if (isset($object)){
        $object->addMedia($media); // In dmMedia/gallery usage, we also need to associate with the object
      }
      return $this->renderText('success');
    }
    $action = '+/dmMediaUploadifyerAdmin/newMultipleFile?'.( isset($object) ? "&model=$objectModel&pk=$objectPk" : 'folder_id='.$folder->id);
    
    return $this->renderAsync(array(
      'html'  => $form->render('.dm_form.list.little action="'.$action.'"'),
      'css'   => $form->getStylesheets(),
      'js'    => $form->getJavascripts()
    ));
  }
  
  public function executeUploadifyTest(dmWebRequest $request)
  {
    $out = 'test';
    
    $out = print_r($request->getPostParameters(), true);
    return $this->renderText($out);
  }
  
}