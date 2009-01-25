<?php
/* SVN FILE: $Id: Utility.php 100 2008-08-06 13:35:07Z leveillej $ */
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
* @version        $Rev: 100 $
* @modifiedby     $LastChangedBy: leveillej $
* @lastmodified   $Date: 2008-08-06 09:35:07 -0400 (Wed, 06 Aug 2008) $
*/  
    
class Utility
{
    /**
    * wrapper function for environment variables.  Corrects issues with DOCUMENT_ROOT in IIS
    * Many thanks to https://trac.cakephp.org/browser/trunk/cake/1.2.x.x/cake/basics.php for a push in the right direction
    * 
    * @return environment variable value
    * @param $var String
    * @access public static
    */
    public static function env($var) {
        $env_val = false;
        
        if (!empty($_SERVER[$var])) {
            $env_val = $_SERVER[$var];
        } elseif (!empty($_ENV[$var])) {
            $env_val = $_ENV[$var];
        } elseif (getenv($var) !== false) {
            $env_val = getenv($var);
        }
        
        if ($env_val !== false) {
            return $env_val;
        }
        
        //correct DOCUMENT_ROOT issue on IIS (at least on IIS 6.0)
        if($var == 'DOCUMENT_ROOT') {
            $offset = 0;
            if (!strpos(Utility::env('SCRIPT_NAME'), '.php')) {
                $offset = 4;
            }
            return substr(Utility::env('SCRIPT_FILENAME'), 0, strlen(Utility::env('SCRIPT_FILENAME')) - (strlen(Utility::env('SCRIPT_NAME')) + $offset));
        }
    }
}