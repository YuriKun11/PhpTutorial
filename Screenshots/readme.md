# Code Snippet

## Example Code

Here is a code snippet you can copy:

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








