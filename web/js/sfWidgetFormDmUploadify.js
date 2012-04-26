(function($){  

  __set_up_uploadify_widget = function($uploadified)
  {
    var 
        $uploadified_form = $uploadified.parents('form'),
        $field_holder = $uploadified.parent().clone().attr('id', 'a-new-and-unique-id'),
        meta_data = $uploadified.metadata({type: 'html5'}),
        link = $uploadified_form.attr('action').replace('+', '%2B');
    
    $field_holder.children().remove('input, label');
    
    $uploadified.parent().after(
      $field_holder.append(
        $('<label/>', {
          'for' :  'fileQueue',
          text  :  'Upload Queue'
        })
      ).append(
        $('<div/>', {
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
      'script'         : link,
      'cancelImg'      : dm_configuration.relative_url_root+'/dmMediaUploadifyerPlugin/images/cancel.png',
      'queueID'        : 'fileQueue',
      'simUploadLimit' : 3,
      'fileDataName'   : $uploadified.attr('name'),
      'auto'           : false,
      'multi'          : true,
      'onAllComplete'  : function(event, queueID, fileObj, response, data) {
        if ($uploadified.closest('div.ui-dialog-content').length){
          $uploadified.closest('div.ui-dialog-content').dialog('close');  
        }
        if ($('#dm_admin_content').length){
          $('#dm_admin_content').block();  
        }
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
      $uploadified.uploadifySettings('scriptData', $.extend({
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
    $.each(fields, function(i, field) {
      if ('' !== field.value) {
        result[ field.name ] = field.value;
      }
    });
    
    return result;
  };



  $(document).ready(function() {
      __set_up_uploadify_widget($('input.uploadify_file_field'));
  });   


  
})(jQuery)