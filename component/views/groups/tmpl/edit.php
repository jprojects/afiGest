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


$model = $app->getModel();
$item  = $model->getItem();
$id    = $app->getVar('id', 0, 'get');
?>

<div class="breadcrumb-holder">
	<div class="container-fluid">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Inici</a></li>
			<li class="breadcrumb-item">Administració</li>
            <li class="breadcrumb-item active">Groups</li>
		</ul>
	</div>
</div>

<section class="forms">
    <div class="container-fluid">
    <div class="row">

		<div class="col-lg-12 my-3"><a title="Tornar a grups" class="hasTip" href="javascript:history.go(-1);"><i class="fa fa-angle-left fa-2x"></i></a></div>

        <div class="col-12">

			<div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Grup</h4>
                </div>
                <div class="card-body">
                    <p>Com administrador pots crear nous grups d'usuaris.</p>
                    <form method="post" action="index.php?view=groups&task=saveGroup">
                        <input type="hidden" name="id" value="<?= $id; ?>">
                        <?= $html->getTextField('groups', 'usergroup', $item->usergroup); ?>
                        <?= $html->getListField('groups', 'nou', $item->nou); ?>
                        <?= $html->getListField('groups', 'editar', $item->editar); ?>
                        <?= $html->getListField('groups', 'esborrar', $item->esborrar); ?>
                        <?= $html->getViewsField('groups', 'views', $item->views); ?>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><?= $lang->get('CW_SAVE'); ?></button>
                        </div>
                    </form>
		        </div>
		    </div>

		</div>

    </div>
	</div>
</section>
