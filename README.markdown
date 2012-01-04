#Simple Managed Content (MC)#

SimpleMC is meant to provide an easy way for content editors to edit blocks of content. It is meant for smaller sites, where clients just want to get in, edit some content, and get out.

##Current Release##
* [0.90 Tarball](http://github.com/leveille/simple-mc/tarball/0.90)
* [0.90 Zip](http://github.com/leveille/simple-mc/zipball/0.90)

##Requirements##

* PHP 5.0.5+
* MySQL 5.0+

##Supported Browsers##
* See [Ticket #13](http://leveille.lighthouseapp.com/projects/24238/tickets/13-browser-testing "Ticket 13")

##Simple MC Setup##
* Download and unzip SimpleMC to your desired location.
* At this point you should have a directory structure that looks similar to:
        /root
        -index.php
        -/smc
* Create a mysql database for your project
* Import the sql file into your new database, located at /smc/config/sql/smc.sql
* Duplicate the database connection file located at /smc/config/database.config.php.default. Call it database.config.php.
* Modify the database connection information for the database connection file you just created.
* Duplicate the config file located at /smc/config/config.ini.php.default. Call it config.ini.php.
* Take a look at /smc/config/config.ini.php and modify it if necessary.
* Visit the landing page for SMC (the root directory index.php page) and take care of any outstanding issues.  Outstanding issues would be highlighted in the "Pre-flight Check" section.  As soon as you have everything set up properly, you can delete this page.
* Login to the administrator.
    - un1: admin OR un2: editor
    - pw1: admin OR pw2: editor
* Add some content blocks.
* Create a test page (in the root of your site).  For example, test.php.
* Use the [sample layout page](http://github.com/leveille/simple-mc/blob/04f112384fcc52bbb5ea0143742587f549a43854/smc/core/docs/usage.txt "sample layout page") as a guide to what you should include and where you should include it in test.php.
* Visit the administrator and copy the code shortcut for one of the content blocks you created.  Paste this shortcut in the test.php page you just created.
* Visit the page in your browser and you should be able to edit the content block.

##Setting up the Demo##
* FYI, even though the demo is located in the smc directory, it is strongly advised that you do NOT create your site files in the smc directory. Instead, drop the smc directory in your site root and reference the necessary files.
* Import the /smc/config/sql/smc_demo.sql file into the blocks table that you should have in your SimpleMC database
* If you haven't already, login to the administrator.
    - un1: admin OR un2: editor
    - pw1: admin OR pw2: editor
* Visit the demo.
