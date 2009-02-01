/**
 * SimpleMC - http://github.com/leveille/simple-mc/tree/master
 * Copyright (C) Blue Atlas Interactive
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 * == END LICENSE ==
 */
Ext.namespace('SMC_AUTH');

SMC_AUTH = function(config){
    
    var defaultConfig = {
        path : '',
        timer : 120
    }
    
    Ext.applyIf(this, config, defaultConfig);
}

Ext.apply(SMC_AUTH.prototype, {
    authTask: null,
    authRunner: null,
    
    authenticate: function(){
        Ext.Ajax.request({
            url: this.path + '/core/action/check_auth.php',
            scope: this,
            success: function(r, o){
                response = Ext.util.JSON.decode(r.responseText);
                if (!response.success) {
                    this.logoutPrompt();
                }
            },
            failure: function(r, o){
                this.logoutPrompt();
            }
        });
    },
    
    logoutPrompt: function(){
        //stop the auth task runner
        this.authRunner.stop(this.authTask);
        
        Ext.MessageBox.confirm('Automatic Logout', 'Your administrative session has expired.  Any changes you made within the last ' + this.timer + ' seconds may not have been saved.  Would you like to authenticate and continue?', function(choice){
            if (choice == 'yes') {
                window.top.location.href = this.path;
            } else {
                window.top.location.href = this.path + '/logout.php';
            }
        }, this);
    },
    
    initiateAuthTaskRunner: function(){
        //start TaskRunner to check authentication every x seconds
        this.authTask = {
            run: function(){
                this.authenticate();
            },
            scope: this,
            interval: this.timer * 1000 //check login every x seconds to ensure user is logged in
        };
        
        this.authRunner = new Ext.util.TaskRunner();
        this.authRunner.start(this.authTask);
    }
});
