<?php

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