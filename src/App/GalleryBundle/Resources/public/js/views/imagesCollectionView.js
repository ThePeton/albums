define([
    'jquery',
    'underscore',
    'marionette',
    'gallery/views/imageView'
], function(
    $,
    _,
    Marionette,
    ImageView
){
    return Marionette.CollectionView.extend({

        childView: ImageView,

        initialize: function(){
            this.collection.fetch({ data: { albumId: this.collection.albumId }, reset: true });
        },

        onBeforeRender: function(){
            var paginationTemplate = _.template($('#template-pagination').html());
            $('.pagination-block')
                .html(paginationTemplate(
                    _.extend(this.collection.state, {link: 'album/' + this.collection.albumId})
                ));
        }

    });
});