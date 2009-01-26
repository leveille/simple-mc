<?php
include_once(dirname(__FILE__) . '/config/config.ini.php');

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
    header('Location: ' . ROOT);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Login</title>
        
        <?php if(defined('SMC_DEBUG_MODE') && SMC_DEBUG_MODE): ?>
            <link href="<?php echo SMC_EXT_REL . '/resources/css/ext-all.css'; ?>" rel="stylesheet" type="text/css" media="screen">
            <link href="<?php echo SMC_EXT_REL . '/resources/css/xtheme-gray.css'; ?>" rel="stylesheet" type="text/css" media="screen">
            <link href="<?php echo SMC_CSS_REL . '/login.css'; ?>" rel="stylesheet" type="text/css" media="screen">

            <script type="text/javascript" src="<?php echo SMC_EXT_REL . '/adapter/ext/ext-base.js'; ?>"></script>
            <script type="text/javascript" src="<?php echo SMC_EXT_REL . '/ext-all.js'; ?>"></script>
        <?php else: ?>
            <!-- Implement js/css minify for production -->
        <?php endif; ?>
        
    </head>
    <body>        
        <script type="text/javascript">
            Ext.namespace('SMC_LOGIN');
            
            SMC_LOGIN = function()
            {
                var msgCt, user, password, form, login;
                
                function createBox(t, s)
                {
                    return ['<div class="msg">', '<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>', '<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc"><div id="err-msg"><strong>', t, ':</strong> ', s, '</div></div></div></div>', '<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>', '</div>'].join('');
                }
                
                function authenticate()
                {
                    var submitTo = '<?php echo SMC_CORE_REL; ?>/action/login.php';
                    
                    if (form.form.isValid()) {
                        form.form.submit({
                            url: submitTo,
                            method: 'post',
                            waitMsg: 'Checking credentials ...',
                            scope: this,
                            success: function(o, r){
                            
                                var success = Ext.util.JSON.decode(r.response.responseText).success || false;
                                var message = Ext.util.JSON.decode(r.response.responseText).msg || '';
                                
                                if (success) {
                                    window.location = '<?php echo BASE_URL; ?>';
                                } else {
                                    SMC_LOGIN.msg('Error', message);
                                }
                                
                            },
                            failure: function(o, r){
                            
                                var message = Ext.util.JSON.decode(r.response.responseText).msg || '';
                                SMC_LOGIN.msg('Error', message);
                                
                            }
                        });
                    }
                    else {
                        SMC_LOGIN.msg('Error', 'Please fill in all required fields!');
                    }
                }
                
                return {
                    companyName: '',
                    init: function()
                    {
                        user = new Ext.form.TextField({
                            fieldLabel: 'Username',
                            name: 'user',
                            allowBlank: false,
                            blankText: 'Username is required',
                            anchor: '92%'
                        });
                        
                        password = new Ext.form.TextField({
                            fieldLabel: 'Password',
                            inputType: 'password',
                            name: 'pass',
                            allowBlank: false,
                            blankText: 'Password is required',
                            anchor: '92%'
                        });
                        
                        form = new Ext.form.FormPanel({
                            baseCls: 'x-login',
                            bodyStyle: 'padding:30px;',
                            labelWidth: 65,
                            defaultType: 'textfield',
                            autoWidth: true,
                            border: false,
                            layout: 'form',
                            autoDestroy: false,
                            keys: [{
                                //when the enter key is pressed
                                key: [10, 13],
                                fn: authenticate
                            }],
                            items: [user, password]
                        });
                        
                        login = new Ext.Window({
                            title: SMC_LOGIN.companyName,
                            id: 'login',
                            iconCls: 'icon-unlock',
                            width: 450,
                            height: 280,
                            layout: 'fit',
                            closable: false,
                            resizable: false,
                            plain: true,
                            buttonAlign: 'right',
                            items: form,
                            border: false,
                            draggable: false,
                            buttons: [{
                                text: 'Login',
                                scope: this,
                                type: 'submit',
                                handler: authenticate
                            }]
                        });
                        
                        login.show();
                    },
                    
                    msg: function(title, format)
                    {
                        if (!msgCt) {
                            msgCt = Ext.DomHelper.append("login", {
                                id: 'msg-div'
                            }, true);
                        }
                        msgCt.alignTo("login");
                        var s = String.format.apply(String, Array.prototype.slice.call(arguments, 1));
                        var m = Ext.DomHelper.overwrite(msgCt, {
                            html: createBox(title, s)
                        }, true);
                        m.slideIn('t').pause(4).ghost("t", {
                            remove: true
                        });
                    }
                    
                };
                
            }
            ();
            
            Ext.onReady(function(){
                Ext.QuickTips.init();
                Ext.BLANK_IMAGE_URL = '<?php echo SMC_EXT_REL; ?>/resources/images/default/s.gif';
                Ext.form.Field.prototype.msgTarget = 'side';
                SMC_LOGIN.companyName = "Member Login";
                SMC_LOGIN.init();
            });
        </script>
    </body>
</html>