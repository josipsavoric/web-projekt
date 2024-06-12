<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>BBC - Edit Articles</title>
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
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bbc";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM articles";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Error fetching articles: " . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_array($result)) {
            echo '<form enctype="multipart/form-data" action="process_form.php" method="POST">
                <div class="form-item">
                    <label for="title">Title:</label>
                    <div class="form-field">
                        <input type="text" name="title" class="form-field-textual" value="' . $row['title'] . '">
                    </div>
                </div>
                <div class="form-item">
                    <label for="about">Summary (up to 50 characters):</label>
                    <div class="form-field">
                        <textarea name="about" cols="30" rows="10" class="form-field-textual">' . $row['about'] . '</textarea>
                    </div>
                </div>
                <div class="form-item">
                    <label for="content">Content:</label>
                    <div class="form-field">
                        <textarea name="content" cols="30" rows="10" class="form-field-textual">' . $row['content'] . '</textarea>
                    </div>
                </div>
                <div class="form-item">
                    <label for="pphoto">Photo:</label>
                    <div class="form-field">
                        <input type="file" class="input-text" id="pphoto" name="pphoto"/> 
                        <br><img src="' . $row['photo'] . '" width="100px"/>
                    </div>
                </div>
                <div class="form-item">
                    <label for="category">Category:</label>
                    <div class="form-field">
                        <select name="category" class="form-field-textual">
                            <option value="sport"' . ($row['category'] == 'sport' ? ' selected' : '') . '>Sport</option>
                            <option value="news"' . ($row['category'] == 'news' ? ' selected' : '') . '>News</option>
                        </select>
                    </div>
                </div>
                <div class="form-item">
                    <label>Archive:</label>
                    <div class="form-field">';
            if ($archive = isset($_POST['archive']) ? 1 : 0) {
                echo '<input type="checkbox" name="archive" id="archive"/> Archive?';
            } else {
                echo '<input type="checkbox" name="archive" id="archive" checked/> Archive?';
            }
            echo '</div>
                </div>
                <div class="form-item">
                    <input type="hidden" name="id" class="form-field-textual" value="' . $row['id'] . '">
                    <button type="reset" value="Reset">Reset</button>
                    <button type="submit" name="update" value="Update">Update</button>
                    <button type="submit" name="delete" value="Delete">Delete</button>
                </div>
            </form>';
        }

        $conn->close();
        ?>
    </div>
    <footer>
        <div class="foot">
            <hr class="footerhr">
            Copyright © 2019 BBC. The BBC is not responsible for the content of external sites. Read about our approach
            to
            external linking.
        </div>
    </footer>
    <script src="script.js"></script>
</body>

</html>