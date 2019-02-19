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
    }).then(result => {
      if (result.value) {
        const sizeHashId = $(this).data('sizeId');
        $.ajax({
          method: 'DELETE',
          url: `/ajax-admin/sizes/${sizeHashId}`
        }).done(() => location.reload());
      }
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
    }).then(result => {
      if (result.value) {
        const colorHashId = $(this).data('colorId');
        $.ajax({
          method: 'DELETE',
          url: `/ajax-admin/colors/${colorHashId}`
        }).done(() => location.reload());
      }
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
    }).then(result => {
      if (result.value) {
        const typeHashId = $(this).data('typeId');
        $.ajax({
          method: 'DELETE',
          url: `/ajax-admin/types/${typeHashId}`
        }).done(() => location.reload());
      }
    })
  });

  $('.subtype-delete').click(function () {
    swal({
      title: 'Eliminar subtipo',
      text: 'Seguro que desea eliminar',
      type: 'question',
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      showLoaderOnConfirm: true,
    }).then(result => {
      if (result.value) {
        const subtypeHashId = $(this).data('subtypeId');
        $.ajax({
          method: 'DELETE',
          url: `/ajax-admin/subtypes/${subtypeHashId}`
        }).done(() => location.reload());
      }
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
    }).then(result => {
      if (result.value) {
        const photoId = $(this).data('photoId');
        $.ajax({
          method: 'DELETE',
          url: `/ajax-admin/photo/${photoId}`
        }).done(() => location.reload());
      }
    });
  });

  $('.home-post-delete').click(function () {
    swal({
      title: 'Eliminar publicación Home',
      text: 'Se eliminarán todos los datos y fotos del producto',
      type: 'question',
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      showLoaderOnConfirm: true,
    }).then(result => {
      if (result.value) {
        const homePostId = $(this).data('homePostId');
        $.ajax({
          method: 'DELETE',
          url: `/ajax-admin/home-posts/${homePostId}`
        }).done(() => location.reload());
      }
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
    }).then(result => {
      if (result.value) {
        const productHashId = $(this).data('productId');
        $.ajax({
          method: 'DELETE',
          url: `/ajax-admin/products/remove/${productHashId}`
        }).done(() => location.reload());
      }
    });
  });

  $('.blog-post-delete').click(function () {
    swal({
      title: 'Eliminar post',
      text: 'Se eliminarán todos los datos y fotos del post',
      type: 'question',
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      showLoaderOnConfirm: true,
    }).then(result => {
      if (result.value) {
        const blogPostId = $(this).data('blogPost');
        $.ajax({
          method: 'DELETE',
          url: `/ajax-admin/post/${blogPostId}/delete`
        }).done(() => location.reload());
      }
    });
  });
});