__set_up_uploadify_widget = function($uploadified)
{
  $uploadified_form = $uploadified.parents('form');
  var meta_data = $uploadified.metadata({type: 'html5'});
  

  $field_holder = $uploadified.parent().clone().attr('id', 'a-new-and-unique-id')
  $field_holder.children().remove('input, label')
  $uploadified.parent().after(
    $field_holder.append(
      jQuery('<label/>', {
        'for' :  'fileQueue',
        text  :  'Upload Queue'
      })
    ).append(
      jQuery('<div/>', {
        id  :  'fileQueue',
        text: '',
        css: {
          'max-height': '350px',
          'overflow': 'auto',
          'width': '70%',
          'float' : 'right'
        }
      })
  ));

  $uploadified.uploadify({
    'uploader'       : dm_configuration.relative_url_root+'/dmMediaUploadifyerPlugin/swf/uploadify.swf',
    'script'         : $uploadified_form.attr('action'),
    'cancelImg'      : dm_configuration.relative_url_root+'/dmMediaUploadifyerPlugin/images/cancel.png',
    'queueID'        : 'fileQueue',
    'simUploadLimit' : 3,
    'fileDataName'   : $uploadified.attr('name'),
    'auto'           : false,
    'multi'          : true,
    'onAllComplete'  : function(event, queueID, fileObj, response, data) {
      $uploadified.closest('div.ui-dialog-content').dialog('close');
      $('#dm_admin_content').block();
      window.location.reload();
    },
    'onProgress'     : function(event, queueID, fileObj, data) {
      $uploadified_form.find(':submit,input:image').attr('value', 'Uploading files...').text('Uploading files...');
      return true;
    },
    'onError'        : function(event, queueID, fileObj, errorObj) {
      $uploadified_form.find(':submit,input:image').attr('value', 'Error uploading!').text('Error uploading!');
      return true;
    }
  });
  

  $uploadified_form.bind('submit', function(e) {
    e.preventDefault();
    
    $uploadified.uploadifySettings('scriptData', jQuery.extend({
        'uploadify_session_name' : meta_data.session_name, 
        'uploadify_session_id' : meta_data.session_id
      }, 
      __get_form_fields_as_object($uploadified_form)
    ));

    $uploadified.uploadifyUpload();
  
    return false;
  });

};


__get_form_fields_as_object = function($form) {
  fields = $form.serializeArray();
  result = {};
  jQuery.each(fields, function(i, field) {
    if ('' !== field.value) {
      result[ field.name ] = field.value;
    }
  });
  
  return result;
};


__uploadify_widget_init = function() {
  $uploadified = jQuery('input.uploadify_file_field');  
  
  $uploadified.each(function(){
    __set_up_uploadify_widget(jQuery(this));
  });
};


jQuery(document).ready(function() {
  __uploadify_widget_init()
});   

