<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container">
        <a class="navbar-brand" href="#">VisionBank</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'home.php' ? 'active' : ''; ?>" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'withdraw.php' ? 'active' : ''; ?>" href="withdraw.php">Withdrawal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'profile.php' ? 'active' : ''; ?>" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'logout.php' ? 'active' : ''; ?>" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>