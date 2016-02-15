define([
    'jquery',
    'backbone',
    'gallery/routers/appRouter',
    'gallery/views/galleryView',
    'gallery/controllers/galleryController'
], function(
    $,
    Backbone,
    AppRouter,
    GalleryView,
    GalleryController
){

    return {
        router: null,
        view: null,
        controller: null,

        start: function(){
            this.router = new AppRouter;

            this.view = new GalleryView;
            this.view.setRouter(this.router);

            this.controller = new GalleryController(this.view, this.router);

            Backbone.history.start({pushState: true});
        }
    }
});