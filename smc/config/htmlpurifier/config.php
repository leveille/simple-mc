<?php

include_once(dirname(dirname(__FILE__)) . '/config.ini.php');
include_once('HTMLPurifier.standalone.php');

//http://htmlpurifier.org
function htmlPurifierConfig()
{
    $config = HTMLPurifier_Config::createDefault();
    
    //Additional information regarding configuration, etc, can be found here
    //http://htmlpurifier.org/svnroot/htmlpurifier/tags/3.0.0/INSTALL
    
    //using a different character encoding?
    //default is utf-8.  If you need ISO-8859-1, for example, uncomment the next line
    //$config->set('Core', 'Encoding', 'ISO-8859-1');
    
    //using a different doctype, or do you want the cleanliness of XHTML 1.0 Strict?
    /*
    * Other supported doctypes include:
    * HTML 4.01 Strict
    * HTML 4.01 Transitional
    * XHTML 1.0 Strict
    * XHTML 1.0 Transitional
    * XHTML 1.1
    */
    $doctype = defined('SMC_DOC_TYPE') && SMC_DOC_TYPE != '' ? SMC_DOC_TYPE : 'HTML 4.01 Strict';
    $config->set('HTML', 'Doctype', $doctype);
    
    /*
    * Additional Resources
    * http://htmlpurifier.org/phorum/read.php?3,1112,1113,quote=1
    */
    $config->set('HTML', 'DefinitionID', 'content');
    $config->set('HTML', 'DefinitionRev', 1);
    $def = $config->getHTMLDefinition(true);
    $def->addAttribute('a', 'target', 'Enum#_blank,_self,_target,_top');
    
    $purifier = new HTMLPurifier($config);
    return $purifier;
}