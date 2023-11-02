<?php

require "../../koneksi.php";

class Venue{

    function get(){
        $sql = "SELECT 
        v.id_venue, v.venue_name, v.venue_photo, v.sport, v.status,
        v.price AS harga,
        IFNULL((SUM(r.rating) / COUNT(r.id_review)), 0) AS rating,
        IFNULL(MIN(p.price), 0) AS harga_sewa
        FROM venues AS v 
        LEFT JOIN venue_price AS p
        ON v.id_venue = p.id_venue
        LEFT JOIN venue_review AS r 
        ON v.id_venue = r.id_venue
        GROUP BY v.id_venue
        ORDER BY v.id_venue DESC
        ;
        ";
        $result = $conn->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);

        if ($result->num_rows >= 1) {
            $response = array("status"=>"success", "message"=>"data didapatkan", "data"=>$data);
        }

        // close koneksi
        $conn->close();
    }

}

?>