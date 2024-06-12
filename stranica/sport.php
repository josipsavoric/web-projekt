<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBC - Sport</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <nav>
            <img class="logo" src="images/logo.jpg" alt="BBC">
            <a href="index.php">Home</a>
            <a href="news.php">News</a>
            <a href="sport.php">Sport</a>
            <?php if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1): ?>
                <a href="administracija.php">Administration</a>
                <a href="unos.html">New article</a>
            <?php endif; ?>
            <a href="login.php">Login</a>
        </nav>
        <div class="subheader">
            <div class="welcome">Welcome to BBC.com</div>
            <div class="date"><?php echo date('l, j F'); ?></div>
            <div>
                <div class="spacer"></div>
            </div>
        </div>
    </header>
    <div class="main">
        <div class="spacer"></div>
        <h2 class="sptext">Sports Articles</h2>
        <div class="articleholder sport">
            <!-- Sports articles will be dynamically added here -->
        </div>
    </div>
    <div class="spacer"></div>
    <footer>
        <div class="foot">
            <hr class="footerhr">
            Copyright © 2019 BBC. The BBC is not responsible for the content of external sites. Read about our approach
            to external linking.
        </div>
    </footer>
    <script src="sport.js"></script>
</body>

</html>