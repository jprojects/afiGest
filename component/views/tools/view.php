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

$app->addScript($config->site.'/template/nova/vendor/datatables.net/js/jquery.dataTables.js');
$app->addScript($config->site.'/template/nova/vendor/datatables.net-bs4/js/dataTables.bootstrap4.js');
$app->addScript($config->site.'/template/nova/vendor/datatables.net-responsive/js/dataTables.responsive.min.js');
$app->addScript($config->site.'/template/nova/vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');
$app->addScript($config->site.'/template/nova/js/tables-datatable.js');
$app->addStyleSheet($config->site.'/template/nova/vendor/datatables.net-bs4/css/dataTables.bootstrap4.css');
$app->addStyleSheet($config->site.'/template/nova/vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
