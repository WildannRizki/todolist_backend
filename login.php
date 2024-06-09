<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username']; // Store the username in the session
        header('Location: index.php');
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:ital,wght@0,500;0,600;0,700;1,400&family=Roboto:wght@400;500;700&display=swap');
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Roboto", sans-serif;
            background: #F4F4F9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #8e2de2, #4a00e0);
        }
        .login-container {
            width: 400px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 30px;
            color: #4a00e0;
        }
        .input-control {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            cursor: pointer;
            background: #4a00e0;
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        button:hover {
            background: #6a00e0;
        }
        .footer {
            margin-top: 20px;
        }
        .footer a {
            color: #4a00e0;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <input type="text" name="username" class="input-control" placeholder="Username" required>
            <input type="password" name="password" class="input-control" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="footer">
            <p>Belum punya akun? <a href="registrasi.php">Buat akun</a></p>
        </div>
    </div>
</body>
</html>
