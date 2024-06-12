<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_sports = 'SELECT id, title, about, photo FROM articles WHERE category = "sport" ORDER BY reg_date DESC LIMIT 3';
$result_sports = $conn->query($sql_sports);
if (!$result_sports) {
    die("Error fetching sports articles: " . $conn->error);
}

$sports_articles = [];
if ($result_sports->num_rows > 0) {
    while ($row = $result_sports->fetch_assoc()) {
        $sports_articles[] = $row;
    }
}

$sql_news = 'SELECT id, title, about, photo FROM articles WHERE category = "news" ORDER BY reg_date DESC LIMIT 3';
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
$json_data = array('sports' => $sports_articles, 'news' => $news_articles);
echo json_encode($json_data);

error_log(json_encode($json_data));

$conn->close();
?>