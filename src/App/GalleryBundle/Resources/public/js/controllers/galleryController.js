define([
    'gallery/views/galleryView',
    'gallery/collections/albumCollection',
    'gallery/collections/imageCollection',
    'gallery/views/albumsCollectionView',
    'gallery/views/imagesCollectionView'
], function(
    GalleryView,
    AlbumCollection,
    ImageCollection,
    AlbumsCollectionView,
    ImagesCollectionView
){
    return {

        index: function(){
            var pageAlbums = new AlbumCollection;
            var view = new GalleryView;

            view.render();
            $('#gallery-wrapper').empty().append(view.$el);

            view.getRegion('regionGallery').show( new AlbumsCollectionView({ collection: pageAlbums }) );
        },

        album: function(albumId, page){
            if (!page) {
                page = 1;
            }

            var pageImages = new ImageCollection({albumId: albumId}, {state: {currentPage: parseInt(page)}});
            var view = new GalleryView;

            view.render();
            $('#gallery-wrapper').empty().append(view.$el);

            view.getRegion('regionGallery').show( new ImagesCollectionView({ collection: pageImages }) );
            $('#gallery-wrapper .back-link').show();
        }

    }
});