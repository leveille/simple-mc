<?php
    include_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config/config.ini.php');	
    include_once('verify.php');
   
    $block  = new Block();
    echo $block->getContentBlocks();