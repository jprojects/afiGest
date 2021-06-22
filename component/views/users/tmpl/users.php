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

$model 	= $app->getModel('users');
?>

<!-- Breadcrumb-->
<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Inici</a></li>
      <li class="breadcrumb-item">Administració</li>
      <li class="breadcrumb-item active">Usuaris</li>
    </ul>
  </div>
</div>

<section>
  <div class="container-fluid">

    <div class="col-12 my-3"><a class="btn btn-success" href="<?= $config->site; ?>/index.php?view=users&layout=edit"><i class="fa fa-plus"></i> Nou</a></div>

    <!-- Page Header-->
    <div class="card">
      <div class="card-header">
        <h4>Usuaris</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="datatable1" style="width: 100%;" class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Usergroup</th>
                <th>Last Visit</th>
                <th>Esborrar</th>
                <th>Editar</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($model->getUsers() as $usr) : ?>
              <tr>
                <td><?= $usr->username; ?></td>
                <td><?= $usr->email; ?></td>
                <td><?= $usr->level == 1 ? 'Admin' : 'Registered'; ?></td>
                <td><?= $usr->lastvisitDate; ?></td>
                <td><a href="index.php?view=users&task=removeUser&id=<?= $usr->id; ?>"><i class="fa fa-trash-o"></i></a></td>
                <td><a href="index.php?view=users&layout=edit&id=<?= $usr->id; ?>"><i class="fa fa-edit"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
