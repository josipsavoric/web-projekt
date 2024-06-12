<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $article_id = $_GET['id'];
    $sql = "SELECT * FROM articles WHERE id = $article_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $about = $row['about'];
        $photo = $row['photo'];
        $content = $row['content'];
        $category = $row['category']; 
    } else {
        echo "No article found with ID $article_id";
    }
} else {
    echo "No article ID provided";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>BBC</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <style>

        .banner {
            text-align: center;
            padding: 10px 0;
            color: black;
            font-size: 24px;
            font-weight: bold;
        }
        .sports-banner {
            background-color: yellow;
        }
        .news-banner {
            background-color: red;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <img class="logo" src="images/logo.jpg" alt="BBC">
            <a href="">Home</a>
            <a href="">News</a>
            <a href="">Sport</a>
            <a href="administracija.php">Administration</a>
            <a href="unos.html">New article</a>
        </nav>
        <div class="subheader">
            <div class="welcome">Welcome to BBC.com</div>
            <div class="date"><?php echo date('l, j F'); ?></div>
            <div>
                <div class="spacer"></div>
            </div>
        </div>
    </header>

    <?php

$banner_class = '';
$banner_text = '';
if ($category === 'sport') { 
    $banner_class = 'sports-banner';
    $banner_text = 'SPORTS';
} elseif ($category === 'news') {
    $banner_class = 'news-banner';
    $banner_text = 'NEWS';
} else {

    $banner_class = 'news-banner';
    $banner_text = 'NEWS';
}

    ?>
    <!-- Display the banner -->
    <div class="banner <?php echo $banner_class; ?>"><?php echo $banner_text; ?></div>

    <div class="main">
        <?php

        ?>
        <div class="article-details">
            <h2><?php echo htmlspecialchars($title); ?></h2>
            <p><?php echo htmlspecialchars($about); ?></p>
            <?php if (!empty($photo)): ?>
                <img src="<?php echo $photo; ?>" alt="<?php echo htmlspecialchars($title); ?>"/>
            <?php endif; ?>
            <p><?php echo htmlspecialchars($content); ?></p>
        </div>
    </div>

    <footer>
        <div class="foot">
            <hr class="footerhr">
            Copyright © 2019 BBC. The BBC is not responsible for the content of external sites. Read about our approach to external linking.
        </div>
    </footer>
</body>
</html>