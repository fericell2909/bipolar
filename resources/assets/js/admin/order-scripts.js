const Sortable = require('sortablejs');
require('block-ui');

const createSortable = (elementId, urlToSave) => {
  if ($(elementId).length) {
    const elem = document.querySelector(elementId);
    const sortable = new Sortable(elem, {
      onEnd() {
        $.blockUI({
          message:
            `<i class='fa fa-refresh fa-spin'></i> 
              Guardando 
            <i class='fa fa-refresh fa-spin'></i>`
        });
        $.post(urlToSave, {newOrder: sortable.toArray()})
          .done(() => $.unblockUI());
      }
    });
  }
};

$(function () {
  createSortable('#sortable-items', '/ajax-admin/products/photos/order');
  createSortable('#sortable-products', '/ajax-admin/products/order');
  createSortable('#sortable-home-posts', '/ajax-admin/home-posts/order');
  createSortable('#sortable-home-posts-photos', '/ajax-admin/home-posts/photos/order');
});