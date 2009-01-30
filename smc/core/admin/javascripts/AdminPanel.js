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
AdminPanel = function()
{

    var Tree = Ext.tree, tree2, root, help;
    
    this.tree2 = new Ext.tree.TreePanel({
        id: 'cms-users',
        title: 'Manage Users',
        border: false,
        loader: new Ext.tree.TreeLoader({
            dataUrl: 'action/get-users.php'
        }),
        rootVisible: false,
        lines: true,
        enableDD: true,
        animate: true,
        containerScroll: true,
        autoScroll: true,
        tbar: [{
            tooltip: '<strong>Add User</strong><br />Add an additional user',
            text: 'Add User',
            iconCls: 'icon-add-user',
            id: 'cms-add-user',
            handler: this.userSave.createDelegate(this, ['add'])
        }, ' ', {
            tooltip: '<strong>Edit User</strong><br />Edit the user selected from the tree below',
            text: 'Edit User',
            iconCls: 'icon-edit-user',
            id: 'cms-edit-user',
            handler: this.userSave.createDelegate(this, ['edit'])
        }, {
            tooltip: '<strong>Delete User</strong><br />Delete the user selected from the tree below',
            text: 'Delete User',
            iconCls: 'icon-delete-user',
            id: 'cms-delete-user',
            handler: this.userDelete,
            scope: this
        }],
        tools: [{
            id: 'refresh',
            on: {
                click: function()
                {
                    var tree = Ext.getCmp('cms-users');
                    tree.body.mask('Loading', 'x-mask-loading');
                    tree.root.collapse(true, false);
                    tree.root.reload();
                    tree.body.unmask();
                    tree.root.expand(true, true);
                }
            }
        }]
    });
    
    new Tree.TreeSorter(this.tree2, {
        folderSort: true
    });
    
    // set the root node
    this.root = new Tree.AsyncTreeNode({
        text: 'Users',
        draggable: false,
        allowDrop: false,
        id: 'source'
    });
    
    this.tree2.setRootNode(this.root);
    
    AdminPanel.superclass.constructor.call(this, {
        region: 'west',
        title: 'Administration',
        iconCls: 'icon-accordian',
        collapsible: true,
        split: true,
        width: 275,
        minSize: 175,
        maxSize: 400,
        margins: '5 0 5 5',
        layout: 'accordion',
        layoutConfig: {
            animate: true
        },
        items: [this.tree2],
        handler: this.treeRender,
        scope: this
    });
    
    this.gsm = this.tree2.getSelectionModel();
    
    this.tree2.on('movenode', this.onNodeMove, this);
    this.tree2.on('dblclick', this.userSave.createDelegate(this, ['edit']), this);
    this.tree2.on('click', this.onNodeClick, this);
    this.tree2.on('contextmenu', this.onContextMenu, this);
    
    //ensure that these buttons cannot be clicked until a valid node is selected
    this.tree2.on('beforerender', function(cmp)
    {
        var items = cmp.topToolbar.items;
        items.get('cms-edit-user').disable();
        items.get('cms-delete-user').disable();
    }, this, {
        buffer: 250
    });
    
};

//Class AdminPanel extends Panel
Ext.extend(AdminPanel, Ext.Panel, {

    /***
     DESCRIPTION: Set up the right click context menu for tree nodes
     @node (object), @e (event object)
     ***/
    onContextMenu: function(node, e)
    {
    
        //auto select the node which has been right clicked
        node.select();
        
        if (!this.menu) {
            this.menu = new Ext.menu.Menu({
                id: 'feeds-ctx',
                items: [{
                    iconCls: 'icon-add-user-ctxt',
                    text: 'Add New User',
                    handler: this.userSave.createDelegate(this, ['add'])
                }, {
                    text: 'Edit User',
                    iconCls: 'icon-edit-user-ctxt',
                    scope: this,
                    handler: this.userSave.createDelegate(this, ['edit'])
                }, {
                    iconCls: 'icon-delete-user-ctxt',
                    text: 'Delete User',
                    handler: this.userDelete,
                    scope: this
                }, '-', {
                    iconCls: 'refresh-icon',
                    text: 'Refresh',
                    scope: this,
                    handler: function()
                    {
                        this.ctxNode = null;
                        this.root.reload();
                    }
                }]
            });
            this.menu.on('hide', this.onContextHide, this);
        }
        
        if (this.ctxNode) {
            this.ctxNode.ui.removeClass('x-node-ctx');
            this.ctxNode = null;
        }
        
        var items = this.tree2.topToolbar.items;
        
        //disable buttons if a tree node is not a leaf
        if (node.isLeaf()) {
            items.get('cms-edit-user').enable();
            items.get('cms-delete-user').enable();
            
            this.ctxNode = node;
            this.ctxNode.ui.addClass('x-node-ctx');
            this.menu.showAt(e.getXY());
        }
        else {
            items.get('cms-edit-user').disable();
            items.get('cms-delete-user').disable();
        }
        
    },
    
    /***
     DESCRIPTION: Hides the tree node context menu
     ***/
    onContextHide: function()
    {
        if (this.ctxNode) {
            this.ctxNode.ui.removeClass('x-node-ctx');
            this.ctxNode = null;
        }
    },
    
    /***
     DESCRIPTION: enable/disable toolbar items based on the selected node
     @node (object), @e (event object)
     ***/
    onNodeClick: function(node, e)
    {
        var items = this.tree2.topToolbar.items;
        
        if (node.isLeaf()) {
            items.get('cms-edit-user').enable();
            items.get('cms-delete-user').enable();
        }
        else {
            items.get('cms-edit-user').disable();
            items.get('cms-delete-user').disable();
        }
    },
    
    /***
     DESCRIPTION: setup drag/drop functionality for treenode leaf.  Also submits/saves data changes
     @tree (object), @node (object), @oldParent (object), @newParent (object), @index (int)
     ***/
    onNodeMove: function(tree, node, oldParent, newParent, index)
    {
    
        if (node.isLeaf()) {
            Ext.Msg.confirm('Confirm', 'Are you sure you want to change the role of the selected user?', function(choice)
            {
                if (choice == 'yes') {
                    Ext.Ajax.request({
                        url: 'action/update-user-drag.php',
                        params: {
                            uId: parseInt(node.id).toString(),
                            rId: parseInt(newParent.id)
                        },
                        method: 'POST',
                        failure: function(response, options)
                        {
                        
                            var message = options.result.msg || '';
                            
                            Ext.Msg.show({
                                title: 'Error',
                                msg: 'An unexpected error has been encountered. ' + message + ' Please correct this issue and try again.',
                                buttons: Ext.Msg.OK,
                                icon: Ext.MessageBox.ERROR
                            });
                            
                        }
                    });
                }
                
                tree.root.reload();
                
            }, this);
        }
    },
    
    /***
     DESCRIPTION: Render the tree to it's container and expand the nodes
     ***/
    treeRender: function()
    {
        this.tree2.render();
        this.root.expand(true, true);
    },
    
    /***
     DESCRIPTION: Sets up ajax call to delete a user
     ***/
    userDelete: function()
    {
        var node = this.gsm.getSelectedNode();
        var items = this.tree2.topToolbar.items;
        
        if (node.isLeaf()) {
            Ext.Msg.confirm('Confirm', 'Are you sure you want to delete the selected user?', function(choice)
            {
                if (choice == 'yes') {
                    Ext.Ajax.request({
                        url: 'action/delete-user.php',
                        params: {
                            uId: parseInt(node.id),
                            uName: node.text
                        },
                        method: 'POST',
                        success: this.userDeleteSuccess.createDelegate(this, []),
                        
                        //bug.  When the request results in a failure this function does not get called
                        failure: function(response, options)
                        {
                            var message = (options && options.result.msg) ? options.result.msg : '';
                            
                            Ext.Msg.show({
                                title: 'Error',
                                msg: 'An unexpected error has been encountered. ' + message + ' Please correct this issue and try again.',
                                buttons: Ext.Msg.OK,
                                icon: Ext.MessageBox.ERROR
                            });
                        }
                    });
                }
            }, this);
            
            items.get('cms-edit-user').disable();
            items.get('cms-delete-user').disable();
            
        }
        
    },
    
    /***
     DESCRIPTION: Reload the data store (redraw the tree) if an item was successfully deleted
     ***/
    userDeleteSuccess: function()
    {
        this.tree2.root.reload();
    },
    
    /***
     DESCRIPTION: Sets up the modal window for either an edit or addition of a user.
     Sets up and executes an ajax call to save data if the user submits the window form
     @action (string) - 'edit' or 'add'
     ***/
    userSave: function(action)
    {
    
        var node = this.gsm.getSelectedNode();
        
        action = action.toLowerCase();
        
        //If a selected node is not a leaf we don't want to continue
        if (action == 'edit' && !node.isLeaf()) {
            return;
        }
        
        var panel, win, contentForm, icon;
        var format = Ext.util.Format;
        var userForm, userId, userName, userRole, userPassword1, userPassword2, passwordFieldSet;
        
        action == 'add' ? icon = 'icon-add-user-ctxt' : icon = 'icon-edit-user-ctxt';
        
        userId = new Ext.form.Hidden({
            name: 'uId'
        });
        
        userName = new Ext.form.TextField({
            fieldLabel: 'Username',
            name: 'uUsername',
            allowBlank: false,
            anchor: '92%'
        });
        
        userRole = new Ext.form.ComboBox({
            fieldLabel: 'Role',
            name: 'uRole',
            allowBlank: false,
            hiddenName: 'roleId',
            forceSelection: true,
            valueField: 'id',
            displayField: 'role',
            editable: false,
            triggerAction: 'all',
            emptyText: 'Select a role...',
            selectOnFocus: true,
            anchor: '90%',
            
            //grab the data which represents our user base and push it into a data store.
            //An example of the data can be found in /smc/admin/action/users.json
            store: new Ext.data.JsonStore({
                url: 'action/get-roles.php',
                id: 'roles-store',
                root: 'results',
                fields: [{
                    name: 'id',
                    type: 'int'
                }, 'role'],
                autoLoad: true
            })
        });
        
        var pWordError = "";
        
        if (action == 'edit') {
            pWordError = "If you want to reset this user's password this field is required.  Otherwise collapse the \"Reset Password\" panel.";
        } else {
            pWordError = "A password is required and needs to be verified.";
        }
        
        userPassword1 = new Ext.form.TextField({
            fieldLabel: 'Password',
            inputType: 'password',
            name: 'uPassword1',
            allowBlank: false,
            blankText: pWordError,
            anchor: '92%'
        });
        
        userPassword2 = new Ext.form.TextField({
            fieldLabel: 'Repeat Password',
            inputType: 'password',
            name: 'uPassword2',
            allowBlank: false,
            anchor: '92%',
            blankText: pWordError,
            
            //Ensure that the two passwords match
            validator: function(value)
            {
                if (userPassword1.getValue() == value) {
                    return true;
                } else {
                    return 'Passwords must match';
                }
            }
        });
        
        //If we are in add mode the password fields must be entered.
        //In edit mode we want to give the ability to modify a password or leave it alone
        //Hence the reason why we set collapsible to true if we are in edit mode and false otherwise
        passwordFieldSet = new Ext.form.FieldSet({
            title: action == 'edit' ? "Reset Password" : "Set Password",
            collapsible: action == 'edit' ? true : false,
            defaultType: 'textfield',
            autoHeight: true,
            collapsed: action == 'edit' ? true : false,
            items: [userPassword1, userPassword2]
        });
        
        //When collapsed be sure to disable the password fields so that they are not required
        passwordFieldSet.on('collapse', function(el)
        {
            userPassword1.disable();
            userPassword2.disable();
        }, this);
        
        //When expanded be sure to enable the password fields so that they are required
        passwordFieldSet.on('expand', function(el)
        {
            userPassword1.enable();
            userPassword2.enable();
        }, this);
        
        userForm = new Ext.FormPanel({
            labelWidth: 100,
            bodyStyle: 'padding:10px',
            autoWidth: true,
            border: false,
            layout: 'form',
            autoDestroy: false,
            items: [userId, userName, userRole, passwordFieldSet]
        });
        
        //In edit mode we need to set the values of the form elements
        //to the values of the respective tree node leaf
        if (action == 'edit') {
            format = Ext.util.Format;
            userId.setValue(parseInt(node.id));
            userName.setValue(node.text);
            userRole.setValue(parseInt(node.parentNode.id).toString());
        }
        
        this.panel = new Ext.Panel({
            region: 'center',
            margins: '3 3 3 3',
            activeTab: 0,
            defaults: {
                autoScroll: true
            },
            items: [{
                title: (action == "edit") ? "Edit '" + node.text + "'" : 'New User',
                iconCls: icon,
                border: false,
                autoScroll: true,
                items: [userForm]
            }]
        });
        
        this.win = new Ext.Window({
            title: 'User Management',
            closable: true,
            modal: true,
            width: 350,
            resizable: false,
            layout: 'form',
            items: [this.panel],
            buttons: [{
                text: 'Submit',
                scope: this,
                type: 'submit',
                handler: function()
                {
                
                    var submitTo;
                    
                    if (action == 'edit') {
                        submitTo = 'action/update-user.php';
                    }
                    else {
                        submitTo = 'action/add-user.php';
                    }
                    
                    if (userForm.form.isValid()) {
                        userForm.form.submit({
                            url: submitTo,
                            method: 'post',
                            waitMsg: 'Updating User ...',
                            scope: this,
                            success: function(response, options)
                            {
                                this.win.hide();
                                this.root.reload();
                            },
                            failure: function(response, options)
                            {
                            
                                var message = options.result.msg || '';
                                
                                Ext.Msg.show({
                                    title: 'Error',
                                    msg: 'An unexpected error has been encountered. ' + message + ' Please correct this issue and try again.',
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
                handler: function()
                {
                    this.win.hide();
                },
                iconCls: 'icon-cancel-action'
            }]
        });
        
        this.win.show(this.id);
        
    }
});
