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
    
    if(isset($_POST['uId']) && isset($_POST['uUsername']) && isset($_POST['roleId'])) {
        try {
            $user_id = (int)$_POST['uId'];
            $username = $_POST['uUsername'];
            $role_id = (int)$_POST['roleId'];
            
            if($user->userExists($username) && !$user->usernameBelongsToUser($user_id, $username)) {
                echo "{success : false, msg : 'The username you entered already exisits in the database.'}" ;
            } else {
                if(isset($_POST['uPassword1']) && isset($_POST['uPassword1'])) {
                    if($_POST['uPassword1'] == $_POST['uPassword1']) {
                        $password = $_POST['uPassword1'];
                        
                        $user->userUpdate($user_id, $role_id, $username);
                        $user->userUpdatePassword($user_id, $password);
                        echo "{success : true}" ;
                    } else {
                        echo "{success : false, msg : 'Passwords do not match.'}" ;
                    }
                } else {     
                    $user->userUpdate($user_id, $role_id, $username);
                    echo "{success : true}" ;
                }
            }
        } catch (Exception $e) {
            echo "{success : false}" ;
        }
    } else {
        echo "{success : false, msg : 'Data must be submitted in order to update a user.'}" ;
    }