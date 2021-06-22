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

class groups extends model
{
    private $table  = '#_usergroups';
	private $view   = 'groups';
	private $key    = 'id';
	private $order  = 'id';
	private $dir    = 'ASC';
	private $rows   = 'SELECT COUNT(g.id) FROM `#_usergroups` AS g';
	private $sql    = 'SELECT g.* FROM `#_usergroups` AS g';
	
	public function getList()
	{
		$db  	= factory::getDatabase();
		$user 	= factory::getUser();
		$app    = factory::getApplication();
		$config = factory::getConfig();
		$session = factory::getSession();

		$page  = $app->getVar('page', 1, 'get');

		$no_of_records_per_page = $config->pagination;
		if($no_of_records_per_page == '*') $no_of_records_per_page = 100000;

		unset($_GET['page'], $_GET['view']);

        $offset = ($page-1) * $no_of_records_per_page;


		//get all url vars from filters
		$i = 0;
		$filters = '';
		foreach($_GET as $k => $v) {
			$k = explode('_', $k, 3);
			if($v != '') {

				if (strpos($this->sql, 'WHERE') !== false) $filters.= ' AND ';
				else $filters .= $i == 0  ? ' WHERE ' : ' AND ';

				if(strtolower($k[1]) == 'like') {
					$filters .= 'g.'.$k[2].' LIKE "%'.$v.'%"';
				}
				if(strtolower($k[1]) == 'equal') {
					$options = explode(':', $v);
					$j = 0;
					$filters .= '(';
					foreach($options as $option) {
						if($j != 0) $filters .= ' OR ';
						$filters .= 'g.'.$k[2].' = '.$options[$j];
						$j++;
					}
					$filters .= ')';
				}
				$i++;
			}
		}
		$db->query($this->rows.$filters);
		$count_rows = $db->loadResult();

        if($count_rows > 0) {

			$this->sql .= $filters;
		    $this->sql .= ' ORDER BY g.'.$this->order.' '.$this->dir.' LIMIT '.$offset.', '.$no_of_records_per_page;
			if($config->debug == 1) { echo 'getList: '.$this->sql.'\n'; }
		    $db->query($this->sql);
		}
		$_SESSION['total_pages'] = ceil($count_rows / $no_of_records_per_page);
		//echo $this->sql;
		return $db->fetchObjectList();
	}

	public function getItem()
	{
		return parent::getItem($this->table, $this->key);
	}

    public function saveGroup()
    {
        $app  	= factory::getApplication();
        $db   	= factory::getDatabase();
		$config = factory::getConfig();
        $lang 	= factory::getLanguage();

		$id = $app->getVar('id', 0);
  
        $obj = new stdClass();
        $obj->usergroup      = $app->getVar('usergroup');
		$obj->nou      		 = $app->getVar('nou',0);
		$obj->editar         = $app->getVar('editar',0);
		$obj->esborrar       = $app->getVar('esborrar',0);

		//guardem vistes
		foreach($_POST['views'] as $view) {
			$views .= $view . ",";
		}
		$views = substr($views,0,-1);
		$obj->views = $views;
  
		if($id == 0) {
        	$result = $db->insertRow("#_usergroups", $obj);
		} else {
			$result = $db->updateRow("#_usergroups", $obj, 'id', $id);
		}
  
        if($result) {
          $app->setMessage($lang->get('CW_USERS_SAVE_SUCCESS'), 'success');
        } else {
          $app->setMessage($lang->get('CW_USERS_SAVE_ERROR'), 'danger');
        }
        $app->redirect($config->site.'/index.php?view=groups');
    }

    public function removeGroup()
    {
        $app  	= factory::getApplication();
        $db   	= factory::getDatabase();
		$lang 	= factory::getLanguage();
		$config = factory::getConfig();

        $id = $app->getVar('id', 0, 'get');
  
        $result = $db->query('DELETE FROM `#_usergroups` WHERE id = '.$id);
  
        if($result) {
          $app->setMessage($lang->get('CW_GROUPS_SAVE_SUCCESS'), 'success');
        } else {
          $app->setMessage($lang->get('CW_GROUPS_SAVE_ERROR'), 'danger');
        }
        $app->redirect($config->site.'/index.php?view=groups');
    }
}
