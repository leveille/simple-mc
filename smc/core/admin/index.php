<?php
/* SVN FILE: $Id: index.php 116 2008-08-27 02:21:17Z leveillej $ */
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
* @version        $Rev: 116 $
* @modifiedby     $LastChangedBy: leveillej $
* @lastmodified   $Date: 2008-08-26 22:21:17 -0400 (Tue, 26 Aug 2008) $
*/
	include_once(dirname(dirname(dirname(__FILE__))) . '/config/config.ini.php');
	include_once(dirname(__FILE__) . '/action/verify.php');
    include_once('minify/_groupsSources.php'); 
    include_once('Minify/Build.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Simple MC Content Management</title>
    
    <?php $css = new Minify_Build($groupsSources['cssBack']); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $css->uri(SMC_REL . '/min.php/cssBack'); ?>">

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
    
    <?php $js1 = new Minify_Build($groupsSources['jsBack1']); ?>
    <script type="text/javascript" src="<?php echo $js1->uri(SMC_REL . '/min.php/jsBack1'); ?>"></script>
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
                    var auth = new Auth({path : SMC_ADMIN.smc_core, timer : 180});
                    auth.initiateAuthTaskRunner();
                    
                    Ext.BLANK_IMAGE_URL = '<?php echo SMC_EXT_REL; ?>/resources/images/default/s.gif';
                    
                    SMC_ADMIN.oFCKeditor = new FCKeditor('baiEditor');
                    SMC_ADMIN.oFCKeditor.BasePath = "<?php echo SMC_FCK_REL; ?>/";
                    SMC_ADMIN.oFCKeditor.ToolbarSet = "CMS";
                    SMC_ADMIN.oFCKeditor.Height = "325";
                    
                    //remove load mask
                    setTimeout(function(){
                        Ext.get('loading').remove();
                        Ext.get('loading-mask').fadeOut({
                            remove: true
                        });
                    }, 250);
                },
                
                useExtEditor: function()
                {
                    return !Ext.isGecko;
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
    <?php $js2 = new Minify_Build($groupsSources['jsBack2']); ?>
    <script type="text/javascript" src="<?php echo $js2->uri(SMC_REL . '/min.php/jsBack2'); ?>"></script>
</body>
</html>