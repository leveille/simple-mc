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
    
    if(isset($_POST['uId'])) {
        try {
            if($_POST['uName'] == $_SESSION['username'] || $_POST['uName'] == 'admin' || $_POST['uName'] == 'editor') {
                echo "{success : false, msg : 'You cannot delete yourself, or the default roles of admin or editor.'}";
            } else {
                $user->userDelete((int)$_POST['uId']);
                echo "{success:true}" ;
            }
        } catch (Exception $e) {
            echo "{success:false}" ;
        }
    } else {
        echo "{success : false, msg : 'A valid user must be selected.'}" ;
    }