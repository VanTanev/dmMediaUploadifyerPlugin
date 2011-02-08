// Update the add button of the gallery widget to allow multiple upload
(function($) {  

  var $gallery = $("div.dm_gallery_big");
  var $metadata = $gallery.metadata();
  
  // Replace the current click handler by a new one
  $gallery.find('a.open_form').unbind('click')
  .click(function(){
    
    // Construct the url based on the standard form url, but changing the module/action
    var url = $gallery.find('form.dm_add_media').attr('action').match(/(.*)\+\/dmMedia.*/);
    url = url[1]+'+/dmMediaUploadifyerAdmin/newMultipleFile?model='+$metadata.model+'&pk='+$metadata.pk;
    
    // Open the dialog
    var $dialog = $.dm.ctrl.ajaxDialog({
      modal:  true,
      title:  $(this).html(),
      url: url,    
      width:  500
    }).bind('dmAjaxResponse', function(){
      $dialog.prepare();
    });
    
  });
 
})(jQuery);