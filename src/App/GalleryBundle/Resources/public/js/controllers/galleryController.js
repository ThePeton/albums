define([
    'gallery/collections/albumCollection',
    'gallery/collections/imageCollection'
], function(
    AlbumCollection,
    ImageCollection
){

    return function(view, router){

        index = function(){
            var pageAlbums = new AlbumCollection();
            view.clear().setCollection(pageAlbums);
            view.setBackLink(false);
        };

        album = function(albumId, page){
            if (!page) {
                page = 1;
            }

            var pageImages = new ImageCollection({albumId: albumId}, {state: {currentPage: parseInt(page)}});
            view.clear().setCollection(pageImages);
            view.setBackLink(true);
        };

        view.listenTo(router, 'route:index', index);
        view.listenTo(router, 'route:album', album);

    }
});