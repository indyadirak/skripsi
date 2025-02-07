<?php
include 'connection.php';
session_start();
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['email_admin'];
    $password = $_POST['password_admin'];
    $query = 'SELECT * FROM admin WHERE email_admin = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['pass_admin']) {
            $_SESSION['login'] = $username;
            header('Location: dashboard.php');
        } else {
            $error_message = 'Password anda salah';
        }
    } else {
        $error_message = 'Username anda salah';
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>halaman login manajemen risiko</title>
        <link rel="stylesheet" type="text/css" href="index.css">
    </head>
    <body>
        <div class="main_div">
            <div class="title">Selamat Datang</div>
            <p> Silakan untuk memasukkan kredensial untuk memasuki sistem</p>
            <?php if ($error_message): ?>
                <div class="error_message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="index.php" method="post">
              <div class="input_box">
                <input type="text" placeholder="Email" name="email_admin" required>
                <div class="icon"><i class="fas fa-user"></i></div>
              </div>
              <div class="input_box">
                <input type="password" placeholder="Password" name="password_admin" required>
                <div class="icon"><i class="fas fa-lock"></i></div>
              </div>
              <br>
              <br>
              <div class="input_box button">
                <input type="submit" value="Login" name="login">
              </div>
            </form>
          </div>
    </body>
</html>