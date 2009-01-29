//Thanks http://codylindley.com/Webdev/295/javascript-get-page-height-with-scroll
var smc_client = {
    viewportWidth: function(){
        return self.innerWidth || (document.documentElement.clientWidth || document.body.clientWidth);
    },
    
    viewportHeight: function(){
        return self.innerHeight || (document.documentElement.clientHeight || document.body.clientHeight);
    },
    
    viewportSize: function(){
        return {
            width: this.viewportWidth(),
            height: this.viewportHeight()
        };
    }
};
