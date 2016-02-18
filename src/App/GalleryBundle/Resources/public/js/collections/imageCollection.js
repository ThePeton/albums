define([
    'backbone',
    'backbone_paginator',
    'gallery/models/image'
], function(
    Backbone,
    Paginator,
    Image
){
    return Backbone.PageableCollection.extend({

        model: Image,

        url: '/gallery/images/rpc/',

        albumId: null,

        initialize: function(collection, options){
            if (options && options.albumId) {
                this.albumId = options.albumId;
            }
        },

        state: {
            firstPage: 1,
            pageSize: 10
        },

        queryParams: {
            totalRecords: "total"
        }

    });
});