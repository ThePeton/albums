var AlbumCollection = Backbone.Collection.extend({

    model: Album,

    url: '/gallery/albums/rpc/'

});