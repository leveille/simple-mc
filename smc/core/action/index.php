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
    //@TODO: Move all actions into this routing file
    include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php');	
    include_once(dirname(__FILE__) . '/verify.php');

    $action = $_GET['a'];
    switch($action) {
        case '' :
            break;
         
    }
