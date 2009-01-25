<?php
/* SVN FILE: $Id: verify.php 71 2008-08-02 19:03:43Z leveillej $ */
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
* @version         $Rev: 71 $
* @modifiedby      $LastChangedBy: leveillej $
* @lastmodified   $Date: 2008-08-02 15:03:43 -0400 (Sat, 02 Aug 2008) $
*/

if(!$_SESSION['isAdmin'] && !$_SESSION['isEditor']) die('Access Denied');