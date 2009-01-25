<div id="bai_toggler">
    <div id="bai_links" class="clearfix">
        <a href="#"><img src="<?php echo SMC_CORE_REL; ?>/support/images/logo.png" title="Simple MC" id="simplemc_logo"<?php echo SMC_CLOSE_TAG; ?>></a>
        <span id="bai_link_actions">
            <?php if($_SESSION['isAdmin']): ?>
                <span id="bai_admn"><a href="<?php echo SMC_CORE_REL; ?>/admin/">admin</a></span>
            <?php endif; ?>
            <span id="bai_logout"><a href="<?php echo SMC_REL; ?>/logout.php">logout</a></span>
        </span>
    </div>
    <div id="bai_shortcuts" class="clearfix">
        Editable Content: &nbsp;
    </div>
</div>
