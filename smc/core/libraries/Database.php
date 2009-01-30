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
include_once('database.config.php');

class Database
{
    /**
     * Make a database connection
     * 
     * @return Connection object or false
     */
    public static function connect()
    {
        $mysqli = new mysqli(SMC_DB::$conf['host'], SMC_DB::$conf['username'], SMC_DB::$conf['password'], SMC_DB::$conf['database']);
        
        if (mysqli_connect_errno()) {
            return false;
        }
        
        $mysqli = self::setEncoding($mysqli);
        return $mysqli;
    }
    
    /**
     * Set encoding for 
     * 
     * @return $mysqli Object
     * @param $mysqli Object
     */
    private static function setEncoding($mysqli) 
    {
        $mysqli->set_charset(SMC_DB::$conf['encode']);
        return $mysqli;
    }
    
    /**
     * What is the prefix for our smc tables (if any)
     * 
     * @return smc table prefix
     */
    public static function getTablePrefix()
    {
        return !empty(SMC_DB::$conf['prefix']) ? SMC_DB::$conf['prefix'] : '';
    }
    
    /**
     * Check to see if we have a connection
     * 
     * @return Boolean
     */
    public static function isConnected()
    {
        $connect = self::connect();
        
        if(!$connect) {
            return false;    
        }
        
        return $connect->close();
    }
}