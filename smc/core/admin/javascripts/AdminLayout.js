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
AdminLayout = {};

Ext.onReady(function(){

    Ext.form.Field.prototype.msgTarget = 'side';
    Ext.state.Manager.setProvider(new Ext.state.SessionProvider({
        state: Ext.appState
    }));
    Ext.QuickTips.init();
    
    /*
     * Grab the markup which will represent a template for our content grid
     */
    var tpl = Ext.Template.from('preview-tpl', {
        compiled: true,
        getBody: function(v, all){
            return Ext.util.Format.stripScripts(v || all.description);
        }
    });
    
    /*
     * Grab the template format and return it where it needs to be used
     */
    AdminLayout.getTemplate = function(){
        return tpl;
    };
    
    var sidebar = new AdminPanel();
    var mainPanel = new MainPanel();
    
    var viewport = new Ext.Viewport({
        layout: 'border',
        items: [new Ext.BoxComponent({
            region: 'north',
            el: 'header',
            height: 76
        }), sidebar, mainPanel, new Ext.BoxComponent({
            region: 'south',
            el: 'south',
            height: 20
        })]
    });
});
