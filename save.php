<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit();
}

include 'config.php';

$user_id = $_SESSION['user_id'];
$nominal = $_POST['nominal'];
$timestamp = $_POST['timestamp'];
$authenticity = $_POST['authenticity'];

// Update user's balance
$sql_update_balance = "UPDATE users SET balance = balance + $nominal WHERE id = $user_id";
if ($conn->query($sql_update_balance) === TRUE) {
    // Insert transaction record
    $sql_insert_transaction = "INSERT INTO transactions (user_id, amount, type, timestamp, authenticity) VALUES ($user_id, $nominal, 'deposit', '$timestamp', '$authenticity')";
    if ($conn->query($sql_insert_transaction) === TRUE) {
        echo "Transaction saved successfully";
    } else {
        echo "Error: " . $sql_insert_transaction . "<br>" . $conn->error;
    }
} else {
    echo "Error updating balance: " . $conn->error;
}

$conn->close();
