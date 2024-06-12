<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_news = 'SELECT id, title, about, photo FROM articles WHERE category = "news" ORDER BY reg_date DESC';
$result_news = $conn->query($sql_news);
if (!$result_news) {
    die("Error fetching news articles: " . $conn->error);
}

$news_articles = [];
if ($result_news->num_rows > 0) {
    while ($row = $result_news->fetch_assoc()) {
        $news_articles[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($news_articles);

$conn->close();
?>