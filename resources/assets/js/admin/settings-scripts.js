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
});