$(function () {
    // Owl Carousel scripts
    let thumbs = 5;
    let duration = 300;

    let owlMain = $('.owl-carousel-main').owlCarousel({
        items: 1,
        onDragged: draggedOwlMain,
    });
    let owlThumbnail = $('.owl-carousel-thumbnails').owlCarousel({
        margin: 10,
        items: thumbs,
    });

    function draggedOwlMain (event) {
        owlMain.trigger('to.owl.carousel', [event.item.index, duration, true]);
    }

    owlThumbnail.on('click', '.owl-item', function() {
        let index = $(this).index();
        owlMain.trigger('to.owl.carousel', [index, duration, true]);
        owlThumbnail.trigger('to.owl.carousel', [index, duration, true]);
    });
});