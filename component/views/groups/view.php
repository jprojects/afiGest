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

if(!$user->getAuth() || $user->level != 1) {
    $app->setMessage('No tens suficients permisos per accedir a aquest àrea', 'error');
    $app->redirect($config->site.'/index.php?view=home&layout=dashboard');
}

$app->addScript($config->site.'/assets/js/validator.min.js');