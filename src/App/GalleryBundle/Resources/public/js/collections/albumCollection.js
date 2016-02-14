var AlbumCollection = Backbone.PageableCollection.extend({

    model: Album,

    url: '/gallery/albums/rpc/',

    state: {
        firstPage: 1,
        pageSize: 10
    },

    queryParams: {
        currentPage: "page",
        pageSize: "onPage",
        totalPages: "pageCount",
        totalRecords: "total"
    }
});