<?php
	include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php');
	include_once(dirname(__FILE__) . '/action/verify.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Simple MC Content Management</title>
    
    <?php if((defined('SMC_DEBUG_MODE') && SMC_DEBUG_MODE) || 
        (defined('SMC_MINIFY_ENABLED') && !SMC_MINIFY_ENABLED)): ?>
        <link href="<?php echo SMC_EXT_REL; ?>/resources/css/ext-all.css" rel="stylesheet" type="text/css" media="screen">
        <link href="<?php echo SMC_EXT_REL; ?>/resources/css/xtheme-gray.css" rel="stylesheet" type="text/css" media="screen">
        <link href="<?php echo SMC_ADMIN_REL; ?>/stylesheets/screen.css" rel="stylesheet" type="text/css" media="screen">
        <link href="<?php echo SMC_CSS_REL; ?>/fck_content.css" rel="stylesheet" type="text/css" media="screen">
    <?php else: ?>
        <!-- Serve minified css -->
        <link href="<?php echo SMC_MINIFY_REL; ?>/min/g=cssadmin" rel="stylesheet" type="text/css" media="screen">
    <?php endif; ?>
</head>
<body scroll="no">
    <div id="loading-mask"></div>
    
    <div id="loading">
        <div class="loading-indicator">
            <img src="images/large-loading.gif" width="32" height="32" style="margin-right:8px;" align="absmiddle">Loading...
        </div>
    </div>
    
    <div id="header">
        <img src="images/admin-header.png" alt="SimpleMC Administration">
        <div id="header-nav">
            <span id="bai_home"><a href="<?php echo BASE_URL; ?>">Home</a></span>
            <span id="bai_logout"><a href="<?php echo SMC_REL; ?>/logout.php">Logout</a></span>
        </div>
    </div>
    
    <!-- Template used for Content Block Items -->
    <textarea id="preview-tpl" style="display:none">
        <div class="content-data">
            <h3 class="content-description">{description}</h3>
            <p id="shortcut">
                The code snippet needed to pull this content into the website: <strong>{shortcut:htmlEncode}</strong>
            </p>
        </div>
        <div class="content-source">
            {source}
        </div>
    </textarea>
    
    <div id="south">
        <p>
            &copy; 
            <?php echo date('Y'); ?>
            <a href="http://www.blueatlas.com">Blue Atlas Interactive</a>
        </p>
    </div>

    <?php if(defined('SMC_IE_DEBUG') && SMC_IE_DEBUG): ?>
        <script type='text/javascript' src='http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js'></script>
    <?php endif; ?>
    
    <?php if((defined('SMC_DEBUG_MODE') && SMC_DEBUG_MODE) || 
        (defined('SMC_MINIFY_ENABLED') && !SMC_MINIFY_ENABLED)): ?>
        <script type="text/javascript" src="<?php echo SMC_EXT_REL; ?>/adapter/ext/ext-base.js"></script>
        <script type="text/javascript" src="<?php echo SMC_EXT_REL; ?>/ext-all.js"></script>
        <script type="text/javascript" src="<?php echo SMC_JAVASCRIPTS_REL; ?>/utils.js"></script>
        <script type="text/javascript" src="<?php echo SMC_JAVASCRIPTS_REL; ?>/auth.js"></script>
        <script type="text/javascript" src="<?php echo SMC_ADMIN_REL; ?>/state/SessionProvider.js"></script>
        <script type="text/javascript" src="<?php echo SMC_FCK_REL; ?>/fckeditor.js"></script>
    <?php else: ?>
        <!-- Implement js minify -->
        <script type="text/javascript" src="<?php echo SMC_MINIFY_REL; ?>/min/?g=jsadmin_1"></script>
    <?php endif; ?>
    
    <script type="text/javascript" src="<?php echo sprintf('%s/state/save-state.php', SMC_ADMIN_REL); ?>"></script>
    <script type="text/javascript" src="<?php echo sprintf('%s/state/get-state.php', SMC_ADMIN_REL); ?>"></script>
    
    <script language="javascript" type="text/javascript">
        <!--
        Ext.namespace('SMC_ADMIN');
        
        SMC_ADMIN = function() {
        
            return {
                oFCKeditor: null,
                smc_core: '',
                javascripts: '',
                init: function()
                {
                    //throughout the duration of this administrative session
                    //ensure that the administrator is logged in
                    var auth = new Auth({path : SMC_ADMIN.smc_core, timer : 120});
                    auth.initiateAuthTaskRunner();
                    
                    Ext.BLANK_IMAGE_URL = '<?php echo SMC_EXT_REL; ?>/resources/images/default/s.gif';
                    
                    SMC_ADMIN.oFCKeditor = new FCKeditor('baiEditor');
                    SMC_ADMIN.oFCKeditor.BasePath = "<?php echo SMC_FCK_REL; ?>/";
                    SMC_ADMIN.oFCKeditor.ToolbarSet = "SMC";
                    SMC_ADMIN.oFCKeditor.Height = smc_client.viewportHeight - 200;
                    
                    //remove load mask
                    setTimeout(function(){
                        Ext.get('loading').remove();
                        Ext.get('loading-mask').fadeOut({
                            remove: true
                        });
                    }, 250);
                }
            }
        }();
        
        Ext.onReady(function(){
            SMC_ADMIN.javascripts = '<?php echo SMC_JAVASCRIPTS_REL; ?>';
            SMC_ADMIN.smc_core = '<?php echo SMC_CORE_REL; ?>';
            SMC_ADMIN.init();
        });
        -->
    </script>
    
    <?php if((defined('SMC_DEBUG_MODE') && SMC_DEBUG_MODE) || 
        (defined('SMC_MINIFY_ENABLED') && !SMC_MINIFY_ENABLED)): ?>
        <script type="text/javascript" src="<?php echo SMC_ADMIN_REL; ?>/javascripts/TabCloseMenu.js"></script>
        <script type="text/javascript" src="<?php echo SMC_ADMIN_REL; ?>/javascripts/AdminLayout.js"></script>
        <script type="text/javascript" src="<?php echo SMC_ADMIN_REL; ?>/javascripts/AdminPanel.js"></script>
        <script type="text/javascript" src="<?php echo SMC_ADMIN_REL; ?>/javascripts/ContentGrid.js"></script>
        <script type="text/javascript" src="<?php echo SMC_ADMIN_REL; ?>/javascripts/MainPanel.js"></script>
    <?php else: ?>
        <!-- Implement js minify -->
        <script type="text/javascript" src="<?php echo SMC_MINIFY_REL; ?>/min/?g=jsadmin_2"></script>
    <?php endif; ?>
</body>
    
</html>