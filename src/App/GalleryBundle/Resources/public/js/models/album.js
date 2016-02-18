define([
    'backbone'
], function(
    Backbone
){
    return Backbone.Model.extend({

        type: 'album',

        defaults: {
            name: '(empty)',
            description: '(empty)',
            order: 0
        }

    });
});