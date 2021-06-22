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

$model 	= $app->getModel('groups');
?>

<!-- Breadcrumb-->
<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Inici</a></li>
      <li class="breadcrumb-item">Administració</li>
      <li class="breadcrumb-item active">Groups</li>
    </ul>
  </div>
</div>

<section>
  <div class="container-fluid">

    <div class="col-12 my-3"><a class="btn btn-success" href="<?= $config->site; ?>/index.php?view=groups&layout=edit"><i class="fa fa-plus"></i> Nou</a></div>

    <!-- Page Header-->
    <div class="card">
      <div class="card-header">
        <h4>Grups</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="datatable1" style="width: 100%;" class="table">
            <thead>
              <tr>
                <th>Id</th>
                <th>Usergroup</th>
                <th>Crear</th>
                <th>Editar</th>
                <th>Esborrar</th>
                <th>#</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($model->getList() as $item) : ?>
              <tr>
                <td><?= $item->id; ?></td>
                <td><?= $item->usergroup; ?></td>
                <td><?= $item->nou == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>'; ?></td>
                <td><?= $item->editar == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>'; ?></td>
                <td><?= $item->esborrar == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>'; ?></td>
                <td><a href="index.php?view=groups&task=removeGroup&id=<?= $item->id; ?>"><i class="fa fa-trash-o"></i></a></td>
                <td><a href="index.php?view=groups&layout=edit&id=<?= $item->id; ?>"><i class="fa fa-edit"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
