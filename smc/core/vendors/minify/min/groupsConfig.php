<?php
include_once(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/config/config.ini.php';
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 **/

return array(
    'jslogin' => array(
        sprintf('%s/adapter/ext/ext-base.js', SMC_EXT), 
        sprintf('%s/ext-all.js', SMC_EXT)
    ),
    'csslogin' => array(
        sprintf('%s/resources/css/ext-all.css', SMC_EXT), 
        sprintf('%s/resources/css/xtheme-gray.css', SMC_EXT), 
        sprintf('%s/login.css', SMC_CSS)
    ),
    'jsfront' => array(
        sprintf('%s/adapter/ext/ext-base.js', SMC_EXT), 
        sprintf('%s/ext-all.js', SMC_EXT), 
        sprintf('%s/fckeditor.js', SMC_FCK), 
        sprintf('%s/smc_utils.js', SMC_JAVASCRIPTS),
        sprintf('%s/smc.js', SMC_JAVASCRIPTS), 
        sprintf('%s/smc_auth.js', SMC_JAVASCRIPTS)
    ),
    'cssfront' => array(
        sprintf('%s/resources/css/ext-all.css', SMC_EXT), 
        sprintf('%s/resources/css/xtheme-gray.css', SMC_EXT), 
        sprintf('%s/admin.css', SMC_CSS), 
        sprintf('%s/fck_content.css', SMC_CSS)
    ),
    'jsadmin_1' => array(
        sprintf('%s/adapter/ext/ext-base.js', SMC_EXT), 
        sprintf('%s/ext-all.js', SMC_EXT), 
        sprintf('%s/smc_utils.js', SMC_JAVASCRIPTS),
        sprintf('%s/smc_auth.js', SMC_JAVASCRIPTS),
        sprintf('%s/state/SessionProvider.js', SMC_ADMIN),
        sprintf('%s/fckeditor.js', SMC_FCK)
    ),
    'jsadmin_2' => array(
        sprintf('%s/javascripts/TabCloseMenu.js', SMC_ADMIN), 
        sprintf('%s/javascripts/AdminLayout.js', SMC_ADMIN), 
        sprintf('%s/javascripts/AdminPanel.js', SMC_ADMIN), 
        sprintf('%s/javascripts/ContentGrid.js', SMC_ADMIN), 
        sprintf('%s/javascripts/MainPanel.js', SMC_ADMIN)
    ),
    'cssadmin' => array(
        sprintf('%s/resources/css/ext-all.css', SMC_EXT), 
        sprintf('%s/resources/css/xtheme-gray.css', SMC_EXT), 
        sprintf('%s/stylesheets/screen.css', SMC_ADMIN), 
        sprintf('%s/fck_content.css', SMC_CSS)
    ),
);