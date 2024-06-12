<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $error_message = "All fields are required.";
        } else {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {
                $error_message = "Username already exists.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("INSERT INTO user (username, password, razina) VALUES (?, ?, 0)");
                $stmt->bind_param("ss", $username, $hashed_password);

                if ($stmt->execute()) {
                    $success_message = "Registration successful. Please log in.";
                } else {
                    $error_message = "Error: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    } elseif (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $error_message = "All fields are required.";
        } else {
            $stmt = $conn->prepare("SELECT password, razina FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($hashed_password, $razina);
            $stmt->fetch();
            $stmt->close();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                $_SESSION['isadmin'] = $razina;
                $success_message = "Login successful.";
            } else {
                $error_message = "Invalid username or password.";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBC - Login</title>
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
        <h2 class="nwstext">Login / Register</h2>
        <?php
        if (isset($error_message)) {
            echo "<div class='error'>$error_message</div>";
        }
        if (isset($success_message)) {
            echo "<div class='success'>$success_message</div>";
        }
        ?>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br><br>
            <button type="submit" name="register">Register</button>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
    <div class="spacer"></div>
    <footer>
        <div class="foot">
            <hr class="footerhr">
            Copyright © 2019 BBC. The BBC is not responsible for the content of external sites. Read about our approach
            to external linking.
        </div>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();
            const options = { weekday: 'long', day: 'numeric', month: 'long' };
            const formattedDate = today.toLocaleDateString('en-US', options);
            document.querySelector('.date').textContent = formattedDate;
        });
    </script>
</body>

</html>