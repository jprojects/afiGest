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

$model 	= $app->getModel('hores');
$page  	= $app->getVar('page', 1, 'get');
$view  	= $app->getVar('view', '', 'get');
?>

<div class="breadcrumb-holder">
	<div class="container-fluid">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Inici</a></li>
			<li class="breadcrumb-item active">Administració</li>
			<li class="breadcrumb-item active">Hores</li>
		</ul>
	</div>
</div>

<section class="statistics">
  <div class="container-fluid">
    <div class="row d-flex">

      <div class="col-12">

			<form action="" method="get" id="itemsList" name="itemsList" class="w-100">

				<input type="hidden" name="view" value="hores">
				<?php $get = $_GET; ?>

				<?php $columns = array('User', 'Tipus', 'Registre'); ?>

				<div class="table-responsive">
        			<table id="hores" class="table table-striped table-bordered">
        				<thead>
        					<tr>
								<?php
								foreach($columns as $column) : ?>
									<th><?= $column; ?></th>
								<?php endforeach; ?>
        					</tr>
        				</thead>
        				<tbody>
						<?php
						foreach($model->getList() as $d) : ?>
							<tr class="item table-<?= $d->type == 1 ? 'success' : 'danger'; ?>">
								<td>
									<?= $d->username; ?></a>
								</td>
								<td>
									<?= $d->type == 1 ? 'Entrada' : 'Sortida'; ?>
								</td>
								<td>
									<?= date('d-m-Y H:i:s', strtotime($d->registre)); ?>
								</td>
							</tr>
						<?php endforeach; ?>
        				</tbody>
        			</table>
        			<script>$(document).ready(function() { var dataTable = $("#hores").DataTable({ "order": [[1, "asc"]], "paging": false, rowReorder: true, responsive: { details: false } })});</script>
        		</div>

        		<?= $model->pagination($get); ?>

			</form>

      </div>
		</div>
	</div>
</section>
