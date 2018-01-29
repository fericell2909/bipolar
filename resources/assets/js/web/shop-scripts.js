$(function () {
    // Icheck
    /* let shopIcheck = $('.icheck').iCheck({
        checkboxClass: 'iradio_square',
        radioClass: 'iradio_square',
        increaseArea: '20%',
    }); */

    if ($('.bipolar-filters').length) {
        $('.bipolar-filters').show('slow');
    }

    if ($('.btn-see-filters').length) {
        $('.btn-see-filters').click(() => {
            $('.filters-container').toggle();
        });
    }

    if ($('#shopForm').length) {
        $('.bipolar-filter.pretty').click(() => {
            setTimeout(function () {
                $('#shopForm').submit();
            }, 1000);
        })

        $('#shop-sort-by').change(function () {
            setTimeout(function () {
                $('#shopForm').submit();
            }, 1000);
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