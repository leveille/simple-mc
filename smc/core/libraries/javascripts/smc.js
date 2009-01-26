Ext.namespace('SMC');

SMC = function(){
    var dialog, oEditor, HtmlEditor, getBlockId, 
        getEditorData, setEditorTitle, oFCKeditor, 
        oEditor, clickCount = 0, errorTriggered = false;
        
    /**
     * Sets the value of our errorTrigger
     * 
     * @param {Boolean} value
     * @scope private
     */
    function setError(value)
    {
        errorTriggered = value;
    }
    
    /**
     * Takes a javascript error and writes it to a log file
     * 
     * @param {Object} err
     * @scope private
     */
    function logJsError(err)
    {
        if (err == "") {
            err = "No error reported";
        }
        
        Ext.Ajax.request({
            url : SMC.smcCore + '/action/log_js_error.php',
            params: {
                err_data: err
            },
            method: 'POST',
            success: function(result, request)
            {
                Ext.Msg.alert('Error Logged', 'The date, time, and nature' + 
                    ' of this error have been logged.  Please notify the administrator.');
            },
            failure: function(result, request)
            {
                Ext.Msg.alert('Failed to Log Data', 'The nature of this error' + 
                    ' could not be logged.  Please notify the administrator of this application.');
            }
        });
    }
    
    /**
     * If an error is caught it is handled here
     * 
     * @param {String} err
     * @scope private
     */    
    function error(err)
    {
        setError(true);
        Ext.Msg.alert('Error Encountered?', 'The application has' + 
            ' encountered an unexpected error and cannot continue.', 
            logJsError.createCallback(err));
    }
    
    /**
     * This function is responsible for setting up the html editor 
     * dialog window with the appropriate data and element id
     * 
     * @param {Object} requestor
     * @param {String} blockId
     * @scope private
     */
    function showDialog(requestor, blockId)
    {
        getBlockId = function(){
            return blockId;
        };
        
        getEditorData = function(){
            var oEditor = FCKeditorAPI.GetInstance(SMC.editorName);
            return oEditor.GetXHTML();
        };

        getBlockTitle = function(){
            return requestor.title;
        };
        
        if (!dialog) {
            dialog = new Ext.Window({
                modal: true,
                resizable: true,
                shadow: true,
                draggable: false,
                maximizable: true,
                closable: false,
                minHeight: 312,
                minWidth: 572,
                keys: [{
                    //when the enter key is pressed
                    key: [10, 13],
                    scope: this,
                    fn: function()
                    {
                        save(getEditorData(), dialog, getBlockId());
                    }
                }]
            });
            
            dialog.addButton({
                text: 'Cancel',
                scope: this
            }, function(){
                cancel(dialog);
            });
            
            dialog.addButton({
                text: 'Submit',
                scope: this
            }, function(){
                save(getEditorData(), dialog, getBlockId(), getBlockTitle());
            });
            
            dialog.add(new Ext.Panel('bai-center'));
        }
        
        //listen for a resize of the dialog window   
        dialog.on('resize', function(window, width, height){
            Ext.get(SMC.editorName + '___Frame').setHeight(dialog.getInnerHeight());            
        }, this);
                
        dialog.setSize(577, 385)
            .setTitle("Content Editor " + requestor.title)
            .show(requestor);
    }
    
    /**
     * This function is responsible for saving 
     * edited content back to the database
     * 
     * @param {String} blockData
     * @param {Object} dialog
     * @param {String} blockId
     * @param {String} description
     * @scope private
     */
    function save(blockData, dialog, blockId, description)
    {
        /*
         * let's ensure that the user is authenticated prior to saving any content
         * running the check here takes care of the instance when the editor window 
         * is opened, and the admin walks away and comes back
         */
        //var auth = new Auth();
        //auth.authenticate();
        
        var el = Ext.get(blockId);
        Ext.Ajax.request({
            url : SMC.smcCore + '/action/update.php',
            params: {
                element_id: blockId,
                update_value: blockData,
                element_description : description
            },
            method: 'POST',
            success: function(result, request){
                dialog.hide();
                Ext.DomHelper.overwrite(blockId, "", false);
                Ext.DomHelper.append(blockId, blockData, false);
                el.frame("93BCF4", 1, {
                    duration: 1
                });
            },
            failure: function(result, request){
                Ext.MessageBox.alert('Save Request', 'The application was' + 
                    ' unable to save your data.  Try again in a few moments.' + 
                    '  If this problem persists please contact the application administrator.');
            }
        });
    }
    
    /**
     * This function is responsible making sure no content blocks remain locked
     * @param {Object} dialog
     */
    function cancel(dialog)
    {
        dialog.hide();
    }
    
    function populateEditor(requestor, blockId)
    {
        var el = Ext.get(blockId);
        var blockData = el.dom.innerHTML;

        try {
            //Do not remove the following line, as it is necessary to ensure that
            //the editor will pull valid content from the text area
            document.getElementById('baiEditor').value = blockData;
            var oEditor = FCKeditorAPI.GetInstance('baiEditor');
            oEditor.SetHTML(blockData);
        } catch (err) {
            error(err.toString());
        } finally {
            showDialog(requestor, blockId);
        }
    }
    
    return {
        cp : '', //cookie provider
        editorName : '',
        init: function()
        {
            //set up the authentication timer to ensure authentication
            //check every x seconds
            //var auth = new Auth();
            //auth.initiateAuthTaskRunner();
            
            /***
             Iterate over each editable block and append a shortcut to the top admin bar
             ***/
            Ext.select('.editable').each(function(e){
                var blockId = this.dom.id;
                var description = this.dom.title;
                Ext.DomHelper.append(
                    'bai_shortcuts', 
                    '<span class="bai_block"><a class="bai_shortcut" href="javascript:void(0);" id="' + 
                    blockId + '-shortcut">' + description + '</a></span>'
                );
            });
            
            Ext.addBehaviors({
            
                'div.editable@mouseover': function(e, target){
                    Ext.get(this.id).addClass('focus');
                },
                
                'div.editable@mouseout': function(e, target){
                    Ext.get(this.id).removeClass('focus');
                },
                
                'div.editable@click': function(e, target){
                    //assumming we have links in the editable content block,
                    //prevent links in those blocks from linking when clicked
                    e.preventDefault();
                    
                    //ensure we have an authenticated user before allowing this request
                    //auth.authenticate();
                    
                    Ext.get(this.id).removeClass('focus');
                    populateEditor(this, this.id);
                },
                
                'a.bai_shortcut@mousedown': function(e, target){
                    var blockId = parseInt(this.id, 10).toString();
                    Ext.get(blockId).removeClass('focus');
                    populateEditor(this, blockId);
                },
                
                'a.bai_shortcut@mouseover': function(e, target){
                    var blockId = parseInt(this.id, 10).toString();
                    Ext.get(blockId).addClass('focus');
                },
                
                'a.bai_shortcut@mouseout': function(e, target){
                    var blockId = parseInt(this.id, 10).toString();
                    Ext.get(blockId).removeClass('focus');
                }
                
            });            
        },
                
        getCookie: function(name){
            BAI.cp.get(name, null);
        },
        
        setCookie: function(name, value){
            BAI.cp.set(name, value);
        },
        
        deleteCookie: function(name){
            BAI.cp.clear(name);
        }
    }
}();