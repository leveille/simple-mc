<?php
/* SVN FILE: $Id: _groupsSources.php 60 2008-07-24 10:55:26Z leveillej $ */
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
    include_once('Minify/Source.php');

    $groupsSources = array(
        'jsFront' => array(
            sprintf("%s/jquery.js", SMC_JQUERY),
            sprintf("%s/jquery_blockui.js", SMC_JQUERY),
            sprintf("%s/tiny_mce.js", SMC_TINYMCE),
            sprintf("%s/smc.js", SMC_JAVASCRIPTS)
        ),
        'jsLogin' => array(
            sprintf("%s/adapter/ext/ext-base.js", SMC_EXT),
            sprintf("%s/ext-all.js", SMC_EXT)
        ),
        'jsBack1' => array(
            sprintf("%s/adapter/ext/ext-base.js", SMC_EXT),
            sprintf("%s/ext-all.js", SMC_EXT),
            sprintf("%s/auth.js", SMC_JAVASCRIPTS),
            sprintf("%s/state/SessionProvider.js", SMC_ADMIN),
            sprintf("%s/fckeditor.js", SMC_FCK)
        ),
        'jsBack2' => array(
            sprintf("%s/javascripts/TabCloseMenu.js", SMC_ADMIN),
            sprintf("%s/javascripts/AdminLayout.js", SMC_ADMIN),
            sprintf("%s/javascripts/AdminPanel.js", SMC_ADMIN),
            sprintf("%s/javascripts/ContentGrid.js", SMC_ADMIN),
            sprintf("%s/javascripts/MainPanel.js", SMC_ADMIN)
        ),
        'cssLogin' => array(
            new Minify_Source(array(
                'filepath' => sprintf("%s/resources/css/ext-all.css", SMC_EXT),
                    'minifyOptions' => array(
                        'prependRelativePath' => sprintf('%s/resources/images/', SMC_EXT_REL)
                    )
                )
            ),
            new Minify_Source(array(
                'filepath' => sprintf("%s/resources/css/xtheme-gray.css", SMC_EXT),
                    'minifyOptions' => array(
                        'prependRelativePath' => sprintf('%s/resources/images/', SMC_EXT_REL)
                    )
                )
            ),
            new Minify_Source(array(
                'filepath' => sprintf("%s/login.css", SMC_CSS),
                    'minifyOptions' => array(
                        'prependRelativePath' => sprintf('%s/', SMC_CORE_REL)
                    )
                )
            )
        ),
        'cssBack' => array(
            new Minify_Source(array(
                'filepath' => sprintf("%s/resources/css/ext-all.css", SMC_EXT),
                    'minifyOptions' => array(
                        'prependRelativePath' => sprintf('%s/resources/images/', SMC_EXT_REL)
                    )
                )
            ),
            new Minify_Source(array(
                'filepath' => sprintf("%s/resources/css/xtheme-gray.css", SMC_EXT),
                    'minifyOptions' => array(
                        'prependRelativePath' => sprintf('%s/resources/images/', SMC_EXT_REL)
                    )
                )
            ),
            new Minify_Source(array(
                'filepath' => sprintf("%s/screen.css", SMC_ADMIN . '/stylesheets'),
                    'minifyOptions' => array(
                        'prependRelativePath' => sprintf('%s/images/', SMC_ADMIN_REL)
                    )
                )
            )
        )
    );