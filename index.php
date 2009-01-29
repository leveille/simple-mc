<?php
session_start();

if(!defined('PRE_FLIGHT')) {
    define('PRE_FLIGHT', true);
}

include_once(dirname(__FILE__) . '/smc/config/config.ini.php'); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SimpleMC Setup</title>
        <style type="text/css">
            body {
                font:95%/1.125em "Lucida Grande", "Trebuchet MS", Verdana, san-serif;
                text-align: center;
                background: #F5F5F5;
                margin:0;
                padding: 1em
            }
            
            a {
                color: #006699;
                text-decoration: underline
            }
            
            a:hover {
                text-decoration: none
            }
            
            li {
                line-height: 1.6em
            }
            
            #container {
                text-align: left;
                width: 90%;
                margin-left: auto;
                margin-right: auto;
                background: #FFF;
                color: #000;
                padding: 3em;
                font-size: 90%;
                border: 1px solid #CCC
            }
            
            div#logo {
                background: #000000 url(smc/core/support/images/bg/login.jpg) no-repeat left top;
                height: 8em;
                margin-bottom: 2em
            }
            
            div#logo * {
                display: none
            }
            
            h2 {
                margin-top: 2em;
                margin-bottom: 1em;
                color: #355A8C
            }
            
            span {
                display:block
            }
            
            div#auth {
                float: right
            }
            
            div#auth li {
                display: inline;
                list-style: none
            }
            
            div#auth a {
                margin-left: .3em
            }
            
            p#firebug {
                display:none
            }
            
            .error, 
            .notice, 
            .success {
                padding:.8em;
                margin-bottom:1em;
                border:2px solid #ddd
            }
            
            .error {
                background:#FBE3E4;
                color:#8a1f11;
                border-color:#FBC2C4
            }
            
            .notice {
                background:#FFF6BF;
                color:#514721;
                border-color:#FFD324
            }
            
            .success {
                background:#E6EFC2;
                color:#264409;
                border-color:#C6D880
            }
            
            .error a {
                color:#8a1f11
            }
            
            .notice a {
                color:#514721
            }
            
            .success a {
                color:#264409
            }
            
            .show {display: block}
        </style>
    </head>
    <body>
        <div id="container">
            <div id="logo"><h1>SimpleMC</h1><p>Simple Managed Content</p></div>
            
            <div id="auth">
                <ul>
                    <?php if($_SESSION['loggedIn'] === false): ?>
                        <li><a href="/smc/">Login</a></li>
                    <?php else: ?>
                        <li><a href="/smc/tmp/demo/">View the Demo</a></li>
                        <li><a href="/smc/logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <ul>
                <li><strong>Code</strong>: 
                    <a href="http://github.com/leveille/simplemc/tree/master">
                    http://github.com/leveille/simplemc/tree/master</a>
                </li>
                <li><strong>Issue Tracker</strong>: 
                    <a href="http://leveille.lighthouseapp.com/projects/24238-simple-mc/overview">
                        http://leveille.lighthouseapp.com/projects/24238-simple-mc/overview
                    </a>
                </li>
                <li><strong>Live Demo</strong>: 
                    <a href="http://smc.jasonleveille.com/">
                    http://smc.jasonleveille.com/</a>
                </li>
                <li><strong>A product of</strong>: 
                    <a href="http://www.blueatlas.com">Blue Atlas Interactive</a>
                </li>
            </ul>
            
            <h2>Introduction</h2>
            <p>SimpleMC is meant to provide an easy way for content editors 
            to edit blocks of content. It is meant for smaller sites, where clients 
            just want to get in, edit some content, and get out.</p>
            
            <h2>Pre-flight Check</h2>
            <!--
                Pre-flight check inspired by cakephp preflight check
                http://cakephp.org/
                license: https://trac.cakephp.org/browser/trunk/cake/1.2.x.x/cake/LICENSE.txt
            -->
            
            <p>
                <?php
                    if (!file_exists('/smc/config/config.ini.php')):
                        die("Copy /smc/config/config.ini.php.default to /smc/config/config.ini.php before proceeding.");
                    endif;
                ?>
            </p>
            
            <p>
                <?php
                    if (is_writable(SMC_CACHE)):
                        echo '<span class="notice success">',
                        'Your cache directory is writable.',
                        '</span>';
                    else:
                        echo '<span class="notice warning">',
                        'Your cache directory is NOT writable.<br>',
                        '<strong>Please:</strong> chmod 777 ' . SMC_CACHE,
                        '</span>';
                    endif;
                ?>
            </p>
            
            <p>
                <?php
                    if (is_writable(SMC_LOGS)):
                        echo '<span class="notice success">',
                        'Your log directory is writable.',
                        '</span>';
                    else:
                        echo '<span class="notice warning">',
                        'Your log directory is NOT writable.<br>',
                        '<strong>Please:</strong> chmod 777 ',  SMC_LOGS,
                        '</span>';
                    endif;
                ?>
            </p>
            
            <p>
                <?php
                    if (is_writable(SMC_HTML_PURIFIER . '/standalone/HTMLPurifier/DefinitionCache/Serializer')):
                        echo '<span class="notice success">',
                        'The necessary htmlpurifier directory is writable.',
                        '</span>';
                    else:
                        echo '<span class="notice warning">',
                        'The necessary htmlpurifier directory is NOT writable.<br>',
                        '<strong>Please: </strong> chmod 777 -R ', SMC_HTML_PURIFIER,
                        '/standalone/HTMLPurifier/DefinitionCache/Serializer</span>';
                    endif;
                ?>
            </p>
                             
            <p>
                <?php
                    $filePresent = null;
                    if (file_exists(SMC_CONFIG . '/database.config.php')):
                        echo '<span class="notice success">',
                        'Your database configuration file is present.';
                        $filePresent = true;
                        echo '</span>';
                    else:
                        echo '<span class="notice warning">',
                        'Your database configuration file is NOT present.',
                        '<br>',
                        'Rename ', SMC_CONFIG, '<strong>/database.config.php.default</strong> to ', 
                        SMC_CONFIG, '<strong>/database.config.php</strong>',
                        '</span>';
                    endif;
                ?>
            </p>
            
            <?php
            if (isset($filePresent)):
            ?>
            <p>
                <?php
                    if (Database::isConnected()):
                        echo '<span class="notice success">',
                        'SimpleMC is able to connect to the database.',
                        '</span>';
                    else:
                        echo '<span class="notice warning">',
                        'SimpleMC is NOT able to connect to the database.  Please check your ', 
                        'database connection information.',
                        '</span>';
                    endif;
                ?>
            </p>
            <?php endif;?>
            
            <p id="firebug" class="notice warning"></p>
            
            <h2>Requirements</h2>
            <ol>
                <li>PHP 5.0.5+</li>
                <li>MySQL 5.0+</li>
            </ol>
            
            <h2>Simple MC Sample File Setup</h2>
            <ol>
                <li>Download and unzip SimpleMC to your desired location.</li>
                    <ul>
                        <li>At this point you should have a directory structure that 
                        looks similar to:<br>
                        &nbsp;/root<br>
                        &nbsp;&nbsp;&nbsp;-index.php<br>
                        &nbsp;&nbsp;&nbsp;-/smc<br>
                        </li>
                    </ul>
                <li>Create a mysql database for your project</li>
                <li>Import the sql file into your new database, located at 
                /smc/config/sql/smc.sql</li>
                <li>Duplicate the database connection file located at 
                /smc/config/database.config.php.default.  Call it database.config.php.</li>
                <li>Modify the database connection information for the database 
                connection file you just created.</li>
                <li>Take a look at /smc/config/config.ini.php and modify it if necessary.</li>
                <li><a href="/smc/">Login to the administrator.</a>
                    <ul>
                        <li>un1: admin OR un2: editor</li>
                        <li>pw1: admin OR pw2: editor</li>
                    </ul>
                </li>
                <li>Add some content blocks.</li>
                <li>Use the <a href="smc/core/docs/usage.txt">sample layout page</a> 
                as a guide to what you should include and where you should include it.</li>
                <li>Have fun!</li>
            </ol>
            
            <h2>Running the Demo Application</h2>
            <p>This project does come with a (quickly hobbled together) demonstration application.</p>
            <ol>
                <li><strong>FYI</strong>, even though the demo is located in the smc directory, 
                it is strongly advised that you do NOT create your site files in the smc directory. 
                Instead, drop the smc directory in your site root and reference the necessary files. </li>
                <li>Import the /smc/config/sql/dmtek_demo.sql file into the blocks table that 
                you should have in your SimpleMC database</li>
                <li>If you haven't already, <a href="smc/">login to the administrator.</a>
                    <ul>
                        <li>un1: admin OR un2: editor</li>
                        <li>pw1: admin OR pw2: editor</li>
                    </ul>
                </li>
                <li><a href="<?php echo SMC_DEMO_REL; ?>">Visit the demo</a>.</li>
            </ol>
        </div>
        
        <script type="text/javascript">
            window.onload = function () {
                //check to see if firebug is installed and enabled
                if (window.console && console.firebug) {
                    var firebug = document.getElementById('firebug');
                    firebug.style.display = 'block';
                    firebug.innerHTML = 'It appears that <strong>you have firebug' + 
                    ' enabled</strong>.  Using firebug with SimpleMC will cause' + 
                    ' <strong>significant performance degradation</strong>.';
                }
            }
        </script>
    </body>
</html>
