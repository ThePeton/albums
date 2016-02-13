$(function(){
    var appRouter = new AppRouter;
    var galleryView = new AppListView;
    galleryView.setRouter(appRouter);

    galleryView.listenTo(appRouter, 'route:index', function(){
        var pageAlbums = new AlbumCollection();
        galleryView.clear().setCollection(pageAlbums);
        galleryView.setBackLink(false);
    });

    galleryView.listenTo(appRouter, 'route:album', function(albumId, page){
        if (!page) {
            page = 1;
        }

        var pageAlbums = new ImageCollection;
        galleryView.clear().setCollection(pageAlbums, { albumId: albumId, page: page});
        galleryView.setBackLink(true);
    });

    Backbone.history.start({pushState: true});
    //Backbone.history.start();
});