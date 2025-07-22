<?php

function generateRandomSalt($length = 16) {
    $randomSalt = bin2hex(random_bytes($length / 2)); // Membuat salt acak dengan panjang yang diinginkan
    return $randomSalt;
}

?>