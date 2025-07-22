<?php

function des($input, $key, $mode = 'encrypt') {
    // Initial Permutation (IP) - disederhanakan
    $data = initial_permutation($input);
    echo $data . "\n";

    // Pisahkan data menjadi dua bagian
    $left = substr($data, 0, 4);
    $right = substr($data, 4, 4);

    // Tentukan arah putaran berdasarkan mode
    $start = $mode === 'encrypt' ? 0 : 15;
    $end = $mode === 'encrypt' ? 16 : -1;
    $step = $mode === 'encrypt' ? 1 : -1;

    for ($i = $start; $i !== $end; $i += $step) {
        $expanded = expansion($right); //kata kanan
        $round_key = round_key($key, $i); //nilai kunci

        $xor_result = xor_operation($expanded, $round_key); //mengahsilkan nilai XOR
        $substituted = substitution($xor_result);
        $permuted = permutation($substituted);

        // Feistel function
        $new_right = xor_operation($left, $permuted);
        $left = $right;
        $right = $new_right;
    }

    // Gabungkan kembali kiri dan kanan sebelum Final Permutation
    $pre_output = $right . $left;
    return final_permutation($pre_output);
}

function initial_permutation($input) {
    return strrev($input); // permutasi sederhana
}

function expansion($input) {
    return $input; // tidak ada ekspansi kompleks untuk penyederhanaan
}

function xor_operation($a, $b) {
    $result = '';
    for ($i = 0; $i < strlen($a); $i++) {
        $result .= $a[$i] ^ $b[$i];
    }
    return $result;
}

function substitution($input) {
    $substituted = '';
    for ($i = 0; $i < strlen($input); $i++) {
        $substituted .= $input[$i] ^ chr(1); // XOR dengan nilai tetap
    }
    return $substituted;
}

function round_key($key, $round) {
    return substr($key, 0, 4); // kunci putaran tetap sederhana
}

function permutation($input) {
    return strrev($input); // balik urutan sebagai permutasi sederhana
}

function final_permutation($input) {
    return strrev($input); // balik urutan untuk permutasi final
}

function des_encrypt_long($plaintext, $key) {
    $ciphertext = '';
    $block_size = 8; // 64 bit = 8 byte

    // Enkripsi tiap blok
    for ($i = 0; $i < strlen($plaintext); $i += $block_size) {
        $block = substr($plaintext, $i, $block_size);

        // Tambah padding jika blok kurang dari 64 bit
        if (strlen($block) < $block_size) {
            $block = str_pad($block, $block_size, "\0"); // Padding dengan karakter null
        }

        // Enkripsi blok dan tambahkan ke hasil
        $ciphertext .= des($block, $key, 'encrypt');
    }

    return $ciphertext;
}

function des_decrypt_long($ciphertext, $key) {
    $plaintext = '';
    $block_size = 8; // 64 bit = 8 byte

    // Dekripsi tiap blok
    for ($i = 0; $i < strlen($ciphertext); $i += $block_size) {
        $block = substr($ciphertext, $i, $block_size);

        // Dekripsi blok dan tambahkan ke hasil
        $plaintext .= des($block, $key, 'decrypt');
    }

    return rtrim($plaintext, "\0"); // Hapus padding null karakter
}

?>
