<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $config->description; ?>">
    <meta name="author" content="<?= $config->sitename; ?>">
    <title><?= $config->sitename; ?></title>
    
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/assets/css/bootstrap.css">
    
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/assets/css/app.css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= $config->site; ?>/template/<?= $config->template; ?>/css/custom.css">
    <?php
  	if(count($app->stylesheets) > 0) :
  		foreach($app->stylesheets as $stylesheet) : ?>
  		    <link href="<?= $stylesheet; ?>" rel="stylesheet">
  		<?php endforeach;
  	endif;
  	?>
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
</head>

<body>
    <div id="app">
        
        <?= $app->getModule('sidebarmenu');?>

        <div id="main">
            <?php @include($app->getLayout()); ?>
        </div>

        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p><?= $app->getVersion(); ?></p>
                </div>
                <div class="float-end">
                    <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a target="_blank"
                            href="http://aficat.com">Afi Informàtica</a></p>
                </div>
            </div>
        </footer>

    </div>
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/assets/js/bootstrap.bundle.min.js"></script>
    <!-- Notifications-->
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/messenger-hubspot/build/js/messenger.min.js">   </script>
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/vendor/messenger-hubspot/build/js/messenger-theme-flat.js">       </script>
    <script src="<?= $config->site; ?>/template/<?= $config->template; ?>/assets/js/main.js"></script>
    <?php
    if(count($app->scripts) > 0) :
    foreach($app->scripts as $script) : ?>
    <script src='<?= $script; ?>'></script>
    <?php endforeach;
    endif; ?>
    <script src="<?= $config->site; ?>/assets/js/app.js"></script>
    <?php include('template/'.$config->template.'/message.php'); ?>
</body>

</html>