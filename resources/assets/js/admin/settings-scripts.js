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
            let sizeHashId = $(this).data('sizeId');

            $.ajax({
                method: 'DELETE',
                url: `/admin/settings/size/${sizeHashId}`
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
            let sizeHashId = $(this).data('colorId');

            $.ajax({
                method: 'DELETE',
                url: `/admin/settings/colors/${sizeHashId}`
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
            let typeHashId = $(this).data('typeId');

            $.ajax({
                method: 'DELETE',
                url: `/admin/settings/types/${typeHashId}`
            }).done(() => location.reload());
        })
    });
});