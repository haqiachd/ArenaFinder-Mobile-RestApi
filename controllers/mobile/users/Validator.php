<?php

class Validator{

    function isNull($data) {
        if ($data !== null) {
            return empty(trim($data));
        } else {
            return true;
        }
    }

    function isValidUsername($username) {
        // Allowed characters are letters, numbers, '.', ',', '-', and '_'
        $allowedCharacters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.,-_";
        
        // Check if username is null or empty
        if ($this->isNull($username)) {
            $response = array("status"=>"error", "message"=>"Username tidak boleh kosong");
        }
        // Check the length of the username (between 4 and 20 characters)
        else if (strlen($username) < 4 || strlen($username) > 20) {
            $response = array("status"=>"error", "message"=>"Username harus diantara 4-20 karakter");
        }else{
            // Check each character in the username
            $chars = str_split($username);
            foreach ($chars as $c) {
                if (strpos($allowedCharacters, $c) === false) {
                    $response = array("status"=>"error", "message"=>"Simbol yang diizinkan hanyalah . , - _");
                }else{
                    // If the username is valid
                    $response = array("status"=>"success", "message"=>"Username valid");
                }
            }
        }

        // show response
        echo json_encode($response);
    }

    function isValidEmail($email) {
        // Regex untuk alamat email
        $emailRegex = '/^[_A-Za-z0-9-]+(\\.[_A-Za-z0-9-]+)*@'
                    . '[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/';
    
        // Cek apakah email null atau kosong
        if ($this->isNull($email)) {
            $response = array("status"=>"error", "message"=>"Email tidak boleh kosong");
        }
        // cek regex email
        else if (!preg_match($emailRegex, $email)) {
            $response = array("status"=>"error", "message"=>"Email tidak valid");
        } else {
            $response = array("status"=>"success", "message"=>"Email valid");
        }

        echo json_encode($response);
    }

    function isValidName($name) {
    
        // Cek apakah nama null atau kosong
        if ($this->isNull($name)) {
            $response = array("status"=>"error", "message"=>"Nama tidak boleh kosong");
        }
        // Panjang nama harus berada dalam rentang 4 hingga 50 karakter.
        else if (strlen($name) < 4 || strlen($name) > 50) {
            $response = array("status"=>"error", "message"=>"Nama harus diantara 4–50 karakter");
        }
        // Nama tidak boleh mengandung angka.
        else if (preg_match('/\d/', $name)) {
            $response = array("status"=>"error", "message"=>"Nama tidak boleh mengandung angka");
        }
        // Karakter yang diizinkan adalah '.', ',', '-', dan ''' (tanda kutip tunggal).
        else if (!preg_match('/^[a-zA-Z.,\\-\' ]+$/', $name)) {
            $response = array("status"=>"error", "message"=>"Simbol yang diizinkan hanyalah .,-'");
        }
        // jika email vali
        else {
            $response = array("status"=>"success", "message"=>"Nama valid");
        }
    
        echo json_encode($response);
    }

    function isValidPassword($password) {
    
        // Cek apakah password null atau kosong
        if ($this->isNull($password)){
            $response = array("status"=>"error", "message"=>"Password tidak boleh kosong");
        }
        // Panjang password harus berada dalam rentang 8 hingga 30 karakter.
        else if (strlen($password) < 8 || strlen($password) > 30) {
            $response = array("status"=>"error", "message"=>"Password harus diantara 8-30 karakter");
        }
        // Password harus mengandung setidaknya satu huruf kecil.
        else if (!preg_match('/[a-z]/', $password)) {
            $response = array("status"=>"error", "message"=>"Password harus mengandung huruf kecil");
        }
        // Password harus mengandung setidaknya satu huruf besar.
        else if (!preg_match('/[A-Z]/', $password)) {
            $response = array("status"=>"error", "message"=>"Password harus mengadung huruf besar");
        }
        // Password harus mengandung setidaknya satu angka.
        else if (!preg_match('/[0-9]/', $password)) {
            $response = array("status"=>"error", "message"=>"Password harus mengandung angka");
        }
        // Password harus mengandung setidaknya satu simbol (contoh: !@#$%^&*()_+{}[]:;<>,.?~\/|=).
        else if (!preg_match('/[!@#$%^&*()_+{}\[\]:;<>,.?~\/|=]/', $password)) {
            $response = array("status"=>"error", "message"=>"Password harus mengandung simbol");
        }
        // password valid
        else{
            $response = array("status"=>"error", "message"=>"Kata sandi valid");
        }
    
        echo json_encode($response);
    }
    

}

?>