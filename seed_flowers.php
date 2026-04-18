<?php
/**
 * Seeding Script for Flower Dummy Data
 * Sakura Florist Solo
 */

require_once 'config/db.php';

echo "Starting seeding flower categories...\n";

$categories = [
    ['name' => 'Bunga Papan'],
    ['name' => 'Hand Bouquet'],
    ['name' => 'Bunga Meja'],
    ['name' => 'Standing Flower'],
];

foreach ($categories as $cat) {
    try {
        $stmt = $pdo->prepare("INSERT IGNORE INTO categories (name) VALUES (?)");
        $stmt->execute([$cat['name']]);
        echo "Category '{$cat['name']}' added or already exists.\n";
    } catch (PDOException $e) {
        echo "Error adding category '{$cat['name']}': " . $e->getMessage() . "\n";
    }
}

// Get category IDs
$catIds = [];
$stmt = $pdo->query("SELECT id, name FROM categories");
while ($row = $stmt->fetch()) {
    $catIds[$row['name']] = $row['id'];
}

echo "\nStarting seeding flower data...\n";

$flowers = [
    [
        'image' => 'assets/img/flowers/Bunga Papan/IMG-20251101-WA0088.jpg',
        'name' => 'Karangan Bunga Papan Wedding Lux',
        'description' => 'Rangkaian bunga papan mewah khusus untuk acara pernikahan. Menggunakan bunga segar pilihan dan desain yang elegan untuk memberikan kesan mendalam bagi mempelai.',
        'price' => 1200000,
        'category' => 'Bunga Papan'
    ],
    [
        'image' => 'assets/img/flowers/Bunga Papan/IMG-20251025-WA0018.jpg',
        'name' => 'Bunga Papan Duka Cita Eksklusif',
        'description' => 'Ungkapan bela sungkawa yang khidmat dengan desain bunga yang rapi dan pemilihan warna yang menenangkan sebagai tanda simpati terdalam.',
        'price' => 650000,
        'category' => 'Bunga Papan'
    ],
    [
        'image' => 'assets/img/flowers/Bunga Papan/IMG-20251103-WA0015.jpg',
        'name' => 'Bunga Papan Congratulations & Success',
        'description' => 'Rayakan pencapaian rekan bisnis atau kerabat dengan karangan bunga papan yang ceria dan penuh semangat untuk pembukaan toko atau peresmian kantor baru.',
        'price' => 850000,
        'category' => 'Bunga Papan'
    ],
    [
        'image' => 'assets/img/flowers/Standing Flower/IMG-20250826-WA0096.jpg',
        'name' => 'Standing Flower Lily Putih Premium',
        'description' => 'Rangkaian standing flower yang elegan dengan kombinasi bunga Lily putih dan Mawar, sangat cocok untuk menambah kemewahan di pintu masuk acara spesial Anda.',
        'price' => 1500000,
        'category' => 'Standing Flower'
    ],
    [
        'image' => 'assets/img/flowers/Standing Flower/IMG-20250826-WA0083.jpg',
        'name' => 'Modern Standing Flower Colorful',
        'description' => 'Standing flower dengan nuansa warna-warni yang modern, memberikan kesan segar dan ceria untuk berbagai acara formal maupun informal.',
        'price' => 1100000,
        'category' => 'Standing Flower'
    ],
    [
        'image' => 'assets/img/flowers/Table Bouquet/IMG-20240817-WA0067.jpg',
        'name' => 'Buket Meja Mawar Pink Romantis',
        'description' => 'Buket bunga meja yang cantik dengan mawar merah muda pilihan, dikemas dalam vas elegan yang siap memperindah sudut ruangan atau meja kerja Anda.',
        'price' => 450000,
        'category' => 'Bunga Meja'
    ],
    [
        'image' => 'assets/img/flowers/Table Bouquet/IMG-20230401-110254.jpg',
        'name' => 'Exclusive Table Flower Arrangement',
        'description' => 'Aransemen bunga meja eksklusif dengan paduan berbagai jenis bunga segar yang tahan lama, menghadirkan aroma harum di dalam ruangan.',
        'price' => 550000,
        'category' => 'Bunga Meja'
    ],
    [
        'image' => 'assets/img/flowers/Standing Flower/IMG-20250531-WA0048.jpg',
        'name' => 'Hand Bouquet Mawar Merah Klasik',
        'description' => 'Buket tangan mawar merah yang disusun secara artistik, pilihan sempurna sebagai hadiah romantis bagi orang tercinta di momen spesial.',
        'price' => 350000,
        'category' => 'Hand Bouquet'
    ],
];

foreach ($flowers as $flower) {
    try {
        $stmt = $pdo->prepare("INSERT INTO flowers (image, name, description, price, categories_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $flower['image'],
            $flower['name'],
            $flower['description'],
            $flower['price'],
            $catIds[$flower['category']]
        ]);
        echo "Flower '{$flower['name']}' added successfully.\n";
    } catch (PDOException $e) {
        echo "Error adding flower '{$flower['name']}': " . $e->getMessage() . "\n";
    }
}

echo "\nSeeding completed!\n";
