<?php

if($_SESSION['isAdmin'] || $_SESSION['isEditor']): ?>
   
    <?php if(defined('SMC_IE_DEBUG') && SMC_IE_DEBUG): ?>
        <script type='text/javascript' src='http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js'></script>
    <?php endif; ?>
    
    <?php if((defined('SMC_DEBUG_MODE') && SMC_DEBUG_MODE) || 
        (defined('SMC_MINIFY_ENABLED') && !SMC_MINIFY_ENABLED)): ?>
        <script type="text/javascript" src="<?php echo SMC_EXT_REL; ?>/adapter/ext/ext-base.js"></script>
        <script type="text/javascript" src="<?php echo SMC_EXT_REL; ?>/ext-all.js"></script>
        <script type="text/javascript" src="<?php echo SMC_FCK_REL; ?>/fckeditor.js"></script>
        <script type="text/javascript" src="<?php echo SMC_JAVASCRIPTS_REL; ?>/smc_utils.js"></script>
        <script type="text/javascript" src="<?php echo SMC_JAVASCRIPTS_REL; ?>/smc.js"></script>
        <script type="text/javascript" src="<?php echo SMC_JAVASCRIPTS_REL; ?>/smc_auth.js"></script>
    <?php else: ?>
        <script type="text/javascript" src="<?php echo SMC_MINIFY_REL; ?>/min/?g=jsfront"></script>
    <?php endif; ?>
    
    <script>
        Ext.onReady(function() {
            try {
                SMC.smcRoot = '<?php echo SMC_REL; ?>';
                SMC.smcCore = '<?php echo SMC_CORE_REL; ?>';
                SMC.editorName = "baiEditor";
                
                oFCKeditor = new FCKeditor(SMC.editorName);
                oFCKeditor.BasePath = "<?php echo SMC_FCK_REL; ?>/"
                oFCKeditor.ToolbarSet = "SMC";
                oFCKeditor.Height = SMC_UTILS.viewportHeight() - 130;
                oFCKeditor.ReplaceTextarea();
       
                SMC.init();
            } catch(e) {
                alert('An unexpected error has occured.  Please refresh your window and try again.  If the issue persists please contact technical support.');
            } finally {   
            
                //Set the cookie provider for this application
                SMC.cp = new Ext.state.CookieProvider({
                   path: "/",
                   expires: new Date(new Date().getTime()+(365 * 1000 * 60 * 60 * 24)) //365 days
                })
                
                Ext.state.Manager.setProvider(SMC.cp);  
                               
                //Turn off the body loading mask
                setTimeout(function(){
                    Ext.get('loading').remove();
                    Ext.get('loading-mask').fadeOut({remove:true});
                }, 250);
            }
        }); 
    </script>
<?php endif; ?>