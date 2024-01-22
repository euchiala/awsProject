<?php
include_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission and update the book in the database
} elseif (isset($_GET['id'])) {
    // Retrieve book information from the database for editing
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Book</h2>
        <form method="POST" action="update.php">
            <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $book['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo $book['author']; ?>" required>
            </div>
            <div class="form-group">
                <label for="publication_year">Publication Year:</label>
                <input type="number" class="form-control" id="publication_year" name="publication_year" value="<?php echo $book['publication_year']; ?>">
            </div>
            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo $book['isbn']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
        <a href="index.php" class="btn btn-secondary">Back to List</a>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>