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

        tagName: 'li',

        initialize: function(){
            this.listenTo(this.model, 'change', this.render);
        },

        render: function(){
            var template = _.template($('#template-album').html());
            this.$el.html(template({name: this.model.get('name'), description: this.model.get('description')}));
            this.$el.data('href', 'album/'+this.model.get('id'));
            return this;
        }

    });
});