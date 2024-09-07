<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo "User ID is not set.";
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Database</title>
</head>
<body>
    <?php
    include 'db_connection.php';
    ?>
    <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>! You are logged in.</p>
    
    <!-- Add Record Form -->
    <h1>Add to Database</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="text" name="name" autocomplete="off" placeholder="Add to database">
        <input type="submit" name="add" id="submit" value="Add button">
    </form>

    <!-- Delete Record Form -->
    <h1>Delete from Database</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="number" name="id" autocomplete="off" placeholder="ID to delete">
        <input type="submit" name="delete" id="submit" value="Delete button">
    </form>

    <!-- Fetch Records Form -->
    <h1>Fetch Records</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="text" name="search_name" autocomplete="off" placeholder="Search by name (optional)">
        <input type="submit" name="fetch" id="submit" value="Fetch Records">
    </form>

    <?php
    function addFunction($conn) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
            $name = $_POST['name'];
            $user_id = $_SESSION['user_id'];

            if (empty($name)) {
                echo "Name field is empty. Please fill in the name.";
            } else {
                $name = $conn->real_escape_string($name);

                $check_sql = "SELECT * FROM `data` WHERE name = '$name' AND user_id = '$user_id'";
                $check_result = $conn->query($check_sql);

                if ($check_result->num_rows > 0) {
                    echo "This name already exists.";
                } else {
                    $sql = "INSERT INTO `data` (name, user_id) VALUES ('$name', '$user_id')";

                    if ($conn->query($sql) === TRUE) {
                        echo "Name added successfully!";
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }
            }
        }
    }

    function deleteFunction($conn) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
            $id = $_POST['id'];
            $user_id = $_SESSION['user_id'];

            if (empty($id) || !is_numeric($id)) {
                echo "Invalid ID.";
            } else {
                $id = $conn->real_escape_string($id);

                $sql = "DELETE FROM `data` WHERE id = '$id' AND user_id = '$user_id'";

                if ($conn->query($sql) === TRUE) {
                    if ($conn->affected_rows > 0) {
                        echo "Record deleted successfully!";
                    } else {
                        echo "No record found or you don't have permission to delete this record.";
                    }
                } else {
                    echo "Error: " . $conn->error;
                }
            }
        }
    }

    function fetchFunction($conn) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetch'])) {
            $search_name = $_POST['search_name'];
            $user_id = $_SESSION['user_id'];

            $search_name = $conn->real_escape_string($search_name);
            $search_condition = "";

            if (!empty($search_name)) {
                $search_condition = " AND name LIKE '%$search_name%'";
            }

            $sql = "SELECT id, name FROM `data` WHERE user_id = '$user_id' $search_condition";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Records:</h2><ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li>ID: " . htmlspecialchars($row['id']) . " - Name: " . htmlspecialchars($row['name']) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "No records found.";
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['add'])) {
            addFunction($conn);
        } elseif (isset($_POST['delete'])) {
            deleteFunction($conn);
        } elseif (isset($_POST['fetch'])) {
            fetchFunction($conn);
        }
    }

    $conn->close();
    ?>

    <a href="logout.php">LOGOUT</a>
</body>
</html>
