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

        albums: function(){
            var pageAlbums = new AlbumCollection(defaultAlbumsCollection);
            var view = new GalleryView;

            view.render();
            $('#gallery-wrapper').empty().append(view.$el);

            view.getRegion('regionGallery').show( new AlbumsCollectionView({ collection: pageAlbums }) );
        },

        images: function(albumId, page){
            if (!page) {
                page = 1;
            }

            var pageImages = new ImageCollection(
                defaultImagesCollection ? defaultImagesCollection[1] : [],
                {
                    state: defaultImagesCollection ? defaultImagesCollection[0] : {'currentPage': parseInt(page)},
                    albumId: albumId
                }
            );
            defaultImagesCollection = null;

            var view = new GalleryView;

            view.render();
            $('#gallery-wrapper').empty().append(view.$el);

            view.getRegion('regionGallery').show( new ImagesCollectionView({ collection: pageImages }) );
            $('#gallery-wrapper .back-link').show();
        }

    }
});