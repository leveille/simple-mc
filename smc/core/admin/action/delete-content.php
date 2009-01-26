<?php
    include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config/config.ini.php');	
    include_once('verify.php');
    
    $block  = new Block();
    
    if(isset($_POST['cId'])) {
        try {
            $block->blockDelete((int)$_POST['cId']);
            echo "{success : true}" ;
        } catch (Exception $e) {
            echo "{success : false}" ;
        }
    } else {
        echo "{success : false, msg : 'A valid content block must be selected.'}" ;
    }