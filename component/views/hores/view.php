<?php

/**
 * @version     1.0.0 Afigest $
 * @package     Afigest
 * @copyright   Copyright © 2014 - All rights reserved.
 * @license	    GNU/GPL
 * @author	    kim
 * @author mail kim@aficat.com
 * @website	    http://www.aficat.com
 *
*/

defined('_Afi') or die ('restricted access');

if(!$user->getAuth() || $user->level != 1) {
    $app->setMessage('No tens suficients permisos per accedir a aquest àrea', 'error');
    $app->redirect($config->site.'/index.php?view=home&layout=dashboard');
}