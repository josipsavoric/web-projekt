<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $archive = isset($_POST['archive']) ? 1 : 0;

    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["pphoto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $existing_photo = isset($_POST['existing_photo']) ? $_POST['existing_photo'] : '';

    $stmt = $conn->prepare("UPDATE articles SET title=?, about=?, content=?, photo=?, category=?, archive=? WHERE photo=?");

    if ($stmt) {

        $stmt->bind_param("sssssis", $title, $about, $content, $target_file, $category, $archive, $existing_photo);

        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM articles WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
header("Location: admin.php");
exit;
?>