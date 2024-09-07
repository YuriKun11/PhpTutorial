<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $inputUsername = $conn->real_escape_string($_POST['username']);
    $inputPassword = $conn->real_escape_string($_POST['password']);

        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $inputUsername);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();

            if (password_verify($inputPassword, $hashed_password)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $id; 

                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid username or password!";
            }
        } else {
            $error = "Invalid username or password!";
        }
        $stmt->close(); 
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>
<form  method="post" action="login.php">

    <h2>Admin Login</h2>
        <label class="log-label" for="username">Username:</label>
        <input class="log-input" type="text" id="username" name="username" autocomplete="off"required><br>

        <label class="log-label" for="password" >Password:</label>
        <input class="log-input" type="password" autocomplete="off" id="password" name="password" required><br><br>
        <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="register.php">Sign up!</a></p>
</body>
</html>
