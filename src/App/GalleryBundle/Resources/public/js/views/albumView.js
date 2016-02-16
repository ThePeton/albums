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

        className: 'col-md-3',

        initialize: function(){
            this.listenTo(this.model, 'change', this.render);
        },

        render: function(){
            var template = _.template($('#template-album').html());
            this.$el.html(template({name: this.model.get('name'), description: this.model.get('description')}));
            this.$el.find('.thumbnail').data('href', 'album/'+this.model.get('id'));
            return this;
        }

    });
});