<?php

function md5_custom($input) {
    $input = utf8_encode($input);  // Encoding ke UTF-8 jika diperlukan
    $input_len = strlen($input);
    $bit_len = $input_len * 8;

    // Padding sesuai aturan MD5: bit '1' diikuti dengan beberapa '0' hingga panjang 448 mod 512
    $input .= chr(0x80);  // Menambahkan bit '1' sebagai karakter 0x80
    while ((strlen($input) % 64) !== 56) {
        $input .= chr(0x00);  // Tambahkan karakter '0' hingga panjang 448 mod 512
        echo $input . "\n";
    }

    // Tambahkan panjang asli dalam format 64-bit di bagian akhir blok
    $input .= pack('V2', $bit_len & 0xFFFFFFFF, ($bit_len >> 32) & 0xFFFFFFFF);

    // Inisialisasi variabel
    $a = 0x67452301;
    $b = 0xefcdab89;
    $c = 0x98badcfe;
    $d = 0x10325476;

    // Konstanta shift
    $shifts = [7, 12, 17, 22, 7, 12, 17, 22, 7, 12, 17, 22, 7, 12, 17, 22,
               5, 9, 14, 20, 5, 9, 14, 20, 5, 9, 14, 20, 5, 9, 14, 20,
               4, 11, 16, 23, 4, 11, 16, 23, 4, 11, 16, 23, 4, 11, 16, 23,
               6, 10, 15, 21, 6, 10, 15, 21, 6, 10, 15, 21, 6, 10, 15, 21];

    // Konstanta T
    $T = [];
    for ($i = 1; $i <= 64; $i++) {
        $T[$i - 1] = (int)(abs(sin($i)) * pow(2, 32));
    }

    // Pembagian input menjadi blok 512-bit (64-byte)
    for ($i = 0; $i < strlen($input); $i += 64) {
        $block = substr($input, $i, 64);
        $M = array_values(unpack('V16', $block));  // Membagi blok menjadi 16 bagian 32-bit

        // Simpan nilai awal
        $AA = $a;
        $BB = $b;
        $CC = $c;
        $DD = $d;

        // 64 langkah utama MD5
        for ($j = 0; $j < 64; $j++) {
            if ($j < 16) {
                $F = ($b & $c) | ((~$b) & $d);
                $g = $j;
            } elseif ($j < 32) {
                $F = ($d & $b) | ((~$d) & $c);
                $g = (5 * $j + 1) % 16;
            } elseif ($j < 48) {
                $F = $b ^ $c ^ $d;
                $g = (3 * $j + 5) % 16;
            } else {
                $F = $c ^ ($b | (~$d));
                $g = (7 * $j) % 16;
            }

            $F = ($F + $a + $T[$j] + $M[$g]) & 0xFFFFFFFF;
            $a = $d;
            $d = $c;
            $c = $b;
            $b = ($b + (($F << $shifts[$j]) | ($F >> (32 - $shifts[$j])))) & 0xFFFFFFFF;
        }

        // Tambahkan hasil blok ke hash
        $a = ($a + $AA) & 0xFFFFFFFF;
        $b = ($b + $BB) & 0xFFFFFFFF;
        $c = ($c + $CC) & 0xFFFFFFFF;
        $d = ($d + $DD) & 0xFFFFFFFF;
    }

    // Gabungkan hasil akhir
    return sprintf('%08x%08x%08x%08x', $a, $b, $c, $d);
}

?>
