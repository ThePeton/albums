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
            "":                      "albums",
            "album/:id":             "images",
            "album/:id/page/:page":  "images"
        }

    })
});