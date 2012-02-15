<?php

    include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php');	
    include_once(dirname(__FILE__) . '/verify.php');
    
    $block  = new Block();
    
    if(isset($_POST['element_id'])) {
        try {
            $id = (int)$_POST['element_id'];
            
            $markup = array();
            $cMarkup = trim($_POST['update_value']);
            
            $cDescription = trim($_POST['element_description']);
            $description = strip_tags($cDescription);
            
            //Strip tags from the string and convert any entities to
            //their corresponding character.  This is an attempt to ensure
            //that the markup contains at least some data
            $tMarkup = strip_tags(html_entity_decode($cMarkup), '<img>');
            
            if(!empty($tMarkup) && strlen($tMarkup) > 1) {
                $markup = $cMarkup;
            } else {
                $markup = '<p>Temporary data holder</p>';
            }
            
            $block->blockUpdate($id, $markup, $description);
            echo "{success : true}";
        } catch (Exception $e) {
            echo "{success : false}";
        }
    } else {
        echo "{success : false, msg : 'A valid element id must be submitted in order to update a content block.'}";
    }