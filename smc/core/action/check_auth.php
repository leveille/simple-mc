<?php

    include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php');	
    
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
        echo "{success : true, msg : 'You are currently logged in.'}";
    } else {
        echo "{success : false, msg : 'You are not currently logged in.'}";
    }