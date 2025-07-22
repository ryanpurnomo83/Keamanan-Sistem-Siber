<?php

// 1. Fixed Salt
function generateFixedSalt() {
    $fixedSalt = "FixedSalt1234"; // Tetapkan nilai salt tetap yang sama untuk setiap hash
    return $fixedSalt;
}

// 2. Random Salt
function generateRandomSalt($length = 16) {
    $randomSalt = bin2hex(random_bytes($length / 2)); // Membuat salt acak dengan panjang yang diinginkan
    return $randomSalt;
}

// 3. Pepper Salt
function generatePepperSalt() {
    $pepper = "PepperSecretKey"; // Tetapkan nilai 'pepper' tetap untuk seluruh aplikasi
    return $pepper;
}

// 4. Adaptive Salt (misalnya dengan bcrypt)
function generateAdaptiveSalt($password) {
    $options = [
        'cost' => 12, // Mengatur biaya (default biasanya 10-12 untuk bcrypt)
    ];
    $hash = password_hash($password, PASSWORD_BCRYPT, $options); // Bcrypt secara otomatis menambahkan salt secara adaptif
    return $hash;
}

/*
// Menggunakan fungsi generate salt untuk melihat hasil masing-masing
$password = "examplePassword";

// Fixed Salt
$fixedSaltHash = hash('sha256', $password . generateFixedSalt());
echo "Fixed Salt Hash: " . $fixedSaltHash . "\n";

// Random Salt
$randomSalt = generateRandomSalt();
$randomSaltHash = hash('sha256', $password . $randomSalt);
echo "Random Salt Hash: " . $randomSaltHash . " (Salt: " . $randomSalt . ")\n";

// Pepper Salt
$pepperSaltHash = hash('sha256', $password . generatePepperSalt());
echo "Pepper Salt Hash: " . $pepperSaltHash . "\n";

// Adaptive Salt (Bcrypt)
$adaptiveSaltHash = generateAdaptiveSalt($password);
echo "Adaptive Salt Hash: " . $adaptiveSaltHash . "\n";
*/
?>
