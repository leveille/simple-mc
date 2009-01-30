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