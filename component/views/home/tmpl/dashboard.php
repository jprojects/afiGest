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

if(!$user->getAuth()) {
    $app->redirect($config->site.'?view=home');
}

$model = $app->getModel();
$u     = $app->getVar('u', $user->id, 'get');
?>

<div class="breadcrumb-holder">
	<div class="container-fluid">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Inici</a></li>
			<li class="breadcrumb-item active">Dashboard</li>
		</ul>
	</div>
</div>

<section class="statistics">

  <div class="container-fluid">

	<?php if($settings->show_quotes == 1) : ?>
    <div class="alert alert-success my-3"><i class="fa fa-quote-left"></i>&nbsp;<?= $model->randomQuote(); ?>&nbsp;<i class="fa fa-quote-right"></i></div>
	<?php endif; ?>

	<div class="row">

		<div class="col-12 col-md-9">

			<div class="row d-flex text-center">
				<div class="col-12 col-lg-4 mt-3">
					<div class="card counter text-success">
						<i class="fa fa-flask fa-2x"></i>
						<h2 class="timer count-title count-number" data-to="<?= $model->getCountProjects(); ?>" data-speed="1500"></h2>
						<p class="count-text ">Projectes</p>
					</div>
				</div>
				<div class="col-12 col-lg-4 mt-3">
					<div class="card counter text-success">
						<i class="fa fa-rocket fa-2x"></i>
						<h2 class="timer count-title count-number" data-to="<?= $model->getCountIssues(); ?>" data-speed="1500"></h2>
						<p class="count-text ">Incidències Obertes</p>
					</div>
				</div>
				<div class="col-12 col-lg-4 mt-3">
					<div class="card counter text-success">
						<i class="fa fa-rocket fa-2x"></i>
						<h2 class="timer count-title count-number" data-to="<?= $model->getCountIssuesClosed(); ?>" data-speed="1500"></h2>
						<p class="count-text ">Incidències resoltes</p>
					</div>
				</div>
			</div>

			<div class="row d-flex">

				<?php $temps_restant_total = 0; ?>

				<?php foreach($model->getProjectsAffected() as $project) : ?>
				<?php
				$temps_restant = $model->getTotalTempsRestant($project->projecte_id);
				$temps_restant_total += $temps_restant;
				$data_limit = $model->getDataLimit($project->projecte_id);
				$project->slack_channel != '' ? $link = $project->slack_channel : $link = '';
				$project->slack_channel != '' ? $disabled = '' : $disabled = 'disabled';
				?>
				<div class="col-lg-4 mt-3">
					<div class="card user-activity" <?php if($model->isPanic($project->projecte_id)) : ?>style="background-color: #e6b9b9 !important;"<?php endif; ?>>
						<h2 class="display h4 d-flex"><a class="text-left" href="<?= $config->site; ?>/index.php?view=issues&filter_equal_projecteId=<?= $project->projecte_id; ?>&filter_equal_estat=2%3A1&filter_equal_usuari=<?= $user->id; ?>"><i class="fa fa-flask"></i> <?= $project->nom; ?></a> <a class="btn btn-primary ml-auto <?= $disabled; ?>" href="<?= $link; ?>" target="_blank"><i class="fa fa-slack"></i> Obre a Slack</a></h2>
						<div class="number"><?= $model->countOpenIssues($project->projecte_id); ?> <?php if($model->isPanic($project->projecte_id)) : ?><i class="fa fa-exclamation-triangle float-right text-danger"></i><?php endif; ?></div>
						<div class="progress">
							<div role="progressbar" style="width: <?= $model->countOpenIssues($project->projecte_id); ?>%" aria-valuenow="<?= $model->countOpenIssues($project->projecte_id); ?>" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>
						</div>
						<div class="page-statistics d-flex justify-content-between">
							<div class="page-statistics-left"><span>Total temps:</span> <?php if ($temps_restant != 0) { echo floor($temps_restant/60) . 'h ' . sprintf('%02d',$temps_restant%60) . 'm';} ?></div>
							<div class="page-statistics-right"><span>Data limit:</span> <?php if ($data_limit != '0000-00-00' && $data_limit != null) { echo '<span class="text-danger"><i class="fa fa-thumbs-down"></i> '.date('d-m-Y', strtotime($data_limit)).'</span>';} else { echo '<span class="text-success"><i class="fa fa-thumbs-up"></i></span>'; } ?></span></div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>

				<div class="col-12 my-4 text-left">Temps total: <span style="font-weight: bold;"><?php echo floor($temps_restant_total/60) . 'h ' . sprintf('%02d',$temps_restant_total%60) . 'm'; ?></span></div>
			</div>

		</div>
		<div class="col-12 col-md-3 mt-3">
			<?= $app->getModule('online'); ?>
			<?= $app->getModule('chartTags'); ?>
		</div>

	</div>

</div>

</section>
