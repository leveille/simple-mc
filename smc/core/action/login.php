<?php

    include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php');	
   
    $login = new Login();
   
    if(isset($_POST['user']) && isset($_POST['pass'])) {
        
        try {
            $user = $_POST['user'];
            $password = $_POST['pass'];
	         
            /***
            Cleanup of the $user and $password vars
            will take place in the validate function
            ***/
            $data = $login->validate($user, $password);
	      
            if(count($data) == 0) {
                echo "{success : false, msg : 'Invalid username and/or password.'}";
            } else {
                session_regenerate_id();
	         
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $data['username'];
	         
                if($data['role'] == 'administrator') {
	                $_SESSION['isMember'] = false;
                    $_SESSION['isEditor'] = false;
                    $_SESSION['isAdmin'] = true;
                    echo "{success : true}" ;
                } else if($data['role'] == 'editor') {
                    $_SESSION['isAdmin'] = false;
                    $_SESSION['isMember'] = false;
                    $_SESSION['isEditor'] = true;
                    echo "{success : true}" ;
                } else if($data['role'] == 'member') {
                    $_SESSION['isAdmin'] = false;
                    $_SESSION['isEditor'] = false;
                    $_SESSION['isMember'] = true;
                    echo "{success : true}" ;
                } else {
                    $_SESSION['isAdmin'] = false;
                    $_SESSION['isEditor'] = false;
                    $_SESSION['isMember'] = false;
                    echo "{success : false, msg : 'Invalid user role.'}";
                }
            }
        } catch (Exception $e) {
            echo "{success : false, msg : 'An unexpected error has occured.  Please try to login again.'}";
        }
    } else {
      echo "{success : false, msg : 'You must submit a username/password.'}";
	}