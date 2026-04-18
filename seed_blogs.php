<?php
/**
 * Seeding Script for SEO-Optimized Blog Data
 * Sakura Florist Solo
 */

require_once 'config/db.php';

echo "Starting seeding blog data...\n";

// Clear existing blogs for a clean slate
$pdo->exec("DELETE FROM blogs");
$pdo->exec("ALTER TABLE blogs AUTO_INCREMENT = 1");

$blogs = [
    [
        'title' => '5 Tips Memilih Karangan Bunga Papan di Solo untuk Berbagai Acara',
        'slug' => 'tips-memilih-bunga-papan-solo',
        'excerpt' => 'Sedang mencari karangan bunga papan di Solo? Simak 5 tips penting agar pesan Anda tersampaikan dengan elegan dan berkesan.',
        'content' => '<h2>Pentingnya Memilih Bunga Papan yang Tepat</h2><p>Di Solo, karangan bunga papan atau "stekwerk" adalah cara yang sangat populer untuk mengungkapkan perasaan, baik itu suka maupun duka. Namun, memilih yang terbaik tidaklah semudah kelihatannya.</p><h3>1. Sesuaikan Desain dengan Momen</h3><p>Pastikan desain bunga papan sesuai dengan acaranya. Untuk pernikahan (Wedding), gunakan warna-warna cerah dan romantis. Sedangkan untuk duka cita, pilihlah warna yang lebih tenang seperti kuning atau biru tua.</p><h3>2. Gunakan Bunga Segar Pilihan</h3><p>Toko bunga Solo yang berkualitas selalu menggunakan bunga segar seperti krisan, mawar, dan aster agar tampilan tetap prima selama acara berlangsung.</p>',
        'image' => 'assets/img/flowers/Bunga Papan/IMG-20251101-WA0088.jpg'
    ],
    [
        'title' => 'Makna Mendalam di Balik Setiap Warna Bunga Mawar',
        'slug' => 'makna-warna-bunga-mawar',
        'excerpt' => 'Ketahui arti dari setiap warna mawar sebelum Anda memberikannya kepada seseorang spesial. Jangan sampai salah pesan!',
        'content' => '<h2>Bahasa Bunga: Simbolisme Mawar</h2><p>Bunga mawar adalah ratunya bunga yang memiliki sejuta makna. Setiap warnanya mewakili emosi yang berbeda.</p><h3>Mawar Merah: Cinta dan Keberanian</h3><p>Mawar merah adalah simbol abadi untuk cinta sejati dan romansa. Sangat cocok diberikan saat Valentine atau Anniversary.</p><h3>Mawar Putih: Kemurnian dan Ketulusan</h3><p>Putih melambangkan kesucian. Sering digunakan dalam buket pernikahan atau sebagai tanda penghormatan terakhir.</p><h3>Mawar Pink: Kekaguman dan Terima Kasih</h3><p>Berikan mawar merah muda untuk menunjukkan rasa terima kasih atau kekaguman yang manis kepada teman atau kerabat.</p>',
        'image' => 'assets/img/flowers/Standing Flower/IMG-20250531-WA0048.jpg'
    ],
    [
        'title' => 'Cara Merawat Bunga Meja Agar Tetap Segar dan Tahan Lama',
        'slug' => 'merawat-bunga-meja-segar',
        'excerpt' => 'Ingin bunga meja Anda awet hingga berhari-hari? Ikuti panduan praktis dari florist profesional kami di Solo.',
        'content' => '<h2>Tips Menjaga Kesegaran Bunga di Dalam Ruangan</h2><p>Bunga meja (Table Bouquet) dapat memberikan nuansa segar di rumah atau kantor. Namun, tanpa perawatan yang benar, bunga akan cepat layu.</p><h3>Ganti Air Secara Teratur</h3><p>Pastikan air di dalam vas selalu bersih. Ganti air setiap dua hari sekali untuk mencegah pertumbuhan bakteri yang dapat menyumbat batang bunga.</p><h3>Potong Batang Secara Diagonal</h3><p>Setiap kali mengganti air, potong ujung batang sekitar 1-2 cm dengan kemiringan 45 derajat agar daya serap air lebih maksimal.</p><h3>Hindari Sinar Matahari Langsung</h3><p>Letakkan bunga di tempat yang sejuk dan jauhkan dari paparan sinar matahari langsung atau hembusan AC yang terlalu kuat.</p>',
        'image' => 'assets/img/flowers/Table Bouquet/IMG-20240817-WA0067.jpg'
    ],
    [
        'title' => 'Mengapa Hand Bouquet Selalu Jadi Kado Wisuda Favorit di Solo',
        'slug' => 'buket-wisuda-solo-terfavorit',
        'excerpt' => 'Buket tangan atau hand bouquet adalah pelengkap sempurna saat momen wisuda. Intip mengapa kado ini tak lekang oleh waktu.',
        'content' => '<h2>Momen Spesial dengan Buket Bunga Wisuda</h2><p>Wisuda adalah pencapaian besar dalam hidup. Memberikan buket bunga bukan hanya tradisi, tapi juga bentuk apresiasi tertinggi.</p><h3>Kecantikan yang Estetik di Foto</h3><p>Hand bouquet memberikan elemen visual yang sangat cantik saat sesi foto wisuda. Bunga pastel atau mawar merah sering menjadi pilihan utama mahasiswa di Solo.</p><h3>Pesan yang Personal</h3><p>Anda bisa menyelipkan kartu ucapan berisi motivasi atau doa bagi wisudawan, membuat kado ini terasa sangat personal dan berkesan.</p><h3>Varian yang Beragam</h3><p>Mulai dari buket mawar klasik hingga kombinasi bunga matahari yang ceria, Anda bisa menyesuaikan buket dengan karakter sang wisudawan.</p>',
        'image' => 'assets/img/flowers/Table Bouquet/IMG-20230221115901.jpg'
    ],
    [
        'title' => 'Trend Standing Flower untuk Grand Opening Usaha Baru di Solo',
        'slug' => 'standing-flower-grand-opening-solo',
        'excerpt' => 'Tingkatkan prestise acara pembukaan usaha Anda dengan Standing Flower yang mewah dan modern. Simak tren terbarunya!',
        'content' => '<h2>Elegansi Standing Flower dalam Acara Formal</h2><p>Berbeda dengan bunga papan, standing flower menawarkan kesan yang lebih eksklusif dan minimalis namun tetap mewah.</p><h3>Pemanis Sudut Ruangan</h3><p>Standing flower sangat efektif untuk menghias pintu masuk atau sudut ruangan toko. Bentuknya yang ramping tidak memakan banyak tempat tapi tetap mencuri perhatian.</p><h3>Kombinasi Bunga Premium</h3><p>Tren terbaru di Solo adalah menggunakan perpaduan bunga Lily, Mawar, dan Baby Breath untuk memberikan kesan "High-End" pada acara Grand Opening.</p><h3>Tanda Dukungan Rekan Bisnis</h3><p>Mengirimkan standing flower kepada mitra bisnis yang baru membuka usaha adalah bentuk dukungan yang sangat elegan dan profesional.</p>',
        'image' => 'assets/img/flowers/Standing Flower/IMG-20250826-WA0096.jpg'
    ],
];

foreach ($blogs as $blog) {
    try {
        $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, excerpt, content, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $blog['title'],
            $blog['slug'],
            $blog['excerpt'],
            $blog['content'],
            $blog['image']
        ]);
        echo "Blog '{$blog['title']}' added successfully.\n";
    } catch (PDOException $e) {
        echo "Error adding blog '{$blog['title']}': " . $e->getMessage() . "\n";
    }
}

echo "\nSeeding blogs completed!\n";
