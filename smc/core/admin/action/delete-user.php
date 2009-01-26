<?php
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