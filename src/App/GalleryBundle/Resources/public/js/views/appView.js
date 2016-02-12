var AppView = Backbone.View.extend({
    el: $('#album-wrapper > ul'),

    initialize: function(){
        this.listenTo(PageAlbum, 'add', this.addOne);

        PageAlbum.fetch();
    },

    addOne: function(image){
        var newImage = new ImageView({model: image}).render().el;
        this.$el.append(newImage);
    }

    /*render: function(){

     }*/
});