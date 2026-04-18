/**
 * Sakura Florist Solo - Main Script
 * Handles animations, filtering, and WhatsApp redirection with SweetAlert.
 */

$(document).ready(function() {
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });

    // Navbar scroll effect
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass('shadow-sm bg-white');
        } else {
            $('.navbar').removeClass('shadow-sm bg-white');
        }
    });

    // Category Filtering
    $('.filter-btn').on('click', function() {
        const filterValue = $(this).attr('data-filter');
        
        // Update active button
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        if (filterValue === 'all') {
            $('.flower-item').show(400);
        } else {
            $('.flower-item').hide();
            $('.' + filterValue).show(400);
        }
    });

    // WhatsApp Order Confirmation
    $('.btn-order-whatsapp').on('click', function(e) {
        e.preventDefault();
        
        const flowerName = $(this).attr('data-flower');
        const waNumber = $(this).attr('data-wa');
        const template = $('#waTemplate').val() || "Min, saya mau order {{flower_name}}";
        
        const message = flowerName 
            ? template.replace('{{flower_name}}', `*${flowerName}*`)
            : `Halo Sakura Florist Solo, saya ingin bertanya mengenai layanan bunga.`;
        
        const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;

        Swal.fire({
            title: 'Lanjut ke WhatsApp?',
            text: flowerName ? `Anda akan memesan: ${flowerName}` : "Hubungi admin kami melalui WhatsApp.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#F94687',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Chat Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.open(waUrl, '_blank');
            }
        });
    });

    // Smooth Scrolling for anchor links
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });
});
