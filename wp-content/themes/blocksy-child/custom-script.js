
jQuery(document).ready(function($) {
    var $testimonialCarousel = $('.testimonial-carousel');
    var $testimonialItems = $testimonialCarousel.children('.testimonial-item');
    var itemsPerPage = 4;
    var currentPage = 1;
    var totalItems = $testimonialItems.length;
    var totalPages = Math.ceil(totalItems / itemsPerPage);

    function showPage(page) {
        var startIndex = (page - 1) * itemsPerPage;
        var endIndex = startIndex + itemsPerPage - 1;
        $testimonialItems.hide().slice(startIndex, endIndex + 1).show();
    }

    // Show initial page
    showPage(currentPage);

    // Previous button click event
    $('.testimonial-carousel-prev').on('click', function() {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    });

    // Next button click event
    $('.testimonial-carousel-next').on('click', function() {
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    });
});