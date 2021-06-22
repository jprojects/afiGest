<?php

/**
 * @version     1.0.0 Deziro $
 * @package     Deziro
 * @copyright   Copyright © 2014 - All rights reserved.
 * @license	    GNU/GPL
 * @author	    kim
 * @author mail info@dezi.ro
 * @website	    http://www.dezi.ro
 *
*/

defined('_Afi') or die ('restricted access');

if(!$user->getAuth() || $user->level != 1) {
    $app->setMessage('No tens suficients permisos per accedir a aquest àrea', 'error');
    $app->redirect($config->site.'/index.php?view=home&layout=dashboard');
}

$app->addStylesheet($config->site.'/assets/css/bootstrap-colorpicker.min.css');
$app->addScript($config->site.'/assets/js/moment.js');
$app->addScript($config->site.'/assets/js/bootstrap-datetimepicker.min.js');
$app->addScript($config->site.'/assets/js/jquery.cropit.js');
