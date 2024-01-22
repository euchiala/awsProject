<?php
include_once 'includes/db.php';

$result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Book List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publication Year</th>
                    <th>ISBN</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['title']}</td>";
                    echo "<td>{$row['author']}</td>";
                    echo "<td>{$row['publication_year']}</td>";
                    echo "<td>{$row['isbn']}</td>";
                    echo "<td>
                            <a href='update.php?id={$row['id']}' class='btn btn-warning'>Edit</a>
                            <a href='delete.php?id={$row['id']}' class='btn btn-danger'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="create.php" class="btn btn-primary">Add New Book</a>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
