var Image = Backbone.Model.extend({

    type: 'image',

    defaults: {
        src: '/upload/gallery/empty.jpg',
        text: '(empty)',
        order: 0
    }

});