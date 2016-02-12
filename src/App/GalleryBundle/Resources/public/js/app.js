$(function(){
    var Image = Backbone.Model.extend({
        defaults: {
            src: '/upload/gallery/empty.jpg',
            text: '',
            order: 0
        }
    });

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

    var Album = Backbone.Collection.extend({
        model: Image,
        url: '/gallery/rpc/',
        /*initialize: function(){
            this.on('all', function(a1, a2, a3){
                console.log(a1, a2, a3);
            });
        }*/
    });

    var PageAlbum = new Album;

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

    var App = new AppView;
})