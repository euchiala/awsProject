<?php
define('DB_SERVER', 'database-ds.che2uwcwu9s6.us-east-1.rds.amazonaws.com');
define('DB_USERNAME', 'admin');
define('DB_PASSWORD', 'admin123');
define('DB_DATABASE', 'db');
?>

<html>
<head>
    <title>Test Page PHP</title>
    <!-- Add Bootstrap CDN for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            margin: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="mt-4">Employee Information</h1>

    <?php
    // Fonction pour vérifier l'existence d'une table
    function tableExists($tableName, $connection, $dbName) 
    {
        $tableName = mysqli_real_escape_string($connection, $tableName);
        $dbName = mysqli_real_escape_string($connection, $dbName);
        $checkTable = mysqli_query($connection,
            "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$tableName' AND TABLE_SCHEMA = '$dbName'");

        return mysqli_num_rows($checkTable) > 0;
    }

    // Fonction pour créer la table EMPLOYEES si elle n'existe pas
    function verifyEmployeesTable($connection, $dbName) 
    {
        if (!tableExists("EMPLOYEES", $connection, $dbName)) 
        {
            $query = "CREATE TABLE EMPLOYEES (
                        ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        NAME VARCHAR(45),
                        ADDRESS VARCHAR(90)
                        )";
                        
            if (!mysqli_query($connection, $query)) 
            {
                echo("<p>Error creating table.</p>");
            }
        }
    }

    // Fonction pour ajouter un employé à la table
    function addEmployee($connection, $name, $address) 
    {
        $n = mysqli_real_escape_string($connection, $name);
        $a = mysqli_real_escape_string($connection, $address);
        $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a')";
        if (mysqli_query($connection, $query)) 
        {
            echo("<p>Employee added successfully.</p>");
        } 
        else 
        {
            echo("<p>Error adding employee data: " . mysqli_error($connection) . "</p>");
        }
    }

    // Function to delete an employee by ID
    function deleteEmployee($connection, $id) 
    {
        $id = mysqli_real_escape_string($connection, $id);
        $query = "DELETE FROM EMPLOYEES WHERE ID = $id";
        if (!mysqli_query($connection, $query)) 
        {
            echo("<p>Error deleting employee data.</p>");
        }
    }

    // Function to update an employee by ID
    function updateEmployee($connection, $id, $name, $address) 
    {
        $id = mysqli_real_escape_string($connection, $id);
        $n = mysqli_real_escape_string($connection, $name);
        $a = mysqli_real_escape_string($connection, $address);
        $query = "UPDATE EMPLOYEES SET NAME='$n', ADDRESS='$a' WHERE ID=$id";
        if (!mysqli_query($connection, $query)) 
        {
            echo("<p>Error updating employee data.</p>");
        }
    }

    // Connexion à MySQL et sélection de la base de données
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    if (mysqli_connect_errno()) 
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $database = mysqli_select_db($connection, DB_DATABASE);

    // Assurer que la table EMPLOYEES existe
    verifyEmployeesTable($connection, DB_DATABASE);

    // Handle the deletion when the delete button is clicked
    if (isset($_POST['delete'])) 
    {
        $deleteId = $_POST['delete'];
        deleteEmployee($connection, $deleteId);
    }

    // Handle the update when the update button is clicked
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) 
    {
        $updateId = $_POST['update'];
        $updateName = htmlentities($_POST['update_NAME']);
        $updateAddress = htmlentities($_POST['update_ADDRESS']);

        if (strlen($updateName) > 0 || strlen($updateAddress) > 0) 
        {
            updateEmployee($connection, $updateId, $updateName, $updateAddress);
        }
    }

    // Traitement du formulaire d'ajout d'un employé
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) 
    {
        $employeeName = htmlentities($_POST['NAME']);
        $employeeAddress = htmlentities($_POST['ADDRESS']);

        if (strlen($employeeName) > 0 || strlen($employeeAddress) > 0) 
        {
            addEmployee($connection, $employeeName, $employeeAddress);
        }
    }
    ?>

    <!-- Form for adding an employee -->
    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputName">Name</label>
                <input type="text" class="form-control" id="inputName" name="NAME" maxlength="45" required>
            </div>
            <div class="form-group col-md-8">
                <label for="inputAddress">Address</label>
                <input type="text" class="form-control" id="inputAddress" name="ADDRESS" maxlength="90" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="add">Add Data</button>
    </form>

    <!-- Display data from the table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

            while ($queryData = mysqli_fetch_assoc($result)) 
            {
                echo "<tr>";
                echo "<td>", $queryData['ID'], "</td>",
                    "<td>", isset($queryData['NAME']) ? htmlentities($queryData['NAME']) : '', "</td>",
                    "<td>", isset($queryData['ADDRESS']) ? htmlentities($queryData['ADDRESS']) : '', "</td>",
                    "<td>",
                    "<form action='" . $_SERVER['SCRIPT_NAME'] . "' method='POST' style='display:inline;'>",
                    "<input type='hidden' name='update' value='" . $queryData['ID'] . "'>",
                    "<button type='button' class='btn btn-warning' data-toggle='modal' data-target='#updateModal" . $queryData['ID'] . "'>Update</button>",
                    "</form>",
                    "&nbsp;", // Add some spacing between buttons
                    "<form action='" . $_SERVER['SCRIPT_NAME'] . "' method='POST' style='display:inline;'>",
                    "<button type='submit' class='btn btn-danger' name='delete' value='" . $queryData['ID'] . "'>Delete</button>",
                    "</form>",
                    "</td>";
                echo "</tr>";
                // Update Modal
                echo "<div class='modal fade' id='updateModal" . $queryData['ID'] . "' tabindex='-1' role='dialog' aria-labelledby='updateModalLabel" . $queryData['ID'] . "' aria-hidden='true'>";
                echo "<div class='modal-dialog' role='document'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<h5 class='modal-title' id='updateModalLabel" . $queryData['ID'] . "'>Update Employee</h5>";
                echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo "<span aria-hidden='true'>&times;</span>";
                echo "</button>";
                echo "</div>";
                echo "<div class='modal-body'>";
                echo "<form action='" . $_SERVER['SCRIPT_NAME'] . "' method='POST'>";
                echo "<input type='hidden' name='update' value='" . $queryData['ID'] . "'>";
                echo "<div class='form-row'>";
                echo "<div class='form-group col-md-4'>";
                echo "<label for='updateName" . $queryData['ID'] . "'>Name</label>";
                echo "<input type='text' class='form-control' id='updateName" . $queryData['ID'] . "' name='update_NAME' maxlength='45' value='" . htmlentities($queryData['NAME']) . "' required>";
                echo "</div>";
                echo "<div class='form-group col-md-8'>";
                echo "<label for='updateAddress" . $queryData['ID'] . "'>Address</label>";
                echo "<input type='text' class='form-control' id='updateAddress" . $queryData['ID'] . "' name='update_ADDRESS' maxlength='90' value='" . htmlentities($queryData['ADDRESS']) . "' required>";
                echo "</div>";
                echo "</div>";
                echo "<button type='submit' class='btn btn-primary'>Update Data</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Cleanup -->
<?php
mysqli_free_result($result);
mysqli_close($connection);
?>

<!-- Add Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>