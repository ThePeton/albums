define([
    'backbone',
    'marionette',
    'gallery/routers/appRouter',
], function(
    Backbone,
    Marionette,
    AppRouter
){

    return Marionette.Application.extend({

        onStart: function(){
            var router = new AppRouter;

            this.reqres.setHandler("getRouter", function(){
                return router;
            });

            Backbone.history.start({pushState: true});
        }

    });
});