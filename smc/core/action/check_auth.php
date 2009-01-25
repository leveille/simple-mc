<?php
/* SVN FILE: $Id: check_auth.php 96 2008-08-05 16:40:10Z leveillej $ */
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
* @version         $Rev: 96 $
* @modifiedby      $LastChangedBy: leveillej $
* @lastmodified   $Date: 2008-08-05 12:40:10 -0400 (Tue, 05 Aug 2008) $
*/    
    include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php');	
    
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
        echo "{success : true, msg : 'You are currently logged in.'}";
    } else {
        echo "{success : false, msg : 'You are not currently logged in.'}";
    }