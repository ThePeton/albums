define([
    'marionette'
], function(
    Marionette
){
    return Marionette.ItemView.extend({

        template: '#template-album',

        onRender: function(){
            this.$el.find('.album-thumbnail').data('href', 'album/' + this.model.get('id'));
            return this;
        }

    });
});