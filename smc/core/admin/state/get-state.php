<?php
    include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config/config.ini.php');	
    include_once(dirname(dirname(__FILE__)) . '/action/verify.php');
   
    if(!isset($_SESSION['state'])){
        $_SESSION['state'] = array(
            'sessionId'=>session_id()
        );
    }
    echo 'Ext.appState = ';
    echo json_encode($_SESSION['state']);
    echo ';';