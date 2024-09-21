# Code Snippet

## Database Connection
```
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Error connecting to database";
}

```

## Form and Insert to Database

### Form
```
 <form action="index.php" method="POST">
        <label for="name">Enter name: </label>
        <input type="text" id="name" name="name" required>
        <input type="submit" name="add" value="Submit">
    </form>
```

### Insert Function
```
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST["name"];

    $sql = "INSERT INTO crud(name) VALUES (?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        echo "Name Added";
    } else {
        echo "Error";
    }
}
```


## Fetch Database
```
$sqlFetch = "SELECT id, name FROM crud";
$result = $conn->query($sqlFetch);
```
```
 <h2>Names: </h2>
    <?php
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<li>" .htmlspecialchars($row['name']) . "</li>";
            }
        }
    ?>
```


## Delete Function
```
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST["id"];

    $sql = "DELETE FROM crud WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Name Deleted";
    } else {
        echo "Error deleting name";
    }
}
```
```
<h2>Names List:</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['name']) . "
                    <form action='index.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='submit' name='delete' value='Delete' 
                        onclick=\"return confirm('Are you sure you want to delete this name?');\">
                    </form>
                </li>";
            }
        } else {
            echo "<li>No names found</li>";
        }
        ?>
    </ul>
  ```

## Update Function

```
<h2>Names List:</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['name']) . "
                   <form action='index.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='submit' name='delete' value='Delete' 
                        onclick=\"return confirm('Are you sure you want to delete this name?');\">
                    </form>
                    <form action='index.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='submit' name='edit' value='Edit'>
                    </form>
                    <form action='index.php' method='POST' style='display:inline;'>
                        <input type='text' name='name' value='" . htmlspecialchars($row['name']) . "' required style='display:none;'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='submit' name='update' value='Update' style='display:none;'>
                    </form>
                </li>";
            }
        } else {
            echo "<li>No names found</li>";
        }
        ?>
    </ul>
```
```
 document.querySelectorAll('input[name="edit"]').forEach((editButton) => {
            editButton.addEventListener('click', function(event) {
                event.preventDefault();
                const listItem = this.parentElement.parentElement;
                const textInput = listItem.querySelector('input[name="name"]');
                const updateButton = listItem.querySelector('input[name="update"]');

                textInput.style.display = textInput.style.display === 'none' ? 'inline' : 'none';
                updateButton.style.display = updateButton.style.display === 'none' ? 'inline' : 'none';
            });
        });
```

```
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST["id"];
    $name = $_POST["name"];

    $sql = "UPDATE crud SET name = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        echo "Name Updated";
    } else {
        echo "Error: " . $stmt->error;
    }
}
```





