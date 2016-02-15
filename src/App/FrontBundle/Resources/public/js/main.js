requirejs.config({
    paths: {
        jquery: 'bower_components/jquery/dist/jquery',
        underscore: 'bower_components/underscore/underscore',
        backbone: 'bower_components/backbone/backbone',
        backbone_paginator: 'bower_components/backbone.paginator/lib/backbone.paginator',

        gallery: '../../appgallery/js'
    }
});

requirejs(['gallery/main']);