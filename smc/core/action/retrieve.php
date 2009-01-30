<?php
/**
 * SimpleMC - http://github.com/leveille/simple-mc/tree/master
 * Copyright (C) Blue Atlas Interactive
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 * == END LICENSE ==
 */
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