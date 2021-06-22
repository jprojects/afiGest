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

if($user->level != 1) {
    $app->redirect($config->site);
}

$model = $app->getModel();
?>

<div class="breadcrumb-holder">
 <div class="container-fluid">
   <ul class="breadcrumb">
     <li class="breadcrumb-item"><a href="index.php">Inici</a></li>
     <li class="breadcrumb-item">Administració</li>
     <li class="breadcrumb-item active">Documents legals</li>
   </ul>
 </div>
</div>

<section class="forms">
  <div class="container-fluid">

  <div class="my-4 w-100 text-right"><?= $html->renderButtons('tools', 'tools'); ?></div>

    <div class="row mt-4">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h4>Genera documentació</h4>
          </div>
          <div class="card-body">
           <form name="gdpr" id="gdpr" action="index.php?view=tools&task=legal" method="post">

             <div class="form-group">
                 <input type="text" class="form-control" name="nom" placeholder="Nom del projecte">
             </div>
    	    		<div class="form-group">
    	      			<input type="text" class="form-control" name="empresa" placeholder="Nom d'empresa">
    	    		</div>
    	    		<div class="form-group">
    	      			<input type="text" class="form-control" name="nif" placeholder="NIF">
    	    		</div>
    	    		<div class="form-group">
    	      			<input type="text" class="form-control" name="adreca" placeholder="Adreça de l'empresa">
    	    		</div>
    	    		<div class="form-group">
    	      			<input type="text" class="form-control" name="email" placeholder="Email de l'empresa">
    	    		</div>
    	    		<div class="form-group">
    	      			<input type="text" class="form-control" name="jutjats" placeholder="Població Jutjats">
    	    		</div>
    	    		<div class="form-group">
    	      			<select class="form-control" name="format">
    	      				<option value="html" selected>html</option>
    	      				<option value="txt">txt</option>
    	      				<option value="odt">odt</option>
    	      			</select>
    	    		</div>

    	    		<button type="submit" class="btn btn-primary btn-block">DESCARREGAR</button>

    	  		</form>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h4>Arxius generats</h4>
          </div>
          <div class="card-body">

            <table class="table">
              <thead>
                <tr>
                  <th>Projecte</th>
                  <th>#</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($model->getFiles() as $file) : ?>
                <tr>
                  <td><a href="<?= $config->site; ?>/assets/legal/files/<?= $file; ?>"><?= $file; ?></a></td>
                  <td><a href="<?= $config->site; ?>/index.php?view=admin&task=deleteFile&file=<?= $file; ?>"><i class="fa fa-remove"></i></a></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
