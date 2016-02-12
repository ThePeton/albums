var AppView = Backbone.View.extend({
    el: $('#album-wrapper > ul'),

    images: {},

    initialize: function(options){
        if (options.images) {
            this.setImages(options.images);
        }
    },

    setImages: function(images){
        this.images = images;
        this.listenTo(this.images, 'add', this.addOne);
        this.listenTo(this.images, 'reset', this.onReset);
        //this.listenTo(this.images, 'all', this.log);
        this.images.fetch();
    },
    log: function(a1, a2, a3){
      console.log(a1, a2, a3);
    },

    addOne: function(image){
        var newImage = new ImageView({model: image}).render().el;
        this.$el.append(newImage);
    },

    addBatch: function(){
        this.images.each(this.addOne, this);
    },

    onReset: function(){
        this.$el.find('li').remove();
        this.addBatch();
    }
});