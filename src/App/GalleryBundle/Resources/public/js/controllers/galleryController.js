var GalleryController = function(view, router){

    this.index = function(){
        var pageAlbums = new AlbumCollection();
        view.clear().setCollection(pageAlbums);
        view.setBackLink(false);
    };

    this.album = function(albumId, page){
        if (!page) {
            page = 1;
        }

        var pageImages = new ImageCollection({albumId: albumId}, {state: {currentPage: parseInt(page)}});
        view.clear().setCollection(pageImages);
        view.setBackLink(true);
    };

    view.listenTo(router, 'route:index', this.index);
    view.listenTo(router, 'route:album', this.album);
}