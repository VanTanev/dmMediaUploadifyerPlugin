(function($) {  

var $library = $("div.dm_media_library");   

$library.find("div.control a.uploadify_dialog_me").bind('click', function()
{
  var $dialog = $.dm.ctrl.ajaxDialog({
    modal:  true,
    title:  $(this).html(),
    url:    $(this).attr("href"),
    width:  380
  }).bind('dmAjaxResponse', function()
  {
    $dialog.prepare();
  });

  return false;
});

})(jQuery);