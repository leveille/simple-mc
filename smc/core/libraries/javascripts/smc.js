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
     * Return id associated w/ content block
     * -for now we assume id is an int
     * @param {Object} $this
     */
    function getId($this)
    {
        var id = parseInt($this.id, 10).toString();
        return id;
    }
    
    /**
     * This function is responsible for setting up the html editor 
     * dialog window with the appropriate data and element id
     * 
     * @param {Object} $this
     * @scope private
     */
    function showDialog($this)
    {
        getCurrentContentBlock = function(){
            return $this;
        };
        
        getEditorData = function(){
            var oEditor = FCKeditorAPI.GetInstance(SMC.editorName);
            return oEditor.GetXHTML();
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
                        save(dialog, getEditorData(), getCurrentContentBlock());
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
                save(dialog, getEditorData(), getCurrentContentBlock());
            });
            
            dialog.add(new Ext.Panel('bai-center'));
        }
        
        //listen for a resize of the dialog window   
        dialog.on('resize', function(window, width, height){
            Ext.get(SMC.editorName + '___Frame').setHeight(dialog.getInnerHeight());            
        }, this);
               
        dialog.setSize(smc_client.viewportWidth() - 100, smc_client.viewportHeight() - 60)
            .setTitle("Content Editor " + $this.title)
            .show($this);
    }
    
    /**
     * This function is responsible for saving 
     * edited content back to the database
     * 
     * @param {Object} dialog
     * @param {String} blockData
     * @param {Object} $this
     * @scope private
     */
    function save(dialog, blockData, $this)
    {
        /*
         * let's ensure that the user is authenticated prior to saving any content
         * running the check here takes care of the instance when the editor window 
         * is opened, and the admin walks away and comes back
         */
        
        var auth = new Auth({path : SMC.smcCore});
        auth.authenticate()
        
        var id = getId($this);
        var title = $this.title;
        
        Ext.Ajax.request({
            url : SMC.smcCore + '/action/update.php',
            params: {
                element_id: id,
                update_value: blockData,
                element_description : title
            },
            method: 'POST',
            success: function(result, request){
                dialog.hide();
                Ext.DomHelper.overwrite(id, "", false);
                Ext.DomHelper.append(id, blockData, false);
                Ext.get(id).frame("93BCF4", 1, {
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
    
    function populateEditor($this)
    {
        try {
            //Do not remove the following line, as it is necessary to ensure that
            //the editor will pull valid content from the text area
            document.getElementById(SMC.editorName).value = $this.innerHTML;
            var oEditor = FCKeditorAPI.GetInstance(SMC.editorName);
            oEditor.SetHTML($this.innerHTML);
            showDialog($this);
        } catch (err) {
            error(err.toString());
        }
    }
    
    return {
        cp : '', //cookie provider
        editorName : '',
        smcCore : '',
        init: function()
        {
            //set up the authentication timer to ensure authentication
            //check every x seconds
            //ensure this user remains logged in
            var auth = new Auth({path : SMC.smcCore, timer : 120});
            auth.initiateAuthTaskRunner()
            
            /***
             Iterate over each editable block and append a shortcut to the top admin bar
             ***/
            Ext.select('.editable').each(function(e){
                //var blockId = this.dom.id;
                var description = this.dom.title;
                Ext.DomHelper.append(
                    'bai_shortcuts', 
                    '<span class="bai_block"><a class="bai_shortcut" href="javascript:void(0);" id="' + 
                    this.dom.id + '-shortcut">' + description + '</a></span>'
                );
            });
            
            Ext.addBehaviors({
            
                'div.editable@mouseover': function(e, target){
                    Ext.get(getId(this)).addClass('focus');
                },
                
                'div.editable@mouseout': function(e, target){
                    Ext.get(getId(this)).removeClass('focus');
                },
                
                'div.editable@click': function(e, target){
                    //assumming we have links in the editable content block,
                    //prevent links in those blocks from linking when clicked
                    //e.preventDefault();
                    
                    //ensure we have an authenticated user before allowing this request
                    auth.authenticate();

                    Ext.get(getId(this)).removeClass('focus');
                    populateEditor(this);
                },
                
                'a.bai_shortcut@mousedown': function(e, target){
                    var $that = Ext.get(getId(this));
                    $that.removeClass('focus');
                    populateEditor($that.dom);
                },
                
                'a.bai_shortcut@mouseover': function(e, target){
                    Ext.get(getId(this)).addClass('focus');
                },
                
                'a.bai_shortcut@mouseout': function(e, target){
                    Ext.get(getId(this)).removeClass('focus');
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