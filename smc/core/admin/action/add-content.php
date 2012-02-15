<?php

    include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config/config.ini.php');	
    include_once('verify.php');
    
    $block  = new Block();
    
    if(isset($_POST['cMarkup'])) {
        try {
            $markup = array();
            $cMarkup = trim($_POST['cMarkup']);
            $cDescription = trim($_POST['cDescription']);
            
            //Strip tags from the string and convert any entities to
            //their corresponding character.  This is an attempt to ensure
            //that the markup contains at least some data
            $tMarkup = strip_tags(html_entity_decode($cMarkup), '<img>');
            
            if(!empty($tMarkup) && strlen($tMarkup) > 1) {
                $markup = $cMarkup;
            } else {
                $markup = '<p>Temporary data holder.</p>';
            }
            
            $block->create($markup, $cDescription);
            echo "{success : true}" ;
        } catch (Exception $e) {
            echo "{success : false}" ;
        }
    } else {
        echo "{success : false, msg : 'Data must be submitted in order to add a content block.'}" ;
    }  