<?php
/**
 * @version     1.0.0 Afi Framework $
 * @package     Afi Framework
 * @copyright   Copyright © 2014 - All rights reserved.
 * @license	    GNU/GPL
 * @author	    kim
 * @author mail kim@aficat.com
 * @website	    http://www.aficat.com
 *
*/

defined('_Afi') or die ('restricted access');

class model
{
  public function getItem($table, $key)
	{
		$db = factory::getDatabase();
		$app = factory::getApplication();
		$config = factory::getConfig();

		$id = $app->getVar('id', 0);

		if($id > 0) {
			$sql = "select * from $table where $key = $id";
			if($config->debug == 1) { echo 'getItem: '.$sql.'\n'; }
			$db->query($sql);

			return $db->fetchObject();
		}
  }

  public function getMobileIssuesByUser()
	{
		$db = factory::getDatabase();
		$app = factory::getApplication();

		$userid = $app->getVar('userid', 0);
    $project = $app->getVar('project', 0);

		if($userid > 0) {
      $sql = "SELECT p.nom AS project,i.incidencia_id,i.nom,i.descripcio,i.estat,i.data_incidencia,i.data_limit FROM `#_incidencies` AS i INNER JOIN `#_projectes` AS p ON p.projecte_id = i.projecteId WHERE i.usuari = $userid AND i.estat < 3";
      if($project > 0) { $sql .= " AND i.projecteId = $project"; }
      $sql .= " ORDER BY i.incidencia_id DESC";
			$db->query($sql);
      header('Content-Type: application/json');
			echo $_GET['callback'].'('.json_encode($db->fetchObjectList()).')';
		}
  }

  public function getMobileProjects()
	{
		$db = factory::getDatabase();

		$db->query("SELECT projecte_id, UPPER(nom) AS nom FROM #_projectes ORDER BY nom");
    header('Content-Type: application/json');
		echo $_GET['callback'].'('.json_encode($db->fetchObjectList()).')';
  }

  public function getMobileUsers()
	{
		$db = factory::getDatabase();

		$db->query("SELECT id,username FROM `#_users` WHERE level = 1 AND block = 0");
    header('Content-Type: application/json');
		echo $_GET['callback'].'('.json_encode($db->fetchObjectList()).')';
  }

  public function getMobileMessages()
  {
    $db = factory::getDatabase();
    $app = factory::getApplication();

    $userid = $app->getVar('userid', '');

    $db->query("SELECT * FROM `#_messages` WHERE userid = ".$db->quote($userid)." AND estatMobil = 0");

    header('Content-Type: application/json');
    echo $_GET['callback'].'('.json_encode($db->fetchObjectList()).')';
  }

  public function updateMobileMessages()
  {
    $db = factory::getDatabase();
    $app = factory::getApplication();

    $userid = $app->getVar('userid', '');

    $db->query("UPDATE `#_messages` SET estatMobil = 1 WHERE userid = ".$db->quote($userid));
  }

  public function getMobileUserLogin()
	{
		$db = factory::getDatabase();
    $app = factory::getApplication();

		$email = base64_decode($app->getVar('email', ''));
    $pass  = base64_decode($app->getVar('password', ''));

    //$db->query("SELECT password FROM `#_users` WHERE email = ".$db->quote($email)." AND block = 0");
    //$dbpass = $db->loadResult();

    //if($app->decryptPassword($pass, $dbpass)) {
      $db->query("SELECT * FROM `#_users` WHERE email = ".$db->quote($email));
      header('Content-Type: application/json');
  		echo $_GET['callback'].'('.json_encode($db->fetchObject()).')';
    //}
  }

	public static function getProjects() {
		$db  = factory::getDatabase();
		$db->query( "SELECT projecte_id, UPPER(nom) AS nom FROM `#_projectes` ORDER BY nom" );
		return $db->fetchObjectList();
	}

  public static function getCountProjects() {
		$db  = factory::getDatabase();
		$db->query( "SELECT COUNT(projecte_id) FROM `#_projectes`" );
		return $db->loadResult();
	}

  public static function getCountIssues() {
		$db  = factory::getDatabase();
		$db->query( "SELECT COUNT(incidencia_id) FROM `#_incidencies`" );
		return $db->loadResult();
	}

  public static function getCountIssuesClosed() {
		$db  = factory::getDatabase();
		$db->query( "SELECT COUNT(incidencia_id) FROM `#_incidencies` WHERE estat = 3" );
		return $db->loadResult();
	}

	public static function getUsers()
	{
		$db = factory::getDatabase();
		$db->query('select * from #_users');
		return $db->fetchObjectList();
	}

  /**
   * Method to get the username
   * @param $username string
  */
  public static function getUsername($userid)
  {
  	$db     = factory::getDatabase();

  	$db->query('select username from #_users WHERE id = '.$userid);
      return $db->loadResult();
  }

  function configParam($field)
  {
  	$db = factory::getDatabase();

      $db->query("SELECT $field FROM #_configuration");

      return $db->loadResult();
  }

  function isAdmin() {

  	$user = factory::getUser();

  	if($user->level == 1) { return true; }

  	return false;
  }

  /**
   * Method to secure the wishlist
  */
  public static function tokenCheck()
  {
      $db     = factory::getDatabase();

      //exit if its the token owner...
      $db->query('select token from #_users WHERE username = '.$_GET['username']);
      $token = $db->loadResult();
      if($token != $_GET['token']) {
          return false;
      }

      return true;
  }

  function timeElapsed($datetime, $full = false)
	{
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
		    'y' => 'any',
		    'm' => 'mes',
		    'w' => 'setmana',
		    'd' => 'dia',
		    'h' => 'hora',
		    'i' => 'minut',
		    's' => 'segon',
		);
		foreach ($string as $k => &$v) {
		    if ($diff->$k) {
		        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		    } else {
		        unset($string[$k]);
		    }
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? 'fa '.implode(', ', $string) : 'just ara';
	}

    /**
     * Send email to the user
     * @param $mail string the user email
     * @param $name string the username
     * @param $subject string the mail subject
     * @param $body string the mail body
     * @return boolean true if success false if not
    */
    public static function sendMail($email, $name, $subject, $body)
    {
        if($email == '') { return; }
        $mail   = factory::getMailer();
        $config = factory::getConfig();

        @ob_start();
        include 'assets/mail/mail.html';
        $html = @ob_get_clean();
        $htmlbody = str_replace('{{LOGO}}', $config->site.'/assets/img/mail_logo.png', $html);
        $htmlbody = str_replace('{{BODY}}', $body, $htmlbody);

        $mail->setFrom($config->email, $config->sitename);
        $mail->addRecipient($name, $email);
        $mail->setReplyTo($config->email);
        $mail->Subject($subject);
        $mail->Body($htmlbody);
        if($mail->send()) {
            return true;
        }
        return false;
    }

    /**
     * Send email to the admin
     * @param $subject string the mail subject
     * @param $body string the mail body
     * @return boolean true if success false if not
    */
    public static function sendAdminMail($subject, $body)
    {
        $mail   = factory::getMailer();
        $config = factory::getConfig();


		@ob_start();
		include 'assets/mail/mail.html';
		$html = @ob_get_clean();
		$htmlbody = str_replace('{{LOGO}}', $config->site.'/assets/img/mail_logo.png', $html);
		$htmlbody = str_replace('{{BODY}}', $body, $htmlbody);

        $mail->setFrom($config->email, $config->sitename);
        $mail->addRecipient($config->sitename, $config->email);
        $mail->setReplyTo($config->email);
        $mail->Subject($subject);
        $mail->Body($htmlbody);
        if($mail->send()) {
            return true;
        }
        return false;
    }

	public function saveMessage($usuari, $issueid)
    {
    	$db     = factory::getDatabase();

    	$message = new stdClass();
		$message->userid = $usuari;
		$message->titol = 'Nova acció a la incidencia '.$issueid;
		$message->incidencia_id = $issueid;
		$message->estat = 0;
    $message->estatMobil = 0;
		return $db->insertRow('#_messages', $message);
    }

    /**
     * Method to cut a long text
     * @param string $string the input text
     * @param int $number the number of words in output
    */
    public function textShorterer($string, $number)
    {
        $string = str_replace('<p>', '', $string);
        $string = str_replace('</p>', '', $string);
        $string = str_word_count($string, 1, '0..9ÁáÉéÍíÓóÚúñäëïöü');
        $i = 0;
        $phrase = "";
        foreach($string as $str) {
            if($i == $number) { break; }
            $phrase .= $str . " ";
            $i++;
        }
        return $phrase;
    }

    /**
     * Method to destroy session messages
    */
    public function unsetSession()
    {
    	$_SESSION['message'] = '';
		$_SESSION['messageType'] = '';
    }

	/**
     * Method to create a pagination
    */
    public function pagination($filters)
    {
		$app = factory::getApplication();
		$lang = factory::getLanguage();

    $orderDir    = $app->getVar('orderDir', 'asc');
    $colDir      = $app->getVar('colDir', 'projecte_id');

    	$total_pages = $_SESSION['total_pages'];
		$html = array();
        $string = '';

        $page = (empty($filters['page'])) ? 1 : $filters['page'];
        unset($filters['page']);

		foreach($filters as $k => $v) {
			$string .= '&'.$k.'='.$v;
		}

        $first = $lang->get('CW_FIRST');
        $last = $lang->get('CW_LAST');
        $pages = $lang->get('CW_PAGES');

        //no do not go over index
        $before5 = ($page - 5 < 1) ? 1 : $page - 5;

        $max5laps = 0;
        $after5 = $page;
        while ($after5 <= $total_pages && $max5laps < 5) {
            $after5++;
            $max5laps++;
        }
        $after5--;

        $html[] = '<div class="pager my-3">';

        if($total_pages > 0){
            $html[] = '<nav aria-label="">';
            $html[] = '<ul class="pagination">';
            //FIRTS
            $html[] = '<li class="page-item ';
            if($page <= 1 ) $html[] = 'disabled';
            $html[] = '"><a class="page-link" href="index.php?'.$string.'&page=1">'.$first.'</a></li>';
            //BEFORE
            $html[] = '<li class="page-item ';
            if($page <= 1 ) $html[] = 'disabled';
            $html[] = '"><a class="page-link" href="index.php?'.$string.'&page='. $before5 .'&orderDir='.$orderDir.'&colDir='.$colDir.'">«</a></li>';

            //While PAGES
            $max5laps = 0;
            $field = $page;
            while ($field <= $total_pages && $max5laps < 5) {
                $html[] = '<li class="page-item ';
                if($page == $field ) $html[] = 'active';
                $html[] = '"><a class="page-link" href="index.php?'.$string.'&page='.$field.'&orderDir='.$orderDir.'&colDir='.$colDir.'">'.$field.'</a></li>';

                $field++;
                $max5laps++;
            }

            //AFTER
            $html[] = '<li class="page-item ';
            if($page == $total_pages || $after5 == $total_pages) $html[] = 'disabled';
            $html[] = '"><a class="page-link" href="index.php?'.$string.'&page='. $after5 .'&orderDir='.$orderDir.'&colDir='.$colDir.'">»</a></li>';
            //LAST
            $html[] = '<li class="page-item ';
            if($page < 1 || $page == $total_pages || $after5 == $total_pages) $html[] = 'disabled';
            $html[] = '"><a class="page-link" href="index.php?'.$string.'&page='. $total_pages .'&orderDir='.$orderDir.'&colDir='.$colDir.'">'.$last.'</a></li>';
            $html[] = '</ul>';
            $html[] = '</nav>';
            //TOTAL PAGES
            $html[] = '<p style="font-size: small">'.$pages.' '.$total_pages.'</p>';

        }

        $html[] = '</div>';

		return implode($html);
    }
}
