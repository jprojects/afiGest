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

class users extends model
{
  private $table  = '#_users';
	private $view   = 'users';
	private $key    = 'id';
	private $order  = 'id';
	private $dir    = 'DESC';

    public function saveUser()
    {
        $app    = factory::getApplication();
        $db     = factory::getDatabase();
        $user   = factory::getUser();
        $lang   = factory::getLanguage();
        $config = factory::getConfig();

        $id = $app->getVar('id', 0);
  
        $obj = new stdClass();
        $obj->username      = $app->getVar('username');
        $obj->email         = $app->getVar('email');
        if($app->getVar('password', '') != '') {
          $obj->password    = $app->encryptPassword($app->getVar('password'));
        }
        $obj->level         = $app->getVar('usergroup');

        //guardem projectes
        if($_POST['projects'] != '*') {
          foreach($_POST['projects'] as $project) {
            $projectes .= $project . ",";
          }
          $projectes = substr($projectes,0,-1);
          $obj->projects = $projectes;
        }
  
        if($id == 0) {
          $obj->registerDate  = date('Y-m-d H:i:s');
          $obj->language      = 'en-gb';
          $obj->block         = 0;
          $obj->token         = $user->genToken($obj->email);
          $result = $db->insertRow("#_users", $obj);
        } else {
          $result = $db->updateRow("#_users", $obj, 'id', $id);
        }
  
        if($result) {
          $app->setMessage($lang->get('CW_USERS_SAVE_SUCCESS'), 'success');
        } else {
          $app->setMessage($lang->get('CW_USERS_SAVE_ERROR'), 'danger');
        }
        $app->redirect($config->site.'/index.php?view=users');
    }

    public function getItem()
	  {
		  return parent::getItem($this->table, $this->key);
	  }

    public function removeUser()
    {
        $app    = factory::getApplication();
        $db     = factory::getDatabase();
        $lang   = factory::getLanguage();
        $config = factory::getConfig();

        $id   = $app->getVar('id', 0, 'get');
  
        $result = $db->query('DELETE FROM `#_users` WHERE id = '.$id);
  
        if($result) {
          $app->setMessage($lang->get('CW_USERS_SAVE_SUCCESS'), 'success');
        } else {
          $app->setMessage($lang->get('CW_USERS_SAVE_ERROR'), 'danger');
        }
        $app->redirect($config->site.'/index.php?view=users');
    }
}
