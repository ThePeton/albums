var ImageCollection = Backbone.Collection.extend({
    model: Image,
    url: '/gallery/rpc/',
    /*initialize: function(){
        this.on('all', function(a1, a2, a3){
            console.log(a1, a2, a3);
        });
    }*/
});