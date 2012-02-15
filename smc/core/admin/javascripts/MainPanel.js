
MainPanel = function()
{

    this.preview = new Ext.Panel({
        id: 'preview',
        region: 'south',
        cls: 'preview',
        autoScroll: true,
        tbar: [{
            id: 'tab',
            text: 'View in New Tab',
            iconCls: 'icon-tab',
            disabled: true,
            handler: this.openTab,
            scope: this
        }, '-', {
            split: true,
            text: 'Content Preview',
            tooltip: {
                title: 'Content Preview',
                text: 'Move the preview pane.'
            },
            iconCls: 'icon-preview-bottom',
            handler: this.movePreview.createDelegate(this, []),
            menu: {
                id: 'reading-menu',
                cls: 'reading-menu',
                width: 100,
                items: [{
                    text: 'Bottom',
                    checked: true,
                    group: 'rp-group',
                    checkHandler: this.movePreview,
                    scope: this,
                    iconCls: 'icon-preview-bottom'
                }, {
                    text: 'Right',
                    checked: false,
                    group: 'rp-group',
                    checkHandler: this.movePreview,
                    scope: this,
                    iconCls: 'icon-preview-right'
                }]
            }
        }],
        clear: function()
        {
            this.body.update('');
            var items = this.topToolbar.items;
            items.get('tab').disable();
        }
    });
    
    this.grid = new ContentGrid(this);
    
    //ensure that the grid is refreshed every 3 minutes
    this.task = {
        run: function()
        {
            this.grid.store.reload();
        },
        scope: this,
        interval: 300000
    };
    
    this.runner = new Ext.util.TaskRunner();
    this.runner.start(this.task);
    
    MainPanel.superclass.constructor.call(this, {
        id: 'main-tabs',
        activeTab: 0,
        region: 'center',
        margins: '5 5 5 0',
        resizeTabs: true,
        tabWidth: 150,
        minTabWidth: 120,
        enableTabScroll: true,
        plugins: new Ext.ux.TabCloseMenu(),
        items: {
            id: 'main-view',
            layout: 'border',
            title: 'Manage Content',
            hideMode: 'offsets',
            items: [this.grid, {
                id: 'bottom-preview',
                layout: 'fit',
                items: this.preview,
                height: 235,
                split: true,
                border: false,
                region: 'south'
            }, {
                id: 'right-preview',
                layout: 'fit',
                border: false,
                region: 'east',
                width: 350,
                split: true,
                hidden: true
            }]
        }
    });
    
    //The grid selection model gives us a hook into the selected row 
    this.gsm = this.grid.getSelectionModel();
    
    //When a row is selected we need to update/overwrite the preview pane
    this.gsm.on('rowselect', function(sm, index, record)
    {
        AdminLayout.getTemplate().overwrite(this.preview.body, record.data);
        var items = this.preview.topToolbar.items;
        items.get('tab').enable();
    }, this, {
        buffer: 250
    });
    
    this.grid.store.on('beforeload', this.preview.clear, this.preview);
    this.grid.store.on('load', this.gsm.selectFirstRow, this.gsm);
};

Ext.extend(MainPanel, Ext.TabPanel, {

    /***
     DESCRIPTION: Handle the user choice to open a grid item in a new tab
     @record (object) - The current grid selected record
     POST: Record data is viewable in a new tab
     ***/
    openTab: function(record)
    {
        //grab the current selected record/row
        record = (record && record.data) ? record : this.gsm.getSelected();
        
        //each record has data fields that correspond to the columns of the grid (see ContentGrid columns)
        var d = record.data;
        
        //truncate the description for display at the tab title
        //The description should not contain html, therefore this should be ok
        var truncatedDescription = Ext.util.Format.ellipsis(d.description, 30);
        
        //generate a id for each new tab which is opened
        var id = record.data.id + '_preview_tab';
        var tab = this.getItem(id);
        
        if (!tab) { //Ensure that the id doesn't already exist
            tab = new Ext.Panel({
                id: id,
                cls: 'preview single-preview',
                title: truncatedDescription,
                tabTip: d.description,
                html: AdminLayout.getTemplate().apply(d),
                closable: true,
                autoScroll: true,
                border: true
            });
            this.add(tab);
        }
        
        this.setActiveTab(tab);
    },
    
    /***
     DESCRIPTION: Move the preview pane for a grid record
     @m (object), @pressed (bool)
     POST: Toggles the display of the preview pane between right and bottom
     ***/
    movePreview: function(m, pressed)
    {
    
        if (!m) {
            var readMenu = Ext.menu.MenuMgr.get('reading-menu');
            readMenu.render();
            var items = readMenu.items.items;
            var b = items[0], r = items[1];
            if (b.checked) {
                r.setChecked(true);
            }
            else 
                if (r.checked) {
                    b.setChecked(true);
                }
            return;
        }
        
        if (pressed) {
            var preview = this.preview;
            var right = Ext.getCmp('right-preview');
            var bot = Ext.getCmp('bottom-preview');
            var btn = this.preview.getTopToolbar().items.get(2);
            switch (m.text) {
                case 'Bottom':
                    right.hide();
                    bot.add(preview);
                    bot.show();
                    bot.ownerCt.doLayout();
                    btn.setIconClass('icon-preview-bottom');
                    break;
                case 'Right':
                    bot.hide();
                    right.add(preview);
                    right.show();
                    right.ownerCt.doLayout();
                    btn.setIconClass('icon-preview-right');
                    break;
            }
        }
    }
    
});
