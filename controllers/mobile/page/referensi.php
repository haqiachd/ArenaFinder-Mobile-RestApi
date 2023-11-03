<?php
require "../../koneksi.php";

header("Content-Type: application/json");

function createQueryForVenue($operasional, $sewa, $where, $order, $limit){

    // query dengan jam operasional
    $qOperasionalData = '';
    $qOperasionalJoin = '';
    if($operasional === true){
        $qOperasionalData = "
            IFNULL(o.opened, '-') AS jam_buka, 
            IFNULL(o.closed, '-') AS jam_tutup,
        ";
        $qOperasionalJoin = "
            LEFT JOIN venue_operasional AS o 
            ON v.id_venue = o.id_venue";
    }

    // query dengan harga sewa
    $qHargaSewaData = '';
    $qHargaSewaJoin = '';
    if($sewa === true){
        $qHargaSewaData = "
            , IFNULL(
                MIN(p.price), 0
            ) AS harga_sewa
        ";
        $qHargaSewaJoin = "
            LEFT JOIN venue_price AS p
            ON v.id_venue = p.id_venue
        ";
    }

    // buat query
    return "SELECT 
        v.id_venue, v.venue_name, v.venue_photo, v.sport, v.status, v.coordinate,
        $qOperasionalData
        IFNULL(
            COUNT(r.id_review), 0
        ) AS total_review,
        IFNULL(
            ROUND(SUM(r.rating) / COUNT(r.id_review), 1), 0
        ) AS rating,
        v.price AS harga 
        $qHargaSewaData
        FROM venues AS v 
        LEFT JOIN venue_review AS r 
        ON v.id_venue = r.id_venue 
        $qHargaSewaJoin 
        $qOperasionalJoin
        $where 
        GROUP BY v.id_venue
        $order
        LIMIT $limit
    ";
}

/**
 * get venue by top ratting
 */
function fetchVenueRatting($conn, $limit)
{
    $sql = createQueryForVenue(
        true, true,
        "", 
        "ORDER BY rating DESC, total_review DESC",
        $limit
    );

    // echo $sql;

    $result = $conn->query($sql);

    if ($result) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        if (!empty($data)) {
            return array("status" => "success", "message" => "Data berhasil didapatkan", "data" => $data);
        } else {
            return array("status" => "error", "message" => "Data tidak ditemukan");
        }
    } else {
        return array("status" => "error", "message" => "Perintah gagal dijalankan" . $conn->error);
    }
}

/**
 * get venue by location
 */
function fetchVenueLokasi($conn, $limit)
{
    $sql = createQueryForVenue(
        false, false, 
        "", 
        "ORDER BY rating DESC, total_review DESC",
        $limit
    );

    $result = $conn->query($sql);

    if ($result) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        if (!empty($data)) {
            return array("status" => "success", "message" => "Data berhasil didapatkan", "data" => $data);
        } else {
            return array("status" => "error", "message" => "Data tidak ditemukan");
        }
    } else {
        return array("status" => "error", "message" => "Perintah gagal dijalankan" . $conn->error);
    }
}

/**
 * get venue by venue kosong
 */
function fetchVenueKosong($conn, $limit)
{
    $sql = createQueryForVenue(
        true, true, 
        "WHERE v.status = 'Disewakan'", 
        "ORDER BY rating DESC, total_review DESC",
        $limit
    );

    $result = $conn->query($sql);

    if ($result) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        if (!empty($data)) {
            return array("status" => "success", "message" => "Data berhasil didapatkan", "data" => $data);
        } else {
            return array("status" => "error", "message" => "Data tidak ditemukan");
        }
    } else {
        return array("status" => "error", "message" => "Perintah gagal dijalankan" . $conn->error);
    }
}

/**
 * get venue by venue 'gratis'
 */
function fetchVenueGratis($conn, $limit){

    $sql = createQueryForVenue(
        true, false, 
        "WHERE v.status = 'Gratis'",
        "ORDER BY rating DESC, total_review DESC ",
        $limit
    );
    
    $result = $conn->query($sql);

    if ($result) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        if (!empty($data)) {
            return array("status" => "success", "message" => "Data berhasil didapatkan", "data" => $data);
        } else {
            return array("status" => "error", "message" => "Data tidak ditemukan");
        }
    } else {
        return array("status" => "error", "message" => "Perintah gagal dijalankan" . $conn->error);
    }
}

/**
 * get venue by top status 'berbayar'
 */
function fetchVenueBerbayar($conn, $limit){

    $sql = createQueryForVenue(
        true, false, 
        "WHERE v.status = 'Berbayar'",
        "ORDER BY rating DESC, total_review DESC, v.price ASC",
        $limit
    );
    
    $result = $conn->query($sql);

    if ($result) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        if (!empty($data)) {
            return array("status" => "success", "message" => "Data berhasil didapatkan", "data" => $data);
        } else {
            return array("status" => "error", "message" => "Data tidak ditemukan");
        }
    } else {
        return array("status" => "error", "message" => "Perintah gagal dijalankan" . $conn->error);
    }
}

/**
 * get venue by venue 'disewakan'
 */
function fetchVenueDisewakan($conn, $limit){

    $sql = createQueryForVenue(
        true, true, 
        "WHERE v.status = 'Disewakan'",
        "ORDER BY rating DESC, total_review DESC, v.price ASC",
        $limit
    );
    
    $result = $conn->query($sql);

    if ($result) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        if (!empty($data)) {
            return array("status" => "success", "message" => "Data berhasil didapatkan", "data" => $data);
        } else {
            return array("status" => "error", "message" => "Data tidak ditemukan");
        }
    } else {
        return array("status" => "error", "message" => "Perintah gagal dijalankan" . $conn->error);
    }
}

function searchByName($conn, $limit) {

    $sql = "SELECT ";;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $limit = 5;

    // get data dashboard
    $venueRatting = fetchVenueRatting($conn, $limit);
    $venueLokasi = fetchVenueLokasi($conn, $limit);
    $venueKosong = fetchVenueKosong($conn, $limit);
    $venueGratis = fetchVenueGratis($conn, $limit);
    $venueBerbayar = fetchVenueBerbayar($conn, $limit);
    $venueDisewakan = fetchVenueDisewakan($conn, $limit);

    // cek apakah data status venue error atau tidak
    if ($venueRatting['status'] == 'error'){
        $venueRatting = array("data"=>[]);
    }

    if ($venueLokasi['status'] == 'error'){
        $venueLokasi = array("data"=>[]);
    }

    if ($venueKosong['status'] == 'error'){
        $venueKosong = array("data"=>[]);
    }

    if ($venueGratis["status"] == "error"){
        $venueGratis = array("data"=>[]);
    }

    if ($venueBerbayar["status"] == "error"){
        $venueBerbayar = array("data"=>[]);
    }

    if ($venueDisewakan["status"] == "error"){
        $venueDisewakan = array("data"=>[]);
    }

    // menyimpan data halaman referensi mobile
    $data = array(
        "top_ratting" => $venueRatting['data'],
        "venue_lokasi" => $venueLokasi["data"],
        "venue_kosong" => $venueKosong["data"],
        "venue_gratis" => $venueGratis['data'],
        "venue_berbayar" => $venueBerbayar["data"],
        "venue_disewakan"=> $venueDisewakan["data"],
    );

    // response sukses
    $response = array("status" => "success", "message" => "Data beranda sukses didapatkan", "data" => $data);
} else {
    $response = array("status" => "error", "message" => "not get method");
}

echo json_encode($response);

?>