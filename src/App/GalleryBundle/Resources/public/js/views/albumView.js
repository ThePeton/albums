var AlbumView = Backbone.View.extend({

    tagName: 'li',

    router: null,

    initialize: function(){
        this.listenTo(this.model, 'change', this.render);
    },

    events: {
        click: function(){
            this.router.navigate('album/' + this.model.get('id'), { trigger: true });
        }
    },

    render: function(){
        this.$el.html('<h2>'+this.model.get('name')+'</h2><p>'+this.model.get('description')+'</p>');
        return this;
    },

    setRouter: function(routerItem){
        this.router = routerItem;
        return this;
    }

});