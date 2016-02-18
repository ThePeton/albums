define([
    'backbone'
], function(
    Backbone
){
    return Backbone.Model.extend({

        type: 'image',

        defaults: {
            src: '/upload/gallery/empty.jpg',
            description: '(empty)',
            order: 0
        }

    });
});