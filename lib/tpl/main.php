<?php
$servers = $console->getServers();
?><!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Beanstalk console</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customer.css" rel="stylesheet">
        <link href="highlight/styles/magula.css" rel="stylesheet">
        <script>
            var url = "./index.php?server=<?php echo $server ?>";
            var contentType = "<?php echo isset($contentType) ? $contentType : '' ?>";
        </script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <?php if (!empty($servers)): ?>
        <body>
        <?php else: ?>
        <body class="no-nav">
        <?php endif ?>

        <?php if (!empty($servers)): ?>
            <?php require_once(dirname(__FILE__) . '/nav.php'); ?>
        <?php endif ?>

        <div class="container">
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $item): ?>
                    <p class="alert alert-error"><span class="label label-important">Error</span> <?php echo $item ?></p>
                <?php endforeach; ?>
            <?php else: ?>
                <?php if (isset($_tplPage)): print_r($_tplPage);?>
                    <?php include(dirname(__FILE__) . '/' . $_tplPage . '.php') ?>
                <?php elseif (!$server): ?>
                    <div id="idServers">
                        <?php include(dirname(__FILE__) . '/serversList.php'); ?>
                    </div>
                    <div id="idServersCopy" style="display:none"></div>
                    <?php if ($tplVars['_tplMain'] != 'ajax'): ?>
                        <?php require_once dirname(__FILE__) . '/modalAddServer.php'; ?>
                        <?php require_once dirname(__FILE__) . '/modalFilterServer.php'; ?>
                    <?php endif; ?>
                <?php elseif (!$tube):?>
                    <?php if(!is_array($server) || count($server) === 1): ?>
                        <div id="idAllTubes">
                            <?php require_once dirname(__FILE__) . '/allTubes.php'; ?>
                            <?php require_once dirname(__FILE__) . '/modalClearTubes.php'; ?>
                        </div>
                        <div id='idAllTubesCopy' style="display:none"></div>
                    <?php endif; ?>
                <?php elseif (!in_array($tube, $tubes)):?>
                    <?php echo sprintf('Tube "%s" not found or it is empty', $tube) ?>
                    <br><br1><a href="./?server=<?php echo $server ?>"> << back </a>
                <?php else:?>
                    <?php require_once dirname(__FILE__) . '/currentTube.php'; ?>
                    <?php require_once dirname(__FILE__) . '/modalAddJob.php'; ?>
                    <?php require_once dirname(__FILE__) . '/modalAddSample.php'; ?>
                <?php endif; ?>
                <?php if (!isset($_tplPage)): ?>
                    <?php require_once dirname(__FILE__) . '/modalFilterColumns.php'; ?>
                <?php endif; ?>
                <?php require_once dirname(__FILE__) . '/modalSettings.php'; ?>
            <?php endif; ?>
        </div>

        <script src='assets/vendor/jquery/jquery.js'></script>
        <script src="js/jquery.color.js"></script>
        <script src="js/jquery.cookie.js"></script>
        <script src="js/jquery.regexp.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <?php if (isset($_COOKIE['isDisabledJobDataHighlight']) and $_COOKIE['isDisabledJobDataHighlight'] != 1): ?>
            <script src="highlight/highlight.pack.js"></script>
            <script>hljs.initHighlightingOnLoad();</script>
        <?php endif; ?>
        <script src="js/customer.js"></script>
    </body>
</html>
