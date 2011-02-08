<?php
/** @var dmAdminApplicationConfiguration */ $this;


$this->dispatcher->connect('dm.media_library.control_menu', array('dmMediaUploadifyerConfig', 'listenToMediaLibraryControlMenuEvent'));
$this->dispatcher->connect('controller.change_action', array('dmMediaUploadifyerConfig', 'listenToActionChangeEvent'));
 
/**
* Let's talk a bit about the next piece of code
* 
* The reason we need it is because of a bug in Flash 9+
* When Flash makes an http request, it doesn't send the active cookie when using a browser other than IE;
* This means that an authenticated user would be unable to use uploadify, which would defeat the whole 
* purpose of having it in the admin panel ;)  So we use jQuery.metadata and allow for the session_id to
* be set through POST params.
* 
* This code needs to be excuted before the storage factory is loaded, ie before context.factories_loaded event;
* In symfony, there is no event preceeding that, which means we can't use events in this case.
* This leaves us with two possible sollutions:
*   1) Write a custom storage class to execute the code before calling the initialize() method of the parent
*   2) Simply write the code in the configuration, ie here
* The latter is easier on all levels :)
* 
* This code poses no security risk (although de facto it opens the possibility for session riding,
* it uses non-standart param names and also uses the POST array, which makes the attack quite harder;
* esp given that the attacker would first have to get the contents of the symfony cookie (actually,
* of the cookie with the same name as the uploadify_session_name)) and creates no overhead;
* 
*/
if (isset($_POST['uploadify_session_id']) && $_POST['uploadify_session_id'] && isset($_POST['uploadify_session_name']) && $_POST['uploadify_session_name'])
{
  session_name($_POST['uploadify_session_name']);
  session_id($_POST['uploadify_session_id']);
}
