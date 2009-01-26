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
