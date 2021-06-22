<?php

/**
 * @version     1.0.0 Afi framework $
 * @package     Afi framework
 * @copyright   Copyright © 2016 - All rights reserved.
 * @license	    GNU/GPL
 * @author	    kim
 * @author mail kim@afi.cat
 * @website	    http://www.afi.cat
 *
*/

defined('_Afi') or die ('restricted access');

$config = factory::getConfig();
$user   = factory::getUser();
$view   = factory::getApplication()->getVar('view', 'home');
?>

<!-- Sidebar Navigation Menus-->
<div class="main-menu">
	<ul id="side-main-menu" class="side-menu list-unstyled">
		<?php if($user->getAuth()) : ?>
		<li><a <?= $view == 'home' ? 'class="active"' : ''; ?> href="<?= $config->site; ?>/index.php?view=home&layout=dashboard"> <i class="icon-home"></i>Home</a></li>
		<li><a <?= $view == 'issues' ? 'class="active"' : ''; ?>  href="<?= $config->site; ?>/index.php?view=issues"> <i class="fa fa-rocket"></i>Incidències </a></li>
		<li><a <?= $view == 'projects' ? 'class="active"' : ''; ?>  href="<?= $config->site; ?>/index.php?view=projects"> <i class="fa fa-flask"></i>Projectes </a></li>
		<li><a <?= $view == 'profile' ? 'class="active"' : ''; ?>  href="<?= $config->site; ?>/index.php?view=profile"><i class="fa fa-user"></i>Perfil </a></li>
		<li><a <?= $view == 'about' ? 'class="active"' : ''; ?>  href="<?= $config->site; ?>/index.php?view=about"><i class="fa fa-question-circle"></i>About </a></li>
		<?php if($user->level == 1) : ?>
		<li class="py-3 pl-2"><hr></li>
		<li><a <?= $view == 'config' ? 'class="active"' : ''; ?>  href="<?= $config->site; ?>/index.php?view=config"><i class="fa fa-cog"></i>Configuració </a></li>
		<li><a <?= $view == 'hores' ? 'class="active"' : ''; ?>  href="<?= $config->site; ?>/index.php?view=hores"> <i class="fa fa-clock-o"></i>Hores </a></li>
		<li><a <?= $view == 'report' ? 'class="active"' : ''; ?>  href="<?= $config->site; ?>/index.php?view=report"> <i class="fa fa-list"></i>Reports </a></li>
		<li><a <?= $view == 'users' ? 'class="active"' : ''; ?>  href="<?= $config->site; ?>/index.php?view=users"><i class="fa fa-user"></i>Users </a></li>
		<li><a <?= $view == 'groups' ? 'class="active"' : ''; ?>  href="<?= $config->site; ?>/index.php?view=groups"><i class="fa fa-users"></i>Groups </a></li>
		<li><a <?= $view == 'tools' ? 'class="active"' : ''; ?>  href="<?= $config->site; ?>/index.php?view=tools"><i class="fa fa-wrench"></i>Tools </a></li>
		<?php endif; ?>
		<?php else : ?>
		<li><a href="<?= $config->site; ?>/index.php?view=register&amp;layout=login"><i class="fa fa-sign-in"></i>Login </a></li>
		<?php endif; ?>
	</ul>
	<div class="ads">
	<!-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<ins class="adsbygoogle"
		style="display:block"
		data-ad-client="ca-pub-2086277945461916"
		data-ad-slot="9025049959"
		data-ad-format="auto"
		data-full-width-responsive="true"></ins>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
	</script> -->
	</div>
</div>
