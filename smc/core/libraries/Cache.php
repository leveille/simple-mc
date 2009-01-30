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
class Cache
{
    private $_sanitize = null;
    private static $cacheEnabled = false;
    private static $cacheDirectoryName = 'cache';
    private static $cachePath = '';
    private static $cachePrefix = 'smc_';
    
    /**
     * Constructor
     */
    function __construct() {
        $this->_sanitize = new Sanitize();

        if(defined('SMC_CACHE_ENABLED')) { 
            self::$cacheEnabled = SMC_CACHE_ENABLED;
        }

        if(defined('SMC_CACHE')) {
            self::$cachePath = SMC_CACHE;
        } else {
            self::$cachePath = dirname(dirname(__FILE__)) . '/' . self::$cacheDirectoryName;
        }
    }
    
    /**
     * Is cache enabled
     * @return Boolean
     */
    public static function isEnabled()
    {
        return self::$cacheEnabled;
    }
    
    /**
     * Defined cache directory path
     * 
     * @return String Directory Path
     */
    public static function getCachePath()
    {
        return self::$cachePath;
    }
    
    /*
    * Create a cache entry for a unique identifier
    * @cacheId
    * @data (string)
    * @description (string)
    */
    public function create($cacheId, $data, $description)
    {         
        $cacheName = md5($cacheId);
        $file = self::$cachePath . '/' . self::$cachePrefix . $cacheName;
        
        $entry = array(
            'block' => $data,
            'description' => $description
        );
        
        if (get_magic_quotes_gpc()) {
            $entry['block'] = stripslashes($entry['block']);
            $entry['description'] = stripslashes($entry['description']);
        }
        
        @file_put_contents($file, json_encode($entry));
    }
    
    /*
    * Update cache file
    * @cacheId
    * @data (string)
    * @description (string)
    */
    public function update($cacheId, $data, $description = null)
    {
        $cacheName = md5($cacheId);
        $file = self::$cachePath . '/' . self::$cachePrefix . $cacheName;
        $entry = array();
        
        $entry['block'] = $data;         
        $cachedData = $this->retrieve($cacheId);
        
        if($cachedData) {
            $dataArray = json_decode($cachedData, true);
            if(empty($dataArray['description'])) {
                $entry['description'] = 'Data Block';    
            } else {
                $entry['description'] = $dataArray['description'];
            }
        } else {
            if(empty($description)) {
                $entry['description'] = 'Data Block';    
            } else {
                $entry['description'] = $description;
            }
        }
        
        if (get_magic_quotes_gpc()) {
            $entry['block'] = stripslashes($entry['block']);
            $entry['description'] = stripslashes($entry['description']);
        }

        @file_put_contents($file, json_encode($entry));
    }
    
    /*
    * Delete cache file
    * @cacheId
    */
    public function delete($cacheId)
    {         
        $cacheName = md5($cacheId);
        $file = self::$cachePath . '/' . self::$cachePrefix . $cacheName;
        @unlink($file);
    }
    
    /*
    * Read data from a cache entry
    * @cacheId
    */
    public function retrieve($cacheId)
    {         
        $cacheName = md5($cacheId);
        $file = self::$cachePath . '/' . self::$cachePrefix . $cacheName;
        
        if(file_exists($file)) {
            return file_get_contents($file);
        } else {
            return false;
        }
    }
}