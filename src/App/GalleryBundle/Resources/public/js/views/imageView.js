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

        events: {
            'click' : function(){
                $('#preview-image > img').attr('src', this.$el.find('img').attr('src'));
                $('#preview-image').show();
                $('#preview-image-overlay').width($(window).width()).height($(document).height()).show();

                $('#preview-image, #preview-image-overlay').click(function(){
                    $('#preview-image, #preview-image-overlay').hide();
                });
            }
        },

        initialize: function(){
            this.listenTo(this.model, 'change', this.render);
        },

        render: function(){
            var template = _.template($('#template-image').html());
            this.$el.html(template({src: this.model.get('src'), description: this.model.get('description')}));
            return this;
        }

    });
});