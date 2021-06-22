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

class hores extends model
{
	private $table  = '#_hores';
	private $view   = 'hores';
	private $key    = 'id';
	private $order  = 'id';
	private $dir    = 'DESC';
	private $rows   = 'SELECT COUNT(h.id) FROM `#_hores` AS h';
	private $sql    = 'SELECT h.*, u.username FROM `#_hores` AS h INNER JOIN `#_users` AS u ON h.userid = u.id';
	
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
					$filters .= 'i.'.$k[2].' LIKE "%'.$v.'%"';
				}
				if(strtolower($k[1]) == 'equal') {
					$options = explode(':', $v);
					$j = 0;
					$filters .= '(';
					foreach($options as $option) {
						if($j != 0) $filters .= ' OR ';
						$filters .= 'i.'.$k[2].' = '.$options[$j];
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
		    $this->sql .= ' ORDER BY h.'.$this->order.' '.$this->dir.' LIMIT '.$offset.', '.$no_of_records_per_page;
			if($config->debug == 1) { echo 'getList: '.$this->sql.'\n'; }
		    $db->query($this->sql);
		}
		$_SESSION['total_pages'] = ceil($count_rows / $no_of_records_per_page);
		//echo $this->sql;
		return $db->fetchObjectList();
	}
}
