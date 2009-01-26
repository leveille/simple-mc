<?php
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