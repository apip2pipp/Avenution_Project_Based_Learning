<?php
// Simple database connection test
$host = '127.0.0.1';
$db   = 'avenution';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    echo "✅ MySQL Connection: SUCCESS\n\n";
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Database '$db' created or already exists\n\n";
    
    // Select database
    $pdo->exec("USE `$db`");
    echo "✅ Database '$db' selected\n\n";
    
    echo "🎉 Database setup complete! You can now run migrations.\n";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
    echo "\n📝 Troubleshooting:\n";
    echo "1. Pastikan XAMPP/Laragon MySQL sudah running\n";
    echo "2. Check username & password di .env\n";
    echo "3. Test buka http://localhost/phpmyadmin\n";
}
