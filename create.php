<?php
include_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publication_year = $_POST['publication_year'];
    $isbn = $_POST['isbn'];

    $sql = "INSERT INTO books (title, author, publication_year, isbn) VALUES ('$title', '$author', '$publication_year', '$isbn')";

    if ($conn->query($sql) === TRUE) {
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Book</h2>
        <form method="POST" action="create.php">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="publication_year">Publication Year:</label>
                <input type="number" class="form-control" id="publication_year" name="publication_year">
            </div>
            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn">
            </div>
            <button type="submit" class="btn btn-primary">Add Book</button>
        </form>        
        <a href="index.php" class="btn btn-secondary">Back to List</a>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
