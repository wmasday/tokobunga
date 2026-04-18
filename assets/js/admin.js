/**
 * Sakura Florist Solo - Admin Dashboard Interactions
 */

$(document).ready(function() {
    // Sidebar Toggler for Mobile
    $('.navbar-toggler-admin').on('click', function() {
        $('.sidebar').toggleClass('show');
    });

    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() < 992) {
            if (!$(e.target).closest('.sidebar').length && !$(e.target).closest('.navbar-toggler-admin').length) {
                $('.sidebar').removeClass('show');
            }
        }
    });

    // Initialize Summernote if available
    if (typeof $.fn.summernote !== 'undefined') {
        $('.summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    }

    // Modern Swal Confirmation for Delete
    window.confirmDelete = function(url, title = 'Are you sure?', text = "You won't be able to revert this!") {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F94687',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!',
            borderRadius: '1rem'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    };
});
