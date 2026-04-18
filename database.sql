-- Database Schema for Sakura Florist Solo
DROP DATABASE tokobungasakurasolo;
CREATE DATABASE tokobungasakurasolo;
USE tokobungasakurasolo;
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `visible` TINYINT(1) DEFAULT 1
);

CREATE TABLE IF NOT EXISTS `flowers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `image` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` LONGTEXT DEFAULT NULL,
  `price` INT NOT NULL,
  `categories_id` INT,
  `visible` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`categories_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `config` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `logo` VARCHAR(255),
  `favicon` VARCHAR(255),
  `description` TEXT,
  `whatsapp` VARCHAR(20),
  `facebook` VARCHAR(255),
  `instagram` VARCHAR(255),
  `wa_message` TEXT,
  `address` TEXT,
  `title` VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS `pages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `content` LONGTEXT,
  `visible` TINYINT(1) DEFAULT 1
);

-- Seed Data
INSERT INTO `users` (`username`, `password`) VALUES ('admin', '$2y$10$8.V77l8.V77l8.V77l8.V77l8.V77l8.V77l8.V77l8.V77l8.V77l'); -- password: admin (placeholder hash, will fix in script)

INSERT INTO `categories` (`name`) VALUES ('Bunga Papan'), ('Hand Bouquet'), ('Bunga Meja'), ('Standing Flower');

INSERT INTO `flowers` (`image`, `name`, `description`, `price`, `categories_id`) VALUES 
('assets/img/flowers/Bunga Papan/IMG-20251101-WA0088.jpg', 'Karangan Bunga Papan Wedding Lux', 'Rangkaian bunga papan mewah khusus untuk acara pernikahan. Menggunakan bunga segar pilihan dan desain yang elegan untuk memberikan kesan mendalam bagi mempelai.', 1200000, 1),
('assets/img/flowers/Bunga Papan/IMG-20251025-WA0018.jpg', 'Bunga Papan Duka Cita Eksklusif', 'Ungkapan bela sungkawa yang khidmat dengan desain bunga yang rapi dan pemilihan warna yang menenangkan sebagai tanda simpati terdalam.', 650000, 1),
('assets/img/flowers/Bunga Papan/IMG-20251103-WA0015.jpg', 'Bunga Papan Congratulations & Success', 'Rayakan pencapaian rekan bisnis atau kerabat dengan karangan bunga papan yang ceria dan penuh semangat untuk pembukaan toko atau peresmian kantor baru.', 850000, 1),
('assets/img/flowers/Standing Flower/IMG-20250826-WA0096.jpg', 'Standing Flower Lily Putih Premium', 'Rangkaian standing flower yang elegan dengan kombinasi bunga Lily putih dan Mawar, sangat cocok untuk menambah kemewahan di pintu masuk acara spesial Anda.', 1500000, 4),
('assets/img/flowers/Standing Flower/IMG-20250826-WA0083.jpg', 'Modern Standing Flower Colorful', 'Standing flower dengan nuansa warna-warni yang modern, memberikan kesan segar dan ceria untuk berbagai acara formal maupun informal.', 1100000, 4),
('assets/img/flowers/Table Bouquet/IMG-20240817-WA0067.jpg', 'Buket Meja Mawar Pink Romantis', 'Buket bunga meja yang cantik dengan mawar merah muda pilihan, dikemas dalam vas elegan yang siap memperindah sudut ruangan atau meja kerja Anda.', 450000, 3),
('assets/img/flowers/Table Bouquet/IMG-20230401-110254.jpg', 'Exclusive Table Flower Arrangement', 'Aransemen bunga meja eksklusif dengan paduan berbagai jenis bunga segar yang tahan lama, menghadirkan aroma harum di dalam ruangan.', 550000, 3),
('assets/img/flowers/Standing Flower/IMG-20250531-WA0048.jpg', 'Hand Bouquet Mawar Merah Klasik', 'Buket tangan mawar merah yang disusun secara artistik, pilihan sempurna sebagai hadiah romantis bagi orang tercinta di momen spesial.', 350000, 2);

INSERT INTO `config` (`title`, `logo`, `description`, `whatsapp`, `facebook`, `instagram`, `wa_message`, `address`) VALUES 
('Sakura Florist Solo', 'assets/img/logo.png', 'Toko bunga terpercaya di Solo. Karangan bunga kualitas terbaik untuk setiap momen Anda.', '081567883835', 'https://facebook.com/sakurafloristsolo', 'https://instagram.com/sakurafloristsolo', 'Min, saya mau order {{flower_name}}', 'SURAKARTA, Jawa Tengah, Indonesia');

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `excerpt` TEXT,
  `content` LONGTEXT,
  `image` VARCHAR(255),
  `visible` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Data (cont.)
INSERT INTO `blogs` (`title`, `slug`, `excerpt`, `content`, `image`) VALUES 
('5 Tips Memilih Karangan Bunga Papan di Solo untuk Berbagai Acara', 'tips-memilih-bunga-papan-solo', 'Sedang mencari karangan bunga papan di Solo? Simak 5 tips penting agar pesan Anda tersampaikan dengan elegan dan berkesan.', '<h2>Pentingnya Memilih Bunga Papan yang Tepat</h2><p>Di Solo, karangan bunga papan atau "stekwerk" adalah cara yang sangat populer untuk mengungkapkan perasaan, baik itu suka maupun duka. Namun, memilih yang terbaik tidaklah semudah kelihatannya.</p><h3>1. Sesuaikan Desain dengan Momen</h3><p>Pastikan desain bunga papan sesuai dengan acaranya. Untuk pernikahan (Wedding), gunakan warna-warna cerah dan romantis. Sedangkan untuk duka cita, pilihlah warna yang lebih tenang seperti kuning atau biru tua.</p><h3>2. Gunakan Bunga Segar Pilihan</h3><p>Toko bunga Solo yang berkualitas selalu menggunakan bunga segar seperti krisan, mawar, dan aster agar tampilan tetap prima selama acara berlangsung.</p>', 'assets/img/flowers/Bunga Papan/IMG-20251101-WA0088.jpg'),

('Makna Mendalam di Balik Setiap Warna Bunga Mawar', 'makna-warna-bunga-mawar', 'Ketahui arti dari setiap warna mawar sebelum Anda memberikannya kepada seseorang spesial. Jangan sampai salah pesan!', '<h2>Bahasa Bunga: Simbolisme Mawar</h2><p>Bunga mawar adalah ratunya bunga yang memiliki sejuta makna. Setiap warnanya mewakili emosi yang berbeda.</p><h3>Mawar Merah: Cinta dan Keberanian</h3><p>Mawar merah adalah simbol abadi untuk cinta sejati dan romansa. Sangat cocok diberikan saat Valentine atau Anniversary.</p><h3>Mawar Putih: Kemurnian dan Ketulusan</h3><p>Putih melambangkan kesucian. Sering digunakan dalam buket pernikahan atau sebagai tanda penghormatan terakhir.</p><h3>Mawar Pink: Kekaguman dan Terima Kasih</h3><p>Berikan mawar merah muda untuk menunjukkan rasa terima kasih atau kekaguman yang manis kepada teman atau kerabat.</p>', 'assets/img/flowers/Standing Flower/IMG-20250531-WA0048.jpg'),

('Cara Merawat Bunga Meja Agar Tetap Segar dan Tahan Lama', 'merawat-bunga-meja-segar', 'Ingin bunga meja Anda awet hingga berhari-hari? Ikuti panduan praktis dari florist profesional kami di Solo.', '<h2>Tips Menjaga Kesegaran Bunga di Dalam Ruangan</h2><p>Bunga meja (Table Bouquet) dapat memberikan nuansa segar di rumah atau kantor. Namun, tanpa perawatan yang benar, bunga akan cepat layu.</p><h3>Ganti Air Secara Teratur</h3><p>Pastikan air di dalam vas selalu bersih. Ganti air setiap dua hari sekali untuk mencegah pertumbuhan bakteri yang dapat menyumbat batang bunga.</p><h3>Potong Batang Secara Diagonal</h3><p>Setiap kali mengganti air, potong ujung batang sekitar 1-2 cm dengan kemiringan 45 derajat agar daya serap air lebih maksimal.</p><h3>Hindari Sinar Matahari Langsung</h3><p>Letakkan bunga di tempat yang sejuk dan jauhkan dari paparan sinar matahari langsung atau hembusan AC yang terlalu kuat.</p>', 'assets/img/flowers/Table Bouquet/IMG-20240817-WA0067.jpg'),

('Mengapa Hand Bouquet Selalu Jadi Kado Wisuda Favorit di Solo', 'buket-wisuda-solo-terfavorit', 'Buket tangan atau hand bouquet adalah pelengkap sempurna saat momen wisuda. Intip mengapa kado ini tak lekang oleh waktu.', '<h2>Momen Spesial dengan Buket Bunga Wisuda</h2><p>Wisuda adalah pencapaian besar dalam hidup. Memberikan buket bunga bukan hanya tradisi, tapi juga bentuk apresiasi tertinggi.</p><h3>Kecantikan yang Estetik di Foto</h3><p>Hand bouquet memberikan elemen visual yang sangat cantik saat sesi foto wisuda. Bunga pastel atau mawar merah sering menjadi pilihan utama mahasiswa di Solo.</p><h3>Pesan yang Personal</h3><p>Anda bisa menyelipkan kartu ucapan berisi motivasi atau doa bagi wisudawan, membuat kado ini terasa sangat personal dan berkesan.</p><h3>Varian yang Beragam</h3><p>Mulai dari buket mawar klasik hingga kombinasi bunga matahari yang ceria, Anda bisa menyesuaikan buket dengan karakter sang wisudawan.</p>', 'assets/img/flowers/Table Bouquet/IMG-20230221115901.jpg'),

('Trend Standing Flower untuk Grand Opening Usaha Baru di Solo', 'standing-flower-grand-opening-solo', 'Tingkatkan prestise acara pembukaan usaha Anda dengan Standing Flower yang mewah dan modern. Simak tren terbarunya!', '<h2>Elegansi Standing Flower dalam Acara Formal</h2><p>Berbeda dengan bunga papan, standing flower menawarkan kesan yang lebih eksklusif dan minimalis namun tetap mewah.</p><h3>Pemanis Sudut Ruangan</h3><p>Standing flower sangat efektif untuk menghias pintu masuk atau sudut ruangan toko. Bentuknya yang ramping tidak memakan banyak tempat tapi tetap mencuri perhatian.</p><h3>Kombinasi Bunga Premium</h3><p>Tren terbaru di Solo adalah menggunakan perpaduan bunga Lily, Mawar, dan Baby Breath untuk memberikan kesan "High-End" pada acara Grand Opening.</p><h3>Tanda Dukungan Rekan Bisnis</h3><p>Mengirimkan standing flower kepada mitra bisnis yang baru membuka usaha adalah bentuk dukungan yang sangat elegan dan profesional.</p>', 'assets/img/flowers/Standing Flower/IMG-20250826-WA0096.jpg');
