define([
    'jquery',
    'underscore',
    'backbone'
], function(
    $,
    _,
    Backbone
){
    return Backbone.View.extend({

        tagName: 'div',

        className: 'col-sm-4 col-md-3 col-lg-3',

        initialize: function(){
            this.listenTo(this.model, 'change', this.render);
        },

        render: function(){
            var template = _.template($('#template-album').html());
            this.$el.html(
                template({
                    name: this.model.get('name'),
                    description: this.model.get('description'),
                    previewImages: this.model.get('previewImages')
                })
            );

            this.$el.find('.album-thumbnail').data('href', 'album/'+this.model.get('id'));
            return this;
        }

    });
});