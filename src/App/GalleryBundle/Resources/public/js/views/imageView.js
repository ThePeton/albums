define([
    'jquery',
    'marionette'
], function(
    $,
    Marionette
){
    return Marionette.ItemView.extend({

        template: '#template-image',

        events: {
            'click' : function(){
                $('#preview-image > img').attr('src', this.$el.find('img').attr('src'));
                $('#preview-image').show();
                $('#preview-image-overlay').width($(window).width()).height($(document).height()).show();

                $('#preview-image, #preview-image-overlay').click(function(){
                    $('#preview-image, #preview-image-overlay').hide();
                });
            }
        }

    });
});