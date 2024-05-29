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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $password = $_POST['confirm_password']; // Changed to match the input field name in the modal

    // Verify password
    $sql_verify_password = "SELECT password FROM users WHERE id = '$user_id'";
    $result_verify_password = $conn->query($sql_verify_password);
    $user_data = $result_verify_password->fetch_assoc();

    if (password_verify($password, $user_data['password'])) {
        if ($amount > $user['balance']) {
            $error = "Insufficient balance.";
        } else {
            $new_balance = $user['balance'] - $amount;
            $conn->query("UPDATE users SET balance = '$new_balance' WHERE id = '$user_id'");
            $conn->query("INSERT INTO transactions (user_id, amount, type) VALUES ('$user_id', '$amount', 'withdrawal')");
            header('Location: home.php');
            exit();
        }
    } else {
        $error = "Incorrect password.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Withdrawal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        .nav-link.active,
        .nav-link:hover {
            font-weight: 900;
        }
    </style>
    <script>
        function showPasswordModal() {
            let amount = document.getElementById("amount").value;
            if (amount > 0) {
                document.getElementById("withdrawAmount").innerText = amount;
                new bootstrap.Modal(document.getElementById('passwordModal')).show();
            } else {
                alert("Please enter a valid amount.");
            }
        }
    </script>
</head>

<body>
    <div class="container-fluid p-0">
        <header class="text-center mb-3 py-3 bg-primary text-white">
            <h1 class="display-1"><b>Money Eyes</b></h1>
        </header>

        <?php include 'navbar.php'; ?>

        <div class="container mt-5">
            <h2>Withdrawal</h2>
            <p>Current Balance: Rp <?= number_format($user['balance'], 2) ?></p>
            <?php if (isset($error)) {
                echo "<div class='alert alert-danger'>$error</div>";
            } ?>
            <form method="POST" action="">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" required class="form-control"><br>
                <input type="hidden" id="confirm_password" name="confirm_password">
                <button type="button" class="btn btn-primary" onclick="showPasswordModal()">Withdraw</button>
            </form>
        </div>
    </div>

    <!-- Password Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Confirm Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please enter your password to confirm the withdrawal of Rp <span id="withdrawAmount"></span>.</p>
                    <input type="password" class="form-control" id="password" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
    <script>
        function submitForm() {
            document.getElementById("confirm_password").value = document.getElementById("password").value;
            document.forms[0].submit();
        }
    </script>
</body>

</html>