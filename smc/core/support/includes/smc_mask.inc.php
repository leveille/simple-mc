<?php if($_SESSION['isAdmin'] || $_SESSION['isEditor']): ?>

    <?php include_once('smc_nav.php'); ?>
    <?php include_once('smc_editor.php'); ?>
    
    <div id="loading-mask"></div>
    <div id="loading">
    	<div class="loading-indicator">
    		<img src="<?php echo SMC_CORE_REL; ?>/support/images/large-loading.gif" width="32" height="32" style="margin-right:8px;"<?php echo SMC_CLOSE_TAG; ?>>Loading...
    	</div>
    </div>

<?php endif; ?>