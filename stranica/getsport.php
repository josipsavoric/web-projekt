<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_sport = 'SELECT id, title, about, photo FROM articles WHERE category = "sport" ORDER BY reg_date DESC';
$result_sport = $conn->query($sql_sport);
if (!$result_sport) {
    die("Error fetching sports articles: " . $conn->error);
}

$sport_articles = [];
if ($result_sport->num_rows > 0) {
    while ($row = $result_sport->fetch_assoc()) {
        $sport_articles[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($sport_articles);

$conn->close();
?>