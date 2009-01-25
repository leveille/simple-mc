<?php include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Dimensional Technical Services</title>
        <?php require_once('smc_stylesheets.inc.php'); ?>
        <script type="text/javascript" src="menus.js">
        </script>
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php require_once('smc_mask.inc.php'); ?>
        <div id="wrapper">
            <div id="content">
                <div id="header">
                    <div id="logo">
                        <h1>dimensional</h1>
                        <h4>Technical Services, LLC</h4>
                    </div>
                    <?php include "nav_top.php"; ?>
                </div>
                <div id="mainimg">
                    <?php echo $block->get(5);	?>
                </div>
                <div id="contentarea">
                    <div id="leftbar">
                        <?php echo $block->get(22); ?>
                        <div align="center">
                            <?php echo $block->get(4);	?>
                        </div>
                        <br>
                        <br>
                    </div>
                    <div id="rightbar">
                        <?php echo $block->get(23); ?>
                        <br>
                        <div align="center">
                            <br>
                            <img src="images/woman.jpg">
                        </div>
                    </div>
                </div>
            </div>
            <?php include "footer.php"; ?>
        </div>
    </body>
</html>