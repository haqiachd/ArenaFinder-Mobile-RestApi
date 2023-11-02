<?php

require "../../koneksi.php";

header("Content-Type: application/json");

function fetchVenueBaru($conn, $limit)
{
    $sql = "SELECT 
        v.id_venue, v.venue_name, v.venue_photo, v.sport, v.status,
        IFNULL(
            (SUM(r.rating) / COUNT(r.id_review)), 0
        ) AS rating,
        v.price AS harga,
        IFNULL(
            MIN(p.price), 0
        ) AS harga_sewa
        FROM venues AS v 
        LEFT JOIN venue_price AS p
        ON v.id_venue = p.id_venue
        LEFT JOIN venue_review AS r 
        ON v.id_venue = r.id_venue
        GROUP BY v.id_venue
        ORDER BY v.id_venue DESC
        LIMIT $limit
    ";
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

function fetchRekomendasi($conn, $limit)
{
    $sql = "SELECT 
        v.id_venue, v.venue_name, v.venue_photo, v.sport, v.status,
        IFNULL(
            COUNT(p.id_venue), 0
        ) AS total_slot,
        IFNULL(
            o.opened, '07:00'
        ) AS buka, 
        IFNULL(
            o.closed,'17:00'
        ) AS tutup,
        v.price AS harga,
        IFNULL(
            (SUM(r.rating) / COUNT(r.id_review)), 0
        ) AS rating,
        IFNULL(
            MIN(p.price), 0
        ) AS harga_sewa
        FROM venues AS v 
        LEFT JOIN venue_operasional AS o 
        ON v.id_venue = o.id_venue
        LEFT JOIN venue_price AS p
        ON v.id_venue = p.id_venue
        LEFT JOIN venue_review AS r 
        ON v.id_venue = r.id_venue 
        GROUP BY v.id_venue 
        LIMIT $limit
    ";
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

function fetchLokasi($conn, $limit)
{
    $sql = "SELECT 
        v.id_venue, v.venue_name, v.venue_photo, v.sport, v.status, v.coordinate,
        v.price AS harga,
        IFNULL(
            COUNT(r.id_review), 0
        ) AS total_ulasan,
        IFNULL(
            (SUM(r.rating) / COUNT(r.id_review)), 0
        ) AS rating,
        IFNULL(
            MIN(p.price), 0
        ) AS harga_sewa
        FROM venues AS v 
        LEFT JOIN venue_price AS p
        ON v.id_venue = p.id_venue
        LEFT JOIN venue_review AS r 
        ON v.id_venue = r.id_venue
        GROUP BY v.id_venue 
        LIMIT $limit
    ";
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

function fetchAktivitas($conn, $limit)
{
    $sql = "SELECT 
            a.id_aktvitias, a.nama_aktivitas, v.venue_name, a.date, a.photo, a.max_member,
        IFNULL(
            SUM(am.id_member), 0
        ) AS jumlah_member 
        FROM venue_aktivitas AS a 
        LEFT JOIN venues AS v 
        ON a.id_venue = v.id_venue
        LEFT JOIN venue_aktivitas_member AS am 
        ON a.id_aktvitias = am.id_aktivitas 
        GROUP BY a.id_aktvitias
        HAVING a.date >= NOW() AND jumlah_member < a.max_member
        ORDER BY a.date ASC 
        LIMIT $limit
    ";

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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $limit = 5;

    // get data dashboard
    $venue_baru = fetchVenueBaru($conn, $limit);
    $rekomendasi = fetchRekomendasi($conn, $limit);
    $dekat_kamu = fetchLokasi($conn, $limit);
    $aktivitas = fetchAktivitas($conn, $limit);

    // cek apakah data venue baru berhasil didapatkan
    if ($venue_baru['status'] == 'error') {
        $venue_baru = array("data" => []);
    }

    // cek apakah data rekomendasi berhasil didapatkan
    if ($rekomendasi['status'] == 'error') {
        $rekomendasi = array("data" => []);
    }

    // cek apakah data venue lokasi berhasil didapatkan
    if ($dekat_kamu['status'] == 'error') {
        $dekat_kamu = array("data" => []);
    }

    // cek apakah data venue lokasi berhasil didapatkan
    if ($aktivitas['status'] == 'error') {
        $aktivitas = array("data" => []);
    }

    // menyimpan data dashboard
    $data = array(
        "venue_baru" => $venue_baru['data'],
        "rekomendasi" => $rekomendasi["data"],
        "dekat_kamu" => $dekat_kamu['data'],
        "aktivitas" => $aktivitas["data"],

    );

    $response = array("status" => "success", "message" => "Data beranda sukses didapatkan", "data" => $data);
} else {
    $response = array("status" => "error", "message" => "not get method");
}

echo json_encode($response);
