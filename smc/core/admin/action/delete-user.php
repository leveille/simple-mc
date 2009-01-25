<?php
/* SVN FILE: $Id: delete-user.php 96 2008-08-05 16:40:10Z leveillej $ */
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
* @version        $Rev: 96 $
* @modifiedby     $LastChangedBy: leveillej $
* @lastmodified   $Date: 2008-08-05 12:40:10 -0400 (Tue, 05 Aug 2008) $
*/
    include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config/config.ini.php');	
    include_once('verify.php');
    
    $user  = new User();
    
    if(isset($_POST['uId'])) {
        try {
            if($_POST['uName'] == $_SESSION['username'] || $_POST['uName'] == 'admin' || $_POST['uName'] == 'editor') {
                echo "{success : false, msg : 'You cannot delete yourself, or the default roles of admin or editor.'}";
            } else {
                $user->userDelete((int)$_POST['uId']);
                echo "{success:true}" ;
            }
        } catch (Exception $e) {
            echo "{success:false}" ;
        }
    } else {
        echo "{success : false, msg : 'A valid user must be selected.'}" ;
    }