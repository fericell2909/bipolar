import swal from 'sweetalert2';

$(function () {
    $('.size-delete').click(function () {
        swal({
            title: 'Eliminar talla',
            text: 'Seguro que desea eliminar',
            type: 'question',
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true,
        }).then(() => {
            const sizeHashId = $(this).data('sizeId');
            $.ajax({
                method: 'DELETE',
                url: `/ajax-admin/size/${sizeHashId}`
            }).done(() => location.reload());
        })
    });

    $('.color-delete').click(function () {
        swal({
            title: 'Eliminar color',
            text: 'Seguro que desea eliminar',
            type: 'question',
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true,
        }).then(() => {
            const colorHashId = $(this).data('colorId');
            $.ajax({
                method: 'DELETE',
                url: `/ajax-admin/colors/${colorHashId}`
            }).done(() => location.reload());
        })
    });

    $('.type-delete').click(function () {
        swal({
            title: 'Eliminar tipo',
            text: 'Seguro que desea eliminar',
            type: 'question',
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true,
        }).then(() => {
            const typeHashId = $(this).data('typeId');
            $.ajax({
                method: 'DELETE',
                url: `/ajax-admin/types/${typeHashId}`
            }).done(() => location.reload());
        })
    });

    $('.photo-delete').click(function () {
        swal({
            title: 'Eliminar foto',
            text: 'Seguro que desea eliminar la foto',
            type: 'question',
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true,
        }).then(() => {
            const photoId = $(this).data('photoId');
            $.ajax({
                method: 'DELETE',
                url: `/ajax-admin/photo/${photoId}`
            }).done(() => location.reload());
        });
    });

    $('.product-delete').click(function () {
        swal({
            title: 'Eliminar producto',
            text: 'Se eliminarán todos los datos, stock y fotos del producto',
            type: 'question',
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true,
        }).then(() => {
            const productHashId = $(this).data('productId');
            $.ajax({
                method: 'DELETE',
                url: `/ajax-admin/products/${productHashId}`
            }).done(() => location.reload());
        });
    });
});