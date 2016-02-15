define(['backbone'], function(Backbone){
    return Backbone.Model.extend({

        type: 'album',

        defaults: {
            name: '(empty)',
            order: 0
        }

    });
});