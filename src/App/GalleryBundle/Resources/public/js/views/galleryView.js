define([
    'jquery',
    'marionette',
], function(
    $,
    Marionette
){
    return Marionette.LayoutView.extend({

        template: '#template-gallery',

        regions: {
            regionGallery: '.gallery'
        },

        events: {
            'click a[class!="outer"]' : 'navigateLink',
            'click .thumbnail' : 'navigateListItem'
        },

        navigateLink: function(event){
            var targetHref = $(event.target).attr('href');
            if (targetHref && targetHref.toString().search('http') !== 0) {
                this.getRouter().navigate(targetHref, {trigger: true});
                return false;
            }
        },

        navigateListItem: function(event){
            var targetHref = $(event.currentTarget).data('href');
            if (targetHref) {
                this.getRouter().navigate(targetHref, {trigger: true});
                return false;
            }
        },

        getRouter: function(){
            var globalCh = Backbone.Wreqr.radio.channel('global');
            return globalCh.reqres.request('getRouter');
        }

    });
});