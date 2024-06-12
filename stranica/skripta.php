<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$title = $_POST['title'] ?? '';
$about = $_POST['about'] ?? '';
$content = $_POST['content'] ?? '';
$category = $_POST['category'] ?? '';

$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["pphoto"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$errors = [];

if (empty($title)) {
    $errors[] = "Title is required.";
}

if (empty($about)) {
    $errors[] = "Short description is required.";
}

if (empty($content)) {
    $errors[] = "Content is required.";
}

if (empty($category)) {
    $errors[] = "Category is required.";
}

$check = getimagesize($_FILES["pphoto"]["tmp_name"]);
if ($check === false) {
    $errors[] = "File is not an image.";
}

if ($_FILES["pphoto"]["size"] > 500000) {
    $errors[] = "Sorry, your file is too large.";
}

$allowed_formats = ["jpg", "jpeg", "gif"];
if (!in_array($imageFileType, $allowed_formats)) {
    $errors[] = "Sorry, only JPG, JPEG, and GIF files are allowed.";
}

if (!empty($errors)) {
    $response = ["success" => false, "message" => implode("<br>", $errors)];
} else {

    if (move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO articles (title, about, content, photo, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $about, $content, $target_file, $category);

        if ($stmt->execute()) {
            $response = ["success" => true, "message" => "New record created successfully", "redirect" => "index.php"];
        } else {
            $response = ["success" => false, "message" => "Error: " . $stmt->error];
        }

        $stmt->close();
    } else {
        $response = ["success" => false, "message" => "Sorry, there was an error uploading your file."];
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>