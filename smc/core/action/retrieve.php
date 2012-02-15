<?php

    include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php');	
    include_once(dirname(__FILE__) . '/verify.php');
    
    $block  = new Block();
    
    if(isset($_POST['element_id'])) {
        try {
            $id = (int)$_POST['element_id'];
            echo $block->getUnwrapped($id);
        } catch (Exception $e) {
            echo "{success : false}" ;
        }
    } else {
        echo "{success : false, msg : 'A valid id must be submitted in order to retrieve a content block.'}" ;
    }