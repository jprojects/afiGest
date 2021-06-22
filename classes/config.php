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

defined('_Afi') or die('restricted access');

class Configuration {

	public $site        = 'https://afigest.aficat.com';
	public $offline     = 0;
	public $log         = '/var/www/vhosts/aficat.com/afigest/logs/afigest.log';
	public $sitename    = 'afiGest';
	public $description = 'Gestió de tasques de desenvolupament de software';
	public $email       = 'kim@afi.cat';
	public $debug       = 0;
	public $driver      = 'mysqli';
	public $host        = 'localhost';
	public $user        = 'afigest_usr';
	public $pass        = 'q9Sip5*3';
	public $database    = 'afigest';
	public $dbprefix    = 'afi_';
	public $token_time  = 300;
	public $template    = 'nova';
	public $cookie      = 30;
	public $admin_mails = 1;
	public $inactive    = 1000;
	public $login_redirect = '/index.php?view=home&layout=dashboard';
	public $show_register = 0;
	public $pagination  = 20;
}
