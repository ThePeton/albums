var ImageView = Backbone.View.extend({

    tagName: 'li',

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
        this.$el.html('<div class="image-block"><img src="'+this.model.get('src')+'"><\/div><p>'+this.model.get('text')+'</p>');
        return this;
    }

});