define([
    'jquery',
    'backbone',
    'underscore',
    'gallery/views/imageView',
    'gallery/views/albumView'
], function(
    $,
    Backbone,
    _,
    ImageView,
    AlbumView
){

    return Backbone.View.extend({

        el: $('#content-wrapper'),

        collection: null,

        router: null,

        backLink: false,

        events: {
            'click a' : 'navigateLink',
            'click li' : 'navigateListItem'
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

            var paginationTemplate = _.template($('#template-pagination').html());
            this.$el
                .find('.pagination')
                .html(paginationTemplate(
                    _.extend(this.collection.state, {link: 'album/' + this.collection.albumId + '/'})
                ));
        },

        setCollection: function(collection){
            this.collection = collection;
            this.listenTo(this.collection, 'add', this.addOne);
            this.listenTo(this.collection, 'reset', this.onReset);
            this.collection.fetch({data: {albumId: this.collection.albumId}, reset: true});
            return this;
        },

         addOne: function(modelItem){
            if (modelItem.type == 'image') {
                var newElement = new ImageView({model: modelItem}).render().el;
            } else if (modelItem.type == 'album') {
                var newElement = new AlbumView({model: modelItem}).render().el;
            }

            this.$el.find('ul').append(newElement);
        },

        addBatch: function(){
            this.collection.each(this.addOne, this);
        },

        onReset: function(){
            this.clear();
            this.addBatch();
            this.render();
        },

        clear: function(){
            this.$el.find('ul > li').remove();
            this.$el.find('.pagination ul').remove();
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

        navigateLink: function(){
            this.router.navigate($(event.target).attr('href'), {trigger: true});
            return false;
        },

        navigateListItem: function(event){
            var targetHref = $(event.currentTarget).data('href');
            if (targetHref) {
                this.router.navigate(targetHref, {trigger: true});
                return false;
            }
        }

    });
});