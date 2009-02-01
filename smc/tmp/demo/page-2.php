<?php 
/**
 * SimpleMC - http://github.com/leveille/simple-mc/tree/master
 * Copyright (C) Blue Atlas Interactive
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 * == END LICENSE ==
 */
include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">   
        <meta http-equiv="Content-Language" content="en-us">
        <meta name="author" content="Blue Atlas Interactive">
        <meta name="copyright" content="http://www.blueatlas.com">

        <title>Simple MC Demo</title>

        <?php include_once('smc_stylesheets.inc.php'); ?>
        <link rel="stylesheet" type="text/css" href="assets/css/base.css" media="screen, projection">
        <link rel="stylesheet" type="text/css" href="assets/css/print.css" media="print">
    </head>
    <body>
        <?php include_once('smc_mask.inc.php'); ?>
        <div id="doc" class="yui-t5">
            
            <div id="hd">
                <div id="logo">
                    <h1>SimpleMC</h1>
                    <p>Simple Managed Content</p>
                </div>
                
                <div id="nav">
                    <ul>
                        <li><a href="index.php" title="Home">Home</a></li>
                        <li><a href="page-2.php" title="Page 2">Page 2</a></li>
                    </ul>
                </div><!-- closing nav -->
            </div><!-- closing hd -->
            
            <div id="bd">
                <div class="yui-gb">
                    <div class="yui-u first">
                        <div class="pad">
                            <?php echo $block->get(5); ?>
                        </div>
                    </div><!-- closing yui-u first -->
                    <div class="yui-u">
                        <div class="pad">
                            <?php echo $block->get(6); ?>
                       </div>
                    </div><!-- closing yui-u -->
                    <div class="yui-u">
                        <div class="pad">
                            <?php echo $block->get(7); ?>
                        </div>
                    </div><!-- closing yui-u  -->
                </div>
            </div><!-- closing bd -->
            
            <div id="ft">
                <?php echo $block->get(2); ?>
            </div><!-- closing ft -->
        </div><!-- closing doc -->
        <?php include_once('smc_javascripts.inc.php'); ?>
    </body>
</html>
