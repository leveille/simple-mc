<?php
/* SVN FILE: $Id: add-content.php 110 2008-08-07 14:50:23Z leveillej $ */
/**
*
* SimpleMC - BlueAtlas content manager
* Copyright 2008 - Present,
*      19508 Amaranth Dr., Suite D, Germantown, Maryland 20874 | 301.540.5950
*
* Redistributions of files must retain the above notice.
*
* @filesource
* @copyright      Copyright 2008 - Present, Blue Atlas Interactive
* @version        $Rev: 110 $
* @modifiedby     $LastChangedBy: leveillej $
* @lastmodified   $Date: 2008-08-07 10:50:23 -0400 (Thu, 07 Aug 2008) $
*/
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