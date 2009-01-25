<?php
/* SVN FILE: $Id: log_js_error.php 96 2008-08-05 16:40:10Z leveillej $ */
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
    include_once(dirname(__FILE__) . '/verify.php');
    
    if(isset($_POST['err_data'])) {      
        $log_file = sprintf("%s/js_errors.log", SMC_LOGS);
        
        $log_entry = "\r\n==================================================\r\n";
        $log_entry .= date('l dS \of F Y h:i:s A') . "\r\n";
        $log_entry .= $_POST['err_data'];
        $log_entry .= "\r\n==================================================\r\n";
        
        if (is_writable($log_file)) {
        
            if (!$handle = fopen($log_file, 'a'))  {
                echo "Cannot open file ($log_file)";
                exit;
            }
            
            // Write $log_entry to our opened file.
            if (fwrite($handle, $log_entry) === FALSE) {
                echo "Cannot write to file ($log_file)";
                exit;
            }
            
            fclose($handle);
        
        } else  {
            echo "The file $log_file is not writable";
        }
    
    } else {
        die('Unable to log error.');
    }