<?php

require "../../../../koneksi.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the request
    $idVenue = $_POST['id_venue'];
    $email = $_POST['email'];
    $totalPrice = $_POST['total_price'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO venue_booking (id_venue, email, total_price, created_at) VALUES (?, ?, ?, NOW())");

    // Bind parameters correctly
    $stmt->bind_param("iss", $idVenue, $email, $totalPrice);

    if ($stmt->execute()) {

        $sql = "SELECT * FROM venue_booking 
            WHERE id_venue = $idVenue AND
            email = '$email' AND 
            total_price = '$totalPrice'
            ORDER BY id_booking DESC 
            LIMIT 1
        ";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $response = ["status" => "success", "message" => "Data inserted successfully", "data" => $data];
        }else{
            $response = ["status" => "error", "message" => "Data inserted failure"];
        }

        // Data inserted successfully
        
        echo json_encode($response);
    } else {
        // Failed to insert data
        $response = ["status" => "error", "message" => "Failed to insert data"];
        echo json_encode($response);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Invalid request method
    $response = ["status" => "error", "message" => "Invalid request method"];
    echo json_encode($response);
}
?>