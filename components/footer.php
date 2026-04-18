<?php
/**
 * Shared Footer Component
 * Sakura Florist Solo
 */

$wa_number = $config['whatsapp'] ?? '081567883835';
$wa_message = $config['wa_message'] ?? 'Min, saya mau order {{flower_name}}';
?>
<!-- Footer -->
<footer class="text-center text-md-start pt-5 pb-4 mt-5 bg-light border-top" aria-label="Footer Navigation">
    <div class="container">
        <div class="row g-4">
            <!-- Column 1: Brand & About -->
            <div class="col-lg-4">
                <a href="/index.php" class="h3 navbar-brand d-block mb-3 text-primary">SAKURA FLORIST</a>
                <p class="text-muted small mb-4 pe-lg-4">
                    Toko bunga terpercaya di Solo yang menyediakan berbagai pilihan rangkaian bunga segar dan papan bunga elegan. Kami berkomitmen memberikan kualitas terbaik untuk setiap momen berharga Anda sejak 2010.
                </p>
                <div class="d-flex gap-3 justify-content-center justify-content-md-start">
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-circle p-2 btn-order-whatsapp" data-wa="<?php echo $wa_number; ?>" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="<?php echo htmlspecialchars($config['facebook'] ?? '#'); ?>" class="btn btn-outline-primary btn-sm rounded-circle p-2" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="<?php echo htmlspecialchars($config['instagram'] ?? '#'); ?>" class="btn btn-outline-primary btn-sm rounded-circle p-2" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="col-6 col-lg-2">
                <h6 class="text-uppercase fw-bold mb-4">Link Cepat</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="/index.php" class="text-muted text-decoration-none hover-primary">Beranda</a></li>
                    <li class="mb-2"><a href="/catalog" class="text-muted text-decoration-none hover-primary">Katalog Bunga</a></li>
                    <li class="mb-2"><a href="/blog" class="text-muted text-decoration-none hover-primary">Blog Inspirasi</a></li>
                    <li class="mb-2"><a href="/index.php#catalog" class="text-muted text-decoration-none hover-primary">Produk Unggulan</a></li>
                </ul>
            </div>

            <!-- Column 3: Services -->
            <div class="col-6 col-lg-2">
                <h6 class="text-uppercase fw-bold mb-4">Layanan</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2 text-muted">Bunga Papan</li>
                    <li class="mb-2 text-muted">Hand Bouquet</li>
                    <li class="mb-2 text-muted">Bunga Meja</li>
                    <li class="mb-2 text-muted">Decorasi Event</li>
                </ul>
            </div>

            <!-- Column 4: Location & Map -->
            <div class="col-lg-4">
                <h6 class="text-uppercase fw-bold mb-4">Lokasi Kami</h6>
                <p class="text-muted small mb-3">
                    <i class="fas fa-map-marker-alt me-2 text-primary"></i> <?php echo htmlspecialchars($config['address'] ?? 'Surakarta, Jawa Tengah, Indonesia'); ?>
                </p>
                <div class="rounded-3 overflow-hidden shadow-sm border" style="height: 150px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126597.1000!2d110.8242!3d-7.5666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a166275efad29%3A0x3027a763a1154c0!2sSurakarta%2C%20Kota%20Surakarta%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>

        <hr class="my-5 opacity-10">
        
        <div class="row align-items-center">
            <div class="col-md-12 text-center text-md-start">
                <p class="text-muted small mb-0">&copy; <?php echo date('Y'); ?> Sakura Florist Solo. All rights reserved. Built for premium floral experiences in Surakarta.</p>
            </div>
        </div>

        <!-- WA Template for JS -->
        <input type="hidden" id="waTemplate" value="<?php echo htmlspecialchars($wa_message); ?>">
    </div>
</footer>

<style>
    .hover-primary:hover { color: var(--bs-primary) !important; transition: 0.3s; }
</style>

<!-- Interactive Elements -->
<a href="#" class="floating-wa btn-order-whatsapp" data-wa="<?php echo $wa_number; ?>" aria-label="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<div id="scrollTop" aria-label="Scroll to top">
    <i class="fas fa-chevron-up text-primary"></i>
</div>

<!-- Global Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="/assets/js/script.js"></script>
<script>
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true
        });
    }
</script>
