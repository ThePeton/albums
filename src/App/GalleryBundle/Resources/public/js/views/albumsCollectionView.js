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
            if (this.collection.length == 0) {
                this.collection.fetch();
            }
        }

    });
});