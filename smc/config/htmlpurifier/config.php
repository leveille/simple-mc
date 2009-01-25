<?php
/* SVN FILE: $Id: config.php 114 2008-08-11 11:53:19Z leveillej $ */
/**
 *
 * Comment here
 *
 * @filesource
 * @copyright      Copyright 2008 - Present Blue Atlas Interactive
 * @version        $Revision: 114 $
 * @modifiedby     $LastChangedBy: leveillej $
 * @lastmodified   $Date: 2008-08-11 07:53:19 -0400 (Mon, 11 Aug 2008) $
 */
include_once(dirname(dirname(__FILE__)) . '/config.ini.php');
include_once('HTMLPurifier.auto.php');

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