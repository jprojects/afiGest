<?php
/**
 * @version     1.0.0 Afi Framework $
 * @package     Afi Framework
 * @copyright   Copyright © 2014 - All rights reserved.
 * @license	    GNU/GPL
 * @author	    kim
 * @author mail kim@afi.cat
 * @website	    http://www.afi.cat
 *
*/

defined('_Afi') or die ('restricted access');

include('includes/model.php');

class profile extends model
{
    function saveProfile()
    {

      $app  = factory::getApplication();
      $db   = factory::getDatabase();
      $user = factory::getUser();
      $lang = factory::getLanguage();

      $obj = new stdClass();
      $obj->email     = $_POST['email'];
      if($_POST['password'] != '') {
        $obj->password  = $app->encryptPassword($_POST['password']);
      }
      //$obj->language  = $_POST['language'];
      $obj->address   = $_POST['address'];
      $obj->cp        = $_POST['cp'];
      $obj->poblacio  = $_POST['poblacio'];
      $obj->bio       = $_POST['bio'];
      $obj->cargo     = $_POST['cargo'];
      $obj->apikey    = $_POST['apikey'];
      $obj->wallet    = $_POST['wallet'];
      $obj->template  = $_POST['template'];
      $obj->language  = $_POST['language'];

      $result = $db->updateRow("#_users", $obj, 'id', $user->id);

      if($result) {
          $app->setMessage( $lang->get('CW_SETTINGS_SAVE_SUCCESS'), 'success');
      } else {
          $app->setMessage( $lang->get('CW_SETTINGS_SAVE_ERROR'), 'danger');
      }
      $app->redirect($config->site.'/index.php?view=profile');
    }
}
