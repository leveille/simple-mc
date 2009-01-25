<?php
/* SVN FILE: $Id: m.php 60 2008-07-24 10:55:26Z leveillej $ */
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
* @version        $Rev: 60 $
* @modifiedby     $LastChangedBy: leveillej $
* @lastmodified   $Date: 2008-07-24 06:55:26 -0400 (Thu, 24 Jul 2008) $
*/
    include_once(dirname(__FILE__) . '/config/config.ini.php');
    include_once('minify/_groupsSources.php');
    
    //http://code.google.com/p/minify/wiki/UserGuide
    
    if (defined('SMC_CACHE')) {
        Minify::useServerCache(SMC_CACHE);
    }
    
    $serveOptions = array(
        'groups' => $groupsSources,
        'setExpires' => time() + 86400 * 365
    );
    
    Minify::serve('Groups', $serveOptions);