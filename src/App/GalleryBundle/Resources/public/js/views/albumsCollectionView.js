define([
    'marionette',
    'gallery/views/albumView'
], function(
    Marionette,
    AlbumView
){
    return Marionette.CollectionView.extend({

        childView: AlbumView,

        onBeforeRender: function(){
            this.collection.fetch();
        }

    });
});