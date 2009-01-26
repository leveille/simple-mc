<?php
if($_SESSION['isAdmin'] || $_SESSION['isEditor']): ?>

    <?php if(defined('SMC_DEBUG_MODE') && SMC_DEBUG_MODE): ?>
        <link href="<?php echo SMC_EXT_REL; ?>/resources/css/ext-all.css" rel="stylesheet" type="text/css" media="screen"<?php echo SMC_CLOSE_TAG; ?>>
        <link href="<?php echo SMC_EXT_REL; ?>/resources/css/xtheme-<?php echo SMC_THEME; ?>.css" rel="stylesheet" type="text/css" media="screen"<?php echo SMC_CLOSE_TAG; ?>>
        <link href="<?php echo SMC_CSS_REL; ?>/admin.css" rel="stylesheet" type="text/css" media="screen"<?php echo SMC_CLOSE_TAG; ?>>
        <link href="<?php echo SMC_CSS_REL; ?>/fck_content.css" rel="stylesheet" type="text/css" media="screen"<?php echo SMC_CLOSE_TAG; ?>>
    <?php else: ?>
        <!-- Serve minified css -->
    <?php endif; ?>
    
    <!--[if IE]>
    <link href="<?php echo SMC_CSS_REL; ?>/ie.css" rel="stylesheet" type="text/css" media="screen"<?php echo SMC_CLOSE_TAG; ?>>
    <![endif]-->
    
<?php endif; ?>