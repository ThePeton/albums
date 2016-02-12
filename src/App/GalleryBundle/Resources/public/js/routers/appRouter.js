var AppRouter = Backbone.Router.extend({

    routes: {
        "":                  "index",
        "album/:id":         "album",
        "album/:id/:page":   "album"
    },

    index: function(){
        //
    },

    album: function(albumId, page){
        //
    }
});