<?php
    include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config/config.ini.php');	
    include_once(dirname(dirname(__FILE__)) . '/action/verify.php');
   
    if(!isset($_SESSION['state'])){
        $_SESSION['state'] = array(
            'sessionId'=>session_id()
        );
    }
   
    foreach($_COOKIE as $name=>$value){
        // look for state cookies
        if(strpos($name, 'ys-') === 0){
            // store in session
            $_SESSION['state'][substr($name, 3)] = $value;
            // remove cookie
            setCookie($name, '', time()-10000, '/');
        }
    }