<?php
    session_start();
    
    define("SMC", ROOT . SMC_REL);
    define("SMC_CORE", SMC . '/core');
    define("SMC_CORE_REL", SMC_REL . '/core');
    
    define("SMC_VENDORS", SMC_CORE . '/vendors');
    define("SMC_VENDORS_REL", SMC_CORE_REL . '/vendors');
    
    define("SMC_TMP", SMC . '/tmp');
    define("SMC_LOGS", SMC_TMP . '/logs');
    
    define("SMC_CACHE", SMC_TMP . '/cache');
    
    define("SMC_ADMIN", SMC_CORE . '/admin');
    define("SMC_ADMIN_REL", SMC_CORE_REL . '/admin');
    
    define("SMC_CONFIG", SMC . '/config');
    define("SMC_CLASSES", SMC_CORE . '/libraries');
    define("SMC_INCLUDES", SMC_CORE . '/support/includes');
    define("SMC_HTML_PURIFIER", SMC_VENDORS . '/htmlpurifiersa');
    define("SMC_MINIFY", SMC_VENDORS . '/minify');
    define("SMC_MINIFY_REL", SMC_VENDORS_REL . '/minify');
    
    /*
    * Set include path to include paths to classes and bai_cms includes
    */
    ini_set('include_path', 
        SMC_CONFIG . PATH_SEPARATOR .
        SMC_CLASSES . PATH_SEPARATOR . 
        SMC_VENDORS . PATH_SEPARATOR .
        SMC_INCLUDES . PATH_SEPARATOR . 
        SMC_HTML_PURIFIER . PATH_SEPARATOR .
        SMC_MINIFY . PATH_SEPARATOR .
        ini_get('include_path')
    );
    
    define("SMC_JAVASCRIPTS", SMC_CORE . '/libraries/javascripts');
    define("SMC_JAVASCRIPTS_REL", SMC_CORE_REL . '/libraries/javascripts');
    define("SMC_CSS", SMC_CORE . '/support/stylesheets');
    define("SMC_CSS_REL", SMC_CORE_REL . '/support/stylesheets');
    define("SMC_FCK", SMC_VENDORS . '/fckeditor');
    define("SMC_FCK_REL", SMC_VENDORS_REL . '/fckeditor');
    define("SMC_EXT", SMC_VENDORS . '/extjs');
    define("SMC_EXT_REL", SMC_VENDORS_REL . '/extjs');
            
    
    /********************************************************************
    DO NOT EDIT BELOW THIS LINE
    ********************************************************************/
    
    //setup closing tag based on doctype
    $docType = defined('SMC_DOC_TYPE') && SMC_DOC_TYPE != '' ? SMC_DOC_TYPE : 'HTML 4.01 Strict';
    if(stristr($docType, 'xhtml') === FALSE) {
        define('SMC_CLOSE_TAG', '');
    } else {
        define('SMC_CLOSE_TAG', ' /');    
    }
    
    include_once(dirname(__FILE__) . '/autoloader.php');
    define("BASE_URL", 'http://' . Utility::env('HTTP_HOST'));
    
    if(SMC_DEBUG_MODE || SMC_SHOW_ERRORS) {
        ini_set('error_reporting', E_ALL | E_STRICT);
        ini_set('display_errors', 'On');
        $logErrors = defined('SMC_LOG_ERRORS') && SMC_LOG_ERRORS ? 'On' : 'Off';
        ini_set('log_errors', $logErrors);
        ini_set('error_log', SMC_LOGS . '/errors.log');
    } else {
        error_reporting( 0 );   
    }
    
    if(!isset($_SESSION['isAdmin'])) {
        $_SESSION['isAdmin'] = false;
    }
    
    if(!isset($_SESSION['isEditor'])) {
        $_SESSION['isEditor'] = false;
    }
    
    if(!isset($_SESSION['isMember'])){
        $_SESSION['isMember'] = false;
    }
    
    if(!isset($_SESSION['loggedIn'])) {
        $_SESSION['loggedIn'] = false;
    }
    
    if(!defined('PRE_FLIGHT') || !PRE_FLIGHT) {
        $block = new Block();
    }