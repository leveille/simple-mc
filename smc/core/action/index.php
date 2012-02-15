<?php 

    //@TODO: Move all actions into this routing file
    include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php');	
    include_once(dirname(__FILE__) . '/verify.php');

    $action = $_GET['a'];
    switch($action) {
        case '' :
            break;
         
    }
