<?php
include_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Fetch book details before deletion
    $result = $conn->query("SELECT * FROM books WHERE id = $id");
    
    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();
        
        // Delete the book from the database
        $sql = "DELETE FROM books WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error: Book not found.";
    }
} else {
    echo "Error: Invalid request.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
        <h2>Delete Book</h2>
        <?php if (isset($book)): ?>
            <form method="POST" action="delete.php">
                <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                <p>Are you sure you want to delete the book "<?php echo $book['title']; ?>"?</p>
                <button type="submit" class="btn btn-danger">Delete Book</button>
            </form>
        <?php else: ?>
            <p>Error: Book not found.</p>
        <?php endif; ?>
        <a href="index.php" class="btn btn-secondary">Back to List</a>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
