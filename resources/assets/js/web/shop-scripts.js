$(function () {
    // Icheck
    let shopIcheck = $('.icheck').iCheck({
        checkboxClass: 'icheckbox_flat',
        radioClass: 'iradio_flat',
    });

    if ($('#shopForm').length) {
        shopIcheck.on('ifClicked', () => {
            setTimeout(function () {
                $('#shopForm').submit();
            }, 1000);
        });

        $('#shop-sort-by').change(function () {
            setTimeout(function () {
                $('#shopForm').submit();
            }, 1000);
        });
    }
});