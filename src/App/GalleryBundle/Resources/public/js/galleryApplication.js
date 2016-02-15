var GalleryApplication = function(){
    this.router = null;
    this.view = null;
    this.controller = null;

    this.start = function(){
        this.router = new AppRouter;

        this.view = new AppGalleryView;
        this.view.setRouter(this.router);

        this.controller = new GalleryController(this.view, this.router);

        Backbone.history.start({pushState: true});
    }
}
