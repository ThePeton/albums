requirejs.config({
    paths: {
        jquery: 'bower_components/jquery/dist/jquery',
        underscore: 'bower_components/underscore/underscore',
        backbone: 'bower_components/backbone/backbone',
        backbone_paginator: 'bower_components/backbone.paginator/lib/backbone.paginator',
        'backbone.wreqr': 'bower_components/backbone.wreqr/lib/backbone.wreqr',
        'backbone.babysitter': 'bower_components/backbone.babysitter/lib/backbone.babysitter',
        marionette: 'bower_components/marionette/lib/core/backbone.marionette',

        gallery: '../../appgallery/js'
    }
});

requirejs(['gallery/main']);