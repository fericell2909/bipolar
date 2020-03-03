const Sortable = require('sortablejs');
import swal from 'sweetalert2';

const createSortable = (elementId, urlToSave) => {
  if ($(elementId).length) {
    const elem = document.querySelector(elementId);
    const sortable = new Sortable(elem, {
      scroll: true,
      onEnd() {
        swal({
          text: 'Cargando.',
          timer: 1000,
          onOpen: () => {
            swal.showLoading();
          },
        }).then(result => {
          if (result.dismiss) {
            $.post(urlToSave, { newOrder: sortable.toArray() }).done(() =>
              swal({
                title: 'Hecho',
                type: 'success',
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
              })
            );
          }
        });
      },
    });
  }
};

$(function() {
  createSortable('#sortable-items', '/ajax-admin/products/photos/order');
  createSortable('#sortable-products', '/ajax-admin/products/order');
  createSortable('#sortable-home-posts', '/ajax-admin/home-posts/order');
  createSortable('#sortable-home-posts-photos', '/ajax-admin/home-posts/photos/order');
  createSortable('#sortable-banners', '/ajax-admin/banners/order');
  createSortable('#sortable-historics', '/ajax-admin/historics/order');
  createSortable('#sortable-post-photos', '/ajax-admin/post/photos/order');
});
