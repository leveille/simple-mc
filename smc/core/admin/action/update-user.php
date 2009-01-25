<?php
/* SVN FILE: $Id: update-user.php 96 2008-08-05 16:40:10Z leveillej $ */
/**
*
* SimpleMC - BlueAtlas content manager
* Copyright 2008 - Present,
*      19508 Amaranth Dr., Suite D, Germantown, Maryland 20874 | 301.540.5950
*
* Redistributions of files must retain the above notice.
*
* @filesource
* @copyright      Copyright 2008 - Present, Blue Atlas Interactive
* @version        $Rev: 96 $
* @modifiedby     $LastChangedBy: leveillej $
* @lastmodified   $Date: 2008-08-05 12:40:10 -0400 (Tue, 05 Aug 2008) $
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