<!-- config.php -->
<?php
$conn = mysqli_connect("localhost", "root", "", "product_management");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");

function formatVND($amount) {
    return number_format($amount, 0, ',', '.') . 'đ';
}
