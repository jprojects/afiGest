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

if(!$user->getAuth()) {
    $app->redirect($config->site);
}
?>

<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Inici</a></li>
      <li class="breadcrumb-item active">Administració</li>
      <li class="breadcrumb-item active">Configuració</li>
    </ul>
  </div>
</div>

<section class="forms">
  <div class="container-fluid">

    <!-- Page Header-->
    <header>
      <h1 class="h3 display"><?= $lang->get('CW_SETTINGS_TITLE'); ?></h1>
    </header>
    <div class="row">
      <div class="col-lg-12">

					<form class="form-signin" id="settings-form" action='<?php echo $config->site; ?>/index.php?view=config&amp;task=saveConfig' method="post">

						<!-- Coins -->
						<?php echo $html->getListField('config', 'show_coins', $settings->show_coins); ?>
            <!-- Coins -->
						<?php echo $html->getListField('config', 'show_quotes', $settings->show_quotes); ?>

					  <?php echo $html->getButton('config', 'submit'); ?>

				</form>

			</div>
		</div>
	</div>
</section>
