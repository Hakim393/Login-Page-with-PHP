<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registrasi Berhasil'); window.location = 'login.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Halaman Register</h2>
        <form action="register.php" method="post">
            <label for="username">Username :</label>
            <input type="text" name="username" required>
            <label for="password">Password :</label>
            <input type="password" name="password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <a href="login.php">Login</a>
    </div>
</body>
</html>
