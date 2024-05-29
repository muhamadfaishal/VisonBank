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

// Handle manual deposit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['manual_amount'])) {
    $manual_amount = $_POST['manual_amount'];
    $new_balance = $user['balance'] + $manual_amount;

    $conn->query("UPDATE users SET balance = '$new_balance' WHERE id = '$user_id'");
    $conn->query("INSERT INTO transactions (user_id, amount, type) VALUES ('$user_id', '$manual_amount', 'deposit')");
    header('Location: home.php');
    exit();
}

// Fetch transaction history
$sql_transactions = "SELECT * FROM transactions WHERE user_id = '$user_id' ORDER BY timestamp DESC";
$result_transactions = $conn->query($sql_transactions);
$transactions = [];
while ($row = $result_transactions->fetch_assoc()) {
    $transactions[] = $row;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <link href="style.css" rel="stylesheet" />
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
            <h1 class="display-1"><b>Money Eyes</b></h1>
            <p id="description">Smart Technology, Quick Solutions.</p>
        </header>

        <?php include 'navbar.php'; ?>

        <div class="container">
            <div class="row mt-4">
                <div class="col-md-8 text-center">
                    <div class="button-group mb-4">
                        <button id="start" class="btn btn-primary btn-lg" onclick="init()">Start</button>
                        <button id="crop" class="btn btn-warning btn-lg" style="display:none;" onclick="capture()">Crop</button>
                        <button id="start-again" class="btn btn-primary btn-lg" style="display:none;" onclick="startAgain()">Start Again</button>
                        <button id="save" class="btn btn-success btn-lg mt-3" style="display:none;" onclick="saveData()">Save</button>
                    </div>
                    <div>
                        <div id="loading-spinner" class="spinner-border" style="display:none;"></div>
                    </div>
                    <div id="webcam-placeholder" class="text-center mb-4" style="position: relative;">
                        <!-- Webcam video will be placed here -->
                    </div>
                    <div id="captured-image-container" class="text-center mb-4" style="display:none;">
                        <img id="captured-image" class="img-fluid" />
                    </div>
                    <div id="sum-display" class="text-center mb-4">
                        <h2>Sum: Rp <b id="sum"></b></h2>
                    </div>
                    <div class="manual-input-form mt-4">
                        <h3>Manual Deposit</h3>
                        <?php if (isset($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        } ?>
                        <form method="POST" action="">
                            <label for="manual_amount">Amount:</label>
                            <input type="number" id="manual_amount" name="manual_amount" required class="form-control mb-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 bg-light text-center p-4">
                    <h2>Saldo: Rp <?= number_format($user['balance'], 2) ?></h2>
                    <h3>Transaction History</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($transactions)) : ?>
                                <tr>
                                    <td colspan="3">No transactions found.</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($transactions as $transaction) : ?>
                                    <tr>
                                        <td><?= date('Y-m-d H:i:s', strtotime($transaction['timestamp'])) ?></td>
                                        <td><?= ucfirst($transaction['type']) ?></td>
                                        <td><?= number_format($transaction['amount'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>