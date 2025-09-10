<?php
include 'db.php'; // connect to database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id       = $_POST['order_id'];
    $date           = $_POST['date'];
    $customer       = $_POST['customer'];
    $gmail          = $_POST['gmail'];
    $tel_number     = $_POST['tel_number'];
    $animal         = $_POST['animal'];
    $total          = $_POST['total'];
    $payment_status = $_POST['payment_status'];
    $order_status   = $_POST['order_status'];

    $sql = "INSERT INTO orders (order_id, date, customer, gmail, tel_number, animal, total, payment_status, order_status)
            VALUES ('$order_id', '$date', '$customer', '$gmail', '$tel_number', '$animal', '$total', '$payment_status', '$order_status')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Order saved successfully!";
    } else {
        echo "❌ Error: " . $conn->error;
    }
    $conn->close();
}
?>
