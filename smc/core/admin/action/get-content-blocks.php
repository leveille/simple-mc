<?php
/* SVN FILE: $Id: get-content-blocks.php 110 2008-08-07 14:50:23Z leveillej $ */
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
* @version        $Rev: 110 $
* @modifiedby     $LastChangedBy: leveillej $
* @lastmodified   $Date: 2008-08-07 10:50:23 -0400 (Thu, 07 Aug 2008) $
*/
    include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config/config.ini.php');	
    include_once('verify.php');
   
    $block  = new Block();
    echo $block->getContentBlocks();