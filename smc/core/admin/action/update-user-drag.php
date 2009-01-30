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
    include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config/config.ini.php');	
    include_once('verify.php');
    
    $user  = new User();
    
    if(isset($_POST['uId']) && isset($_POST['rId'])) {
        try {
            $user_id = (int)$_POST['uId'];
            $role_id = (int)$_POST['rId'];
            $user->userUpdateRoleId($user_id, $role_id);
            echo "{success : true}";
        } catch (Exception $e) {
            echo "{success : false}";
        }
    } else {
        echo "{success : false}" ;
    }