var AppListView = Backbone.View.extend({

    el: $('#content-wrapper'),

    collection: null,

    router: null,

    backLink: false,

    events: {
        'click .back-link' : 'navigateTop'
    },

    initialize: function(options){
        if (options && options.router) {
            this.setRouter(options.router);
        }

        if (options && options.collection) {
            this.setCollection(options.collection);
        }
    },

    render: function(){
        this.$el.find('.back-link').toggle(this.backLink);
    },

    setCollection: function(collection, fetchOptions){
        this.collection = collection;
        this.listenTo(this.collection, 'add', this.addOne);
        this.listenTo(this.collection, 'reset', this.onReset);
        this.collection.fetch({data: fetchOptions});
        return this;
    },

     addOne: function(modelItem){
        if (modelItem.type == 'image') {
            var newElement = new ImageView({model: modelItem}).render().el;
        } else if (modelItem.type == 'album') {
            var newElement = new AlbumView({model: modelItem})
                .setRouter(this.router)
                .render().el;
        }

        this.$el.find('ul').append(newElement);
    },

    addBatch: function(){
        this.collection.each(this.addOne, this);
    },

    onReset: function(){
        this.clear();
        this.addBatch();
    },

    clear: function(){
        this.$el.find('ul > li').remove();
        return this;
    },

    setRouter: function(routerItem){
        this.router = routerItem;
        return this;
    },

    setBackLink: function(state){
        this.backLink = state;
        this.render();
        return this;
    },

    navigateTop: function(){
        this.router.navigate('', {trigger: true});
    }

});