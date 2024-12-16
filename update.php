<?php
$conn = new mysqli('localhost', 'root', '', 'your_database_name');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $sql = "SELECT * FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $accessLevel = $row['role'];
    } else {
        echo "User not found!";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $accessLevel = $_POST['accessLevel'];

    $sql = "UPDATE users SET name = '$name', role = '$accessLevel' WHERE matric = '$matric'";
    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully.";
        header("Location: display.php"); // Redirect back to display page
        exit();
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <h2>Update User</h2>
    <form method="post" action="">
        <label for="matric">Matric:</label><br>
        <input type="text" name="matric" value="<?php echo $matric; ?>" readonly><br><br>
        
        <label for="name">Name:</label><br>
        <input type="text" name="name" value="<?php echo $name; ?>" required><br><br>
        
        <label for="accessLevel">Access Level:</label><br>
        <input type="text" name="accessLevel" value="<?php echo $accessLevel; ?>" required><br><br>
        
        <button type="submit">Update</button>
        <a href="display.php">Cancel</a>
    </form>
</body>
</html>
<?php $conn->close(); ?>
