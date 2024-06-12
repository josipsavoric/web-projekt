<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>BBC</title>
    <meta charset="utf-8">
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
        <h2 class="nwstext">News Articles</h2>
        <div class="articleholder news">
            <div class="spacer"></div>

            <?php foreach ($news_articles as $article): ?>
                <a href="article.php?id=<?php echo $article['id']; ?>" class="article-link">
                    <article>
                        <?php if (!empty($article['photo'])): ?>
                            <img src="<?php echo $article['photo']; ?>"
                                alt="<?php echo htmlspecialchars($article['title']); ?>" />
                        <?php else: ?>
                            <img src="images/default.jpg" alt="Default Image" />
                        <?php endif; ?>
                        <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p><?php echo htmlspecialchars($article['about']); ?></p>
                    </article>
                </a>
            <?php endforeach; ?>
            <div class="spacer"></div>
        </div>
        <div class="spacer"></div>
        <h2 class="sptext">Sports Articles</h2>
        <div class="articleholder sport">
            <div class="spacer"></div>
            <?php foreach ($sports_articles as $article): ?>
                <a href="article.php?id=<?php echo $article['id']; ?>" class="article-link">
                    <article>
                        <?php if (!empty($article['photo'])): ?>
                            <img src="<?php echo $article['photo']; ?>"
                                alt="<?php echo htmlspecialchars($article['title']); ?>" />
                        <?php else: ?>
                            <img src="images/default.jpg" alt="Default Image" />
                        <?php endif; ?>
                        <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p><?php echo htmlspecialchars($article['about']); ?></p>
                    </article>
                </a>
            <?php endforeach; ?>
            <div class="spacer"></div>
        </div>
    </div>
    <div class="spacer"></div>
    <br>
    <footer>
        <div class="foot">
            <hr class="footerhr">
            Copyright © 2019 BBC. The BBC is not responsible for the content of external sites. Read about our approach
            to external linking.
        </div>
    </footer>
    <script src="script.js"></script>
</body>

</html>