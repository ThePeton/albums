define([
    'backbone',
    'backbone_paginator',
    'gallery/models/album'
], function(
    Backbone,
    Paginator,
    Album
){
    return Backbone.PageableCollection.extend({

        model: Album,

        url: '/gallery/albums/rpc/',

        state: {
            firstPage: 1,
            pageSize: 10
        },

        queryParams: {
            totalRecords: "total"
        }
    });
});