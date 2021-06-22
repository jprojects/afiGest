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

class home extends model
{
	function getProjectsAffected() {

		$db   = factory::getDatabase();
		$user = factory::getUser();
		$app  = factory::getApplication();

		$u    = $app->getVar('u', $user->id, 'get');
		$groups = $user->getGroups($user->level);

		$sql = 'SELECT DISTINCT(p.projecte_id), p.nom, p.slack_channel FROM `#_projectes` p INNER JOIN `#_incidencies` i ON i.projecteId = p.projecte_id WHERE i.estat < 3 AND i.usuari = '.$u;
		
		//si te projectes assignats només ha de veure aquests
		if($user->projects != '' && $user->projects != '*') {
			$sql .= ' AND (p.projecte_id IN ('.$db->quote($user->projects).'))';
		}

		// if($user->level != 1) {
		// 	$sql .= ' AND (i.usergroup IN ('.implode(',',$groups).'))';
		// }

		$db->query($sql);
		if($config->debug == 1 || $app->getVar('debug', 0) == 1) { echo 'getProjectsAffected: '.$sql; }

		return $db->fetchObjectList();
	}

	/*
	 * Metode per registrar entrades i sortides de treballadors
	*/
	function registrar() {

		$db   = factory::getDatabase();
		$user = factory::getUser();
		$app  = factory::getApplication();

		$type = $app->getVar('type', 0, 'get');

		//si no es va registrar sortida insertar-la abans
		$db->query('SELECT DATE_ADD(registre, INTERVAL 6 HOUR) AS data, type FROM `#_hores` WHERE userid = '.$user->id.' ORDER BY id DESC LIMIT 1');
		$row = $db->fetchObject();
		if($row->type == 1 && $type == 1) { //es entrada i l'ultim no es sortida procedim a inventar una sortida
			$hora = new stdClass();
			$hora->userid = $user->id;
			$hora->registre = $row->data;
			$hora->type = 0;

			$result = $db->insertRow('#_hores', $hora);
		}

		$hora = new stdClass();
		$hora->userid = $user->id;
		$hora->registre = date('Y-m-d H:i:s');
		$hora->type = $type;

		$result = $db->insertRow('#_hores', $hora);

		if($result) {
			$type = 'success';
			$msg  = 'Registre guardat';
			$link = $config->site.'/index.php?view=home&layout=dashboard';
		} else {
			$link = $config->site.'/index.php?view=home&layout=dashboard';
			$type = 'danger';
			$msg  = "Error al guardar el registre.";
		}

		$app->setMessage($msg, $type);
		$app->redirect($link);
	}

	/*
	 * Metode que l'api de notificacions fa servir per marcar com llegits els missatges pendents
	*/
	function readMessages() {

		$db = factory::getDatabase();
		$user = factory::getUser();
		$app = factory::getApplication();

		$id = $app->getVar('id', 0, 'get');

		$sql = 'UPDATE `#_messages` SET estat = 1 WHERE estat = 0';
		if($id > 0) { $sql .= ' AND id = '.$id; }
		$db->query($sql);
		if($config->debug == 1) { echo 'readMessages: '.$sql.'\n'; }
	}

	/*
	 * Metode que l'api de notificacions fa servir per dir-te quans missatges pendents tens
	*/
	function checkMessages() {

		$db = factory::getDatabase();
		$user = factory::getUser();

		$sql = 'SELECT COUNT(id) FROM `#_messages` WHERE estat = 0';
		$db->query($sql);

		echo $db->loadResult();
	}

	function countOpenIssues($project) {

		$db   = factory::getDatabase();
		$user = factory::getUser();

		$app  = factory::getApplication();

		$u    = $app->getVar('u', $user->id, 'get');


		$sql = 'SELECT COUNT(incidencia_id) FROM `#_incidencies` WHERE estat < 3 AND projecteId = '.$project.' AND usuari = '.$u;
		$db->query($sql);
		if($config->debug == 1) { echo 'countOpenIssues: '.$sql.'\n'; }

		return $db->loadResult();
	}

	function getDataLimit($project) {

		$db = factory::getDatabase();
		$user = factory::getUser();

		$app  = factory::getApplication();

		$u    = $app->getVar('u', $user->id, 'get');

		$sql = "SELECT MIN(data_limit) FROM `#_incidencies` WHERE estat < 3 AND data_limit IS NOT NULL  AND data_limit!='0000-00-00' AND projecteId = ".$project.' AND usuari = '.$u;
		if($config->debug == 1) { echo 'getDataLimit: '.$sql.'\n'; }
		$db->query($sql);

		return $db->loadResult();
	}

	function getTotalTempsRestant($project) {
		$db = factory::getDatabase();
		$user = factory::getUser();

		$app  = factory::getApplication();

		$u    = $app->getVar('u', $user->id, 'get');

		$sql = "SELECT SUM(COALESCE(temps_previst)-COALESCE(temps_invertit)) FROM `#_incidencies` WHERE estat < 3 AND projecteId = ".$project.' AND usuari = '.$u;
		$db->query($sql);
		if($config->debug == 1) { echo 'getTotalTempsRestant: '.$sql.'\n'; }

		return $db->loadResult();
	}

	function isPanic($project) {

		$db = factory::getDatabase();
		$user = factory::getUser();

		$sql = 'SELECT COUNT(incidencia_id) FROM `#_incidencies` WHERE prioritat = 3 AND estat = 1 AND projecteId = '.$project.' AND usuari = '.$user->id;
		if($config->debug == 1) { echo 'isPanic: '.$sql.'\n'; }
		$db->query($sql);

		if($db->loadResult() > 0) { return true; }

		return false;
	}

	function randomQuote()
	{
		$file= CWPATH_BASE.DS."quotes.txt";
		$quotes = file($file);
		srand((double)microtime()*1000000);
		$randomquote = rand(0, count($quotes)-1);
		return $quotes[$randomquote];
	}
}
