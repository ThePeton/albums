var ImageCollection = Backbone.Collection.extend({

    model: Image,

    url: '/gallery/images/rpc/',

    albumId: null,

    page: 1,

    initialize: function(options){
        if (options && options.albumId) {
            this.albumId = options.albumId;
        }

        if (options && options.page) {
            this.page = options.page;
        }
    }

});