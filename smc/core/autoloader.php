<?php
/* SVN FILE: $Id: autoloader.php 98 2008-08-06 12:40:28Z leveillej $ */
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
* @version        $Rev: 98 $
* @modifiedby     $LastChangedBy: leveillej $
* @lastmodified   $Date: 2008-08-06 08:40:28 -0400 (Wed, 06 Aug 2008) $
*/

    function class_autoloader($c) 
    {      
        $include_path = get_include_path();
        $include_path_tokens = explode(PATH_SEPARATOR, $include_path);

        foreach($include_path_tokens as $prefix) {
            $path = sprintf('%s/%s.php', $prefix, $c);
            if(file_exists($path)){
                include_once($path);
                return true;
            }
        }
        throw new Exception(sprintf('Fatal error. Unable to load class file for %s.', $c));
    }
    spl_autoload_register("class_autoloader");