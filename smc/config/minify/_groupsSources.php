<?php
    include_once('Minify/Source.php');

    $groupsSources = array(
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