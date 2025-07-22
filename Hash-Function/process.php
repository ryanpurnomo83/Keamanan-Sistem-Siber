<?php
    require_once 'DES-Encryption.php';
    require_once 'MD5-Hashing.php';
    require_once 'Random-Salting.php';

    $username = $_POST['Username'];
    $password = $_POST['Password'];

    if(isset($_POST['signupsave']) && $_POST['signupsave'] == 0){
        signupsave($username, $password);
    }else if(isset($_POST['signinchecker']) && $_POST['signinchecker'] == 1){
        signinchecker($username, $password);
    }

    function signupsave($username, $password){
        $username;
        $password;

        $encrypt = passwordencrypt($password);
        $decrypt = passworddecrypt($encrypt);
        $hash = passwordhash($password);
        $salt = saltgenerator();
        $finalpassword = finalpassword($password, $salt);

        $data = "Username : $username\n";
        $data .= "Password Asli: $password\n";
        $data .= "Password Encrypted: $encrypt\n";
        $data .= "Password Decrypted: $decrypt\n";
        $data .= "Password Hashed: $hash\n";
        $data .= "Salt: $salt\n";
        $data .= "Final Password: $finalpassword\n";

        $filename = "$username.txt";
        file_put_contents($filename, $data, FILE_APPEND);
        header('Location: success.php');
        exit();
    }

    function signinchecker($username, $password){
        $filename = "$username.txt";
        $data = file_get_contents($filename);

        if ($data !== false) {
            $saltPosition = strpos($data, "Salt: ");
            $finalPasswordPosition = strpos($data, "Final Password: ");
            
            if ($saltPosition !== false && $finalPasswordPosition !== false) {
                $saltStart = $saltPosition + strlen("Salt: ");
                $saltEnd = strpos($data, "\n", $saltStart);
                $saltt = trim(substr($data, $saltStart, $saltEnd - $saltStart));

                $finalpassStart = $finalPasswordPosition + strlen("Final Password: ");
                $finalpassEnd = strpos($data, "\n", $finalpassStart);
                if ($finalpassEnd === false) {
                    $finalpasst = trim(substr($data, $finalpassStart));
                } else {
                    $finalpasst = trim(substr($data, $finalpassStart, $finalpassEnd - $finalpassStart));
                }
    
                //echo "Salt: " . $saltt . "<br>";
                //echo "Final Password dari file: " . $finalpasst . "<br>";

                $encrypt = passwordencrypt($password);
                $decrypt = passworddecrypt($encrypt);
                $hash = passwordhash($password);
                $final_password_chckr = finalpassword($password, $saltt);
    
                //echo "Final Password hasil fungsi: " . $final_password_chckr . "<br>";
    
                if ($final_password_chckr == $finalpasst) {
                    echo "Password cocok!";
                    header('Location: success2.php');
                    exit();
                } else {
                    echo "Password tidak cocok.";
                }  
            } else {
                echo "Salt atau Final Password tidak ditemukan dalam file.";
            }
        } else {
            echo "Gagal membaca file.";
        }
    }

    function passwordencrypt($password){
        $key = "12345678"; 
        $encrypted_passwordp = des_encrypt_long($password, $key); 
        $encrypted_password = bin2hex($encrypted_passwordp);
        return $encrypted_password;
    }

    function passworddecrypt($password){
        $key = "12345678";
        $binary_password = hex2bin($password);
        $decrypted_password = des_decrypt_long($binary_password, $key);
        return $decrypted_password;
    }

    function passwordhash($password){
        $hashed_password = md5_custom($password);
        return $hashed_password;
    }

    function saltgenerator(){
        $salt_value = generateRandomSalt();
        return $salt_value;
    }

    function finalpassword($password, $salt){
        $saltvalue = $salt;
        //echo "Salt Value (finalpassword) : " . $saltvalue . "<br>";
        $pass_hash_salt = $password . $saltvalue;
        $final_password = passwordhash($pass_hash_salt);
        return $final_password;
    }
?>