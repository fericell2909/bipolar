const PhotoSwipe = require('photoswipe/dist/photoswipe.min');
const PhotoSwipeUI = require('photoswipe/dist/photoswipe-ui-default.min');

$(function () {
    if ($('.image-photoswipe-trigger').length && window.hasOwnProperty('BipolarProductPhotos')) {
        $('.image-photoswipe-trigger').click(() => {
            var pswpElement = document.querySelectorAll('.pswp')[0];

            // build items array
            var items = window.BipolarProductPhotos;

            // define options (if needed)
            var options = {
                // optionName: 'option value'
                // for example:
                index: 0, // start at first slide
                zoomEl: true,
                arrowEl: true,
                shareEl: false,
                tapToClose: false,
                clickToCloseNonZoomable: false,
            };

            // Initializes and opens PhotoSwipe
            var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI, items, options);
            gallery.init();
        });
    }

    if ($('.bipolar-filters').length) {
        $('.bipolar-filters').show('slow');
    }

    if ($('.btn-see-filters').length) {
        $('.btn-see-filters').click(() => {
            $('.filters-container').toggle();
        });
    }

    if ($('#shopForm').length) {
        // $('.bipolar-filter.pretty').click(() => {
        //     setTimeout(function () {
        //         $('#shopForm').submit();
        //     }, 500);
        // });

        $('#shop-sort-by').change(function () {
            setTimeout(function () {
                $('#shopForm').submit();
            }, 500);
        });
    }

    if ($('.button-see-details').length) {
        let $buttonSeeDetails = $('.button-see-details');
        
        $buttonSeeDetails.click(function () {
            let productHashId = $(this).data('hashId');
            $(`.modal-product-detail-${productHashId}`).modal({ show: true });
        });
    }
});