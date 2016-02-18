define([
    'marionette',
    'gallery/controllers/galleryController'
], function(
    Marionette,
    GalleryController
){
    return Marionette.AppRouter.extend({

        controller: GalleryController,

        appRoutes: {
            "":                      "index",
            "album/:id":             "album",
            "album/:id/page/:page":  "album"
        }

    })
});