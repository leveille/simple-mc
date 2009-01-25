<?php
/* SVN FILE: $Id: add-user.php 96 2008-08-05 16:40:10Z leveillej $ */
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
    
    if(isset($_POST['uUsername']) && isset($_POST['uPassword1']) && isset($_POST['uPassword2']) && isset($_POST['roleId'])) {
        try {
            $username = $_POST['uUsername'];
            $pass1 = $_POST['uPassword1'];
            $pass2 = $_POST['uPassword2'];
            $role_id = $_POST['roleId'];
            
            if($user->userExists($username)) {
                echo "{success : false, msg : 'Username already exists.'}";
            } else if($pass1 == $pass2) {
                $user->create($username, $pass1, (int)$role_id);
                echo "{success : true}" ;
            } else {
                echo "{success : false, msg : 'Passwords do not match.'}";
            }
        } catch (Exception $e) {
            echo "{success : false}";
        }
    } else {
        echo "{success : false, msg : 'One or more fields have not been properly filled out.'}";
    }