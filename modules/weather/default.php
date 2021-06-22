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
include_once('helper.php');
$data = weatherHelper::getData();
?>

<div class="row-fluid">
    <div class="card mb-3">
        <h2 class="display text-success">Temps
        <?php if($data['weather'][0]['main'] == 'Clear') : ?>
        <i class="fa fa-sun-o fa-3x text-success float-right"></i>
        <?php endif; ?>
        <?php if($data['weather'][0]['main'] == 'Clouds') : ?>
        <i class="fa fa-cloud fa-3x text-success float-right"></i>
        <?php endif; ?>
        <?php if($data['weather'][0]['main'] == 'Snow') : ?>
        <i class="fa fa-snowflake-o fa-3x text-success float-right"></i>
        <?php endif; ?>
        <?php if($data['weather'][0]['main'] == 'Rain') : ?>
        <i class="fa fa-tint fa-3x text-success float-right"></i>
        <?php endif; ?>
        </h2>
        <p><b>Temp: <?= $data['main']['temp']; ?> Cº</b></p>
        <p><b>Pressió: <?= $data['main']['pressure']; ?> mBar</b></p>
        <p><b>Humitat: <?= $data['main']['humidity']; ?> %</b></p>
        <p><b>Vent: <?= $data['main']['speed']; ?> Km/h</b></p>
    </div>
</div>
