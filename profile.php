<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        .nav-link.active,
        .nav-link:hover {
            font-weight: 900;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <header class="text-center mb-3 py-3 bg-primary text-white">
            <h1 class="display-1"><b>VisionBank</b></h1>
        </header>

        <?php include 'navbar.php'; ?>

        <div class="container mt-5">
            <h2>Profile</h2>
            <p><strong>Name:</strong> <?= $user['name'] ?></p>
            <p><strong>Username:</strong> <?= $user['username'] ?></p>
            <p><strong>Balance:</strong> Rp <?= number_format($user['balance'], 2) ?></p>
        </div>
    </div>
</body>

</html>