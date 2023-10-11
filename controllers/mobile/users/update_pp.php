<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "arenafinder");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // post request
    $email = $_POST['email'];
    $photo = $_POST['photo'];

    // saving photo
    $photo = str_replace('data:image/png;base64,', '', $photo);
    $photo = str_replace(' ', '+', $photo);
    $data = base64_decode($photo);
    $filename = uniqid() . '.png';
    $file = '../../../public/img/user-photo/' . $filename;
    file_put_contents($file, $data);

    // get data user
    $sql = "UPDATE users SET user_photo = '$filename' WHERE email = '$email'";
    $result = $conn->query($sql);

    if($result === true){
        $sql = "SELECT user_photo FROM users WHERE email = '$email' LIMIT 1";
        $result = $conn->query($sql);
        $photo = $result->fetch_assoc();

        if($result->num_rows == 1){
            $response = array("status"=>"success", "message"=>"photo profile berhasil diupdate", "data"=>$photo);
        }else{
            $response = array("status"=>"success", "message"=>"photo profile berhasil diupdate");
        }
        
    }else{
        $response = array("status"=>"error", "message"=>"photo profile gagal diupdate");
    }

    $conn->close();
    echo json_encode($response);
}else{
    echo json_encode(array("status"=>"error", "message"=>"method is not post"));
}

?>
