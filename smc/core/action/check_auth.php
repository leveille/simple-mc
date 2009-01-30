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
    include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php');	
    
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
        echo "{success : true, msg : 'You are currently logged in.'}";
    } else {
        echo "{success : false, msg : 'You are not currently logged in.'}";
    }