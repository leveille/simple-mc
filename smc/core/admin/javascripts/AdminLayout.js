/* SVN FILE: $Id: AdminLayout.js 116 2008-08-27 02:21:17Z leveillej $ */
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
