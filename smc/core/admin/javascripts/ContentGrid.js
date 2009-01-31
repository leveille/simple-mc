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
ContentGrid = function(viewer, config){
    this.viewer = viewer;
    Ext.apply(this, config);
    
    //snippet editor
    var sptEd;
    
    //Grab the data that represents our content blocks and push it into a data store
    this.store = new Ext.data.JsonStore({
        url: SMC_ADMIN.smc_core + '/admin/action/get-content-blocks.php',
        id: 'content-store',
        root: 'results',
        fields: [{
            name: 'id',
            type: 'int'
        }, 'description', 'source', 'shortcut']
    });
    
    this.store.setDefaultSort('id', "ASC");
    
    //snippet editor
    this.sptEd = new Ext.form.TextField({
        allowBlank: false,
        readOnly: true,
        selectOnFocus: true
    });
    
    //The column setup of the data in our data store
    this.columns = [{
        id: 'id',
        header: "Content ID",
        width: 35,
        sortable: false,
        locked: false,
        renderer: this.formatId,
        dataIndex: 'id'
    }, {
        header: "Description",
        width: 110,
        sortable: false,
        dataIndex: 'description'
    }, {
        header: "Shortcut",
        width: 40,
        sortable: false,
        renderer: this.formatShortcut,
        dataIndex: 'shortcut',
        editor: this.sptEd
    }];
    
    ContentGrid.superclass.constructor.call(this, {
        region: 'center',
        id: 'content-grid',
        loadMask: {
            msg: 'Loading Content...'
        },
        collapsible: true,
        animCollapse: false,
        clicksToEdit: 1,
        
        //allow only one row to be selected at once
        sm: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        
        viewConfig: {
            forceFit: true,
            enableRowBody: true
        },
        
        tbar: [{
            text: 'Add Content',
            tooltip: '<strong>Add Content</strong><br />Add a new content block',
            iconCls: 'icon-add-block',
            handler: this.contentSave.createDelegate(this, ['add'])
        }, ' ', {
            text: 'Edit Content',
            tooltip: '<strong>Edit Content</strong><br />Edit the selected content block',
            iconCls: 'icon-edit-block',
            handler: this.contentSave.createDelegate(this, ['edit'])
        }, {
            text: 'Delete Content',
            tooltip: '<strong>Delete Content</strong><br />Delete the selected content block',
            iconCls: 'icon-delete-block',
            scope: this,
            handler: this.contentDelete
        }, '-', {
            iconCls: 'refresh-icon',
            text: 'Refresh',
            scope: this,
            handler: function(){
                this.ctxRow = null;
                this.store.reload();
            }
        }],
        
        handler: this.gridRender,
        scope: this
    });
    
    this.store.load();
    
    //the selectionmode gives us a hook into the selected row of the grid
    this.gsm = this.getSelectionModel();
    
    this.on('rowcontextmenu', this.onRowContextClick, this);
    this.on('rowdblclick', this.contentSave.createDelegate(this, ['edit']), this, {
        buffer: 150
    });
};

Ext.extend(ContentGrid, Ext.grid.EditorGridPanel, {

    /***
     DESCRIPTION: format the source code for the source grid column
     @val (string)
     ***/
    formatSource: function(val){
        return Ext.util.Format.htmlEncode(Ext.util.Format.ellipsis(val, 175));
    },
        
    /***
     DESCRIPTION: format the developer shortcut for the shortcut grid column
     @val (string)
     ***/
    formatShortcut: function(val){
        return '<span style="color: green">' + Ext.util.Format.htmlEncode(val) + '</span>';
    },
    
    /***
     DESCRIPTION: format the content block id for the id grid column
     @val (string)
     ***/
    formatId: function(val){
        return String.format('<div>{0}</div>', val);
    },
    
    /***
     DESCRIPTION: Render our our grid to the container element
     ***/
    gridRender: function(){
        this.render();
    },
    
    /***
     DESCRIPTION: Setup the grid right click row context menu
     @grid (object), @index (int), @e (object)
     POST: a context menu is displayed
     ***/
    onRowContextClick: function(grid, index, e){
    
        //set the grid selected row to the row which was right clicked
        this.gsm.selectRow(index, false);
        
        if (!this.menu) { // create context menu on first right click
            this.menu = new Ext.menu.Menu({
                id: 'grid-ctx',
                items: [{
                    text: 'View in new tab',
                    iconCls: 'icon-tab-ctxt',
                    scope: this,
                    handler: function(){
                        this.viewer.openTab(this.ctxRecord);
                    }
                }, '-', {
                    iconCls: 'icon-add-block-ctxt',
                    text: 'Add New Content',
                    handler: this.contentSave.createDelegate(this, ['add'])
                }, {
                    iconCls: 'icon-edit-block-ctxt',
                    text: 'Edit This Content',
                    handler: this.contentSave.createDelegate(this, ['edit'])
                }, {
                    iconCls: 'icon-delete-block-ctxt',
                    text: 'Delete This Content',
                    scope: this,
                    handler: this.contentDelete
                }, '-', {
                    iconCls: 'refresh-icon',
                    text: 'Refresh',
                    scope: this,
                    handler: function(){
                        this.ctxRow = null;
                        this.store.reload();
                    }
                }]
            });
            
            this.menu.on('hide', this.onContextHide, this);
        }
        
        e.stopEvent();
        
        if (this.ctxRow) {
            Ext.fly(this.ctxRow).removeClass('x-node-ctx');
            this.ctxRow = null;
        }
        
        this.ctxRow = this.view.getRow(index);
        this.ctxRecord = this.store.getAt(index);
        Ext.fly(this.ctxRow).addClass('x-node-ctx');
        this.menu.showAt(e.getXY());
    },
    
    /***
     DESCRIPTION: Hides the context menu
     ***/
    onContextHide: function(){
        if (this.ctxRow) {
            Ext.fly(this.ctxRow).removeClass('x-node-ctx');
            this.ctxRow = null;
        }
    },
    
    /***
     DESCRIPTION: Sets up ajax call to delete the selected grid record
     @record (object)
     ***/
    contentDelete: function(record){
        //grab the data recrod associated with the selected row
        record = (record && record.data) ? record : this.gsm.getSelected();
        
        Ext.Msg.confirm('Confirm', 'Are you sure you want to delete the selected content?', 
        function(choice){
            if (choice == 'yes') {
                Ext.Ajax.request({
                    url: 'action/delete-content.php',
                    params: {
                        cId: record.data.id
                    },
                    method: 'POST',
                    success: this.contentDeleteSuccess.createDelegate(this, []),
                    failure: function(response, options){
                    
                        var message = options.result.msg || '';
                        
                        Ext.Msg.show({
                            title: 'Error',
                            msg: 'An unexpected error has been encountered. ' + message + 
                                ' Please correct this issue and try again.',
                            buttons: Ext.Msg.OK,
                            icon: Ext.MessageBox.ERROR
                        });
                        
                    }
                });
            }
        }, this);
    },
    
    /***
     DESCRIPTION: Reload the data store (redraw the grid) if an item was successfully deleted
     ***/
    contentDeleteSuccess: function(){
        this.store.reload();
    },
    
    /***
     DESCRIPTION: Sets up the modal window for either an edit or addition of a grid item.
     Sets up and executes an ajax call to save data if the user submits the window form
     @action (string) - 'edit' or 'add'
     NOTE: This entire section could use with some serious refactoring
     Namely, lazy loading so that all these elements do not have to be created with every request.
     ***/  
    contentSave: function(action){
    
        //let's ensure that the user is authenticated prior to saving any content
        var auth = new SMC_AUTH({path : SMC_ADMIN.smc_core});
        auth.authenticate();
        
        var record, panel, win, contentForm, icon;
        var format = Ext.util.Format;
        
        action = action.toLowerCase();
        action == 'add' ? icon = 'icon-add-block-ctxt' : icon = 'icon-edit-block-ctxt';
        
        var contentId = new Ext.form.Hidden({
            name: 'cId'
        });
        
        var contentDescription = new Ext.form.TextField({
            fieldLabel: 'Description',
            name: 'cDescription',
            allowBlank: false,
            anchor: '40%'
        });
        
        var contentMarkup = new Ext.form.TextArea({
            name: 'baiEditor',
            id: 'baiEditor',
            fieldLabel: 'Content',
            allowBlank: false,
            height: SMC_UTILS.viewportHeight() - 200,
            value: '<p>Temporary data holder.</p>',
            anchor: '96%'
        });
        
        var contentForm = new Ext.FormPanel({
            labelWidth: 80, // label settings here cascade unless overridden
            bodyStyle: 'padding:10px',
            autoWidth: true,
            height: SMC_UTILS.viewportHeight() - 110,
            border: false,
            autoDestroy: false,
            labelPad: 10,
            items: [contentId, contentDescription, contentMarkup]
        });
        
        if (action == 'edit') {
            format = Ext.util.Format;
            record = this.gsm.getSelected();
            contentId.setValue(record.data.id);
            contentDescription.setValue(record.data.description);
            contentMarkup.setValue(record.data.source);
        }
        
        this.panel = new Ext.Panel({
            region: 'center',
            margins: '3 3 3 3',
            activeTab: 0,
            items: [{
                title: (record && record.data.description) 
                    ? "Edit '" + record.data.description + "'" 
                    : 'New Content Block',
                iconCls: icon,
                border: false,
                items: [contentForm]
            }]
        });
        
        this.win = new Ext.Window({
            title: 'Content Block Management',
            draggable: false,
            maximizable: true,
            closable: false,
            shadow: true,
            modal: true,
            minWidth: 800,
            width: SMC_UTILS.viewportWidth() - 100,
            minHeight: 500,
            height: SMC_UTILS.viewportHeight() - 60,
            resizable: true,
            layout: 'border',
            items: [this.panel],
            buttons: [{
                text: 'Submit',
                scope: this,
                type: 'submit',
                handler: function(){
                
                    /*
                     * Again, ensure we have an authenticated user
                     */
                    auth.authenticate();
                    
                    var submitTo;
                    
                    if (action == 'edit') {
                        submitTo = 'action/update-content.php';
                    } else {
                        submitTo = 'action/add-content.php';
                    }
                    
                    if (contentForm.form.isValid()) {
                        var editorParams = null;              
                        var oEditor = FCKeditorAPI.GetInstance('baiEditor');
                        editorParams = {
                            cMarkup: oEditor.GetXHTML()
                        };
                        
                        contentForm.form.submit({
                            url: submitTo,
                            method: 'post',
                            params: editorParams,
                            waitMsg: 'Updating Content ...',
                            scope: this,
                            success: function(o, r){
                                this.win.close();
                                this.store.reload();
                            },
                            failure: function(o, r){
                                var message = r.response.statusText || '';
                                
                                Ext.Msg.show({
                                    title: 'Error',
                                    msg: 'An unexpected error has been encountered.  ' + 
                                        'The response from the server was: "' + message + 
                                        '".  If this problem persists, please contact the ' + 
                                        'site administrator.',
                                    buttons: Ext.Msg.OK,
                                    icon: Ext.MessageBox.ERROR
                                });
                                
                            }
                        });
                    }
                    else {
                        Ext.Msg.show({
                            title: 'Error',
                            msg: 'Please fill in all required fields',
                            buttons: Ext.Msg.OK,
                            icon: Ext.MessageBox.ERROR
                        });
                    }
                    
                },
                iconCls: 'icon-submit'
            
            }, {
                text: 'Cancel',
                scope: this,
                handler: function(){
                    this.win.close();
                },
                iconCls: 'icon-cancel-action'
            }]
        });
        
        this.win.show(this.id);
        
        /*
         * Let's adjust the height of our main content container so that it can grow with
         * our resized window
         */
        this.win.formPercentHeight = contentForm.height / this.win.height;
        this.win.editorPercentHeight = SMC_ADMIN.oFCKeditor.Height / this.win.height;
        
        //whenever the window is resized, also resize the editor and formpanel
        this.win.on('resize', function(window, width, height){
        
            //resize the form panel
            contentForm.setHeight(Math.ceil(height * this.win.formPercentHeight));
            Ext.get('baiEditor___Frame').setHeight(Math.ceil(height * this.win.editorPercentHeight));
            
        }, this, {
            buffer: 150
        });
        
        SMC_ADMIN.oFCKeditor.ReplaceTextarea();
    }
});
