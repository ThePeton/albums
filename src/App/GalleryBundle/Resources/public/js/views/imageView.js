var ImageView = Backbone.View.extend({
    tagName: 'div',
    className: 'album-image',
    events: {
        'click' : function(){
            alert(this.model.text)
        }
    },
    initialize: function(){
        this.listenTo(this.model, 'change', this.render);
    },
    render: function(){
        this.$el.html('<li><div class="image-block"><img src="'+this.model.get('src')+'"><\/div><p>'+this.model.get('text')+'</p></li>');
        return this;
    }
});